<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "providers".
 *
 * @property int $id
 * @property string $name
 * @property string|null $address
 * @property string|null $contact_person
 * @property string|null $email
 * @property string|null $phone
 */
class Providers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'providers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name', 'address'], 'string', 'max' => 255],
            [['contact_person', 'email'], 'string', 'max' => 100],
            [['phone'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'address' => 'Address',
            'contact_person' => 'Contact Person',
            'email' => 'Email',
            'phone' => 'Phone',
        ];
    }
}
