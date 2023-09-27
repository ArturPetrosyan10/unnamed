<?php
namespace app\models;

use Yii;

/**
 * This is the model class for table "services".
 *
 * @property int $id
 * @property string $service_name
 * @property string|null $description
 * @property float|null $price
 * @property string $created_at
 * @property string $updated_at
 * @property string $def_provider
 * @property string $def_service
 * @property string def_boost_service
 * @property string service_id
 */
class Services extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'services';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['service_name'], 'required'],
            [['description'], 'string'],
            [['price'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['service_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()

    {
        return [
            'id' => 'ID',
            'service_name' => 'Service Name',
            'description' => 'Description',
            'price' => 'Price',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public static function getBalance($service_id)
    {
        $prov = Services::find()
            ->select('providers.balance,providers.id')
            ->where(['services.id' => $service_id])
            ->leftJoin('providers','services.def_provider = providers.id')
            ->asArray()
            ->one();
        return @$prov['balance'];
    }
    public static function getPrice($service_id)
    {
        $price = @(Services::findOne($service_id)->price);
        return @$price;
    }
}
