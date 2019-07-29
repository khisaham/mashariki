$(document).ready(function() {
$("#save").click(function() {
var uname = $("#username").val();
var email = $("#email").val();
var pwd = $("#password").val();
var cpwd = $("#cpassword").val();
var phone = $("#phone").val();
var position = $("#position").val();
if (uname == '' || email == '' || pwd == '' || cpwd == '' || phone =='') {
alert("Please Fill all fields...!!!!!!");
}  else {
$.post("reg-exe.php", {
user_name: uname,
email_address: email,
password: pwd,
cpassword: cpwd,
phone1: phone,
posi: position
}, function(data) {
if (data == 'You have Successfully Registered.....') {
$("form")[0].reset();
}
alert(data, 'Point Of Sale System');
});
}
});
});

