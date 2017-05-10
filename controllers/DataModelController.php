<?php

namespace app\controllers;

use Yii;
use app\models\DataModel;
use app\models\ImportForm;
use app\models\search\DataModel as DataModelSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * DataModelController implements the CRUD actions for DataModel model.
 */
class DataModelController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all DataModel models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DataModelSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DataModel model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new DataModel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DataModel();

        if ($model->load(Yii::$app->request->post())) {
			//print_r(Yii::$app->request->post());die;
			$model->attributes = serialize(Yii::$app->request->post()['fields']);
			$model->save();
			
            return $this->redirect(['view', 'id' => $model->m_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
	public function actionImport(){
		
		$model = new ImportForm();
		
		if ($model->load(Yii::$app->request->post())) {
			set_time_limit(0);
			$model->file = UploadedFile::getInstance($model, 'file');
			if ($model->upload()) {
                // file is uploaded successfully
				$data = \moonland\phpexcel\Excel::import(\Yii::$app->basePath."/web/uploads/". $model->file->baseName . '.' . $model->file->extension, [
					'setFirstRecordAsKeys' => true, 
					'setIndexSheetByName' => true, 
				]);
				foreach($data as $key=>$sheet){
					$datamodel = new DataModel();
					$datamodel->model_name = $model->prefix.$key;
					//$datamodel->prefix = $model->prefix;
					$headers = $sheet[0];
					$attributes = [];
					foreach($headers as $header=>$value){
						if((strtolower($header) != 'id') && $header!='')
							$attributes[] = ['field_name'=>$header,'field_type'=>'text'];
					}
					$datamodel->attributes = serialize($attributes);
					if($datamodel->save()){
						// save data too
					}
				}
				print_r($data);die;
                return;
            }
			//foreach sheet
			//{new datamodel, input sample data}
			
		}else{
            return $this->render('import', [
                'model' => $model,
            ]);
        }
			
	}
    /**
     * Updates an existing DataModel model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->m_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing DataModel model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the DataModel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DataModel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DataModel::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	public function actionTest(){
		$queryBuilder = new \yii\db\Migration();
		$queryBuilder->createTable('myTable', [
			'id' => 'pk',
			'myColumn' => 'integer',
			'myOtherColumn' => 'text'
		]);
	}
	
	public function actionAddData($id){
		
		$model = $this->findModel($id);
		$attributes = unserialize($model->attributes);
		if(\Yii::$app->request->post()){
			//save data
		}
		else
		return $this->render('add_data',[
			'attributes'=>$attributes,
			'model' => $model
		]);
		
	}
	
	public function actionAddForm($id){
		
		$model = $this->findModel($id);
		$attributes = unserialize($model->attributes);
		if(\Yii::$app->request->post()){
			//save data
		}
		else
		return $this->render('add_form',[
			'attributes'=>$attributes,
			'model' => $model
		]);
		
	}
}
