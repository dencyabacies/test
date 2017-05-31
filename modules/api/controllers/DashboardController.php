<?php

namespace app\modules\api\controllers;

use yii\rest\ActiveController;
use yii\filters\auth\HttpBearerAuth;

class DashboardController extends ActiveController
{
    public $modelClass = 'app\models\Dashboard';
	
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
		unset($actions['index']);
		return $actions;
	}
	
	/*
	 * Test action for user endpoint
	 */
	public function actionTest(){
		return ['hi'];
	}

}