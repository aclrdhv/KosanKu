let alert = $(".alert-danger");
alert.addClass("alert-on");
setTimeout(() => {
  alert.removeClass("alert-on");
}, 2500);
