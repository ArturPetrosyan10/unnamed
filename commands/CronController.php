<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\models\Api;
use app\models\BoostServices;
use app\models\ProviderOrders;
use app\models\Providers;
use app\models\Status;
use yii\console\Controller;
use fedemotta\cronjob\models\CronJob;
use yii\console\ExitCode;


/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class CronController extends Controller
{
    public function actionIndex()
    {
//      start cron.bat  for start
        $resp = '';
        $filePath = '/var/www/html/commands/cron_response';
        $provs = Providers::find()
            ->asArray()->all();
        $api = new Api();
        foreach ($provs as $prov) {
            $i = 0;
            $api->api_url = $prov['name'];
            $api->api_key = $prov['api_key'];
            $services = $api->services();
            $check_old = BoostServices::find()
                ->select('service_id')
                ->where(['services_from' => $prov['name']])
                ->asArray()
                ->all();
            $check_old = array_column($check_old, 'service_id');
            foreach ($services as $service) {
                if (!in_array($service->service, $check_old)) {
                    $new_services = new BoostServices;
                    $new_services->service_id = intval($service->service);
                    $new_services->name = $service->name;
                    $new_services->type = $service->type;
                    $new_services->rate = $service->rate;
                    $new_services->min = $service->min;
                    $new_services->max = $service->max;
                    if (isset($service->dripfeed)) {
                        $new_services->dripfeed = $service->dripfeed ? 'true' : 'false';
                    } else {
                        $new_services->dripfeed = '';
                    }
                    $new_services->refill = intval($service->refill);
                    $new_services->cancel = $service->cancel ? 'true' : 'false';
                    $new_services->category = $service->category;
                    $new_services->subscription = $service->subscription ?? '';
                    $new_services->description = $service->description ?? '';
                    $new_services->services_from = $api->api_url ?? '';
                    if ($new_services->save(false) == false) {
                        var_dump($new_services->getErrors());
                    } else {
                        $i++;
                    }
                }
            }
            $resp .= 'createt ' . $i . ' from ' . count($services);
        }
        var_dump(file_put_contents($filePath, $resp, FILE_APPEND));
        $this->actionStatuss();
    }

    public function actionStatuss(){
        $resp = '';
        $filePath = '/var/www/html/commands/cron_response';
        $all_provs = Status::find()
            ->select('status.id,prov_order_id,back_order_id,service_id,providers.api_key,providers.name,providers.id as prov_id')
            ->where(['in','status.id',array_column(Status::find()
                ->select(['MAX(id) AS id'])
                ->groupBy('prov_order_id')
                ->asArray()
                ->all(),'id')])
            ->andWhere(['!=','status','Completed'])
            ->andWhere(['!=','status',''])
            ->andWhere(['!=','status','Canceled'])
            ->leftJoin('services','status.service_id = services.id')
            ->leftJoin('providers','providers.id = status.provider_id')
            ->asArray()
            ->all();
        $StatusResponse = [];
        $i = 0;
        foreach ($all_provs as $index => $all_prov) {
            $api = new Api();
            $api->api_key = $all_prov['api_key'];
            $api->api_url = $all_prov['name'];

            $StatusResponse[] = $api->status($all_prov['back_order_id']);
            if ($StatusResponse[$i]){
                $status = new Status();
                $status->prov_order_id = $all_prov['prov_order_id'];
                $status->back_order_id = $all_prov['back_order_id'];
                $status->status = $StatusResponse[$i]->status;
                $status->remains = $StatusResponse[$i]->status;
                $status->currency = $StatusResponse[$i]->currency;
                $status->updated_at = date('y-m-d H:i:s');
                $status->start_count = $StatusResponse[$i]->start_count;
                $status->charge = $StatusResponse[$i++]->charge;
                $status->provider_id = $all_prov['prov_order_id'];
                $status->service_id = $all_prov['service_id'];
                $status->save();
            }
            $provider_order = ProviderOrders::findOne($all_prov['prov_order_id']);
            $provider_order->status = $status->status;
            $resp .= 'created-'.$provider_order->save();
        }
        var_dump(file_put_contents($filePath, $resp, FILE_APPEND));
    }
}
