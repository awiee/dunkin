<?php
   $tabTitle = ["ALLERGENCE","NON-ALLERGENCE"];
   $tabFile = ["incAllergens","incNon-Allergens"];
   include 'conn.php';
?>
<!DOCTYPE html>
<html>
   <head>
      <?php
         include 'external.php';
         include '214Function.php';
      ?>
      <style>
      </style>
      <script type="text/javascript" src="js/ctrl/ctrl_requestform.js"></script>
   </head>
   <body onload="ActiveModule();">
      <div id="wrapper">
         <input type="hidden" name="hTable" id="hTable" value="requestform">
         <input type="hidden" id="hEmpRefId" value="<?php echo $_SESSION["RefId"]; ?>">
         <?php sideBar(); ?>
         <div id="page-content-wrapper">
            <div class="container-fluid">
               <?php userBar(); ?>
               <div class="row margin-top card">
                  <div id="reqValid" style="color:#000;padding: 15px;font-weight: 700;">
                     You Cant Create a New Request For This Time
                     <br>
                     <br>
                     <button class="btn btn-info" id="sent_special_req">SEND SPECIAL DELIVERY</button>
                  </div>
                  <div id="reqForm">
                     <div class="panel-group">
                        <div class="panel-design">
                           <div class="panel-top">REQUEST FORM FOR DELIVERY</div>
                           <div class="panel-mid">
                              <div class="row">
                                 <div class="col-xs-12">
                                    <div class="row" style="margin-left: 1%;">
                                       <label>DONUTS WITH CRITICAL STOCK(s):</label>
                                    </div>
                                    <?php
                                       $sql = "SELECT * FROM branch_stock WHERE BranchRefId = ".$_SESSION["BranchRefId"]." AND Stock < 20";
                                       $result = mysqli_query($conn,$sql);
                                       if (mysqli_num_rows($result) > 0){
                                          while ($stock = mysqli_fetch_assoc($result)) {
                                    ?>
                                       <div class="row margin-top">
                                          <div class="col-xs-10">
                                             <div class="row">
                                                <div class="col-xs-3">
                                                   CODE:&nbsp;&nbsp;&nbsp;<label><?php echo get("donuts",$stock["DonutRefId"],"Code"); ?></label>
                                                </div>
                                                <div class="col-xs-4">
                                                   NAME:&nbsp;&nbsp;&nbsp;<label><?php echo get("donuts",$stock["DonutRefId"],"Name"); ?></label>
                                                </div>
                                                <div class="col-xs-2">
                                                   STOCK:&nbsp;&nbsp;&nbsp;<label style="color: red;"><?php echo $stock["Stock"]; ?></label>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    <?php
                                          }
                                       } else {
                                          echo "<label>No Items on Critical Level.</label>";
                                       }
                                    ?>
                                 </div>
                              </div>
                              <div class="row" style="margin-top:5px;">
                                 <div class="col-xs-12">
                                    <input type="hidden" name="hTabIdx" value="3">
                                    <div class="btn-group btn-group-sm">
                                       <?php
                                          $idx = 0;
                                          $active = "";
                                          for ($j=0;$j<count($tabTitle);$j++) {
                                             $idx = $j + 1;
                                             echo
                                             '<button type="button" name="btnTab_'.$idx.'" class="btn btn-info '.$active.'">'.$tabTitle[$j].'</button>';
                                          }
                                       ?>
                                    </div>
                                    <div class="row">
                                       <div class="col-xs-12">
                                          <?php
                                             $idx = 0;
                                             for ($j=0;$j<count($tabTitle);$j++) {
                                                $idx = $j + 1;
                                                Tabs($idx,$tabTitle[$j],$tabFile[$j]);
                                             }
                                          ?>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="panel-bot text-right">
                              <div id="hValue"></div>
                              <button type="button" id="check" class="btn btn-info">PROCEED</button>
                              <button type="button" id="reedit" class="btn btn-danger">RE-EDIT</button>
                              <button type="button" id="gSave" class="btn btn-info">YES IM SURE</button>
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