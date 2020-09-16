$(document).ready(function () {
  //Admin Login Ajax Request
  $("#adminLoginBtn").click(function (e) {
    if ($("#admin-login-form")[0].checkValidity()) {
      e.preventDefault();
      $("#adminLoginBtn").val("Please wait...");

      $.ajax({
        url: "admin-action.php",
        method: "post",
        data: $("#admin-login-form").serialize() + "&action=admin-login",
        success: function (response) {
          if (response === "admin_login") {
            window.location = "admin-dashboard.php";
          } else {
            $("#adminLoginAlert").html(response);
          }
          $("#adminLoginBtn").val("Login");
        },
      });
    }
  });
});
