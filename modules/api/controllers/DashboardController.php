<?php

namespace app\modules\api\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;
use yii\filters\auth\HttpBearerAuth;
use app\models\Dashboard as DashboardModel;

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
	 * Action for getting dashboards
	 * Params: $page.If null, first 10 results will be showed
	 * Returns Json
	 */
	Public function actionIndex($page=null){
        $query = DashboardModel::find();
		$dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' => [
				'pageSize' => '10',
				'page' => $page,
			],
        ]);
		return $dataProvider;
	}
	
	/*
	 * Action for getting single dashboard embed details
	 * Params: $id which is the dashboard id
	 * Returns Json
	 */
	Public function actionEmbed($id){
		//Return, array of collection name,access key, workspace id, report id
	}
}