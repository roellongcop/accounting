<?php

namespace app\models\search;

use yii\data\ActiveDataProvider;
use app\models\BirFilling;
use app\helpers\App;

/**
 * BirFillingSearch represents the model behind the search form of `app\models\BirFilling`.
 */
class BirFillingSearch extends BirFilling
{
    public $keywords;
    public $date_range;
    public $pagination;

    public $searchTemplate = 'bir-filling/_search';
    public $searchAction = ['bir-filling/index'];
    public $searchLabel = 'BIR Filling';

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
        $query = BirFilling::find()
            ->alias('bf')
            ->joinWith('user u')
            ->groupBy('bf.id');

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
            'bf.id' => $this->id,
            'bf.user_id' => $this->user_id,
            'bf.record_status' => $this->record_status,
            'bf.created_by' => $this->created_by,
            'bf.updated_by' => $this->updated_by,
            'bf.created_at' => $this->created_at,
            'bf.updated_at' => $this->updated_at,
        ]);
                
        $query->andFilterWhere(['or', 
            ['like', 'bf.name', $this->keywords],  
            ['like', 'bf.description', $this->keywords],  
        ]);

        $query->daterange($this->date_range);

        return $dataProvider;
    }
}