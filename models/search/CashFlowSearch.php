<?php

namespace app\models\search;

use yii\data\ActiveDataProvider;
use app\models\CashFlow;
use app\helpers\App;

/**
 * CashFlowSearch represents the model behind the search form of `app\models\CashFlow`.
 */
class CashFlowSearch extends CashFlow
{
    public $keywords;
    public $date_range;
    public $pagination;

    public $searchTemplate = 'cash-flow/_search';
    public $searchAction = ['cash-flow/index'];
    public $searchLabel = 'AR/AP Management';

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'created_by', 'updated_by'], 'integer'],
            [['name', 'description', 'slug', 'created_at', 'updated_at', 'user_id', 'biller'], 'safe'],
            [['keywords', 'pagination', 'date_range', 'record_status'], 'safe'],
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
        $query = CashFlow::find()
            ->alias('cf')
            ->joinWith('user u')
            ->groupBy('cf.id');

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

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'cf.id' => $this->id,
            'cf.user_id' => $this->user_id,
            'cf.record_status' => $this->record_status,
            'cf.created_by' => $this->created_by,
            'cf.updated_by' => $this->updated_by,
            'cf.created_at' => $this->created_at,
            'cf.updated_at' => $this->updated_at,
            'cf.biller' => $this->biller,
        ]);
                
        $query->andFilterWhere(['or', 
            ['like', 'cf.name', $this->keywords],  
            ['like', 'cf.description', $this->keywords],  
            ['like', 'cf.biller', $this->keywords],  
        ]);

        $query->daterange($this->date_range);

        return $dataProvider;
    }
}