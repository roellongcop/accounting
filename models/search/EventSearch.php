<?php

namespace app\models\search;

use yii\data\ActiveDataProvider;
use app\models\Event;
use app\helpers\App;

/**
 * EventSearch represents the model behind the search form of `app\models\Event`.
 */
class EventSearch extends Event
{
    public $keywords;
    public $date_range;
    public $pagination;

    public $searchTemplate = 'event/_search';
    public $searchAction = ['event/index'];
    public $searchLabel = 'Event';

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'created_by', 'updated_by', 'one_day'], 'integer'],
            [['name', 'description', 'start', 'end', 'slug', 'file_tokens', 'created_at', 'updated_at'], 'safe'],
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
        $query = Event::find()
            ->alias('e')
            ->joinWith('user u')
            ->groupBy('e.id');


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
            'e.id' => $this->id,
            'e.user_id' => $this->user_id,
            'e.record_status' => $this->record_status,
            'e.created_by' => $this->created_by,
            'e.updated_by' => $this->updated_by,
            'e.created_at' => $this->created_at,
            'e.updated_at' => $this->updated_at,
            'e.one_day' => $this->one_day,
        ]);
        
        $query->andFilterWhere(['or', 
            ['like', 'e.name', $this->keywords],  
            ['like', 'e.description', $this->keywords],  
        ]);

        $query->daterange($this->date_range);

        return $dataProvider;
    }
}