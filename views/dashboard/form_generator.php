  <div class="container">

    <div class="tab col-md-2">
      <button class="tablinks" onclick="openCity(event, 'table1')" id="defaultOpen">Table 1</button>
      <button class="tablinks" onclick="openCity(event, 'table2')">Table 2</button>
    </div>


    <div class="demo tabcontent col-md-10" id="table1">

      <div class="your-class col-md-12">

        <div class="form-group fn col-md-6">
          <input class="input" placeholder="Form Name" type="text" >
          <span class="underline"></span>
        </div>

        <div class="form-group cb col-md-6">

          <input type="checkbox" id="visible" class="un-select" name="checkbox"/>
          <label for="visible" class="check-box"></label>
          
          <!-- <label for="default-value">Checkbox</label>
          <input name="checkbox" id="visible" type="checkbox" class="un-select" />  -->
        </div>

      </div>


      <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

        <div class="panel panel-default">
          <div class="panel-heading" role="tab" id="headingOne">
            <h4 class="panel-title">
              <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                <i class="more-less glyphicon glyphicon-plus"></i>
                Field #1
              </a>
            </h4>
          </div>
          <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
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
          </div>

          <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingTwo">
              <h4 class="panel-title">
                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                  <i class="more-less glyphicon glyphicon-plus"></i>
                  Field #2
                </a>
              </h4>
            </div>
            <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
              <div class="panel-body">
                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
              </div>
            </div>
          </div>

          <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingThree">
              <h4 class="panel-title">
                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                  <i class="more-less glyphicon glyphicon-plus"></i>
                  Field #3
                </a>
              </h4>
            </div>
            <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
              <div class="panel-body">
                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
              </div>
            </div>
          </div>

        </div><!-- panel-group -->

        <div class="save-btn">
          <button type="button" class="btn btn-info">Save</button>
        </div>
      </div><!-- demo -->


      <div class="demo tabcontent col-md-10" id="table2">


      </div><!-- demo -->



    </div><!--container-->
    <script>
      function openCity(evt, cityName) {
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