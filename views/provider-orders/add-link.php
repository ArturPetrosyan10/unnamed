<?php

use app\models\Order;
use app\models\ProviderOrders;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<h1><?= Html::encode($this->title) ?></h1>
<p>
    <button type="button" class="btn btn-primary" id="modal-comment" data-toggle="modal" data-target="#commentModal" data-whatever="@getbootstrap">Comment</button>
</p>
<div class="modal fade" id="commentModal" tabindex="-1" role="dialog" aria-labelledby="commentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" >
        <div class="modal-content " style="border-radius:10px">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body d-flex functional-buttons align-items-center" >
                <input data-id="<?= $get['id'] ?>" type="text" class="form-control w-75" value="<?= (ProviderOrders::findOne($get['id'])->link) ?? ''; ?>" disabled>
                <button type="button" class=" btn start-add" style="margin-left:10px;"><img src="/img/Pencil.png"></button>
                <img src="/img/Group 251.png"  class="d-none add_new_link" style="margin-left:10px;cursor:pointer" data-dismiss="modal" aria-label="Close">
            </div>
        </div>
    </div>
</div>
