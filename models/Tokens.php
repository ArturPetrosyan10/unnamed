<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tokens".
 *
 * @property int $id
 * @property string $name
 * @property string $token
 * @property string|null $description
 */
class Tokens extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tokens';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'token'], 'required'],
            [['description'], 'string'],
            [['name', 'token'], 'string', 'max' => 255],
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
            'token' => 'Token',
            'description' => 'Description',
        ];
    }

    public function check_key($post,$token){
        if(@$post['instaboost_sign']){
            //instaboost_sign = strtoupper(md5('token|instaboost_transactionId|instaboost_tildaOrderId|instaboost_transactionStatus'))
            return(strtoupper(md5(@$token.'|'.$post['instaboost_transactionId'].'|'.$post['instaboost_tildaOrderId'].'|'.$post['instaboost_transactionStatus'])) == @$post['instaboost_sign']);
        }
    }

}
