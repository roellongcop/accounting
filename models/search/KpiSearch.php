<?php

namespace app\models\search;

use yii\data\ActiveDataProvider;
use app\models\Kpi;
use app\helpers\App;

/**
 * KpiSearch represents the model behind the search form of `app\models\Kpi`.
 */
class KpiSearch extends Kpi
{
    public $keywords;
    public $date_range;
    public $pagination;

    public $searchTemplate = 'kpi/_search';
    public $searchAction = ['kpi/index'];
    public $searchLabel = 'KPI';

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'created_by', 'updated_by'], 'integer'],
            [['name', 'description', 'slug', 'created_at', 'updated_at', 'user_id'], 'safe'],
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
        $query = Kpi::find()
            ->alias('kpi')
            ->joinWith('user u')
            ->groupBy('kpi.id');

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
            'kpi.id' => $this->id,
            'kpi.user_id' => $this->user_id,
            'kpi.record_status' => $this->record_status,
            'kpi.created_by' => $this->created_by,
            'kpi.updated_by' => $this->updated_by,
            'kpi.created_at' => $this->created_at,
            'kpi.updated_at' => $this->updated_at,
        ]);
                
        $query->andFilterWhere(['or', 
            ['like', 'kpi.name', $this->keywords],  
            ['like', 'kpi.description', $this->keywords],  
        ]);

        $query->daterange($this->date_range);

        return $dataProvider;
    }
}