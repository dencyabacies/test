<?php

namespace app\controllers;

use Yii;
use app\models\Workspace;
use app\models\Collection;

class PowerbiController extends \yii\web\Controller
{
    public function actionConnect()
    {
		//test commit
        return $this->render('connect');
    }

    public function actionCreateWorkspace()
    {
                $workspace      = new Workspace();  
                $collections = Collection::find()->all();
                
		if($workspace->load(Yii::$app->request->post())){
                        $collection = Collection::findOne($workspace->collection_id);
			$end_url	='https://api.powerbi.com/v1.0/collections/';
                        $end_url        .= $collection->collection_name;
                        $end_url        .='/workspaces';
			$access_key	= $collection->AppKey;
			$params = "name={$workspace->workspace_name}";
                        //urlencode("name=test-lalith")
                        $response       = json_decode($this->doCurl($end_url,$access_key,$params,"application/x-www-form-urlencoded"));
                        print_r($response);die;
                       // print_r($response->error);die;
                        if(isset($response->error)){
                            //flash error message
                            Yii::$app->session->setFlash('some_error',  $response->error->message);
                            return $this->render('create-workspace',[
				'model'=>$workspace,
                                'collections' => $collections,
                            ]);
                        }
                        $workspace->workspace_id = $response->workspaceId;
			$workspace->save(false);

                        return $this->redirect(['workspace/index']);
		}
                
		else
		{
			return $this->render('create-workspace',[
				'model'=>$workspace,
                                'collections' => $collections,
			]);
		}
    }

    public function actionImport()
    {
        return $this->render('import');
    }

    public function actionReport()
    {
        return $this->render('report');
    }

    public function doCurl($end_url,$access_key,$params,$content_type){

        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => $end_url,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => $params,
          CURLOPT_HTTPHEADER => array(
            "authorization: AppKey ".$access_key,
            "content-type: {$content_type}",
          ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
       
        curl_close($curl);
        if ($err) {
          echo "cURL Error #:" . $err;
        } else {
          return $response;
        }
        
    }
}
