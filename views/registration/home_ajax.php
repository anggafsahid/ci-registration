<meta name="viewport" content="width=device-width, initial-scale=1">
<title>title</title>
<?php
  $timestamp=time();
//VARIABLE READER
  $hinban=$_GET['hinban'];
  $hinban=mb_convert_kana($hinban, "askh");
  $hinban=strtoupper($hinban);
  
  $pattern = '/(\'|")/'; $replacement = ""; $hinban = preg_replace($pattern, $replacement, $hinban);
  $pattern = '/(\.|,)/'; $replacement = "-"; $hinban = preg_replace($pattern, $replacement, $hinban);
  $category=$_GET['category'];
  $dataexist=null;

  $property=null;
  $pdfcodepro="PRO_";
  $pdfcodedra="DRA_";
  $pdfcodepac="PAC_";
//CHECK CATEGORY PATH
  if  ($category=="ASSEMBLY")
      {$categorypath="ASS_";$categorycode=4;}
  else if($category=="PAINT")
      {$categorypath="PAI_";$categorycode=3;}
  else if($category=="SHIP")
      {$categorypath="SHP_";$categorycode=99;}  
//PATH DEFINED
  $imagepath ="assets/usr/kanban/$categorypath/";
  $pdfpathpro="assets/usr/pdf/procedure/$categorypath/";
  $pdfpathdra="assets/usr/pdf/drawing/ALL_/"; // PDF Drawing will has common pdf file for all process
  $pdfpathpac="assets/usr/pdf/packing/$categorypath/";
//IMAGE NAME SIGN
  $imagename=$categorypath.$hinban.".png";
//PDF NAME SIGN
  $pdfnamepro=$pdfcodepro.$categorypath.$hinban.".pdf";
  $pdfnamedra=$pdfcodedra."ALL_".$hinban.".pdf";  // PDF Drawing will has common pdf file for all process
  $pdfnamepac=$pdfcodepac.$categorypath.$hinban.".pdf";
//CHECK PDF FILE EXISTENCE PATH
  $checkpdfpro=$pdfpathpro.$pdfnamepro;
  $checkpdfdra=$pdfpathdra.$pdfnamedra;
  $checkpdfpac=$pdfpathpac.$pdfnamepac;
  $checkimage =$imagepath.$imagename;

  //QUERRY
      //CHECK DATA EXISTENCE
        $sql = "SELECT hinban FROM t60_filetable where hinban='$hinban' and category=$categorycode";
        $query = $this->db->query($sql);
        $dataexist=$query->num_rows();
      //PROPERTY
        $sqlproperty = "SELECT property FROM t60_filetable where hinban='$hinban' AND category=$categorycode";
        $query = $this->db->query($sqlproperty);
        foreach ($query->result() as $row){
            $property=$row->property;
        }    
//CHECK STATUS
  if ($dataexist==0) //from database
      {$statuslabel="新規登録";$statusexist=0;$hinbanlabel="登録なし";$hinbanstatus=0;$imagename="NoImage.png";}
  else
      {$statuslabel="登録済";$statusexist=1;$hinbanlabel=$imagename;$hinbanstatus=1;}
//CHECK AFTER DELETE
  if ($hinban=="")
      {$statuslabel=null;$statusexist=0;$hinbanlabel="登録なし";$imagename="not found.png";}
//CHECK PROPERTY
  if ($property==null) 
      {$propertylabel="新規登録";$propertystatus=0;}
  else
      {$propertylabel="登録済";$propertystatus=1;}
//CHECK IMAGE
  if (!file_exists($checkimage)) 
      {$hinbanlabel="登録なし";$hinbanstatus=0;$imagename="NoImage.png";}
  else
      {}
//CHECK PROCEDURE
  if (!file_exists($checkpdfpro)) 
      {$pdflabelpro="登録なし";$pdfstatuspro=0;}
  else
      {$pdflabelpro=$pdfnamepro;$pdfstatuspro=1;}
//CHECK DRAWING
  if (!file_exists($checkpdfdra)) 
      {$pdflabeldra="登録なし";$pdfstatusdra=0;}
  else
      {$pdflabeldra=$pdfnamedra;$pdfstatusdra=1;}
//CHECK PACKING
  if (!file_exists($checkpdfpac)) 
      {$pdflabelpac="登録なし";$pdfstatuspac=0;}
  else
      {$pdflabelpac=$pdfnamepac;$pdfstatuspac=1;}
