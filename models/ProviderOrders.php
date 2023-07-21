<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "provider_orders".
 *
 * @property int $id
 * @property int $order_id
 * @property int $client_id
 * @property int $provider_product_id
 * @property int $provider_id
 * @property float $price
 */
class ProviderOrders extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'provider_orders';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'order_id', 'client_id', 'provider_product_id', 'provider_id', 'price'], 'required'],
            [['id', 'order_id', 'client_id', 'provider_product_id', 'provider_id'], 'integer'],
            [['price'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'Order ID',
            'client_id' => 'Client ID',
            'provider_product_id' => 'Provider Product ID',
            'provider_id' => 'Provider ID',
            'price' => 'Price',
        ];
    }
}
