<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<h1><?= Html::encode($this->title) ?></h1>

<p>
    <button type="button" class="btn btn-primary" id="modal-update" data-toggle="modal" data-target="#updateModal" data-whatever="@getbootstrap">Update Account</button>
</p>
<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Update Account</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="user/update" method="post">
<!--                <form action="order/add-orders" method="post">-->
                    <div class="form-group field-user-username">
                        <label class="control-label" for="user-username">Username</label>
                        <input type="hidden" name="id" class="form-control" value="<?= $user->id ?>" id="id">
                        <input type="text" name="username" class="form-control" value="<?= $user->username ?>" id="user-username">
                    </div>
                    <div class="form-group field-user-last-name">
                        <label class="control-label" for="user-email">Last Name</label>
                        <input type="text" name="lastname" class="form-control" value="<?= $user->last_name ?>">
                    </div>
                    <div class="form-group field-user-email">
                        <label class="control-label" for="user-email">Email</label>
                        <input type="email" name="email" class="form-control" value="<?= $user->email ?>" id="email">
                    </div>
                    <div class="form-group field-user-number">
                        <label class="control-label" for="user-number">Number</label>
                        <input type="text" name="number" class="form-control" value="<?= $user->number ?>">
                    </div>
                    <div class="form-group field-user-password">
                        <label class="control-label" for="user-password">Password</label>
                        <input type="password" name="password" class="form-control" id="user-password" >
                    </div>

                    <div class="form-group field-user-password_repeat">
                        <label class="control-label" for="user-password_repeat">Password</label>
                        <input type="password" name="password_repeat" class="form-control" id="user-password_repeat">
                    </div>


                    <div class="form-group field-user-role">
                        <label class="control-label" for="user-role">Role</label>
                        <select class="form-control" name="role">
                            <?php
                            var_dump(Yii::$app->user->identity->u_role_id) ;
                            foreach ($rols as $index => $item) { ?>
                                <?php if(Yii::$app->user->identity->u_role_id == 5){  ?>
                                        <option  value="<?= $item->id ?>" <?= ($user->u_role_id == $item->id ? 'selected' : '')  ?>><?= $item->name ?></option>
                                <?php }else if(Yii::$app->user->identity->u_role_id == 1 && $item->id != 5){ ?>
                                        <option  value="<?= $item->id ?>" <?= ($user->u_role_id == $item->id ? 'selected' : '')  ?>><?= $item->name ?></option>
                                      <?php } ?>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <?= Html::submitButton('Update account', ['class' => 'btn btn-primary', 'name' => 'register-button']) ?>
                    </div>
                </form>
            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>