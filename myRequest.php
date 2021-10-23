<!DOCTYPE html>
<html>
   <head>
      <?php
         include 'external.php';
         include '214Function.php';
         $tabTitle = ["PENDING REQUEST","APPROVED REQUEST","CANCELLED REQUEST"];
         $tabFile = ["incPendingRequest","incApprovedRequest","incCancelledRequest"];
      ?>
      <style>
      </style>
      <script>
         $(document).ready(function () {
            tabClick(1);
            $("[name='btnTab_1']").click(function() {
               tabClick(1);
            });
            $("[name='btnTab_2']").click(function() {
               tabClick(2);
            });
            $("[name='btnTab_3']").click(function() {
               tabClick(3); 
            });
            $("#reqDeliver").click(function () {
               var refid = $("#hRefId").val();
               var branchrefId = $("#hBranchRefId").val();
               /*alert(refid);
               alert(branchrefId);
               return false;*/
               delivered(refid,branchrefId);
            });
         });
         function tabClick(tabidx) {
            $("[name='hTabIdx']").val(tabidx);
            $("[id*='tab_']").hide();
            $("#tab_" + tabidx).show();
         }
         function delivered(refid,branchrefId){
            $.post("system.php",
            {
               task:"deliveryOkay",
               refid:refid,
               branchrefId:branchrefId
            },
            function(data,status) {
               if (status == "success") {
                  try {
                     eval(data);
                  } catch (e) {
                     if (e instanceof SyntaxError) {
                        alert(e.message);
                     }
                  }
               }

            });
         }
      </script>
   </head>
   <body onload="ActiveModule();">
      <div id="wrapper">
         <input type="hidden" name="hTable" id="hTable" value="request">
         <?php sideBar(); ?>
         <div id="page-content-wrapper">
            <div class="container-fluid">
               <?php userBar(); ?>
               <div class="row margin-top card">
                  <div id="reqForm">
                     <div class="panel-group">
                        <div class="panel-design">
                           <div class="panel-top">MY REQUEST</div>
                           <div class="panel-mid">
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