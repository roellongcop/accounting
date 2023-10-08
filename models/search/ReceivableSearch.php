<?php

namespace app\models\search;

use yii\data\ActiveDataProvider;
use app\models\Receivable;
use app\helpers\App;

/**
 * ReceivableSearch represents the model behind the search form of `app\models\Receivable`.
 */
class ReceivableSearch extends Receivable
{
    public $keywords;
    public $date_range;
    public $pagination;

    public $searchTemplate = 'receivable/_search';
    public $searchAction = ['receivable/index'];
    public $searchLabel = 'Receivable';

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
        $query = Receivable::find()
            ->alias('r')
            ->joinWith('user u')
            ->groupBy('r.id');

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
            'asc' => ['(r.amount - r.amount_paid)' => SORT_ASC],
            'desc' => ['(r.amount - r.amount_paid)' => SORT_DESC],
        ];

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'r.id' => $this->id,
            'r.status' => $this->status,
            'r.amount' => $this->amount,
            'r.record_status' => $this->record_status,
            'r.created_by' => $this->created_by,
            'r.updated_by' => $this->updated_by,
            'r.created_at' => $this->created_at,
            'r.updated_at' => $this->updated_at,
            'r.user_id' => $this->user_id,
        ]);
                
        $query->andFilterWhere(['or', 
            ['like', 'r.title', $this->keywords],  
            ['like', 'r.description', $this->keywords],  
            ['like', 'r.amount', $this->keywords],  
        ]);

        $query->daterange($this->date_range);

        return $dataProvider;
    }
}