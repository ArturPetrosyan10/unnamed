<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\BoostServices;

/**
 * BoostServicesSearch represents the model behind the search form of `app\models\BoostServices`.
 */
class BoostServicesSearch extends BoostServices
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'service_id', 'refill'], 'integer'],
            [['name', 'type', 'dripfeed', 'cancel', 'category', 'services_from', 'created_date', 'description', 'subscription'], 'safe'],
            [['rate', 'min', 'max'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = BoostServices::find();
//        $query->where(['like','services_from','fastpanel']);
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'service_id' => $this->service_id,
            'rate' => $this->rate,
            'min' => $this->min,
            'max' => $this->max,
            'refill' => $this->refill,
            'created_date' => $this->created_date,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'dripfeed', $this->dripfeed])
            ->andFilterWhere(['like', 'cancel', $this->cancel])
            ->andFilterWhere(['like', 'category', $this->category])
            ->andFilterWhere(['like', 'services_from', $this->services_from])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'subscription', $this->subscription]);

        return $dataProvider;
    }
}
