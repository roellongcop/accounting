<?php

namespace app\models\search;

use yii\data\ActiveDataProvider;
use app\models\Payable;
use app\helpers\App;

/**
 * PayableSearch represents the model behind the search form of `app\models\Payable`.
 */
class PayableSearch extends Payable
{
    public $keywords;
    public $date_range;
    public $pagination;

    public $searchTemplate = 'payable/_search';
    public $searchAction = ['payable/index'];
    public $searchLabel = 'Payable';

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'created_by', 'updated_by'], 'integer'],
            [['title', 'due_date', 'description', 'file_tokens', 'created_at', 'updated_at'], 'safe'],
            [['amount'], 'number'],
            [['keywords', 'pagination', 'date_range', 'record_status', 'user_id', 'status'], 'safe'],
            [['keywords'], 'trim'],
        ];
    }

    public function init()
    {
        $this->pagination = App::setting('system')->pagination;
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return \yii\base\Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Payable::find()
            ->alias('p')
            ->joinWith('user u')
            ->groupBy('p.id');

        // add conditions that should always apply here
        $this->load($params);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
            'pagination' => [
                'pageSize' => $this->pagination
            ]
        ]);

        $dataProvider->sort->attributes['username'] = [
            'asc' => ['u.username' => SORT_ASC],
            'desc' => ['u.username' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['balance'] = [
            'asc' => ['(p.amount - p.amount_paid)' => SORT_ASC],
            'desc' => ['(p.amount - p.amount_paid)' => SORT_DESC],
        ];

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'p.id' => $this->id,
            'p.status' => $this->status,
            'p.amount' => $this->amount,
            'p.record_status' => $this->record_status,
            'p.created_by' => $this->created_by,
            'p.updated_by' => $this->updated_by,
            'p.created_at' => $this->created_at,
            'p.updated_at' => $this->updated_at,
            'p.user_id' => $this->user_id,
        ]);
                
        $query->andFilterWhere(['or', 
            ['like', 'p.title', $this->keywords],  
            ['like', 'p.description', $this->keywords],  
            ['like', 'p.amount', $this->keywords],  
        ]);

        $query->daterange($this->date_range);

        return $dataProvider;
    }
}