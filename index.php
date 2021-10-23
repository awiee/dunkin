<!DOCTYPE html>
<html>
   <head>
      <?php
         include 'external.php';
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
            background:#000;
            color:#fff;
         }
      </style>
      <script>
         $(document).ready(function () {
            $("#register").click(function () {
               self.location = "register.php";
            });
            $("#forgot").click(function () {
               self.location = "forgotpassword.php";
            });
         });
      </script>
   </head>
   <body>
      <form method="post" action="ctrl_login.php">
         <div class="container-fluid">
            <div class="col-xs-2"></div>
            <div class="col-xs-8" style="padding:50px;">
               <div class="row" style="background-image:url('images/bg1.jpg');height:500px;width:100%;background-repeat:no-repeat;border:1px solid black;">
                  <div class="col-xs-12">
                     <div class="row" style="padding:10px;margin-top: 10%;">
                        <div class="txtPress text-center" style="font-size:25pt;color:#fff;">WELCOME TO DUNKIN DONUTS</div>
                        <?php 
                           if(isset($_GET["sess"])) {
                              $sess = $_GET["sess"];
                              if ($sess != ""){
                              echo '
                                 <script>
                                 $.notify("Session Expired","error");
                                 </script>
                              ';
                              }  
                           }
                        ?>
                     </div>
                     <div class="row margin-top" style="padding:20px;" id="login">
                        <div class="col-xs-8">
                           <div class="txtPress" style="font-size:25pt;color:#fff;">LOGIN USER</div>
                           <div class="row margin-top">
                              <div class="col-xs-12">
                                 <div class="form-group">
                                    <div class="row">
                                       <div class="col-xs-12">
                                          <label>USERNAME:</label>
                                          <input type="text" class="form-control save-- mandatory-- alphanum--" name="Username" placeholder="Enter Username" autofocus required>
                                       </div>
                                    </div>
                                    <div class="row margin-top">
                                       <div class="col-xs-12">
                                          <label>PASSWORD:</label>
                                          <input type="password" class="form-control save-- mandatory--" name="Password" placeholder="Enter Password" required>
                                       </div>
                                    </div>
                                    <div class="row margin-top">
                                       <div class="col-xs-12">
                                          <button type="submit" class="btn btn-info">LOG IN</button>
                                          <button type="button" class="btn btn-warning" id="register">REGISTER</button>
                                          <button type="button" class="btn btn-danger" id="forgot">FORGOT PASSWORD</button>
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