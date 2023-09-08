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
 * @property float $user_id
 * @property float $service_id
 * @property float $quantity
 * @property float $status
 * @property float $currency
 * @property float description
 * @property float customer_comment
 * @property float customer_mobile
 * @property float link
 */
class ProviderOrders extends \yii\db\ActiveRecord
{
    /**`
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
            [['order_id',], 'required'],
            [['id', 'order_id', 'client_id', 'provider_id'], 'integer'],
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
            'provider_id' => 'Provider ID',
            'price' => 'Price',
        ];
    }
    public function getService()
    {
        return Services::find()->where(['id' => $this->service_id])->one()['service_name'];
    }
    public function getProvider()
    {
        return Providers::find()->where(['id' => $this->provider_id])->one()['name'];
    }
}
