<!DOCTYPE html>
<html>
   <head>
      <?php
         include 'external.php';
         include '214Function.php';
      ?>
      <style>
         body {
            /*background-image:url('images/sprinkle.png');*/
         }
         .txtPress {
            text-shadow:0px 2px 3px #000;
            font-weight:600;
         }
         label{
            font-size:12pt;
            text-shadow:0px 2px 3px #000;
         }
         .form-control:focus{
            background:black;
            color:white;
         }
      </style>
      <script>
         $(document).ready(function () {
            $("#cancel").click(function () {
               self.location = "index.php";
            });
         });
      </script>
   </head>
   <body>
      <form name="formlogin" method="post" action="ctrl_forgotpassword.php">
         <div class="container-fluid">
            <div class="col-xs-2"></div>
            <div class="col-xs-8" style="padding:50px;">
               <div class="row" style="background-image:url('images/bg1.jpg');height:550px;width:100%;background-repeat:no-repeat;border:1px solid black;">
                  <div class="col-xs-12">
                     <div class="row margin-top" style="padding:20px;" id="register">
                        <div class="col-xs-8">
                           <div class="row">
                              <div class="col-xs-12">
                                 <div class="txtPress" style="font-size:15pt;color:#fff;">FORGOT PASSWORD</div>
                              </div>
                           </div>
                           <div class="row margin-top">
                              <div class="col-xs-12">
                                 <div class="form-group">
                                    <div class="row">
                                       <div class="col-xs-12">
                                          <label>First Name:</label>
                                          <input type="text" class="form-control save-- mandatory--" name="FirstName" placeholder="Enter First Name" autofocus required>
                                       </div>
                                    </div>
                                    <div class="row margin-top">
                                       <div class="col-xs-12">
                                          <label>Last Name:</label>
                                          <input type="text" class="form-control save-- mandatory--" name="LastName" placeholder="Enter Last Name" required>
                                       </div>
                                    </div>
                                    <div class="row margin-top">
                                       <div class="col-xs-6">
                                          <label>Position:</label>
                                          <?php
                                             echo '<select name="positionRefId" class="form-control" required>
                                                         <option value="">SELECT POSITION</option>';
                                             include "conn.php";
                                             $sql = "SELECT * FROM `position` ORDER BY RefId";
                                             $result = $conn->query($sql);
                                                while($row = $result->fetch_assoc()) {
                                                   echo '<option value="'.$row["RefId"].'">';
                                                   echo ''.$row["Name"].'</option>';
                                                }
                                             echo '<select>';
                                          ?>
                                       </div>
                                       <div class="col-xs-6">
                                          <label>Branch No:</label>
                                          <?php
                                             echo '<select name="branchRefId" class="form-control" required>
                                                         <option value="">SELECT BRANCH</option>';
                                             include "conn.php";
                                             $sql = "SELECT * FROM `branch` ORDER BY RefId";
                                             $result = $conn->query($sql);
                                                while($row = $result->fetch_assoc()) {
                                                   echo '<option value="'.$row["RefId"].'">';
                                                   echo ''.$row["Name"].'</option>';
                                                }
                                             echo '<select>';
                                          ?>
                                       </div>
                                    </div>
                                    <div class="row margin-top">
                                       <div class="col-xs-6">
                                          <label>New Password:</label>
                                          <input type="password" class="form-control save-- mandatory--" name="Password" placeholder="Enter Password">
                                       </div>
                                    </div>
                                    <div class="row margin-top">
                                       <div class="col-xs-12">
                                          <label>What is your favorite pet?</label>
                                          <input type="text" class="form-control save-- mandatory--" name="Answer" placeholder="Enter Answer Here">
                                       </div>
                                    </div>
                                    <div class="row margin-top">
                                       <div class="col-xs-12">
                                          <button type="submit" class="btn btn-info">CHANGE PASSWORD</button>
                                          <button type="button" class="btn btn-danger" id="cancel">CANCEL</button>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  
                  <div class="col-xs-4">
                  
                  </div>
               </div>
            </div>
         </div>
      </form>
   </body>
</html>