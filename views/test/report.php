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
    $accesskey = "K+9mg/Lv0aXgSEfAPo7hJxZ0Pg1Y4zSWM6jsEntdYP66hREZQo+873W6v5CRLUYrjwlHOXJCE8zR1Hwq4nHRog==";

    // 2. construct input value
    $token1 = "{" .
      "\"typ\":\"JWT\"," .
      "\"alg\":\"HS256\"" .
      "}";
    $token2 = "{" .
      "\"wid\":\"6e746957-8e57-41de-a5e3-204bf3d0dbd5\"," . // workspace id
      "\"rid\":\"d6b73aa4-aef9-4256-a51a-824072b73b21\"," . // report id
      "\"wcn\":\"kevindanel\"," . // workspace collection name
      "\"iss\":\"PowerBISDK\"," .
      "\"ver\":\"0.2.0\"," .
      "\"aud\":\"https://analysis.windows.net/powerbi/api\"," .
      "\"nbf\":" . date("U") . "," .
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

      <button id="btnView">View Report !</button>
      <div id="divView">
        <iframe id="ifrTile" width="100%" height="800"></iframe>
      </div>
	</div>
      <script>
        (function () {
          document.getElementById('btnView').onclick = function() {
            var iframe = document.getElementById('ifrTile');
            iframe.src = 'https://embedded.powerbi.com/appTokenReportEmbed?reportId=d6b73aa4-aef9-4256-a51a-824072b73b21';
            iframe.onload = function() {
              var msgJson = {
                action: "loadReport",
                accessToken: "<?=$apptoken?>",
                height: 500,
                width: 722
              };
              var msgTxt = JSON.stringify(msgJson);
              iframe.contentWindow.postMessage(msgTxt, "*");
            };
          };
        }());
      </script>
