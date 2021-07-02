<?php
//VARIABLE READER
  $hinban=null;
  $hinban=strtoupper($_POST['hinban']);
  $category=$_POST['category'];
  $imagenamepost=$_POST['imagenamepost'];
  $property=$_POST['property'];
  $dataexistPost=$_POST['dataexist'];
  $timestamp=time();
  $pdfcodepro="PRO_";
  $pdfcodedra="DRA_";
  $pdfcodepac="PAC_";
  $statusuploadimage="UPLOAD FAILED";
  $categorycode=null;
  $upload_failed=0;
  $uploaded_file_number=0;
  $statusuploadpro=null;
  $statusuploadpac=null;
  $statusuploaddra=null;
  $status_db    ="正常完了";
  $error_pdf    ="登録に失敗しました。pdfを選択してください";
  $error_image  ="登録に失敗しました。画像を選択してください";
  $error_db     ="登録に失敗しました";

  $success_pdf="登録完了";
  $success_image="登録完了";
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
  $pdfpathdra="assets/usr/pdf/drawing/ALL_/";
  $pdfpathpac="assets/usr/pdf/packing/$categorypath/";
//HINBAN NAME SIGN (IMAGE)
  $imagename=$categorypath.$hinban; 
//PDF NAME SIGN
  $pdfnamepro=$pdfcodepro.$categorypath.$hinban.".pdf";
  $pdfnamedra=$pdfcodedra."ALL_".$hinban.".pdf";
  $pdfnamepac=$pdfcodepac.$categorypath.$hinban.".pdf";

  $statusuploadarray[1]=0;
  $statusuploadarray[2]=0;
  $statusuploadarray[3]=0;
  $statusuploadarray[4]=0;
  $unlinkpath_array[1]=($imagepath.$imagename);
  $unlinkpath_array[2]=($pdfpathpro.$pdfnamepro);
  $unlinkpath_array[3]=($pdfpathpac.$pdfnamepac);
  $unlinkpath_array[4]=($pdfpathdra.$pdfnamedra);
//CHECK IMAGE INSERTED? IF YES THEN UPLOAD
    if (!file_exists($_FILES['uploadimage']['tmp_name']) || !is_uploaded_file($_FILES['uploadimage']['tmp_name'])) 
    {
        $statusuploadimage="変更なし";
        $imagefilename=$imagenamepost;
    }
    else
    {  
        $uploaded_file_number=$uploaded_file_number+1;
        $target_dirimage = $imagepath;     
        $target_fileimage = $target_dirimage . basename($imagename.".png");
        $uploadedFile=$_FILES['uploadimage']['tmp_name'];
        $dirPath = $imagepath;
        $newFileName = time();
        $ext=".png";
        //CHECK FILE PIXEL SIZE AND TYPE
        list($width, $height, $type, $attr) = getimagesize($_FILES['uploadimage']['tmp_name']);
        if(($width>1080) || ($height>810))
        {
            if($height>=$width)
            {
            //potrait image
                $propotition=810/$height;
            }else{
            //landscape
                $propotition=1080/$width;
            }//assign new size
            $newImageWidth=$propotition*$width;
            $newImageHeight=$propotition*$height;
        }else{//use old size
            $newImageWidth=$width; 
            $newImageHeight=$height; 
        }
        switch ($type) 
        {
            case IMAGETYPE_PNG:
                $imageSrc = imagecreatefrompng($uploadedFile); 
                $tmp = imageResize($imageSrc,$width,$height,$newImageWidth,$newImageHeight);
                imagepng($tmp,$dirPath.$imagename.".png");
                $statusuploadarray[1]=1;
                $statusuploadimage=$success_image;
                break;           
            case IMAGETYPE_JPEG:
                $imageSrc = imagecreatefromjpeg($uploadedFile); 
                $tmp = imageResize($imageSrc,$width,$height,$newImageWidth,$newImageHeight);
                imagepng($tmp,$dirPath.$imagename.".png");
                $statusuploadarray[1]=1;
                $statusuploadimage=$success_image;
                break;
                default:
                $statusuploadimage=$error_image;
                $upload_failed=1;
                break;
        }
        $imagefilename=$imagename.".png";
    }
//CHECK PDF PROCEDURE INSERTED? IF YES THEN UPLOAD
if (!file_exists($_FILES['uploadpro']['tmp_name']) || !is_uploaded_file($_FILES['uploadpro']['tmp_name'])) 
    {
        //echo 'No upload for pdf pro ';
        $statusuploadpro="変更なし";
    }
