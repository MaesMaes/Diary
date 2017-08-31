<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * UserSearch represents the model behind the search form about `app\Models\User`.
 */
class UserSearch extends User
{
    public $className;
    public $role;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'isAdmin', ], 'integer'],
            [['role'], 'safe'],
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

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->joinWith(['class']);


        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        if($this->role){
            $query->join('LEFT JOIN','auth_assignment','auth_assignment.user_id = user.id')
                ->andFilterWhere(['auth_assignment.item_name' => $this->role]);
        }

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'photo', $this->photo])
            ->andFilterWhere(['like', 'lastName', $this->lastName])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'school_class.name', $this->className]);

        return $dataProvider;
    }
}
