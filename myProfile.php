<!DOCTYPE html>
<html>
   <head>
      <?php
         include 'external.php';
         include '214Function.php';
      ?>
      <style>
      </style>
      <script type="text/javascript" src="js/ctrl/ctrl_myProfile.js"></script>
      <script type="text/javascript">
         $(document).ready(function () {
         });
         
      </script>
   </head>
   <body onload="ActiveModule();">
      <div id="wrapper">
         <input type="hidden" name="hTable" id="hTable" value="myProfile">
         <input type="hidden" name="hEmpRefId" id="hEmpRefId" value="">
         <?php sideBar(); ?>
         <div id="page-content-wrapper">
            <div class="container-fluid">
               <?php userBar(); ?>
               <div class="row margin-top card">
                  <div id="list">
                     <div class="panel-group">
                        <div class="panel-design">
                           <div class="panel-top">MY PROFILE</div>
                           <div class="panel-mid">
                              <div class="row" id="info">
                                 <div class="col-xs-12">
                                    <div class="form-group">
                                       <div class="row">
                                          <div class="col-xs-3">
                                             <label>Employees Reference Id:</label>
                                             <input type="text" class="form-control save-- mandatory-- text-center" id="emprefid" readonly="true">
                                          </div>
                                       </div>
                                       <div class="row margin-top">
                                          <div class="col-xs-6">
                                             <label>Branch:</label>
                                             <input type="text" class="form-control save-- mandatory--" name="Branch" readonly="true">
                                          </div>
                                          <div class="col-xs-6">
                                             <label>Position:</label>
                                             <input type="text" class="form-control save-- mandatory--" name="Position" readonly="true">
                                          </div>
                                       </div>
                                       <div class="row margin-top">
                                          <div class="col-xs-6">
                                             <label>First Name:</label>
                                             <input type="text" class="form-control save-- mandatory-- alpha--" name="FirstName">
                                          </div>
                                          <div class="col-xs-6">
                                             <label>Last Name:</label>
                                             <input type="text" class="form-control save-- mandatory-- alpha--" name="LastName">
                                          </div>
                                       </div>
                                       <div class="row margin-top">
                                          <div class="col-xs-6">
                                             <label>Middle Name:</label>
                                             <input type="text" class="form-control save-- mandatory-- alpha--" name="MiddleName">
                                          </div>
                                          <div class="col-xs-6">
                                             <label>Extension Name:</label>
                                             <input type="text" class="form-control save-- alpha--" name="ExtName">
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
                              </div>
                              <div class="row" id="password">
                                 <div class="col-xs-12">
                                    <div class="form-group">
                                       <div class="row">
                                          <div class="col-xs-6">
                                             <label>Current Password:</label>
                                             <input type="password" id="curr_PW" class="form-control pass" placeholder="Enter Your Current Password">
                                          </div>
                                       </div>
                                       <div class="row margin-top">
                                          <div class="col-xs-6">
                                             <label>New Password:</label>
                                             <input type="password" id="new_PW" class="form-control pass" placeholder="New Password">
                                          </div>
                                          <div class="col-xs-6">
                                             <label>Re-Type Password:</label>
                                             <input type="password" id="retype_PW" class="form-control pass" placeholder="Re-Type Password">
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="panel-bot">
                              <!--<button type="button" class="btn btn-info" id="btn_editInfo">EDIT</button>-->
                              <button type="button" class="btn btn-info" id="btn_updateInfo">UPDATE</button>
                              <button type="button" class="btn btn-danger" id="btn_cancelInfo">CANCEL</button>
                              <button type="button" class="btn btn-info" id="btn_updatePW">UPDATE PASSWORD</button>
                              <button type="button" class="btn btn-danger" id="btn_chngPW">CHANGE PASSWORD</button>
                              <button type="button" class="btn btn-danger" id="btn_cancelPW">CANCEL</button>
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