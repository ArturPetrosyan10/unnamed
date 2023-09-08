<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "service_logs".
 *
 * @property int $id
 * @property int|null $user_id
 * @property string $updated
 * @property int|null $from_def_provider
 * @property int|null $from_def_service
 * @property int|null $to_def_provider
 * @property int|null $to_def_service
 * @property int|null $service_id
 */
class ServiceLogs extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'service_logs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'from_def_provider', 'from_def_service', 'service_id'], 'integer'],
            [['updated'], 'safe'],
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
            'from_def_provider' => 'From Def Provider',
            'from_def_service' => 'From Def Service',
            'service_id' => 'Service ID',
        ];
    }
}
