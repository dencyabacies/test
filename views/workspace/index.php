<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\Workspace */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Workspaces';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="workspace-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Workspace', ['powerbi/create-workspace'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'w_id',
            'workspace_name',
            'workspace_id',
            //'collection_id',
            'collection.collection_name'
            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
