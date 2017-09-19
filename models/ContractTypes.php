<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "contract_types".
 *
 * @property integer $id
 * @property integer $price
 * @property string $title
 */

class ContractTypes extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'contract_types';
    }
}
