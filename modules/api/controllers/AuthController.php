<?php

namespace app\modules\api\controllers;

use yii\rest\ActiveController;
use yii\filters\auth\HttpBasicAuth;

class AuthController extends ActiveController
{

    public $modelClass = 'app\models\APIUser';
	
	public function behaviors()
	{
		$behaviors = parent::behaviors();
		$behaviors['authenticator'] = [
			'class' => HttpBasicAuth::className(),
		];
		return $behaviors;
	}
}