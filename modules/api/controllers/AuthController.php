<?php

namespace app\modules\api\controllers;

use yii\rest\ActiveController;

class AuthController extends ActiveController
{
    public $modelClass = 'app\models\User';
}