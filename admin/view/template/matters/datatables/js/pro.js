$(document).ready(function() {
$("#save").click(function() {
var name = $("#catName").val();
var procode = $("#proCode").val();
var proname = $("#proName").val();
if (proname =='' && procode == '') {
alert("Please Enter Product name...!!!!!!");
}  else {
$.post("pro-exe.php", {
name1: name, 
pcode: procode,
pro_Name: proname,
}, function(data) {
if (data == 'You have Successfully Registered.....') {
$("form")[0].reset();
}
alert(data, 'Point Of Sale System');
});
}
});
});