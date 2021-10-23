<!DOCTYPE html>
<html>
   <head>
      <?php
         include 'external.php';
         include '214Function.php';
      ?>
      <style>
         label {
            color: #000;
         }
      </style>
      <script>
         $(document).ready(function () {
            $("#myprofile").click(function () {
               $("#help_content").load("help/help_myprofile.php");
            });
         });
      </script>
   </head>
   <body onload="ActiveModule();">
      <div id="wrapper">
         <input type="hidden" name="module" id="module" value="">
         <?php sideBar(); ?>
         <div id="page-content-wrapper">
            <div class="container-fluid">
               <?php userBar(); ?>
               <div class="row margin-top card">
                  <div class="col-xs-12">
                     <div class="row">
                        <button class="btn btn-info" id="myprofile">My Profile</button>
                        <button class="btn btn-info">Notifications</button>
                        <button class="btn btn-info">Employees</button>
                        <button class="btn btn-info">Report</button>
                        <button class="btn btn-info">Audit Trail</button>
                        <button class="btn btn-info">File Manager</button>
                     </div>
                     <div class="row margin-top" id="help_content"></div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </body>
</html>