<?php

namespace app\controllers;

use Yii;
use app\models\Dashboard;
use app\models\search\Dashboard as DashboardSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Workspace;
use app\models\Collection;
use app\models\DataModel;
use yii\web\UploadedFile;
/**
 * DashboardController implements the CRUD actions for Dashboard model.
 */
class DashboardController extends Controller
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
     * Lists all Dashboard models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DashboardSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Dashboard model.
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
     * Creates a new Dashboard model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        set_time_limit(0);
		$model = new Dashboard();
		$collections	= Collection::find()->all();
		$workspaces		= Workspace::find()->all();
		
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			
			$model->file = UploadedFile::getInstance($model, 'file');
			if ($model->upload() 
				//&& $model->save()
			) {
                // file is uploaded successfully
				$data = \moonland\phpexcel\Excel::import(\Yii::$app->basePath."/web/uploads/". $model->file->baseName . '.' . $model->file->extension, [
					'setFirstRecordAsKeys' => true, 
					'setIndexSheetByName' => true, 
				]);
				$tables = [];
				
				//**Naming convention check starts
				$checkTableName = $this->validateNamingConvention($data);		
				if ($checkTableName['status']=='error'){
					$model->addError("file",$checkTableName['msg']);
					return $this->render('create', [
					'model' => $model,
					'collections' => $collections,
					'workspaces' => $workspaces
					]);
				}
				//**Check Ends..

				foreach($data as $key=>$sheets){					
					$datamodel = new DataModel();
					$datamodel->model_name = $model->prefix."_".$key;					
					$tables[] = $datamodel->model_name;
					/*if(!isset($sheets[0])){
						$model->addError("file","Excel file requires atleast one sheet.");
						return $this->render('create', [
							'model' => $model,
							'collections' => $collections,
							'workspaces' => $workspaces
						]);
					}*/
					$headers = $sheets[0];
					$attributes = [];
					foreach($headers as $header=>$value){
						if($header!=''){
							if((strtolower($header) == 'id'))
								$attributes[] = ['field_name'=>$header,'field_type'=>'integer'];
							else $attributes[] = ['field_name'=>$header,'field_type'=>'text'];							
						}
					}
					
					$datamodel->attributes = serialize($attributes);					
					if(!empty($headers)&& $datamodel->save()){
						// save data too
						foreach($sheets as $header=>$data){
							foreach($data as $key=>$d){
								//eliminate the null keys
								if($key == '')
									unset($data[$key]);
							}
							$data['eq_customer_id'] = \Yii::$app->user->id;
							\Yii::$app->db->createCommand()
								->insert($datamodel->model_name, $data)->execute();
						}
					}
					$model->models = serialize($tables);
					$model->save();
				}
				return $this->redirect(['view', 'id' => $model->dashboard_id]);
            }						
            
        } else {
            return $this->render('create', [
                'model' => $model,
				'collections' => $collections,
				'workspaces' => $workspaces
            ]);
        }
    }
	
	public function actionCreateForm($id){
		$model = $this->findModel($id);
		$tablenames = unserialize($model->models);
		//print_R($fields);
		foreach($tablenames as $tablename){
			$tableSchema = \Yii::$app->db->getTableSchema($tablename);
			foreach ($tableSchema->columns as $column) {
				echo $column->name;
			}
		}
		echo "Test commit";
		die;
	}
    /**
     * Updates an existing Dashboard model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->dashboard_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Dashboard model.
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
     * Finds the Dashboard model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Dashboard the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Dashboard::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	/* @Name:validateNamingConvention
	** @Def: To check Naming Convention wrt MSSQL
	** convention will follow PascalCase
    ** @Created:22-May-2017	
	*/
	public function validateNamingConvention($data)
	{
		$errMsg = '';
		$model = new Dashboard();
		$result = array('status'=>'success','msg'=>'');
		foreach($data as $key=>$sheets){
			$datamodel = new DataModel();
			$datamodel->model_name = $model->prefix."_".$key;
			$tables[] = $datamodel->model_name;
			if(!isset($sheets[0])){
				$model->addError("file","Excel file requires atleast one sheet.");
				return $this->render('create', [
					'model' => $model,
					'collections' => $collections,
					'workspaces' => $workspaces
				]);
			}
			$headers = $sheets[0];
			$attributes = [];
			foreach($headers as $header=>$value){
				if($header!=''){
					if((strtolower($header) == 'id'))
						$attributes[] = ['field_name'=>$header,'field_type'=>'integer'];
					else $attributes[] = ['field_name'=>$header,'field_type'=>'text'];							
				}
			}					
			$attributes = serialize($attributes);
			//**Naming convention check starts ..sheet column
			$checkTableName = $this->checkNamingConvention($key,$datamodel->model_name,$attributes);
			if ($checkTableName['sheet']['status']=='error'){
				$errMsg.= "$key is not a valid SheetName, it should Alphabetic and Singular only."."\r\n";
			}
			if ($checkTableName['column']['status']=='error'){
				$errMsg.= "$key have invalid column: ".$checkTableName['column']['msg']." it should Alphabetic only."."\r\n";
			}
			//check ends..
		}
        if(!empty($errMsg)){
		   $result = array('status'=>'error','msg'=>$errMsg);
		}
		return $result;
	}
	
	/* @Name:checkNamingConvention
	** @Def: To check Naming Convention wrt MSSQL
	** convention will follow PascalCase
    ** @Created:22-May-2017	
	*/
	public function checkNamingConvention($sheetName,$tableName,$attributes)
	{
		$result['sheet'] = array('status'=>'success','msg'=>'');
		$result['column'] = array('status'=>'success','msg'=>'');
		if (preg_match('/[^a-zA-Z_]/',$tableName)){
		    //Not a valid Name			
			$result['sheet'] = array('status'=>'error','msg'=>$sheetName);
		}
		$lastChar = substr($tableName, -1);
		if ($lastChar=='s' || $lastChar=='S'){			
			$result['sheet'] = array('status'=>'error','msg'=>$sheetName);
		}
		//check column names;
		$attributes = unserialize($attributes);
		$invalidColumn = array();
		foreach($attributes as $attribute){
			$columnName = $attribute['field_name'];
			if (preg_match('/[^a-zA-Z_]/',$columnName)){
		        //Not a valid Name			    
				$invalidColumn[] = $columnName;		
		    }
		}
		if(count($invalidColumn)>0){
		   $strColumn = implode(",",$invalidColumn);
		   $result['column'] = array('status'=>'error','msg'=>$strColumn);
		}
		
		return $result;
	}
	
}
