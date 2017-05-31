<?php

namespace app\modules\api\controllers;

use yii\rest\ActiveController;
use yii\filters\auth\HttpBearerAuth;
use app\models\User;

class UserController extends ActiveController
{
    public $modelClass = 'app\modules\api\models\APIUser';
	
	public function behaviors()
	{
		$behaviors = parent::behaviors();
		$behaviors['authenticator'] = [
			'class' => HttpBearerAuth::className(),
		];
		return $behaviors;
	}
	public function actions()
	{
		$actions = parent::actions();
		// disable the "index" actions
		unset($actions['index'],$actions['view']);
		return $actions;
	}
	
	/*
	 * Test action for user endpoint
	 */
	public function actionTest(){
		return ['hi'];
	}
	
	public function actionView($id){	
		echo \Yii::$app->user->id; die;
		User::findOne($id);
		echo $id;
	}
}