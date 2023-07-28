<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property int $customer_id
 * @property string $created_at
 * @property string $updated_at
 * @property string|null $customer_name
 * @property string|null $transaction_number
 * @property string|null $transaction_date
 * @property int|null $status
 * @property int|null $product_main_id
 * @property int|null $employee_id
 * @property int|null $tilla_id
 * @property int|null payload_link
 * @property int|null customer_mobile
 * @property int|null description
 * @property int|null customer_comment
 * @property int|null reference
 * @property int|null link
 * @property int|null social_type
 * @property int|null amount
 * @property int|null currency
 * @property int|null charge
 * @property int|null sign
 * @property int|null webhookId
 * @property int|null transactionId
 * @property int|null transactionStatus
 * @property int|null customer_email
 * @property int|null instaboost_quantity
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
            [['customer_id', 'status', 'product_main_id', 'employee_id', 'tilla_id'], 'integer'],
            [['created_at', 'updated_at', 'transaction_number', 'transaction_date'], 'safe'],
            [['customer_name'], 'string', 'max' => 100],
            [['customer_email'], 'string', 'max' => 255],
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
            'transaction_number' => 'Transaction Number',
            'transaction_date' => 'Transaction Date',
            'status' => 'Status',
            'customer_email' => 'Customer Email',
            'product_main_id' => 'Product Main ID',
            'employee_id' => 'Employee ID',
            'tilla_id' => 'Tilla ID',
            'payload_link' => 'Payload Link',
            'customer_mobile' => 'Customer Mobile',
            'customer_comment' => 'Customer Comment',
            'description' => 'Description',
            'reference' => 'Reference',
            'social_type' => 'Social Type',
        ];
    }
}
