<?php

use app\models\Order;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<h1><?= Html::encode($this->title) ?></h1>
<p>
    <button type="button" class="btn btn-primary" id="modal-comment" data-toggle="modal" data-target="#commentModal" data-whatever="@getbootstrap">Comment</button>
</p>
<div class="modal fade" id="commentModal" tabindex="-1" role="dialog" aria-labelledby="commentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document d-flex flex-column align-items-center">
        <div class="modal-content " style="border-radius:20px">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body d-flex flex-column align-items-center">
                <form action="<?= Yii::$app->urlManager->createUrl(['provider-orders/delete']) ?>" method="post" class="d-flex flex-column align-items-center w-100">
                    <input type="hidden" value="<?= $get['id'] ?>" name="id">

                    <label>Are you sure you want to delete the order?</label>
                    <button  class="btn choosen_btn">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
