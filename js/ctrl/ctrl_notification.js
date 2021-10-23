$(document).ready(function () {
   $("#reqview").hide();
   $("#reqProceed").hide();
   $("#selDriver").hide();
   $("#reqBack").click(function () {
      $("#reqview").hide();
      $("#list").show();
   });
   $("#reqCancel").click(function () {
      var RefId = $("#hRefId").val();
      if (confirm("Are you sure you want to Cancel this Request " + RefId + "?")) {
         cancelReq(RefId);
      }
   });
   $("#reqApprov").click(function () {
      alert("Select Employee Who Will Deliver..");
      $(this).hide();
      $("#reqCancel, #reqBack").hide();
      $("#reqProceed, #selDriver").show();
   });
   $("#reqProceed").click(function () {
      var RefId = $("#hRefId").val();
      proceedReq(RefId);
   });

});
function check(refid){
   $("#hRefId").val(refid);
   $("#reqHeader").html("Request ID No. [" + refid + "]");
   $.post("system.php",
   {
      task:"getRequest",
      refid:refid
   },
   function(data,status) {
      if (status == "success") {
         $("#list").hide();
         $("#reqview").show();
         try {
            $("#reqBody").html(data);
         } catch (e) {
            if (e instanceof SyntaxError) {
               alert(e.message);
            }
         }
      }

   });
}
function cancelReq(refid){
   $.post("system.php",
   {
      task:"CancelReq",
      refid:refid
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
function proceedReq(){
   var reqRefId = $("#hRefId").val();
   var driver = $("#driver").val();
   if (driver == ""){
      alert ("You Must Select Driver First");
      $("#driver").focus();
      return false;
   } else {
      var donutVal = "";
      $("[id*='donuts_']").each(function () {
         var drefid = $(this).attr("id");
         drefid = drefid.split("_")[1];
         var dVal = $(this).val();
         var donut = $("#dRefId_" + drefid).val();
         var rem = $("#remarks_" + drefid).val();
         var dum = $("#qty_" + drefid).val();
         if (dVal == ""){
            rem = "Approved";
            dVal = "";
         } else {
            dVal = dVal;
            rem = rem;
         }

         var a = dum + "_";
         a = a + dVal;
         a = a + "!";
         a = a + donut;
         a = a + ":";
         a = a + rem;
         a = a + ",";
         var dQty = a;
         donutVal += dQty;
      });
      //alert (donutVal);
      proceed(reqRefId,donutVal,driver);
   }
   
}
function proceed(reqRefId,donutVal,driver){
   $.post("system.php",
   {
      task:"ReqApproved",
      refid:reqRefId,
      obj:donutVal,
      driver:driver
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