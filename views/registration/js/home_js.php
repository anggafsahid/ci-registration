<script>
function reload()
    {
      var strd = document.getElementById("hinban").value;
      loadDoc(strd);
    }
function loadDoc(str) 
    {
      var xhttp;
      xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) 
        {
          document.getElementById("demo").innerHTML = this.responseText;
        }
      };
      var inputAssembly = document.getElementById("categoryAssembly");
      var inputPaint    = document.getElementById("categoryPaint");
      var inputShip     = document.getElementById("categoryShip");
      if (inputAssembly.checked)
        {var category="ASSEMBLY";}
      else if(inputPaint.checked)
        {var category="PAINT";} 
      else if(inputShip.checked)
        {var category="SHIP";} 
      xhttp.open("GET", "registration/ajax/home_ajax?hinban="+str+"&category="+category, true);
      xhttp.send(); 
    }
function readURL(input) 
    {
      if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
          $('#image')
          .attr('src', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
      }
    }
function focusInsert()
  {
      document.getElementById("hinbaninput").focus();
  }
function checkForm()
    { 
      var r = setTimeout(checkForm, 1);
      var hinban = document.getElementById("hinban").value;
      var status = document.getElementById("statusexist").value;
      var postbutton = document.getElementById("postbutton");
      var deleteButton = document.getElementById("deletebutton");
      
      var fileimage = document.getElementById("fileimage");
      var uploadpro = document.getElementById("uploadpro");
      var uploaddra = document.getElementById("uploaddra");
      var uploadpac = document.getElementById("uploadpac");
      
      //CHECK for Deleted Button
      if (status!=0)
      {
        deleteButton.disabled = false;
      }
      //CHECK FOR IMAGE DISPLAY
      if((status!=0) && (fileimage.value=="")){
        var imagename= document.getElementById('hinbanlabel').value;
        var categorypath=document.getElementById('categorypath').value;
        var timestamp=document.getElementById('timestamp').value;
        imagesource="assets/usr/kanban/"+categorypath+"/"+imagename+"?"+timestamp;
       // alert (imagesource);
        $("#image").attr('src',imagesource );
      }
      //CHECK DISPLAY NULL AND POST BUTTON
      if ((status!=0) || (fileimage.value!="") || (uploadpro.value!="") || (uploaddra.value!="") || (uploadpac.value!=""))
      {
        postbutton.disabled = false;
      }else{
        postbutton.disabled = true;
        $("#image").attr('src', null);
      }
      //CHECK Inserted Hinban
      if (hinban!="")
      {        
        fileimage.disabled = false;
        uploadpro.disabled = false;
        uploaddra.disabled = false;
        uploadpac.disabled = false; 
      }
    }
function clearForm()
    { 
      loadDoc('');
      //document.getElementById("mainform").reset();
      document.getElementById("hinbaninput").value=null;
      onloading();
    }
function deleteFunct(existstatus)
    {
      var confirmation = confirm("Delete inputted Data?");
      if (confirmation == true) 
        {
          //DELETE CONFIRMED
          var xhttp;
          xhttp = new XMLHttpRequest();
          xhttp.onreadystatechange = function() 
          {
            if (this.readyState == 4 && this.status == 200) 
            {
              document.getElementById("deleteStatus").innerHTML = this.responseText;
            }
          };
          var hinban = document.getElementById("hinban").value;
          var category = document.getElementById("category").value;
          xhttp.open("GET", "registration/delete?hinban="+hinban+"&category="+category, true);
          xhttp.send();
          clearForm();
          reload();
        } 
      else 
        {
          //DELETE CANCELLED
        }     
    }
function checkForm_Focus(){
  focusInsert();
  checkForm(); 
}
</script>


