<?php

namespace app\controllers;

use Yii;
use app\models\Workspace;
use app\models\Collection;
use app\models\Dataset;
use yii\web\UploadedFile;

class AuthController extends \yii\web\Controller
{
	
	public $modelClass = 'app\models\User';
}