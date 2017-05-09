<?php

namespace app\controllers;

class PowerbiController extends \yii\web\Controller
{
    public function actionConnect()
    {
		//test commit
        return $this->render('connect');
    }

    public function actionCreateWorkspace()
    {
        return $this->render('create-workspace');
    }

    public function actionImport()
    {
        return $this->render('import');
    }

    public function actionReport()
    {
        return $this->render('report');
    }

	public function doCurl(){
		
	}
}
