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
                           <div class="panel-top">LIST OF DONUTS</div>
                           <div class="panel-mid">
                              <?php DataTable("SELECT * FROM donuts ORDER BY RefId DESC",["Code","Name"],["Code","Name"]);?>
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
                           <div class="panel-top" id="templateTitle">CREATING NEW DONUTS</div>
                           <div class="panel-mid">
                              <div class="row" id="EntryScreen">
                                 <div class="col-xs-12">
                                    <div class="form-group">
                                       <div class="row">
                                          <div class="col-xs-6">
                                             <label>Code:</label>
                                             <input type="text" class="form-control save-- mandatory-- alphanum--" name="Code" placeholder="Donut Code">
                                          </div>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <div class="row">
                                          <div class="col-xs-6">
                                             <label>Name:</label>
                                             <input type="text" class="form-control save-- mandatory-- alpha--" name="Name" placeholder="Donut Name">
                                          </div>
                                          <div class="col-xs-6">
                                             <label>Allergence:</label>
                                             <select class="form-control save-- mandatory--" name="Allergence">
                                                <option value="">SELECT ALLERGENCE</option>
                                                <option value="1">Allergence</option>
                                                <option value="0">Non-Allergence</option>
                                             </select>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <div class="row">
                                          <div class="col-xs-6">
                                             <label>Criteria:</label>
                                             <?php select("criteria","criteriaRefId","CRITERIA","mandatory--"); ?>
                                          </div>
                                          <div class="col-xs-6">
                                             <label>Type:</label>
                                             <select class="form-control save-- mandatory--" name="Type">
                                                <option value="">SELECT TYPE</option>
                                                <option value="Ring">Ring</option>
                                                <option value="Shell">Shell</option>
                                                <option value="Tart">Tart</option>
                                             </select>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <div class="row">
                                          <div class="col-xs-6">
                                             <label>Price:</label>
                                             <input type="text" class="form-control save-- number-- mandatory--" name="Price" placeholder="Donut Price">
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
                                 <input type="hidden" class="" name="hTable" id="hTable" value="donuts">
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