<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "status".
 *
 * @property int $id
 * @property int $back_order_id
 * @property string|null $status
 * @property int $prov_order_id
 * @property TimestampBehavior created_at
 * @property TimestampBehavior updated_at
 * @property string currency
 * @property int remains
 * @property int start_count
 * @property int charge
 * @property int provider_id
 * @property int service_id
 * @property int refill
 */
class Status extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'status';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['back_order_id', 'prov_order_id'], 'required'],
            [['back_order_id', 'prov_order_id'], 'integer'],
            [['status'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'back_order_id' => 'Back Order ID',
            'status' => 'Status',
            'prov_order_id' => 'Prov Order ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'refill' => 'refill',
        ];
    }
}
