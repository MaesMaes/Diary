<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "contracts".
 *
 * @property integer $id
 * @property integer $type_id
 * @property integer $client_id
 * @property integer $child_id
 * @property string $datetime
 * @property string $note
 * @property boolean $is_stopped
 */

class Contracts extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'contracts';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'client' => 'Клиент',
            'child' => 'Учащийся',
            'contractType' => 'Тип контракта',
            'datetime' => 'Дата заключения контракта',
            'note' => 'Заметки',
            'type_id' => 'Тип контракта',
            'client_id' => 'Клиент',
            'child_id' => 'Учащийся',
            'is_stopped' => 'Приостановлен'
        ];
    }

    /**
     * Возвращает клиента, с которым заключен договор
     */
    public function getClient() {
        return $this->hasOne(User::className(), ['id' => 'client_id']);
    }


    /**
     * Возвращает ребёнка, по которому заключен договор
     */
    public function getChild() {
        return $this->hasOne(User::className(), ['id' => 'child_id']);
    }


    /**
     * Возвращает тип контакта
     */
    public function getContractType() {
        return $this->hasOne(ContractTypes::className(), ['id' => 'type_id']);

    }
}
