$(document).ready(function() {
$("#save").click(function() {
var name = $("#catName").val();
var procode = $("#proCode").val();
var proQty = $("#proQty").val();
var proPrice =  $("#proPrice").val(); 
var suppId =  $("#suppId").val();

if (proQty =='' || proPrice == '') {
alert("Please Enter Product Quantity and/or Price...!!!!!!");
}  else {
$.post("pur-exe.php", {
name1: name, 
pro_Code: procode,
pro_qty: proQty,
pro_price: proPrice,
supp_Id: suppId
}, function(data) {
if (data == 'You have Successfully Registered.....') {
$("form")[0].reset();
}
alert(data, 'Point Of Sale System');
});
}
});
});