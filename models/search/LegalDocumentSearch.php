<?php

namespace app\models\search;

use yii\data\ActiveDataProvider;
use app\models\LegalDocument;
use app\helpers\App;

/**
 * LegalDocumentSearch represents the model behind the search form of `app\models\LegalDocument`.
 */
class LegalDocumentSearch extends LegalDocument
{
    public $keywords;
    public $date_range;
    public $pagination;

    public $searchTemplate = 'legal-document/_search';
    public $searchAction = ['legal-document/index'];
    public $searchLabel = 'Legal Document';

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
        $query = LegalDocument::find()
            ->alias('ld')
            ->joinWith('user u')
            ->groupBy('ld.id');

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
            'ld.id' => $this->id,
            'ld.user_id' => $this->user_id,
            'ld.record_status' => $this->record_status,
            'ld.created_by' => $this->created_by,
            'ld.updated_by' => $this->updated_by,
            'ld.created_at' => $this->created_at,
            'ld.updated_at' => $this->updated_at,
        ]);
                
        $query->andFilterWhere(['or', 
            ['like', 'ld.name', $this->keywords],  
            ['like', 'ld.description', $this->keywords],  
        ]);

        $query->daterange($this->date_range);

        return $dataProvider;
    }
}