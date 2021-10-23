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
         <input type="hidden" name="hTable" id="hTable" value="rptThrowAway">
         <?php sideBar(); ?>
         <div id="page-content-wrapper">
            <div class="container-fluid">
               <?php userBar(); ?>
               <div class="row margin-top card">
                  <div>
                     <form method="post" action="ctrl_rptThrowAway.php">
                        <div class="panel-group">
                           <div class="panel-design">
                              <div class="panel-top">DELIVERY REPORT</div>
                              <div class="panel-mid">
                                 <div class="row">
                                    <div class="col-xs-12">
                                       <div class="form-group">
                                          	<div class="row">
                                            	<div class="col-xs-4">
                                                	<label>EMPLOYEE NAME</label>
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
                                         			<label>DATE FROM</label>
                                         			<input type="text" class="form-control date--" name="DateFrom">
                                         		</div>
                                         		<div class="col-xs-4">
                                         			<label>DATE TO</label>
                                         			<input type="text" class="form-control date--" name="DateTo">
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