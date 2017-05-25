<?php 
use yii\helpers\Html;

$this->title = 'Form-Generator:'.$model->dashboard_name;
?>
<div class="container">
	<h1><?= Html::encode($this->title) ?></h1>
	
    <div class="tab col-md-2">
	
	<?php 
	$i=1;
	foreach($tables as $name=>$table){ ?>
      <button class="tablinks" onclick="openTab(event, '<?=$name?>')" id="<?php echo $i==1?"defaultOpen":""?>"><?=$name?></button>
    <?php $i++; } ?>
    </div>		
	


	<?php 
	$i=1;
	foreach($tables as $name=>$fields){ ?>
    <div class="demo tabcontent col-md-10" id="<?=$name?>">
	
      <div class="your-class col-md-12">
			<div class="form-group fn col-md-6">
			  <input class="input" placeholder="Form Name" type="text" >
			  <span class="underline"></span>
			</div>
			<div class="form-group cb col-md-6">
			  <input type="checkbox" id="visible" class="un-select" name="checkbox"/>
			  <label for="visible" class="check-box"></label>
			</div>

      </div>

      <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

        <div class="panel panel-default">
			<?php foreach($fields['attributes'] as $field){
			$tab_name = preg_replace('/\s+/', '', $name);
			$field_name = preg_replace('/\s+/', '', $field['field_name']);
			$identifier = "{$tab_name}_{$field_name}";	
			?>
			<div class="panel-heading" role="tab" id="header_<?=$identifier?>">
				<h4 class="panel-title">
				  <a role="button" data-toggle="collapse" data-parent="#accordion" href="#<?=$identifier?>" aria-expanded="true" aria-controls="<?=$identifier?>">
					<i class="more-less glyphicon glyphicon-plus"></i>
					<?= $field['field_name'] ?>
				  </a>
				</h4>
			</div>
		  
			<div id="<?=$identifier?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="header_<?=$identifier?>">
				<div class="panel-body">
					<div class="col-md-12">
						<div class="col-md-3">
						  <div class="form-group field-name">
							<label for="f-name">Field Name</label>
							<input type="text" class="form-control" id="id-fieldname">
						  </div>
						</div>
						<div class="col-md-3">
						  <select id="field" class="select-options" name="inputs">
							<option value="input-type">input-type</option>
							<option value="text-input">text-input</option>
							<option value="text-area">text-area</option>
							<option value="date-input">date-input</option>
							<option value="dropdown">dropdown</option>
							<option value="default-value">default-value</option>
							<option value="hidden">hidden</option>
							<option value="hidden-with">hidden-with</option>
						  </select>
						</div>
						<div class="col-md-3">
							
							<div class="form-group d-format">
							<label>Enter a date:</label>
							<input id="date" type="date">
							</div>
							
							<div class="dropdown column-dropdown">
							<button class="dropdown-toggle" type="button" data-toggle="dropdown">Dropdown
							  <span class="caret"></span></button>
							  <ul class="dropdown-menu">
								<li><a href="#">HTML</a></li>
								<li><a href="#">CSS</a></li>
								<li><a href="#">JavaScript</a></li>
							  </ul>
							</div>
							
							<div class="form-group default-value">
							  <label for="default-value">Default Value</label>
							  <input type="text" class="form-control" id="id-default-value">
							</div>

							<div class="form-group hidden-with">
							  <label for="hidden-with">Hidden With</label>
							  <input type="text" class="form-control" id="id-hidden-with">
							</div>
							
						</div>

					</div>

				</div>
			</div>
			<?php } ?>
        </div>


        </div><!-- panel-group -->

        <div class="save-btn">
          <button type="button" class="btn btn-info">Save</button>
        </div>
      </div><!-- demo -->

	<?php $i++; } ?>
      <div class="demo tabcontent col-md-10" id="table2">


      </div><!-- demo -->



</div><!--container-->

<script>
	function openTab(evt, cityName) {
	var i, tabcontent, tablinks;
	tabcontent = document.getElementsByClassName("tabcontent");
	for (i = 0; i < tabcontent.length; i++) {
	  tabcontent[i].style.display = "none";
	}
	tablinks = document.getElementsByClassName("tablinks");
	for (i = 0; i < tablinks.length; i++) {
	  tablinks[i].className = tablinks[i].className.replace(" active", "");
	}
	document.getElementById(cityName).style.display = "block";
	evt.currentTarget.className += " active";
	}

	// Get the element with id="defaultOpen" and click on it
	document.getElementById("defaultOpen").click();
</script>