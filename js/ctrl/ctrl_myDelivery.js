$(document).ready(function () {
   $("#reqview").hide();
   $("#reqProceed").hide();
   $("#selDriver").hide();
   $("#reqBack").click(function () {
      $("#reqview").hide();
      $("#list").show();
   });
   $("#reqDeliver").click(function () {
      var refid = $("#hRefId").val();
      var branchrefId = $("#hBranchRefId").val();
      delivered(refid,branchrefId);
   });
});
function checkDelivery(refid,branchrefId){
   $("#hBranchRefId").val(branchrefId);
   $("#hRefId").val(refid);
   $("#reqHeader").html("Request ID No. [" + refid + "]");
   $.post("system.php",
   {
      task:"getDelivery",
      refid:refid,
      branchrefId:branchrefId
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