<?php

namespace app\models\search;

use yii\data\ActiveDataProvider;
use app\models\AccountingReport;
use app\helpers\App;

/**
 * AccountingReportSearch represents the model behind the search form of `app\models\AccountingReport`.
 */
class AccountingReportSearch extends AccountingReport
{
    public $keywords;
    public $date_range;
    public $pagination;

    public $searchTemplate = 'accounting-report/_search';
    public $searchAction = ['accounting-report/index'];
    public $searchLabel = 'Accounting Report';

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
        $query = AccountingReport::find()
            ->alias('ar')
            ->joinWith('user u')
            ->groupBy('ar.id');

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
            'ar.id' => $this->id,
            'ar.user_id' => $this->user_id,
            'ar.record_status' => $this->record_status,
            'ar.created_by' => $this->created_by,
            'ar.updated_by' => $this->updated_by,
            'ar.created_at' => $this->created_at,
            'ar.updated_at' => $this->updated_at,
        ]);
                
        $query->andFilterWhere(['or', 
            ['like', 'ar.name', $this->keywords],  
            ['like', 'ar.description', $this->keywords],  
        ]);

        $query->daterange($this->date_range);

        return $dataProvider;
    }
}