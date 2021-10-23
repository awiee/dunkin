$(document).ready(function () {
   $("#hcart").hide();
   $("#clr").click(function () {
      $("#hcart, #cart").html('');
      $("[id*='action_']").prop("disabled",false);
   });
   $("#prcd").click(function () {
      var obj = $("#hcart").html();
      if (obj == "") {
         alert("No items selected.");
         return false;
      } else {
         lessStock(obj);
      }
   });
   $("[id*='action_']").each(function () {
      $(this).click(function () {
         var id = $(this).attr("id").split("_")[1];
         //alert(id);   
         var name = $("#name_" + id).html();
         var qty = $("#qty_" + id).val();
         var stock = $("#stock_"+id).html();
         if (qty == 0) {
            alert("Purchase quantity is 0");
            $("#qty_" + id).val('');
            $("#qty_" + id).focus();
            return false;
         }
         if (qty > parseInt(stock)) {
            alert("Purchase quantity is over the limit");
            $("#qty_" + id).val('');
            $("#qty_" + id).focus();
            return false;
         } else {
            if (qty == "") {
               qty = 1;
            }
            //alert (name);
            //alert (qty);
            var drw = '<div class="row margin-top"><div class="col-xs-4 text-center">' + qty + '</div><div class="col-xs-8 text-right">' + name + '</div></div>';
            var hdrw = parseInt(qty) + "_" + parseInt(id) + ",";
            $("#hcart").append(hdrw);
            $("#cart").append(drw);
            $(this).prop("disabled",true);
         }
      }); 
   });
});
function lessStock(obj){
   $.post("system.php",
   {
      task:"lessStock",
      obj:obj
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