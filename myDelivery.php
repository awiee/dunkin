<!DOCTYPE html>
<html>
   <head>
      <?php
         include 'external.php';
         include '214Function.php';
      ?>
      <style>
      </style>
      <script type="text/javascript" src="js/ctrl/ctrl_myDelivery.js"></script>
   </head>
   <body onload="ActiveModule();">
      <div id="wrapper">
         <input type="hidden" name="hTable" id="hTable" value="delivery">
         <?php sideBar(); ?>
         <div id="page-content-wrapper">
            <div class="container-fluid">
               <?php userBar(); ?>
               <div class="row margin-top card">
                  <div id="list">
                     <div class="panel-group">
                        <div class="panel-design">
                           <div class="panel-top">DELIVERY LIST</div>
                           <div class="panel-mid">
                              <table id="dataList" class="table table-striped table-bordered table-hover">
                                 <thead>
                                    <tr style="background:#4d0000;font-size:10pt;color:#fff;">
                                       <th style="text-align:center;">ACTION</th>
                                       <th style="text-align:center;">ID</th>
                                       <th style="text-align:center;">BRANCH NAME</th>
                                       <th style="text-align:center;">DELIVERY SHIFT</th>
                                       <th style="text-align:center;">REQUESTED DATE</th>
                                       <th style="text-align:center;">REQUESTED TIME</th>
                                    </tr>
                                 </thead>
                                 <tbody style="color: #000;">
                                    <?php
                                       include 'conn.php';
                                       $Driver = $_SESSION["RefId"];
                                       $sql = "SELECT * FROM delivery WHERE Status = 'A' AND DeliveryBy = $Driver";
                                       $rs = mysqli_query($conn,$sql);
                                       if (mysqli_num_rows($rs) > 0){
                                          while($row = mysqli_fetch_assoc($rs)) {
                                             $Branch = get("branch",$row["BranchRefId"],"Name");
                                             $DelShiftId = $row["DeliveryShift"];
                                             if ($DelShiftId == 1){
                                                $DelShift = "First Delivery";
                                             } else if ($DelShiftId == 2) {
                                                $DelShift = "Second Delivery";
                                             } else {
                                                $DelShift = "Third Delivery";
                                             }
                                             $ReqDate = $row["RequestDate"];
                                             $ReqTime = $row["RequestTime"];
                                             $refid = $row["RefId"];
                                    ?>
                                       <tr>
                                          <td style="text-align:center;">
                                             <button type="button" class="btn btn-info" onclick="checkDelivery('<?php echo $refid; ?>','<?php echo $row["BranchRefId"]; ?>');">VIEW</button>
                                          </td>
                                          <td style="width:70px;text-align:center;color:#000;">
                                             <?php echo $refid; ?>
                                          </td>
                                          <td style="color:#000;">
                                             <?php echo $Branch; ?>
                                          </td>
                                          <td style="color:#000;">
                                             <?php echo $DelShift; ?>
                                          </td>
                                          <td style="color:#000;">
                                             <?php echo $ReqDate; ?>
                                          </td>
                                          <td style="color:#000;">
                                             <?php echo $ReqTime; ?>
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
                  <div id="reqview">
                     <div class="panel-group">
                        <div class="panel-design">
                           <div class="panel-top" id="reqHeader"></div>
                           <div class="panel-mid" id="reqBody">
                           </div>
                           <div class="panel-bot">
                              <!--<input type="hidden" id="hRefId" value="">
                              <input type="hidden" id="hBranchRefId" value="">
                              <button type="button" class="btn btn-info" id="reqDeliver">DELIVERED</button>-->
                              <button type="button" class="btn btn-danger" id="reqBack">BACK</button>
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