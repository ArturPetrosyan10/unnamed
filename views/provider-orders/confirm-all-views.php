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
    <div class="modal-dialog" role="document">
        <div class="modal-content " style="border-radius:10px">
            <div class="modal-header">
                <div class="d-flex flex-column">

                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body d-flex justify-content-center">
                <input type="hidden" class="hidden_value" value="<?= $get ?>">
                <button  class="btn choosen_btn confirm_modal_link">Confirm</button>
            </div>
        </div>
    </div>
</div>
