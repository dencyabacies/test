<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TestData */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="test-data-form">
<?php
    // 1. power bi access key
    $accesskey = "o7rSltTDXbKMlWlj3XhAf8KLjq1Tfprs3HDlhXG8En6qdxbvT+s8a4g8+z29p3vCA41ZgZg+qhjtmUvKdCCBJA==";

    // 2. construct input value
    $token1 = "{" .
      "\"typ\":\"JWT\"," .
      "\"alg\":\"HS256\"" .
      "}";
    $token2 = "{" .
      "\"wid\":\"37380bc1-dd47-4c95-8dbd-5efecafc8b26\"," . // workspace id
      "\"rid\":\"5a03df7e-09e3-475c-853d-e1379990437b\"," . // report id
      "\"wcn\":\"washington\"," . // workspace collection name
      "\"iss\":\"PowerBISDK\"," .
      "\"ver\":\"0.2.0\"," .
      "\"aud\":\"https://analysis.windows.net/powerbi/api\"," .
      "\"nbf\":" . date("U") . "," .
	  "\"username\":".\Yii::$app->user->id."," .
	  "\"roles\":\"customer_key\"," .
	  "\"exp\":" . date("U" , strtotime("+1 hour")) .
      "}";
    $inputval = rfc4648_base64_encode($token1) .
      "." .
      rfc4648_base64_encode($token2);

    // 3. get encoded signature value
    $hash = hash_hmac("sha256",
        $inputval,
        $accesskey,
        true);
    $sig = rfc4648_base64_encode($hash);

    // 4. get apptoken
    $apptoken = $inputval . "." . $sig;

    // helper functions
    function rfc4648_base64_encode($arg) {
      $res = $arg;
      $res = base64_encode($res);
      $res = str_replace("/", "_", $res);
      $res = str_replace("+", "-", $res);
      $res = rtrim($res, "=");
      return $res;
    }
    ?>



<div id="reportContainer"  style="height:530px"></div>
    <script src="http://localhost/powerbi/web/js/node_modules/powerbi-client/dist/powerbi.min.js"></script>
    <script>
        (function () {
			var models = window['powerbi-client'].models;
 			//console.log(models);
            var embedToken = '<?=$apptoken?>';
            var reportId = '5a03df7e-09e3-475c-853d-e1379990437b';
            var embedUrl = 'https://embedded.powerbi.com/appTokenReportEmbed?reportId' + reportId;
			var $defaultPageReportContainer = $('#reportContainer');
			
/* 			var defaultFilter =  models.AdvancedFilter({
				  table: "customer_Risk",
				  column: "eq_id"
				}, "And", [
				  {
					operator: "In",
					values: [1]
				  }
				]); */
			var advancedFilter = new window['powerbi-client'].models.AdvancedFilter ({
				  table: "customer_Risk",
				  column: "eq_customer_id"
				}, "And", [
				  {
					operator: "Is",
					value: "<?=\Yii::$app->user->id?>"
				  },
				
				]);
			var advancedFilter1 = new window['powerbi-client'].models.AdvancedFilter ({
				  table: "customer_Budget",
				  column: "eq_customer_id"
				}, "And", [
				  {
					operator: "Is",
					value: "<?=\Yii::$app->user->id?>"
				  },
				
				]);
			var advancedFilter2 = new window['powerbi-client'].models.AdvancedFilter ({
				  table: "customer_MockupHeatmap",
				  column: "eq_customer_id"
				}, "And", [
				  {
					operator: "Is",
					value: "<?=\Yii::$app->user->id?>"
				  },
				
				]);
			//var advancedFilter1= new window['powerbi-client'].models.AdvancedFilter ();
			var defaultFilters = [advancedFilter,advancedFilter1,advancedFilter2];
		  
            var config = {
                type: 'report',
                accessToken: embedToken,
                embedUrl: embedUrl,
                id: reportId,
				//filters: defaultFilters,
				//oDataFilter: "customer_Budget/eq_customer_id eq '1'",
                settings: {
                    filterPaneEnabled: false,
                    navContentPaneEnabled: false
                }
            };

             powerbi.embed(document.getElementById('reportContainer'), config);

		
		})();
    </script>


