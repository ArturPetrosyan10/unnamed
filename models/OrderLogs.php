<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "order_logs".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $updated
 * @property int|null $order_id
 * @property int|null $prov_order_id
 * @property string|null $from_link
 * @property string|null $to_link
 * @property int|null $from_service
 * @property int|null $to_service
 * @property float|null $from_quantity
 * @property float|null $to_quantity
 */
class OrderLogs extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order_logs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'updated', 'order_id', 'from_service', 'to_service'], 'integer'],
            [['from_quantity', 'to_quantity'], 'number'],
            [['from_link', 'to_link'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'updated' => 'Updated',
            'order_id' => 'Order ID',
            'from_link' => 'From Link',
            'to_link' => 'To Link',
            'from_service' => 'From Service',
            'to_service' => 'To Service',
            'from_quantity' => 'From Quantity',
            'to_quantity' => 'To Quantity',
        ];
    }
}
