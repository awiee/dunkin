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
            
            /*var apprvdatefrom = $("[name='apprvDateFrom']").val();
            var apprvdateto = $("[name='apprvDateTo']").val();
            var canceldatefrom = $("[name='cancelDateFrom']").val();
            var canceldateto = $("[name='cancelDateTo']").val();
            var deldatefrom = $("[name='delDateFrom']").val();
            var deldateto = $("[name='delDateTo']").val();
            $("[name='reqDateTo']").change(function () {
               alert(2);
               var reqdatefrom = $("[name='reqDateFrom']").val();
               var reqdateto = $("[name='reqDateTo']").val();   
               if (reqdatefrom > reqdateto){
                  $("[name='reqDateFrom']").focus();
                  alert ("Invalid Date Ranger");
               }
            });*/
         });
      </script>
   </head>
   <body onload="ActiveModule();">
      <div id="wrapper">
         <input type="hidden" name="hTable" id="hTable" value="rptDelDetails">
         <?php sideBar(); ?>
         <div id="page-content-wrapper">
            <div class="container-fluid">
               <?php userBar(); ?>
               <div class="row margin-top card">
                  <div>
                     <form method="post" action="ctrl_rptDelDetails.php">
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
                                                <label>EMPLOYEES</label>
                                                <?php
                                                   include 'conn.php';;
                                                   $sql = "SELECT * FROM employees WHERE positionRefId != 3";
                                                   $result = mysqli_query($conn,$sql);
                                                      echo '<select name="empRefId" class="form-control">';
                                                         echo '<option value="">SELECT EMPLOYEE</option>';
                                                   if (mysqli_num_rows($result) > 0){
                                                      while($row = mysqli_fetch_assoc($result)) {
                                                         $FullName = $row["LastName"].", ".$row["FirstName"];
                                                         echo '<option value="'.$row["RefId"].'">[ '.$row["RefId"].' ] '.$FullName.'</option>';
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
                                             <!--<div class="col-xs-4">
                                                <label>DONUT</label>
                                                <?php
                                                   include 'conn.php';;
                                                   $sql = "SELECT * FROM donuts";
                                                   $result = mysqli_query($conn,$sql);
                                                      echo '<select name="donutRefId" class="form-control">';
                                                         echo '<option value="">SELECT DONUT</option>';
                                                   if (mysqli_num_rows($result) > 0){
                                                      while($row = mysqli_fetch_assoc($result)) {
                                                         if ($row["Allergence"] == 0) {
                                                            echo '<option value="'.$row["RefId"].'">[ A ] '.$row["Name"].'</option>';
                                                         } else {
                                                            echo '<option value="'.$row["RefId"].'">[ N-A ] '.$row["Name"].'</option>';
                                                         }
                                                         
                                                      }
                                                   }
                                                      echo '</select>';
                                                ?>
                                             </div>-->
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