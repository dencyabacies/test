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

	public function actionViewUser($id){		
		$model = User::findOne($id);	 
		if(($model) && ($model->access_token  == \Yii::$app->user->identity->access_token))
		   return $model;
		else {  return ['Error' => $model->getErrors()];	}   
	} 
	
	public function actionDeleteUser($id){				
		$model = User::findOne($id);		
		if(($model) && ($model->access_token  == \Yii::$app->user->identity->access_token))
		{			
		  $model->delete();
 		  $customer = Customer::find()->where(['eq_customer_id'=>$id])->one();
		  $customer->delete(); 
		  return ['Success'];		  
		} else { return ['Error' => $model->getErrors()];	}
	}
	
	public function actionUpdateUser($id){				
		$model = User::findOne($id);
		$customer = Customer::find()->where(['eq_customer_id'=>$id])->one();		
		if(($model) && ($model->access_token  == \Yii::$app->user->identity->access_token))
		{			
			$model->username = $_POST['username'];
			$model->email = $_POST['email'];
			$model->role = $_POST['role'];
			if($model->save())
			{
			  $customer->updated_at = date("Y-m-d H:i:s");
			  $customer->save();
			  return ['Success'];			  
			} 	
			 return ['Error' => $model->getErrors()];
		} else {  return ['Error' => $model->getErrors()];	}
	}	

}