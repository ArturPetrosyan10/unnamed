<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Services $model */

//$this->title = $model->id;
//$this->params['breadcrumbs'][] = ['label' => 'Services', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<button type="button" class="btn btn-primary" id="modal-view-service" data-toggle="modal" data-target="#updateModal" data-whatever="@getbootstrap">View Service</button>
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

                <div class="services-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'service_name',
            'description:ntext',
            'price',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>

                <div class="modal-footer"></div>
            </div>
        </div>
    </div>
</div>