$(document).ready(function () {
   $("#cancel").click(function () {
      self.location = "index.php";
   });
   var fname = $("[name='FirstName']").val();
   var lname = $("[name='LastName']").val();
   var branch = $("[name='branchRefId']").val();
   var gender = $("[name='Sex']").val();
   if (!(fname == "" && lname == "" && branch == "" && gender == "")){
      $("[name='Username']").prop("disabled",false);
   }
   $("[name='Username']").blur(function () {
      var uname = $(this).val().length;
      //alert (uname);
      if(uname < 5){
         $("#status").html("Username should be 8 characters and above!!!");
         //alert("Username should be 8 characters and above!!!");
         $(this).focus();
         return false;
      }else{
         if (chkUsername(uname) == 1){
            $("#status").html("Username is already taken.");
            $(this).val("");
            $(this).focus();
            return false;
         } else {
           $("#status").html(""); 
         }
         
      }
   });
   $("[name='pass2']").blur(function () {
      var pass1 = $("[name='Password']").val();
      var pass2 = $(this).val();
      if(pass1 != pass2) {
         $("#status").html("Password Doesn't Match!!!");
         $("[name='Password']").focus();
         return false;
      } else {
         $("#status").html("");
         
      }
   });
});
function chkUsername(uname){
   $.post("system.php",
   {
      task:"chkUsername",
      uname:uname
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