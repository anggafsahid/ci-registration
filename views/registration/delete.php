<?php
//VARIABLE READER 
$hinban       = strtoupper($_GET['hinban']);
$category     = $_GET['category'];
echo $category;
$pdfcodepro   ="PRO_";
$pdfcodedra   ="DRA_";
$pdfcodepac   ="PAC_";
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
//IMAGE NAME SIGN
  $imagename=$categorypath.$hinban.".png";
//PDF NAME SIGN
  $pdfnamepro=$pdfcodepro.$categorypath.$hinban.".pdf";
  $pdfnamedra=$pdfcodedra."ALL_".$hinban.".pdf";
  $pdfnamepac=$pdfcodepac.$categorypath.$hinban.".pdf";
//CHECK PDF FILE EXISTENCE PATH
  $checkpdfpro=$pdfpathpro.$pdfnamepro;
  $checkpdfdra=$pdfpathdra.$pdfnamedra;
  $checkpdfpac=$pdfpathpac.$pdfnamepac;
//CHECK DATA EXISTENCE
        $sql = "SELECT hinban FROM t60_filetable where hinban='$hinban'";
        $query = $this->db->query($sql);
        $DrawingExist=$query->num_rows();
//QUERRY DELETION
        $sqldelete = "DELETE FROM t60_filetable WHERE hinban='$hinban' AND category=$categorycode";
        $query = $this->db->query($sqldelete);
//DELETE FILE
//CHECK IMAGE
	  if (!file_exists($imagepath.$imagename)) 
	      {$hinbanlabel="登録なし";$hinbanstatus=0; echo " DATA NOT EXIST";}
	  else //delete
	      {unlink($imagepath.$imagename);}
//CHECK PROCEDURE
	  if (!file_exists($checkpdfpro)) 
	      {$pdflabelpro="登録なし";$pdfstatuspro=0;}
	  else //delete
	      { unlink($pdfpathpro.$pdfnamepro); }
//CHECK DRAWING
	  if ((!file_exists($checkpdfdra)) || ($DrawingExist==2) ) //CHECK DRAWING ONLY EXIST FOR ONE PROCESS  
	      {$pdflabeldra="登録なし";$pdfstatusdra=0;}
	  else //delete
	      {unlink($pdfpathdra.$pdfnamedra);}
//CHECK PACKING
	  if (!file_exists($checkpdfpac)) 
	      {$pdflabelpac="登録なし";$pdfstatuspac=0;}
	  else //delete
	      {unlink($pdfpathpac.$pdfnamepac);}
?>