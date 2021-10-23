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
                              <div class="panel-top">LIST OF EMPLOYEES</div>
                              <div class="panel-mid">
                                 <?php DataTable("SELECT * FROM employees ORDER BY RefId DESC",["Last Name","First Name","Branch No","Position No"],["LastName","FirstName","branchRefId","positionRefId"]);?>
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
                              <div class="panel-top" id="templateTitle">ADDING NEW EMPLOYEE</div>
                              <div class="panel-mid">
                                 <div class="row" id="EntryScreen">
                                    <div class="col-xs-12">
                                       <div class="form-group">
                                          <div class="row">
                                             <div class="col-xs-6">
                                                <label>Branch:</label>
                                                <?php select("branch","branchRefId","BRANCH","mandatory--"); ?>
                                             </div>
                                             <div class="col-xs-6">
                                                <label>Position:</label>
                                                <?php select("position","positionRefId","POSITION","mandatory--"); ?>
                                             </div>
                                          </div>
                                          <div class="row margin-top">
                                             <div class="col-xs-6">
                                                <label>First Name:</label>
                                                <input type="text" class="form-control save-- mandatory-- alpha--" name="FirstName" placeholder="First Name">
                                             </div>
                                             <div class="col-xs-6">
                                                <label>Last Name:</label>
                                                <input type="text" class="form-control save-- mandatory-- alpha--" name="LastName" placeholder="Last Name">
                                             </div>
                                          </div>
                                          <div class="row margin-top">
                                             <div class="col-xs-6">
                                                <label>Middle Name:</label>
                                                <input type="text" class="form-control save-- mandatory-- alpha--" name="MiddleName" placeholder="Middle Name">
                                             </div>
                                             <div class="col-xs-6">
                                                <label>Extension Name:</label>
                                                <input type="text" class="form-control save-- alpha--" name="ExtName" placeholder="Extension Name">
                                             </div>
                                          </div>
                                          <div class="row margin-top">
                                             <div class="col-xs-6">
                                                <label>Gender:</label>
                                                <select class="form-control save-- mandatory--" name="Sex">
                                                   <option value="">SELECT GENDER</option>
                                                   <option value="Male">Male</option>
                                                   <option value="Female">Female</option>
                                                </select>
                                             </div>
                                             <div class="col-xs-6">
                                                <label>Civil Status:</label>
                                                <select class="form-control save-- mandatory--" name="CivilStatus">
                                                   <option value="">SELECT CIVIL STATUS</option>
                                                   <option value="Single">Single</option>
                                                   <option value="Married">Married</option>
                                                </select>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <input type="hidden" class="" name="hRefId" id="hRefId">
                                    <input type="hidden" class="" name="hTable" id="hTable" value="employees">
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