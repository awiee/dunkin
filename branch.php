<!DOCTYPE html>
<html>
   <head>
      <?php
         include 'external.php';
         include '214Function.php';
      ?>
      <style>
      </style>
      <script>
         $(document).ready(function () {
            $("#fm").show();
         });
      </script>
   </head>
   <body onload="ActiveModule();">
      <form method="post" name="currentForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
      <div id="wrapper">
         <?php sideBar(); ?>
         <div id="page-content-wrapper">
            <div class="container-fluid">
               <?php userBar(); ?>
               <div class="row margin-top card">
                  <div id="list">
                     <div class="panel-group">
                        <div class="panel-design">
                           <div class="panel-top">LIST OF BRANCH</div>
                           <div class="panel-mid">
                              <?php DataTable("SELECT * FROM branch ORDER BY RefId DESC",["Province","City","Barangay","Street"],["Province","City","Barangay","Street"]);?>
                           </div>
                           <div class="panel-bot">
                              <?php INCLO(); ?>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div id="view">
                     <div class="panel-group">
                        <div class="panel-design">
                           <div class="panel-top" id="templateTitle">CREATING NEW BRANCH</div>
                           <div class="panel-mid">
                              <div class="row" id="EntryScreen">
                                 <div class="col-xs-12">
                                    <div class="form-group">
                                       <div class="row">
                                          <div class="col-xs-6">
                                             <label>Code:</label>
                                             <input type="text" class="form-control save-- mandatory-- alphanum--" name="Code" placeholder="Branch Code">
                                          </div>
                                          <div class="col-xs-6">
                                             <label>Name:</label>
                                             <input type="text" class="form-control save-- mandatory-- alphanum--" name="Name" placeholder="Branch Name">
                                          </div>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <div class="row">
                                          <div class="col-xs-6">
                                             <label>Province:</label>
                                             <input type="text" class="form-control save-- mandatory-- alpha--" name="Province" placeholder="Province">
                                          </div>
                                          <div class="col-xs-6">
                                             <label>City:</label>
                                             <input type="text" class="form-control save-- mandatory-- alpha--" name="City" placeholder="City">
                                          </div>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <div class="row">
                                          <div class="col-xs-6">
                                             <label>Barangay:</label>
                                             <input type="text" class="form-control save-- mandatory-- alpha--" name="Barangay" placeholder="Barangay">
                                          </div>
                                          <div class="col-xs-6">
                                             <label>Street:</label>
                                             <input type="text" class="form-control save-- mandatory-- alpha--" name="Street" placeholder="Street">
                                          </div>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <div class="row">
                                          <div class="col-xs-6">
                                             <label>Remarks:</label>
                                             <textarea type="text" class="form-control save-- alphanum--" name="Remarks" placeholder="" rows="5"></textarea>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <input type="hidden" class="" name="hRefId" id="hRefId">
                                 <input type="hidden" class="" name="hTable" id="hTable" value="branch">
                              </div>
                           </div>
                           <div class="panel-bot">
                              <?php btn();?>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="footer">
                  <label>DUNKIN 2017</label>
               </div>
            </div>
         </div>
      </div>
      </form>
   </body>
</html>