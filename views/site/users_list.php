<?php
    use app\models\User;

    $users = User::find()->orderBy('role')->all();
?>
<div class="card-body">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@getbootstrap">Create New Account</button>
    <table id="example2" class="table table-bordered table-hover   table-striped dataTable dtr-inline">
        <thead>
            <tr>
                <td>name</td>
                <td>lastname</td>
                <td>mail</td>
                <td>number</td>
                <td>role</td>
                <?php if (Yii::$app->user->identity->u_role_id == 1){ ?>
                    <td>settings</td>
                <?php } ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $index => $user) { ?>
                <tr>
                    <td><?= $user->username ?></td>
                    <td><?= $user->last_name ?></td>
                    <td><?= $user->email ?></td>
                    <td><?= $user->number ?></td>
                    <td><?= $user->getRole() ?></td>
                    <?php if (Yii::$app->user->identity->u_role_id == 1){ ?>
                        <td class="d-flex">
                            <a href="#" onclick="deleteUser(<?= $user->id ?>)" style="color:#dc3545!important" class=""><i class="fas fa-trash-alt "></i></a>
                            <a href="#" class="pl-2 modal_update_user" data-id="<?= $user->id ?>"><i class="fas fa-pencil-alt "></i></a>
                        </td>
                    <?php } ?>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
