<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Points;

/**
 * PointsSearch represents the model behind the search form about `app\models\Points`.
 */
class PointsSearch extends Points
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['point', 'user_id', 'event_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
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
        $query = Points::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'point' => $this->point,
            'user_id' => $this->user_id,
            'event_id' => $this->event_id,
        ]);

        return $dataProvider;
    }
}
