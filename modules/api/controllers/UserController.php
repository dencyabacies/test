<?php

namespace app\modules\api\controllers;

use yii\rest\ActiveController;
use yii\filters\auth\HttpBearerAuth;
use app\models\User;
use app\models\Customer;


class UserController extends ActiveController
{
    public $modelClass = 'app\models\User';
	
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
		unset($actions['index'],$actions['view'],$actions['delete'],$actions['update'],$actions['create']);
		return $actions;
	}
	
	/*
	 * Test action for user endpoint
	 */
	public function actionTest(){
		return ['hi'];
	}

	public function actionViewUser(){		
		$model = User::findOne(\Yii::$app->user->id);	 
		if($model)
	    {
			$datas = [
			'username'=>$model->username,
			'email'	 =>$model->email,
			'role'	 =>$model->role,
			];  
		
		   return $datas;
		}  
		else { return ['Error' => $model->getErrors()];	}   
	} 
	
	public function actionDeleteUser(){				
		$model = User::findOne(\Yii::$app->user->id);							
		  if($model->delete())
		  {
			$customer = Customer::find()->where(['eq_customer_id'=>\Yii::$app->user->id])->one();
			if($customer->delete())
			  return ['Success'];	
		  }		  
		 else { return ['Error' => $model->getErrors()]; }
	}
	
	public function actionUpdateUser(){				
		$model = User::findOne(\Yii::$app->user->id);
		$customer = Customer::find()->where(['eq_customer_id'=>\Yii::$app->user->id])->one();		
		$model->email = $_POST['email'];
			if($model->save())
			{
			  $customer->updated_at = date("Y-m-d H:i:s");
			  if($customer->save())
				return ['Success'];			  
			} 	
			else { return ['Error' => $model->getErrors()]; }
	}	

}