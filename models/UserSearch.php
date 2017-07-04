<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\Models\User;

/**
 * UserSearch represents the model behind the search form about `app\Models\User`.
 */
class UserSearch extends User
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'isAdmin'], 'integer'],
            [['name', 'email', 'password', 'photo', 'lastName', 'phone', 'birthDate', 'class', 'className'], 'safe'],
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
        $query = User::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
            'attributes' => [
                'className' => [
                    'asc' => ['school_class.name' => SORT_ASC],
                    'desc' => ['school_class.name' => SORT_DESC],
                    'label' => 'Класс'
                ]
            ]
        ]);

        if (!($this->load($params) && $this->validate())) {
            /**
             * Жадная загрузка данных модели Страны
             * для работы сортировки.
             */
            $query->joinWith(['class']);
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'isAdmin' => $this->isAdmin,
            'birthDate' => $this->birthDate,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'photo', $this->photo])
            ->andFilterWhere(['like', 'lastName', $this->lastName])
            ->andFilterWhere(['like', 'phone', $this->phone]);

        return $dataProvider;
    }
}
