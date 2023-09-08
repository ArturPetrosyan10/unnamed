<?php

namespace app\models;

use Yii;
use \app\models\ProviderOrders;

/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property int $customer_id
 * @property string $created_at
 * @property string $updated_at
 * @property string|null $customer_name
 * @property int|null $status
 * @property int|null $employee_id
 * @property int|null $tilda_id
 * @proderty int|null $payload_link
 * @property int|null $customer_mobile
 * @property int|null $description
 * @property int|null $customer_comment
 * @property int|null $reference
 * @property int|null $link
 * @property int|null $social_type
 * @property int|null $amount
 * @property int|null $currency
 * @property int|null $charge
 * @property int|null $sign
 * @property int|null $webhookId
 * @property int|null $transactionId
 * @property int|null $transactionStatus
 * @property int|null $customer_email
 * @property int|null $instaboost_quantity
 * @property string|null $origName
 * @property string|null $counts_checked
 *
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'required'],
            [['customer_id', 'status',  'employee_id', 'tilda_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['customer_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'customer_id' => 'Customer ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'customer_name' => 'Customer Name',
            'status' => 'Status',
            'customer_email' => 'Customer Email',
            'employee_id' => 'Employee ID',
            'tilda_id' => 'Tilda ID',
            'payload_link' => 'Payload Link',
            'customer_mobile' => 'Customer Mobile',
            'customer_comment' => 'Customer Comment',
            'description' => 'Description',
            'reference' => 'Reference',
            'social_type' => 'Social Type',
        ];
    }
    public function getProvider_orders() {
        return $this->hasMany(ProviderOrders::class, ['order_id' => 'id']);
    }
    public function deleteOrders($id){
        var_dump($id);
        $order =  Order::findOne($id);
        $order->delete();
        ProviderOrders::deleteAll(['order_id'=>$id]);
    }
}
