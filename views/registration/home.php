<body onload="checkForm_Focus();">
  <br>  
  <div class="container">
    <div class="jumbotron">
      <h1>Welcome To Hinban Registration System</h1> 
      <div class="container-fluid">
       <h4>INSERT FILE : </h4>
       <div class="container-fluid" style="border-style: ; box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);">
        <div class="row" style="border-style: ">
          <div class="col-8" style="border-style: ">
            <!--form id="mainform"-->
              <div class="form-group row col-form-label">
                <label for="staticEmail" class="col-sm-3 col-form-label" id="kanji">工程</label>
                <div class="col-sm-6">
                  <div class="form-check form-check-inline col-form-label">
                    <input class="form-check-input" onclick="focusInput()" onchange="reload()" type="radio" name="category" id="categoryAssembly" value="ASSEMBLY" checked>
                    <label class="form-check-label" for="inlineRadio3">ASSEMBLY</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" onclick="focusInput()" onchange="reload()" type="radio" name="category" id="categoryPaint" value="PAINT">
                    <label class="form-check-label" for="inlineRadio3">PAINT</label> 
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" onclick="focusInput()" onchange="reload()" type="radio" name="category" id="categoryShip" value="SHIP">
                    <label class="form-check-label" for="inlineRadio3">SHIP</label> 
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <label for="staticEmail" class="col-sm-3 col-form-label" id="kanji" >入力</label>
                <div class="col-sm-6">
                  <input autocomplete="off" type="url" class="form-control" name="name" id="hinbaninput" onkeyup="loadDoc(this.value)" style="text-transform:uppercase; ime-mode: disabled;">
                </div>
              </div>
            <!--/form-->
          </div><!--COL-->
        </div> <!--ROW-->
        <p id="demo"></p>
      </div> <!--CONTAINER-->
    </div>
  </div>
</div>