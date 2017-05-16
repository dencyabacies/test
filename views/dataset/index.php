<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\Dataset */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Datasets';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dataset-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Dataset', ['powerbi/create-dataset'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            's_id',
            'dataset_name',
            'dataset_id',
            //'workspace_id',
			'workspace.workspace_name',
            'datasource_id',
            // 'gateway_id',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
