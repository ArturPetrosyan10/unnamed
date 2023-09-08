<?php

use app\models\BoostServices;
use app\models\Providers;
use app\models\Services;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\ServicesSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

//$this->title = 'Services';
//$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .pagination .page-item.disabled .page-link {
        pointer-events: none; /* Disable click events on disabled links */
        cursor: default; /* Show default cursor on disabled links */
        color: #868e96; /* Set text color for disabled links */
    }
    table tr td:last-child,th:last-child {
        border: 1px solid #dee2e6;
        min-width: 100px;
        padding: 0.5rem 0.5rem !important;
    }

</style>
<div class="services-index " style="padding:4% 3%">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#serviceModal" data-whatever="@getbootstrap">Create New Service</button>
    </p>

<!--    --><?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php $dataProvider->pagination->pageSize = 11; ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'service_name',
            'description:ntext',
            'created_at',
//            'price',
            [
                'attribute' => 'price',
                'label' => 'Price', // Default label
                'headerOptions' => ['class' => 'sorting'], // Default sorting class
                'contentOptions' => [], // Default content options
                'footerOptions' => [], // Default footer options
                'value' => function ($model) { return number_format($model->price,'4'); }, // Default value
            ],
            'def_provider'=> [
                'attribute' => 'def_provider',
                'label' => 'Default Provider',
                'headerOptions' => ['class' => 'sorting'], // Default sorting class
                'format' => 'raw',
                'value' => function($model) {
                    @$url = @parse_url(Providers::findOne($model->def_provider)->name);
                    return @$url['host'];
                }
            ],
            'def_service'=> [
                'attribute' => 'def_service',
                'label' => 'Default Service',
                'headerOptions' => ['class' => 'sorting'], // Default sorting class
                'format' => 'raw',
                'value' => function($model) {
                    $def_serv = BoostServices::findOne($model->def_service);
                    return  @$def_serv->service_id.' '.@$def_serv->name ?? '' ;
                }
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, $model, $key, $index, $column) {
                    if ($action === 'update') {
                        return Url::toRoute(['#', 'id' => $model->id]);
                    }
                    if ($action === 'view') {
                        return Url::toRoute(['#', 'id' => $model->id]);
                    }
                    else {
                        return Url::toRoute([$action, 'id' => $model->id]);
                    }
                },
                'buttons' => [
                    'update' => function ($url, $model, $key) {
                        return '<a class="update-service-modal" data-id="'.$model->id.'" style="cursor:pointer"><i class="fas fa-pencil-alt" aria-hidden="true"></i></a>';
                    },
                    'view' => function ($url, $model, $key) {
                        return '<a class="view-service-modal cursor-pointer" data-id="'.$model->id.'" style="cursor:pointer"><i class="fa fa-eye" aria-hidden="true"></i></a>';
                    },
                ],
            ],

        ],
        'pager' => [
            'options' => ['class' => 'pagination'], // Customize the CSS class for the pagination container
//            'prevPageLabel' => 'Previous', // Customize the "Previous" page label
//            'nextPageLabel' => 'Next', // Customize the "Next" page label
            'firstPageLabel' => 'First', // Customize the "First" page label
            'lastPageLabel' => 'Last', // Customize the "Last" page label
            'maxButtonCount' => 15, // Maximum number of page buttons to be displayed
            'linkContainerOptions' => ['class' => 'page-item'], // Customize the CSS class for the <li> elements
            'linkOptions' => ['class' => 'page-link'], // Customize the CSS class for the <a> elements
            'disabledListItemSubTagOptions' => ['tag' => 'a href="#" class="page-link"'], // Render disabled links as <a> tags
//            'disabledListItemSubTagClass' => 'page-link', // Set the class for disabled links
        ],
    ]); ?>
</div>


<?php
    if (!@$model){
        $model = new Services();
    }
?>
<?= $this->render('_form', [
    'model' => $model,
]) ?>
<!--    <table class="table table-striped table-bordered" style="display:none !important;">-->
<!--        <thead>-->
<!--            <tr>-->
<!--                <th>id</th>-->
<!--                <th>name</th>-->
<!--                <th>rate</th>-->
<!--                <th>min</th>-->
<!--                <th>max</th>-->
<!--                <th>Prov_Link</th>-->
<!--            </tr>-->
<!--        </thead>-->
        <?php
//        $boost = BoostServices::find()->where(['like','name','facebook'])
//            ->andWhere(['like','name','like'])
//            ->orderBy('rate','min','max')->asArray()->all();
//        foreach ($boost as $item) { ?>
<!--            <tr>-->
<!--                <td>--><?php //= $item['id'] ?><!--</td>-->
<!--                <td>--><?php //= $item['name'] ?><!--</td>-->
<!--                <td>--><?php //= $item['rate'] ?><!--</td>-->
<!--                <td>--><?php //= number_format($item['min']) ?><!--</td>-->
<!--                <td>--><?php //= number_format($item['max']) ?><!--</td>-->
<!--                <td>--><?php //= $item['services_from'] ?><!--</td>-->
<!--            </tr>-->
<!---->
<?php //  } ?>
<!--    </table>-->

