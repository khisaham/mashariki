$(document).ready(function() {
$("#save").click(function() {
var proname = $("#proName").val();
var procatId = $("#procatId").val();
var proPrice = $("#proPrice").val();
if (proPrice =='') {
alert("Please Enter Product Price...!!!!!!");
}  else {
$.post("pricing-exe.php", {
proName: proname,
proCatId: procatId,
proprice: proPrice
}, function(data) {
if (data == 'You have Successfully Registered.....') {
$("form")[0].reset();
}
alert(data, 'Point Of Sale System');
});
}
});
});