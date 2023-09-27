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
                <?php if($get['to_confirm'] == 0){ ?>
                    <label>Сancel payment confirmation?</label>
                <?php }else if ($get['to_confirm'] == 1){?>
                    <label>Confirm payment?</label>
                <?php } ?>
                <form action="<?= Yii::$app->urlManager->createUrl(['provider-orders/confirm-payment']) ?>" method="post" class="d-flex flex-column align-items-center w-100">
                    <input type="hidden" value="<?= $get['id'] ?>" name="id">

                    <?php if(!!$get['to_confirm']){ ?>
                        <input type="hidden" value="<?= 1 ?>" name="to_confirm">
                        <button  type="submit" class="btn choosen_btn">Confirm</button>
                    <?php }else if (!$get['to_confirm']){ ?>
                        <button  type="submit" class="btn choosen_btn">Cancel</button>
                    <?php } ?>

                </form>
            </div>
        </div>
    </div>
</div>