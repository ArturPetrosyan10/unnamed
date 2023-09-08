<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "provider_counts".
 *
 * @property int $id
 * @property int|null $order_id
 * @property string|null $name
 * @property int|null $follows
 * @property int|null $post_share
 * @property int|null $likes
 * @property int|null $comments
 * @property int|null $played
 * @property int|null $video_likes
 * @property int|null $shareCount
 * @property int|null $app_type
 * @property int|null $videos_count
 */
class ProviderCounts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'provider_counts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_id', 'follows', 'likes', 'comments', 'played'], 'integer'],
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
            'name' => 'Name',
            'follows' => 'Follows',
            'likes' => 'Likes',
            'comments' => 'Comments',
            'played' => 'Played',
            'app_type' => 'App Type',
            'videos_count' => 'Videos Count',
            'post_share' => 'Shares Count',
        ];
    }
}