else
    {
        // Your file has been uploaded
        $target_dirpro = $pdfpathpro;
        $ext = pathinfo($_FILES["uploadpro"]["name"], PATHINFO_EXTENSION);
        $target_filepro = $target_dirpro . basename($pdfnamepro);
        $uploaded_file_number=$uploaded_file_number+1;
        if (($_FILES['uploadpro']['type']) == 'application/pdf')
        {
            if (move_uploaded_file($_FILES["uploadpro"]["tmp_name"], $target_filepro)) 
            {
                $statusuploadpro=$success_pdf;
                $statusuploadarray[2]=1;
            }else{$upload_failed=$upload_failed+1;}
        }   
        else
        {
            //echo " " . $_FILES["uploadpro"]['name'] . " is not a PDF file";
            $upload_failed=$upload_failed+1; //edit heere
            $statusuploadpro=$error_pdf;
        }
    }

//CHECK PDF PACKING INSERTED? IF YES THEN UPLOAD
    if (!file_exists($_FILES['uploadpac']['tmp_name']) || !is_uploaded_file($_FILES['uploadpac']['tmp_name'])) 
    {
        $statusuploadpac="変更なし";
    }
else
    {
        // Your file has been uploaded
        $uploaded_file_number=$uploaded_file_number+1;
        $target_dirpac = $pdfpathpac;
        $ext = pathinfo($_FILES["uploadpac"]["name"], PATHINFO_EXTENSION);
        $target_filepac = $target_dirpac . basename($pdfnamepac);

        if (($_FILES['uploadpac']['type']) == 'application/pdf')
        {
            if (move_uploaded_file($_FILES["uploadpac"]["tmp_name"], $target_filepac)) 
            {
                $statusuploadpac=$success_pdf;
                $statusuploadarray[3]=1;
                echo "AJA";
            }else{$upload_failed=$upload_failed+1;}
        }
        else
        {
           // echo " " . $_FILES["uploadpac"]['name'] . " is not a PDF file";
            $upload_failed=$upload_failed+1;
            $statusuploadpac=$error_pdf;
        }
    }
//CHECK PDF DRAWING INSERTED? IF YES THEN UPLOAD
    if (!file_exists($_FILES['uploaddra']['tmp_name']) || !is_uploaded_file($_FILES['uploaddra']['tmp_name'])) 
    {
        //echo 'No upload for pdf drawing ';
        $statusuploaddra="変更なし";
    }
else
    {
        // Your file has been uploaded
        $uploaded_file_number=$uploaded_file_number+1;
        $target_dirdra = $pdfpathdra;
        $ext = pathinfo($_FILES["uploaddra"]["name"], PATHINFO_EXTENSION);
        $target_filedra = $target_dirdra . basename($pdfnamedra);

        if (($_FILES['uploaddra']['type']) == 'application/pdf')
        {
            if (move_uploaded_file($_FILES["uploaddra"]["tmp_name"], $target_filedra)) 
            {
                $statusuploaddra=$success_pdf;
                $statusuploadarray[4]=1;
            }else{$upload_failed=$upload_failed+1;}
        }
        else
        {
            //echo " " . $_FILES["uploaddra"]['name'] . " is not a PDF file";
            $statusuploaddra=$error_pdf;
            $upload_failed=$upload_failed+1;
        }
    } 
function imageResize($imageSrc,$imageWidth,$imageHeight,$newImageWidth,$newImageHeight) {
            $newImageLayer=imagecreatetruecolor($newImageWidth,$newImageHeight);
            imagecopyresampled($newImageLayer,$imageSrc,0,0,0,0,$newImageWidth,$newImageHeight,$imageWidth,$imageHeight);
            return $newImageLayer;
        }
        //echo "Upload Failed Number: ".$upload_failed;
//CHECK DATA EXISTENCE
    $sql = "SELECT hinban FROM t60_filetable where hinban='$hinban' and category=$categorycode"; 
    $query = $this->db->query($sql);
    $dataexist=$query->num_rows();
//menahan semua query untuk tidak di eksekusi  
$this->db->trans_begin(); 
//QUERY INSERT 
    if (($dataexist==0) AND ($hinban != "") AND ($dataexistPost==0))
    {   
        $pattern = "/'/"; $replacement = "''"; $property1 = preg_replace($pattern, $replacement, $property);
        $sqlinsert = "INSERT t60_filetable(hinban,category,property) VALUES('$hinban','$categorycode','$property1')";
        $queryinsert = $this->db->query($sqlinsert);
    }

