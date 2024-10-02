<!DOCTYPE html>
<html>


<?php  
  // __________________________________________________________________
  // HOW TO INSTALL AND CONFIGURE
  // TinyMCE Text Editor 
  // __________________________________________________________________

  // STEP 1 : DOWNLOAD THE FREE LIBRARY "TINYMCE.ZIP" AT THE URL (LICENCE TYPE: GPL2+)
  // https://www.tiny.cloud/get-tiny/ 


  // STEP 2 EXTRACT THE FILES 

  // STEP 3 : SAVE THE DOWNLOADED LIBRARY "tinymce" IN THE TASKMANAGER JS FOLDER    /js/tinymce/
?> 


<head>


<?php  
  // __________________________________________________________________
  // HOW TO USE TinyMCE Text Editor IN A PHP PROJECT 
  // __________________________________________________________________
?> 

  <!-- // IMPORT THE LIBRARY IN THE HTML/HEADE OF YOUR PHP FILE (VIEW) --> 
  <script src="/js/tinymce/tinymce.min.js"></script>

  <!-- 
    - DECLARE AN INSTANCE OF TYPE TINYMCE 
    - INITIALIZE THE INSTANCE OBEJECT WITH A SELECTOR 


      <script type="text/javascript"> tinymce.init({ selector: '#mytextarea'  }); </script> 
  -->   


  <script type="text/javascript"> 
  tinymce.init({
    selector: "textarea",
    plugins:
      "advcode advlist anchor autosave autolink casechange charmap checklist codesample directionality editimage emoticons export formatpainter help image insertdatetime link linkchecker lists media mediaembed nonbreaking pagebreak permanentpen powerpaste save searchreplace table tableofcontents tinymcespellchecker visualblocks visualchars wordcount",
    toolbar:
      "undo redo print spellcheckdialog formatpainter | blocks fontfamily fontsize | bold italic underline forecolor backcolor | link image | alignleft aligncenter alignright alignjustify lineheight | checklist bullist numlist indent outdent | removeformat",
    height: "700px",
    spellchecker_language: "en",
    spellchecker_active: false,
  });
  
</script> 


</head>


<body>

<?php  
  require 'vue/partials/header.php';
  include 'vue/partials/nav.php';   
?> 

  <h1>TinyMCE Quick Start Guide</h1>

  <!--  DECLARE A FORM WITH POST HTTP METHOD  --> 
  <form method="post">

    <!--  CREATE A TEXTAREA WITH AN ID  --> 
    <textarea id="mytextarea">Hello, World!</textarea>

  </form>


</body>
</html>


