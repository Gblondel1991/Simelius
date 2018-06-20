$(document).ready(function () {
$('#email').on('input', function (event) {
var email = event.target.value;

if (email.length > 3) {
$.ajax({
method: 'GET',
url: '/Simelius/ajax/checkuser.php?name='+email
}).done(function (result) {
console.log(result);
if (result.hasUser) {
$(event.target).addClass('is-invalid');
} else {
$(event.target).removeClass('is-invalid');
}
});
} else {
$(event.target).removeClass('is-invalid');
}
});
});