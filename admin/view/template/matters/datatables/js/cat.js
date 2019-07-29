$(document).ready(function() {
$("#save").click(function() {
var name = $("#catname").val();
if (name == '') {
alert("Please Enter Category name...!!!!!!");
}  else {
$.post("category-exe.php", {
name1: name,
}, function(data) {
if (data == 'You have Successfully Registered.....') {
$("form")[0].reset();
}
alert(data, 'Point Of Sale System');
});
}
});
});