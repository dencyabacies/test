<?php

namespace app\controllers;

use Yii;
use app\models\Usertest;
use yii\rest\ActiveController;
use yii\filters\auth\HttpBearerAuth;
/**
 * UserController implements the CRUD actions for User model.
 */
class SampleController extends ActiveController
{
    /**
     * @inheritdoc
     */
	 
    public $modelClass = 'app\models\Usertest';
	
	public function init()
	{
		parent::init();
		\Yii::$app->user->enableSession = false;
	} 
	
	
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
	
	public function actionGetApiAllUser(){
	
		 
		 
	 
		$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => "http://localhost/powerbi/web/index.php/samples",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 30,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "GET",
			  CURLOPT_HTTPHEADER => array(
				"authorization: Bearer 4p9mj82PTl1BWSya7bfpU_Nm8u07hkcB",
				"cache-control: no-cache",
				"postman-token: 2da8ae06-80a7-2204-3e27-1b3ba00f6ae4"
			  ),
			));

			$response = curl_exec($curl);
			$err = curl_error($curl);

			curl_close($curl);

			if ($err) {
			  echo "cURL Error #:" . $err;
			} else {
			  echo $response;
			}
  
    }
	
	
}
