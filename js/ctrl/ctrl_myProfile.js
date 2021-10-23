$(document).ready(function () {
   getEmpInfo();
   $("#password, #btn_updatePW, #btn_cancelPW, #btn_updateInfo, #btn_cancelInfo").hide();
   $(".save--").prop("disabled",true);
   $("#btn_updateInfo").click(function () {
      updateEmpInfo();
   });
   $("#btn_editInfo").click(function () {
      $(".save--").prop("disabled",false);
      $(this).hide();
      $("#btn_chngPW").hide();
      $("#btn_updateInfo, #btn_cancelInfo").show();
   });
   $("#btn_cancelInfo").click(function () {
      $("#btn_updateInfo, #btn_cancelInfo").hide();
      $("#btn_editInfo, #btn_chngPW").show();
      $(".save--").prop("disabled",true);
      getEmpInfo();
   });

   $("#btn_chngPW").click(function () {
      $("#info").slideUp();
      $("#password").slideDown();
      $("#btn_editInfo, #btn_chngPW").hide();
      $("#btn_updatePW, #btn_cancelPW").show();
   });
   $("#btn_cancelPW").click(function () {
      $("#password").slideUp();
      $("#info").slideDown();
      $("#btn_updatePW, #btn_cancelPW").hide();
      $("#btn_editInfo, #btn_chngPW").show();
   });
   $("[class*='pass']").hover(function () {
      $(this).attr("type","text");
   },
   function(){
      $("[class*='pass']").attr("type","password");
   });
   $("#btn_updatePW").click(function () {
      if ($("#curr_PW").val() != ""){
         if ($("#fav_pet").val() != ""){
            if ($("#new_PW").val() != "") {
               if ($("#retype_PW").val() != "") {
                  if ($("#new_PW").val() == $("#retype_PW").val()) {
                     var currpw = $("#curr_PW").val();
                     var pet = $("#fav_pet").val();
                     var newpw = $("#new_PW").val();
                     var refid = $("#hEmpRefId").val();
                     updatePW(refid,currpw,pet,newpw);
                  } else {
                     alert("Password Didn't Match.");
                     $("#new_PW").focus();
                     return false;            
                  }
               } else {
                  alert("Re-Type Password is Needed.");
                  $("#retype_PW").focus();
                  return false;         
               }
            } else {
               alert("New Password is Needed.");
               $("#new_PW").focus();
               return false;      
            }
         } else {
            alert("Favorite Pet is Needed.");
            $("#fav_pet").focus();
            return false;   
         }
      } else {
         alert("Current Password is Needed.");
         $("#curr_PW").focus();
         return false;
      }
   });
});
function getEmpInfo(){
   $.post("system.php",
   {
      task:"getEmpInfo"
   },
   function(data,status) {
      if (status == "success") {
         code = data;
         try {
             eval(code);
         } catch (e) {
            if (e instanceof SyntaxError) {
               alert(e.message);
            }
         }
      }

   });
}
function updateEmpInfo(){
   var fname = $("[name='FirstName']").val();
   var lname = $("[name='LastName']").val();
   var mname = $("[name='MiddleName']").val();
   var extname = $("[name='ExtName']").val();
   var sex = $("[name='Sex']").val();
   var cvlstat = $("[name='CivilStatus']").val();
   var refid = $("#hEmpRefId").val();
   $.post("system.php",
   {
      task:"updateEmpInfo",
      EmpRefId:refid,
      FName:fname,
      LName:lname,
      MName:mname,
      ExtName:extname,
      Sex:sex,
      CvlStat:cvlstat
   },
   function(data,status) {
      if (status == "success") {
         code = data;
         try {
             eval(code);
         } catch (e) {
            if (e instanceof SyntaxError) {
               alert(e.message);
            }
         }
      }

   });
}
function updatePW(refid,currpw,pet,newpw) {
   $.post("system.php",
   {
      task:"updatePW",
      refid:refid,
      currpw:currpw,
      newpw:newpw
   },
   function(data,status) {
      if (status == "success") {
         code = data;
         try {
             eval(code);
         } catch (e) {
            if (e instanceof SyntaxError) {
               alert(e.message);
            }
         }
      }

   });
}