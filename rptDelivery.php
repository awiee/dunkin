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
            $("#rpt").show();
            $("#reqDate, #apprvDate, #cancelDate, #delDate").hide();
            $("[name='status']").change(function () {
               if ($(this).val() == "P") {
                  $("#apprvDate, #cancelDate, #delDate").hide();
                  $("#reqDate").show();
               } else if ($(this).val() == "A") {
                  $("#reqDate, #cancelDate, #delDate").hide();
                  $("#apprvDate").show();
               } else if ($(this).val() == "D") {
                  $("#reqDate, #apprvDate, #cancelDate").hide();
                  $("#delDate").show();
               } else if ($(this).val() == "C") {
                  $("#reqDate, #apprvDate, #delDate").hide();
                  $("#cancelDate").show();
               } else {
                  $("#reqDate, #apprvDate, #cancelDate, #delDate").hide();
               }
            });
         });
      </script>
   </head>
   <body onload="ActiveModule();">
      <div id="wrapper">
         <input type="hidden" name="hTable" id="hTable" value="rptDelivery">
         <?php sideBar(); ?>
         <div id="page-content-wrapper">
            <div class="container-fluid">
               <?php userBar(); ?>
               <div class="row margin-top card">
                  <div>
                     <form method="post" action="ctrl_rptDelivery.php">
                        <div class="panel-group">
                           <div class="panel-design">
                              <div class="panel-top">DELIVERY REPORT</div>
                              <div class="panel-mid">
                                 <div class="row">
                                    <div class="col-xs-12">
                                       <div class="form-group">
                                          <div class="row">
                                             <div class="col-xs-4">
                                                <label>DELIVERY REF ID</label>
                                                <input type="text" class="form-control number-- text-center" name="delRefId">
                                             </div>
                                             <div class="col-xs-4">
                                                <label>EMPLOYEE NAME</label>
                                                <!--<input type="text" class="form-control number text-center" name="empRefId">-->
                                                <?php
                                                   include 'conn.php';;
                                                   $sql = "SELECT * FROM employees WHERE positionRefId = 3";
                                                   $result = mysqli_query($conn,$sql);
                                                      echo '<select name="empRefId" class="form-control">';
                                                         echo '<option value="">SELECT EMPLOYEE</option>';
                                                   if (mysqli_num_rows($result) > 0){
                                                      while($row = mysqli_fetch_assoc($result)) {
                                                         $FullName = $row["LastName"].", ".$row["FirstName"];
                                                         echo '<option value="'.$row["RefId"].'">'.$FullName.'</option>';
                                                      }
                                                   }
                                                      echo '</select>';
                                                ?>
                                             </div>
                                             <div class="col-xs-4">
                                                <label>BRANCH</label>
                                                <?php select("branch","branchRefId","BRANCH",""); ?>
                                             </div>
                                          </div>
                                          <div class="row margin-top">
                                             <div class="col-xs-4">
                                                <label>DELIVERY BY</label>
                                                <?php
                                                   include 'conn.php';
                                                   $rs = mysqli_query($conn,"SELECT * FROM position WHERE Name = 'Driver'");
                                                   if (mysqli_num_rows($rs) > 0){
                                                      $row = mysqli_fetch_assoc($rs);
                                                      $DriverRefId = $row["RefId"];
                                                      $sql = "SELECT * FROM employees WHERE positionRefId = $DriverRefId";
                                                      $result = mysqli_query($conn,$sql);
                                                         echo '<select name="driverRefId" class="form-control">';
                                                            echo '<option value="">SELECT DRIVER</option>';
                                                      if (mysqli_num_rows($result) > 0){
                                                         while($drvRow = mysqli_fetch_assoc($result)) {
                                                            $drvFullName = $drvRow["LastName"].", ".$drvRow["FirstName"];
                                                            echo '<option value="'.$drvRow["RefId"].'">'.$drvFullName.'</option>';
                                                         }
                                                      }
                                                         echo '</select>';
                                                   } else {
                                                      echo '<label>No Driver Positon</label>';
                                                   }
                                                   
                                                ?>
                                             </div>
                                             <div class="col-xs-4">
                                                <label>DELIVERY SHIFT</label>
                                                <select class="form-control" name="delShift">
                                                   <option value="">SELECT SHIFT</option>
                                                   <option value="1">FIRST SHIFT</option>
                                                   <option value="2">SECOND SHIFT</option>
                                                   <option value="3">THIRD SHIFT</option>
                                                </select>
                                             </div>
                                             <div class="col-xs-4">
                                                <label>STATUS</label>
                                                <select class="form-control" name="status">
                                                   <option value="">SELECT SHIFT</option>
                                                   <option value="P">PENDING</option>
                                                   <option value="A">APPROVED</option>
                                                   <option value="D">DELIVERED</option>
                                                   <option value="C">CANCELLED</option>
                                                </select>
                                             </div>
                                          </div>
                                          <div class="row margin-top" id="reqDate">
                                             <div class="col-xs-4">
                                                <label>REQUESTED DATE FROM:</label>
                                                <input type="text" class="form-control date--" name="reqDateFrom">
                                             </div>
                                             <div class="col-xs-4">
                                                <label>REQUESTED DATE TO:</label>
                                                <input type="text" class="form-control date--" name="reqDateTo">
                                             </div>
                                             <div class="col-xs-4">
                                                <label>SHOW DELIVERY DETAILS:</label>
                                                <select name="Req_delDetails" class="form-control">
                                                   <option value="0">NO</option>
                                                   <option value="1">YES</option>
                                                </select>
                                             </div>
                                          </div>
                                          <div class="row margin-top" id="apprvDate">
                                             <div class="col-xs-4">
                                                <label>APPROVED DATE FROM:</label>
                                                <input type="text" class="form-control date--" name="apprvDateFrom">
                                             </div>
                                             <div class="col-xs-4">
                                                <label>APPROVED DATE TO:</label>
                                                <input type="text" class="form-control date--" name="apprvDateTo">
                                             </div>
                                             <div class="col-xs-4">
                                                <label>SHOW DELIVERY DETAILS:</label>
                                                <select name="Apprv_delDetails" class="form-control">
                                                   <option value="0">NO</option>
                                                   <option value="1">YES</option>
                                                </select>
                                             </div>
                                          </div>
                                          <div class="row margin-top" id="cancelDate">
                                             <div class="col-xs-4">
                                                <label>CANCELLED DATE FROM:</label>
                                                <input type="text" class="form-control date--" name="cancelDateFrom">
                                             </div>
                                             <div class="col-xs-4">
                                                <label>CANCELLED DATE TO:</label>
                                                <input type="text" class="form-control date--" name="cancelDateTo">
                                             </div>
                                             <div class="col-xs-4">
                                                <label>SHOW DELIVERY DETAILS:</label>
                                                <select name="Cncl_delDetails" class="form-control">
                                                   <option value="0">NO</option>
                                                   <option value="1">YES</option>
                                                </select>
                                             </div>
                                          </div>
                                          <div class="row margin-top" id="delDate">
                                             <div class="col-xs-4">
                                                <label>DELIVERED DATE FROM:</label>
                                                <input type="text" class="form-control date--" name="delDateFrom">
                                             </div>
                                             <div class="col-xs-4">
                                                <label>DELIVERED DATE TO:</label>
                                                <input type="text" class="form-control date--" name="delDateTo">
                                             </div>
                                             <div class="col-xs-4">
                                                <label>SHOW DELIVERY DETAILS:</label>
                                                <select name="delDetails" class="form-control">
                                                   <option value="0">NO</option>
                                                   <option value="1">YES</option>
                                                </select>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="panel-bot">
                                 <button type="submit" class="btn btn-info" id="btn_generate">GENERATE REPORT</button>
                              </div>
                           </div>
                        </div>
                     </form>
                  </div>
               </div>
               <div class="footer">
                  <label>DUNKIN <?php echo date("Y",time()); ?></label>
               </div>
            </div>
         </div>
      </div>
   </body>
</html>