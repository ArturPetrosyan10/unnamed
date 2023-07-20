<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property int $user_id
 * @property string $created_at
 * @property string $updated_at
 * @property string|null $name
 * @property string|null $transaction_number
 * @property string|null $transaction_date
 * @property int|null $status
 * @property string|null $email
 * @property int|null $product_main_id
 * @property int|null $employee_id
 * @property int|null $tilaa_id
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
            [['user_id', 'created_at', 'updated_at'], 'required'],
            [['user_id', 'status', 'product_main_id', 'employee_id', 'tilaa_id'], 'integer'],
            [['created_at', 'updated_at', 'transaction_number', 'transaction_date'], 'safe'],
            [['name'], 'string', 'max' => 100],
            [['email'], 'string', 'max' => 255],
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
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'name' => 'Name',
            'transaction_number' => 'Transaction Number',
            'transaction_date' => 'Transaction Date',
            'status' => 'Status',
            'email' => 'Email',
            'product_main_id' => 'Product Main ID',
            'employee_id' => 'Employee ID',
            'tilaa_id' => 'Tilaa ID',
        ];
    }
}
