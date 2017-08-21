<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Marks;

/**
 * MarksSearch represents the model behind the search form about `app\models\Marks`.
 */
class MarksSearch extends Marks
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'eventID', 'test', 'test_theme', 'test_lesson', 'lights', 'active'], 'integer'],
            [['pupilID'], 'safe'],
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
        $query = Marks::find();

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
            'id' => $this->id,
            'eventID' => $this->eventID,
            'test' => $this->test,
            'test_theme' => $this->test_theme,
            'test_lesson' => $this->test_lesson,
            'lights' => $this->lights,
            'active' => $this->active,
        ]);

        $query->andFilterWhere(['like', 'pupilID', $this->pupilID]);

        return $dataProvider;
    }
}
