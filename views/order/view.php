<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Order $model */

//$this->title = $model->customer_name;
//$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<button type="button" class="btn btn-primary" id="modal-view-order" data-toggle="modal" data-target="#updateModal" data-whatever="@getbootstrap">View Order</button>
<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">View Order</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">


                <div class="order-view">

                    <h1><?= Html::encode($this->title) ?></h1>

                    <?= DetailView::widget([
                        'model' => $model,
                        'options' => ['class' => 'table table-bordered table-hover table-striped'],
                        'attributes' => [
                            'id',
                            'customer_id',
                            'created_at',
                            'updated_at',
                            'customer_name',
                            'customer_mobile',
                            'status',
                            'email:email',
                            'product_main_id',
                            'employee_id',
                            'tilaa_id',
                        ],
                    ]) ?>

                </div>

                <div class="modal-footer"></div>
            </div>
        </div>
    </div>
</div>
