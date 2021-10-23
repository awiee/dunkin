<!DOCTYPE html>
<html>
   <head>
      <?php
         include 'external.php';
         include '214Function.php';
         include 'conn.php';
      ?>
      <style>
      </style>
      <script>
         $(document).ready(function () {
            
         });
      </script>
   </head>
   <body onload="ActiveModule();">
      <div id="wrapper">
         <input type="hidden" name="hTable" id="hTable" value="audit_trail">
         <?php sideBar(); ?>
         <div id="page-content-wrapper">
            <div class="container-fluid">
               <?php userBar(); ?>
               <div class="row margin-top card">
                  <div id="list">
                     <div class="panel-group">
                        <div class="panel-design">
                           <div class="panel-top">LIST OF</div>
                           <div class="panel-mid">
                              <?php 
                                 /*$sql = "SELECT * FROM audit_trail";
                                 DataTable($sql,["TABLE MOVEMENT","STATUS"],["InTable","Status"]);*/
                              ?>
                              <table id="dataList" class="table table-striped table-bordered table-hover">
                                 <thead>
                                    <tr style="background:#4d0000;font-size:10pt;color:#fff;">
                                       <th style="text-align:center;">ACTION</th>
                                       <th style="text-align:center;">ID</th>
                                       <th style="text-align:center;">TABLE MOVEMENT</th>
                                       <th style="text-align:center;">STATUS</th>
                                    </tr>
                                 </thead>
                                 <tbody style="color: #000;">
                                    <?php
                                       $sql = "SELECT * FROM audit_trail ORDER BY RefId DESC";
                                       $rs = mysqli_query($conn,$sql);
                                       if (mysqli_num_rows($rs) > 0){
                                          while($row = mysqli_fetch_assoc($rs)) {
                                             $stat = $row["Status"];
                                             if ($stat == "A"){
                                                $stat = "ADDED";
                                             } else if ($stat == "E") {
                                                $stat = "EDITED";
                                             } else {
                                                $stat = "DELETED";
                                             }
                                    ?>
                                       <tr>
                                          <td style="text-align:center;">
                                             <button type="button" class="btn btn-info" onclick="edit('<?php echo $row["RefId"]; ?>');">
                                                VIEW
                                             </button>
                                          </td>
                                          <td style="text-align:center;">
                                             <?php echo $row["RefId"]; ?>
                                          </td>
                                          <td style="text-align:center;">
                                             <?php echo $row["InTable"]; ?>
                                          </td>
                                          <td style="text-align: center;">
                                             <?php echo $stat; ?>
                                          </td>
                                       </tr>
                                    <?php
                                          }
                                       }
                                    ?>
                                 </tbody>
                              </table>
                           </div>
                           <div class="panel-bot">
                           </div>
                        </div>
                     </div>
                  </div>
                  <div id="view">
                     <div class="panel-group">
                        <div class="panel-design">
                           <div class="panel-top" id="templateTitle"></div>
                           <div class="panel-mid">
                              <div class="row" id="EntryScreen">
                                 <div class="col-xs-12">
                                    <div class="form-group">
                                       <div class="row">
                                          <div class="col-xs-3">
                                             <label>Employees Ref Id:</label>
                                             <input type="text" class="form-control save--" name="EmployeesRefId" readonly>
                                          </div>
                                          <div class="col-xs-3">
                                             <label>Status:</label>
                                             <input type="text" class="form-control save--" name="Status" readonly>
                                          </div>
                                       </div>
                                       <div class="row margin-top">
                                          <div class="col-xs-3">
                                             <label>MAC Address:</label>
                                             <input type="text" class="form-control save--" name="MACAddress" readonly>
                                          </div>
                                          <div class="col-xs-3">
                                             <label>In Table:</label>
                                             <input type="text" class="form-control save--" name="InTable" readonly>
                                          </div>
                                       </div>
                                       <div class="row margin-top">
                                          <div class="col-xs-12">
                                             <label>IF ADD/DELETE</label>
                                          </div>
                                       </div>
                                       <div style="background:#bbb;height:1px;margin-top:1px;margin-bottom:10px;"></div>
                                       <div class="row margin-top">
                                          <div class="col-xs-12">
                                             <label>Movement:</label>
                                             <textarea type="text" class="form-control save--" name="Movement" rows="3" readonly></textarea>
                                          </div>
                                       </div>
                                       <div class="row margin-top">
                                          <div class="col-xs-12">
                                             <label>IF EDIT</label>
                                          </div>
                                       </div>
                                       <div style="background:#bbb;height:1px;margin-top:1px;margin-bottom:10px;"></div>
                                       <div class="row margin-top">
                                          <div class="col-xs-12">
                                             <label>Old Value:</label>
                                             <textarea type="text" class="form-control save--" name="LastValue" rows="3" readonly></textarea>
                                          </div>
                                       </div>
                                       <div class="row margin-top">
                                          <div class="col-xs-12">
                                             <label>New Value:</label>
                                             <textarea type="text" class="form-control save--" name="NewValue" rows="3" readonly></textarea>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <input type="hidden" class="" name="hRefId" id="hRefId">
                           </div>
                           <div class="panel-bot">
                              <button type="button" class="btn btn-danger" id="btn_back">BACK</button>
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