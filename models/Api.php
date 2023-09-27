<?php
namespace app\models;
class Api
{
    /** demo */
    //    public $api_url = 'https://demo.perfectpanel.com/api/v2';
    //    public $api_key = 'd36d6a4ae6493e70f61f605de38f9c75';

    /** first */
//        public $api_url = 'https://piarpanelpro.com/api/v2';  ++
//        public $api_key = '5b04d42a121900588ef1806b9795e122';
//+467 done
    /** second */
//        public  $api_url = 'https://bulkfollows.com/api/v2';  ++
//        public  $api_key = '2fcbddb824b9195a986fdb23c0e340bb';
// 4192 done // 82
    /** third */
//        public  $api_url = 'https://n1panel.com/api/v2';      ++
//        public  $api_key = '9cb8720a96af3c41ab944c0ef7d27137';
// 1014 done
    /** forth */
//        public  $api_url = 'https://www.smmraja.com/api/v3'; ++
//        public  $api_key = 'PdH)U*J*4u3E)2*4*X(m(H(C';
// 4813 done
    /** fivth */
//        public  $api_url = 'https://fastpanel.io/api/v2';
//        public  $api_key = '618e858f842bed176c3b1f97c4a7e343';
// 49 done
//10535  all -10733
    /** Add order */
    public function order($data)
    {
        $post = array_merge(['key' => $this->api_key, 'action' => 'add'], $data);
        return json_decode($this->connect($post));
    }

    /** Get order status  */
    public function status($order_id)
    {
        return json_decode(
            $this->connect([
                'key' => $this->api_key,
                'action' => 'status',
                'order' => $order_id
            ])
        );
    }

    /** Get orders status */
    public function multiStatus($order_ids)
    {
        return json_decode(
            $this->connect([
                'key' => $this->api_key,
                'action' => 'status',
                'orders' => implode(",", (array)$order_ids)
            ])
        );
    }

    /** Get services */

    public function services()
    {
        return json_decode(
            $this->connect([
                'key' => $this->api_key,
                'action' => 'services',
            ])
        );
    }

    /** Refill order */
    public function refill($orderId)
    {
        return json_decode(
            $this->connect([
                'key' => $this->api_key,
                'order' => $orderId,
                'action' => 'refill',
            ])
        );
    }

    /** Refill orders */
    public function multiRefill(array $orderIds)
    {
        return json_decode(
            $this->connect([
                'key' => $this->api_key,
                'orders' => implode(',', $orderIds),
            ]),
            true,
        );
    }

    /** Get refill status */
    public function refillStatus(int $refillId)
    {
        return json_decode(
            $this->connect([
                'key' => $this->api_key,
                'refill' => $refillId,
            ])
        );
    }

    /** Get refill statuses */
    public function multiRefillStatus(array $refillIds)
    {
        return json_decode(
            $this->connect([
                'key' => $this->api_key,
                'refills' => implode(',', $refillIds),
            ]),
            true,
        );
    }

    /** Get balance */
    public function balance()
    {
        return json_decode(
            $this->connect([
                'key' => $this->api_key,
                'action' => 'balance',
//                'action' => 'services',
            ])
        );
    }

    public function connect($post)
    {
        $_post = [];
        if (is_array($post)) {
            foreach ($post as $name => $value) {
                $_post[] = $name . '=' . urlencode($value);
            }
        }

        $ch = curl_init($this->api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        if (is_array($post)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, join('&', $_post));
        }
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        $result = curl_exec($ch);
        if (curl_errno($ch) != 0 && empty($result)) {
            $result = false;
        }
        curl_close($ch);
        return $result;
    }
}

// Examples
/*
$api = new Api();

$services = $api->services(); # Return all services

$balance = $api->balance(); # Return user balance

// Add order

$order = $api->order(['service' => 1, 'link' => 'http://example.com/test', 'quantity' => 100, 'runs' => 2, 'interval' => 5]); # Default

$order = $api->order(['service' => 1, 'link' => 'http://example.com/test', 'comments' => "good pic\ngreat photo\n:)\n;)"]); # Custom Comments

$order = $api->order(['service' => 1, 'link' => 'http://example.com/test', 'quantity' => 100, 'usernames' => "test, testing", 'hashtags' => "#goodphoto"]); # Mentions with Hashtags

$order = $api->order(['service' => 1, 'link' => 'http://example.com/test', 'usernames' => "test\nexample\nfb"]); # Mentions Custom List

$order = $api->order(['service' => 1, 'link' => 'http://example.com/test', 'quantity' => 100, 'hashtag' => "test"]); # Mentions Hashtag

$order = $api->order(['service' => 1, 'link' => 'http://example.com/test', 'quantity' => 1000, 'username' => "test"]); # Mentions User Followers

$order = $api->order(['service' => 1, 'link' => 'http://example.com/test', 'quantity' => 1000, 'media' => "http://example.com/p/Ds2kfEr24Dr"]); # Mentions Media Likers

$order = $api->order(['service' => 1, 'link' => 'http://example.com/test', 'quantity' => 1000, 'usernames' => "test"]); # Mentions

$order = $api->order(['service' => 1, 'link' => 'http://example.com/test']); # Package

// Old posts only
$order = $api->order(['service' => 1, 'username' => 'username', 'min' => 100, 'max' => 110, 'posts' => 0, 'delay' => 30, 'expiry' => '11/11/2022']); # Subscriptions

// Unlimited new posts and 5 old posts
$order = $api->order(['service' => 1, 'username' => 'username', 'min' => 100, 'max' => 110, 'old_posts' => 5, 'delay' => 30, 'expiry' => '11/11/2022']); # Subscriptions

$order = $api->order(['service' => 1, 'link' => 'http://example.com/test', 'quantity' => 100, 'answer_number' => '7']); # Poll

$order = $api->order(['service' => 1, 'link' => 'http://example.com/test', 'username' => 'username', 'comments' => "good pic\ngreat photo\n:)\n;)"]); # Comment Replies


$status = $api->status($order->order); # Return status, charge, remains, start count, currency

$statuses = $api->multiStatus([1, 2, 3]); # Return orders status, charge, remains, start count, currency
$refill = (array) $api->multiRefill([1, 2]);
$refillIds = array_column($refill, 'refill');
if ($refillIds) {
    $refillStatuses = $api->multiRefillStatus($refillIds);
}

}
*/