?>
  <body>
    <div class="container-fluid" id="ajaxbox" style="border-style:  ; box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);">
            <div class="row" style="border-style:;">
              <div class="col-8" style="border-style:; ">
                <form id="submitform" onsubmit="return validate()" action="registration/upload" method="post" enctype="multipart/form-data">
                    <div class="form-group row">
                        <label for="staticEmail" class="col-sm-3 col-form-label" id="kanji-ajax-label">品番</label>
                        <div class="col-sm-6">
                            <label type="text" onchange="" class="col-form-label" id="kanji-ajax-label"><?php echo $hinban ?></label>
                            <input type="hidden" name="hinban" value="<?php echo $hinban ?>">
                        </div>
                    </div>
                    <div class="form-group row" style="border-style: ; ">
                        <label for="staticEmail" class="col-sm-3 col-form-label" id="kanji-ajax-label">ステータス</label>
                        <div class="col-sm-6">
                            <label type="text" class="col-form-label" id="kanji-ajax-label"><?php echo $statuslabel ?></label>
                        </div>
                    </div>
                    <div class="form-group row" style="border-style:; ">
                        <div class="col-sm-3 ">
                            <label for="uploadpro" class="col-form-label"id="kanji-ajax-label">写真</label><span> </span>
                        </div>
                        <div class="col-sm-6">
                            <span  id="kanji-ajax-status" > <?php echo $hinbanlabel ?></span>           
                            <input type="file" class="form-control-file" name="uploadimage" id="fileimage" onchange="readURL(this)" accept='image/*'disabled></input>
                        </div>
                        </div>
                    <div class="form-group row" style="border-style:; ">
                        <div class="col-sm-3 col-form-label">
                            <label for="uploadpro" class="col-form-label col-form-label" id="kanji-ajax-label">手順書</label>
                        </div>
                        <div class="col-sm-6">
                            <span id="kanji-ajax-status"> <?php echo $pdflabelpro ?></span>         
                            <input type="file" class="form-control-file" name="uploadpro" id="uploadpro" accept="application/pdf"disabled>
                        </div>
                        </div>
                    <div class="form-group row" style="border-style:;">
                        <div class="col-sm-3 col-form-label">
                            <label for="uploadfilepacking" class="col-form-label" id="kanji-ajax-label">荷姿</label><span></span>
                        </div>
                        <div class="col-sm-6">
                          <span id="kanji-ajax-status"> <?php echo $pdflabelpac ?></span>         
                            <input type="file" class="form-control-file" name="uploadpac" id="uploadpac" accept="application/pdf"disabled>
                        </div>
                    </div>
                    <div class="form-group row" style="border-style: ;">
                        <div class="col-sm-3 col-form-label">
                            <label class="col-form-label" for="uploadfiledrawing" id="kanji-ajax-label">図面</label><span></span>
                        </div>
                        <div class="col-sm-6"> 
                            <span id="kanji-ajax-status"> <?php echo $pdflabeldra ?></span>          
                            <input type="file" class="form-control-file" name="uploaddra" id="uploaddra" accept="application/pdf"disabled>
                        </div>
                    </div>
                    <div class="form-group row" style="border-style: ;">
                        <div class="col-sm-3 col-form-label">
                            <label class="col-form-label" for="uploadfiledrawing"id="kanji-ajax-label">プロパティ</label><span></span>
                        </div>
                        <div class="col-sm-6"> 
                            <span id="kanji-ajax-status"><?php echo $propertylabel; ?></span>          
                            <textarea class="form-control" rows="5" id="property" name="property"><?php echo $property; ?></textarea>
                        </div>
                    </div>
                    <input type="hidden" id="category" name="category" value="<?php echo $category; ?>">
                    <input type="hidden" id="categorypath" name="categorypath" value="<?php echo $categorypath; ?>">
                    <input type="hidden" name="hinban" id="hinban" value="<?php echo $hinban; ?>"> 
                    <input type="hidden" name="imagenamepost" value="<?php echo $imagename; ?>">
                    <input type="hidden" name="dataexist" value="<?php echo $dataexist; ?>">
                    <input type="hidden" id="statusexist" name="statusexist" value="<?php echo $statusexist; ?>"> 
                    <input type="hidden" id="hinbanlabel" value="<?php echo $hinbanlabel ?>">
                    <button type="submit" class="btn btn-primary" name="submit" id="postbutton" disabled="">POST</button>
                    <!--DELETE BUTTON-->
                    <?php 
                    if ($statusexist==0) { //enable
                      ?>      
                      <button type="button" id="deletebutton" class="btn btn-primary" disabled>Delete</button>
                      <?php 
                    }else{ //disable
                      ?>
                      <button type="button" id="deletebutton" class="btn btn-primary" onclick="deleteFunct('<?php echo $statusexist; ?>')">Delete</button>
                      <?php
                    }
                    ?> 
                     <button type="button" class="btn btn-primary" id="deletebutton" onclick="clearForm()">Clear</button>
                     <br>
                    <br>
                </form>
              </div><!--COL-->
            <div class="col-3 mb-2" style="border-style:; ">
              <br>
              <div class="card shadow" style="width: 17rem; height: auto; ; top:auto;box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);">
                <div class="card-body">
                <?php 
                if($statusexist!=0){
                $displayimage=base_url('assets/usr/kanban/').$categorypath."/".$imagename;}
                else {$displayimage=null;} 
                ?>
                <img id="image" class="card-img-top" src="<?php echo $displayimage.'?'.$timestamp;?>" alt="">        
                <p class="card-text"></p>
              </div>
              </div>
            </div>
          </div> <!--CONTAINER-->
		</div>
		</div>
		</div>
    <br>
<style type="text/css">
#example {
    display: inline;
}
.LINE{
	margin-left:  800px;
}
#ajaxbox{
  height: auto;
}
#kanji-ajax-label{
font:22px BIZ UDPGothic;
}
#kanji-ajax-status{
font:14px BIZ UDPGothic;
}
#submit{
  width: 90px;
}
#deletebutton{
  margin-left: 40px;
  margin-top: 10px;
  width: 100px;
}
#postbutton{
   margin-left: 40px;
   margin-top: 10px;
   width: 100px;
}
</style>
</html>
