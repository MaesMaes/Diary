<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Incoming;

/**
 * IncomingSearch represents the model behind the search form about `app\models\Incoming`.
 */
class IncomingSearch extends Incoming
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['incomingID', 'childName', 'subject', 'sum', 'checkingAccount'], 'integer'],
            [['description', 'parentName'], 'safe'],
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
        $query = Incoming::find();

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
            'incomingID' => $this->incomingID,
            'childName' => $this->childName,
            'subject' => $this->subject,
            'sum' => $this->sum,
            'checkingAccount' => $this->checkingAccount,
        ]);

        $query->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'parentName', $this->parentName]);

        return $dataProvider;
    }
}
