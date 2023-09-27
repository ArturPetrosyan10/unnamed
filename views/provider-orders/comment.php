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
    <div class="modal-dialog w-100" role="document">
        <div class="modal-content " style="border-radius:10px">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body d-flex flex-column align-items-center">
                <?php if(isset($get['not_confirmed'])) { ?>
                    <p class="">Link is not pressed!</p>
                    <button class="choosen_btn btn" data-dismiss="modal" aria-label="Close"> OK </button>
                <?php } ?>
                <p class="w-75"><?= @ProviderOrders::findOne($get['id'])->customer_comment; ?></p>
            </div>
        </div>
    </div>
</div>