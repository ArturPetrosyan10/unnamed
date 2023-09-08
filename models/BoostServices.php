<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "boost_services".
 *
 * @property int $id
 * @property int $service_id
 * @property string|null $name
 * @property string $type
 * @property float $rate
 * @property float $min
 * @property float $max
 * @property string|null $dripfeed
 * @property int $refill
 * @property string|null $cancel
 * @property string $category
 * @property string|null $services_from
 * @property string $created_date
 * @property string $description
 * @property string $subscription
 */
class BoostServices extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'boost_services';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['service_id', 'type', 'rate', 'min', 'max', 'refill', 'category'], 'required'],
            [['service_id', 'refill'], 'integer'],
            [['rate', 'min', 'max'], 'number'],
            [['created_date'], 'safe'],
            [['name', 'type', 'cancel', 'category', 'services_from'], 'string', 'max' => 255],
            [['dripfeed'], 'string', 'max' => 25],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'service_id' => 'Service ID',
            'name' => 'Name',
            'type' => 'Type',
            'rate' => 'Rate',
            'min' => 'Min',
            'max' => 'Max',
            'dripfeed' => 'Dripfeed',
            'refill' => 'Refill',
            'cancel' => 'Cancel',
            'category' => 'Category',
            'services_from' => 'Services From',
            'created_date' => 'Created Date',
        ];
    }
}
