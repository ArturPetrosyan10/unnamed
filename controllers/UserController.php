<?php

namespace app\controllers;

use app\models\Rols;
use app\models\User;
use Yii;

class UserController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;

    public function beforeAction($action)
    {
        if ($action->id == 'your-action') {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionDelete(){
        if(\Yii::$app->request->get('user_id')) {
            $id = \Yii::$app->request->get('user_id');
            if (\Yii::$app->user->identity->u_role_id == 1 || \Yii::$app->user->identity->u_role_id == 5) {
                $user = User::findOne($id);
                if ($user) {
                    $user->delete();
                }
            }
        }
    }
    public function actionUpdate(){
        if(\Yii::$app->request->get('user_id')) {
            $id = \Yii::$app->request->get('user_id');
            if (\Yii::$app->user->identity->u_role_id == 1 || \Yii::$app->user->identity->u_role_id == 5) {
                $user = User::findOne($id);
                $rols = Rols::find()->all();
                return $this->renderAjax('update', ['user' => $user,'rols' => $rols]);
            }
        }if(\Yii::$app->request->post()){
            $post = \Yii::$app->request->post();
            $model = User::find()->where(['id'=>$post['id']])->one();
            $model->username = $post['username'];
            $model->last_name = $post['lastname'];
            $model->email = $post['email'];
            $model->number = $post['number'];
            $model->role = $post['role'];
            $model->updated_at = date('Y-m-d H:i:s');
            if(isset($post['password']) && !empty($post['password'])){
                $model->password = Yii::$app->security->generatePasswordHash($post['password']);
            }
            $model->save();
            Yii::$app->session->setFlash('success', 'Updated successful! You can now login.');
            return $this->redirect('/register');
        }
    }
    public function actionCheckUsername ()
    {
        if($_GET['username']){
            $id = $_GET['id'] ?? false;
            $user =  User::findOne(['username' => $_GET['username']]);
            if($user && $user->id != $id){
                $err_message = '<span style="color:red">The name is already exist</span>';
                return $err_message;
            }else{
                return false;
            }
        }
    }


}
