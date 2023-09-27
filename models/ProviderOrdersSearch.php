<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ProviderOrders;

/**
 * ProviderOrdersSearch represents the model behind the search form of `app\models\ProviderOrders`.
 */
class ProviderOrdersSearch extends ProviderOrders
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'order_id', 'client_id',  'provider_id'], 'integer'],
            [['price'], 'number'],
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
        $query = ProviderOrders::find();
        $query->where(['!=','status','']);
        if(!isset($params['sort'])){
            $query->orderBy(['created_at' => SORT_DESC]);
        }

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
            'order_id' => $this->order_id,
            'client_id' => $this->client_id,
            'provider_id' => $this->provider_id,
            'price' => $this->price,
            'description' => $this->description,
            'status_paid' => $this->status_paid,
        ]);
        return $dataProvider;
    }
    public function prov_search($params){
        $pageSize = 20;
        $select = 'provider_orders.id,order.social_type,provider_orders.quantity
        ,provider_orders.created_at,provider_orders.order_id
        ,provider_orders.status_paid,provider_orders.description,provider_orders.service_id
        ,provider_orders.updated_at,provider_orders.customer_mobile,provider_orders.description
        ,order.customer_email,order.link,order.customer_comment,order.customer_name,order.counts_checked';
        $query = ProviderOrders::find();
        $query->select($select);

        if(isset($params['sorting']['about'])){
            $query->andWhere(['or',
                ['like','order.customer_name',$params['sorting']['about']],
                ['like','order.link',$params['sorting']['about']],
                ['like','provider_orders.description',$params['sorting']['about']]
            ]);
        }
        if(isset($params['sorting']['s_t'])){
            $query->andWhere(['like','social_type',$params['sorting']['s_t'][0]]);
        }
        if(isset($params['sorting']['date'])){
            $timestamp = strtotime($params['sorting']['date']);
            $params['sorting']['date'] = date("Y-m-d", $timestamp);

            $query->andWhere(['and',
                    ['<=','provider_orders.created_at',$params['sorting']['date'].' 23:59:59'],
                    ['>=','provider_orders.created_at',$params['sorting']['date'].' 00:00:00']
            ]);
        }
        if(isset($params['sorting']['status'])){
            $query->andWhere(['like','provider_orders.status',$params['sorting']['status']]);
        }
        if(isset($params['paging'])){
            $page = $params['paging'];
        }
        elseif (isset($params['swipe_page'])){
            $page = $params['swipe_page'];
        }
        else{
            $page = 1;
        }

        $query->leftJoin('order','provider_orders.order_id = order.id');
        $count = $query;
        $count = $count->all();
        $count = count($count);
        $offset = ($page-1) * $pageSize;
        if($offset){
            $query->offset($offset);
        }
        $query->limit($pageSize);

//        $query->groupBy('provider_orders.description');

        $query->orderBy([
            'provider_orders.created_at' => SORT_DESC,
            'provider_orders.id' => SORT_DESC
        ]);
        $query->asArray();
//        echo '<pre>';
//        var_dump($params);
//        var_dump($query->createCommand()->getRawSql());
//        die;
        $result = $query->all();
        return ['query'=>$result,'count'=> $count];

    }
}