//EXECUTE QUERY WITH Transaction Method
    if (($dataexist==0) AND ($dataexistPost==0))
    {   
        //NEW DATA
        if (($uploaded_file_number > $upload_failed))  
        {
            if (($this->db->trans_status() === TRUE) )
            {
                $this->db->trans_commit();
            }
            else
            {
                $this->db->trans_rollback();
                $status_db=$error_db;
                //put unlink file here
                for ($unl= 1; $unl <= 4; $unl++) {
                    if ($statusuploadarray[$unl]==1)
                        {
                            unlink($unlinkpath_array[$unl]);
                            // /echo $statusuploadarray[$unl];
                        }
                }
            }
        }
        else
        {
            //Jumlah Error dan data imnsert sama, tidak ada data masuk - > db tidak diupdate
            //echo "upload_failed: ".$upload_failed; 
            //echo "uploaded_file_number: ".$uploaded_file_number;
        }
    }
    else //REGISTERED
    {   
    //PROPERTY
    $pattern = "/'/"; $replacement = "''"; $property1 = preg_replace($pattern, $replacement, $property);
    $sqlinsertProperty = "UPDATE t60_filetable SET property='$property1' where hinban='$hinban' AND category='$categorycode'";
    $queryinsert = $this->db->query($sqlinsertProperty);
        if (($this->db->trans_status() === TRUE) ) //CHECK APAKAH ADA ERROR DAtabase
        {
            $this->db->trans_commit();
        }
        else
        {
            $this->db->trans_rollback();
            $status_db=$error_db;
        }
    }
?>
<br>
<body>
<div class="container">
<div class="jumbotron">
<h1>Welcome To Product List Registration System</h1> 
<div class="container-fluid">
    <h4>INSERTED FILE : </h4>
    <div class="container-fluid" style="border-style:; box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);">
        <div class="row" style="border-style: "> <!--ROW-->
          <div class="col-8" style="border-style: ">
            <form>
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-3 col-form-label" id="kanji">工程</label>
                    <div class="col-sm-8">
                        <div class="form-check form-check-inline">
                          <label class="form-check-label col-form-label" style="font: 22px BIZ UDPGothic;"><?php echo $category; ?></label>
                      </div>
                  </div>
                </div>
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-3 col-form-label" id="kanji" >ステータス</label>
                    <div class="col-sm-8">
                        <label class="form-check-label col-form-label" style="font: 22px BIZ UDPGothic;"><?php echo $status_db; ?></label>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-3 col-form-label" id="kanji" >品番</label>
                    <div class="col-sm-8">
                        <label class="form-check-label col-form-label" style="font: 22px BIZ UDPGothic;"><?php echo $hinban; ?></label>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-3 col-form-label" id="kanji" >写真</label>
                    <div class="col-sm-8">
                        <label class="form-check-label col-form-label" style="font: 22px BIZ UDPGothic;"><?php echo $statusuploadimage; ?></label>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-3 col-form-label" id="kanji" >手順書</label>
                    <div class="col-sm-8">
                        <label class="form-check-label col-form-label" style="font: 22px BIZ UDPGothic;"><?php echo $statusuploadpro; ?></label>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-3 col-form-label" id="kanji" >荷姿</label>
                    <div class="col-sm-8">
                        <label class="form-check-label col-form-label" style="font: 22px BIZ UDPGothic;"><?php echo $statusuploadpac; ?></label>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-3 col-form-label" id="kanji">図面</label>
                    <div class="col-sm-8">
                        <label class="form-check-label col-form-label" style="font: 22px BIZ UDPGothic;"><?php echo $statusuploaddra; ?></label>
                    </div>
                </div>
                <!-- ROW 1-->
                
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-3 col-form-label" id="kanji" >プロパティ</label>
                    <div class="col-sm-8">
                        <textarea readonly class="col-form-label" style="font: 22px BIZ UDPGothic;"><?php echo $property; ?></textarea>
                    </div>
                </div>
            </form>
          </div><!--COL-->
          <div class="col-3" style="border-style:; ">
            <br>
            <div class="card shadow" style="width: 17rem; height: auto; ; top:auto;box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);">
                <div class="card-body">
                <img id="image" class="card-img-top" src="<?php echo base_url('').$imagepath.$imagefilename.'?'.$timestamp?>" alt="">        
                <p class="card-text"></p>
            </div>
            </div>
            </div>
        </div> <!--ROW-->
<img src="<? echo base_url('');?>public/theme/img/logo.png" width="50" height="30" class="d-inline-block align-top" alt="" style="margin-right: 15px">
<br>
<a href="<?php echo base_url('registration');?>" class="btn btn-success" id="kanji-btn">もどる</a>
<br><br><br>
</div> <!--CONTAINER-->
</div>
</div>
</div>
</body>
<style type="text/css">
#kanji-btn{
    font:24px BIZ UDPGothic;
    margin-right: 100px;
}
</style>
