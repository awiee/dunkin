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
      <div id="wrapper">
         <?php sideBar(); ?>
         <div id="page-content-wrapper">
            <div class="container-fluid">
               <?php userBar(); ?>
               <div class="row margin-top card">
                  <div id="list">
                     <div class="panel-group">
                        <div class="panel-design">
                           <div class="panel-top">LIST OF ITEMS</div>
                           <div class="panel-mid">
                              <?php DataTable("SELECT * FROM items ORDER BY RefId DESC",["Code","Name"],["Code","Name"]);?>
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
                           <div class="panel-top" id="templateTitle">CREATING NEW ITEMS</div>
                           <div class="panel-mid">
                              <div class="row" id="EntryScreen">
                                 <div class="col-xs-12">
                                    <div class="form-group">
                                       <div class="row">
                                          <div class="col-xs-6">
                                             <label>Code:</label>
                                             <input type="text" class="form-control save-- mandatory--" name="Code" placeholder="Item Code" autofocus>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <div class="row">
                                          <div class="col-xs-6">
                                             <label>Name:</label>
                                             <input type="text" class="form-control save-- mandatory--" name="Name" placeholder="Item Name">
                                          </div>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <div class="row">
                                          <div class="col-xs-6">
                                             <label>Remarks:</label>
                                             <textarea type="text" class="form-control save--" name="Remarks" placeholder="" rows="5"></textarea>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <input type="hidden" class="" name="hRefId" id="hRefId">
                                 <input type="hidden" class="" name="hTable" id="hTable" value="items">
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
   </body>
</html>