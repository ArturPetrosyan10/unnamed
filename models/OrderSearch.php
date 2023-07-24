<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Order;

/**
 * OrderSearch represents the model behind the search form of `app\models\Order`.
 */
class OrderSearch extends Order
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'customer_id', 'status', 'product_main_id', 'employee_id', 'tilaa_id'], 'integer'],
            [['created_at', 'updated_at', 'customer_name', 'transaction_number', 'transaction_date', 'email'], 'safe'],
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
        $query = Order::find();

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
            'customer_id' => $this->customer_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'transaction_number' => $this->transaction_number,
            'transaction_date' => $this->transaction_date,
            'status' => $this->status,
            'product_main_id' => $this->product_main_id,
            'employee_id' => $this->employee_id,
            'tilaa_id' => $this->tilaa_id,
            'customer_mobile' => $this->customer_mobile,
            'customer_comment' => $this->customer_comment,
            'reference' => $this->reference,
            'description' => $this->description,
            'amount' => $this->amount,
        ]);

        $query->andFilterWhere(['like', 'customer_name', $this->customer_name])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'payload_link', $this->payload_link]);

        return $dataProvider;
    }
}
