<?php

namespace app\models\search;

use yii\data\ActiveDataProvider;
use app\models\InvoiceLog;
use app\helpers\App;

/**
 * InvoiceLogSearch represents the model behind the search form of `app\models\InvoiceLog`.
 */
class InvoiceLogSearch extends InvoiceLog
{
    public $keywords;
    public $date_range;
    public $pagination;

    public $searchTemplate = 'invoice-log/_search';
    public $searchAction = ['invoice-log/index'];
    public $searchLabel = 'InvoiceLog';

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status', 'type', 'created_by', 'updated_by'], 'integer'],
            [['remarks', 'created_at', 'updated_at'], 'safe'],
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
        $query = InvoiceLog::find();

        // add conditions that should always apply here
        $this->load($params);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
            'pagination' => [
                'pageSize' => $this->pagination
            ]
        ]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'type' => $this->type,
            'record_status' => $this->record_status,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);
        
        $query->andFilterWhere(['like', 'remarks', $this->remarks]);
        
                
        $query->andFilterWhere(['or', 
            ['like', 'type', $this->keywords],  
            ['like', 'remarks', $this->keywords],  
        ]);

        $query->daterange($this->date_range);

        return $dataProvider;
    }
}