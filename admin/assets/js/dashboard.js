$(document).ready(function () {
  $("#open-nav").click(function () {
    $(".admin-nav").toggleClass("animate");
  });

  //Fetch Users in admin-users.php Ajax Request
  fetchAllUsers();
  function fetchAllUsers() {
    $.ajax({
      url: "admin-action.php",
      method: "post",
      data: { action: "fetchAllUsers" },
      success: function (response) {
        $("#showAllUsers").html(response);
        $(".tableOne").DataTable({
          order: [0, "desc"],
        });
      },
    });
  }

  //Display User's Details Ajax Request-for the showUserDetailsModal
  $("body").on("click", ".userDetailsIcon", function (e) {
    e.preventDefault();

    details_id = $(this).attr("id");
    $.ajax({
      url: "admin-action.php",
      type: "post",
      data: { details_id: details_id },
      success: function (response) {
        data = JSON.parse(response);
        $("#getName").text(data.name + "" + "(ID: " + data.id + ")");
        $("#getEmail").text("Email : " + data.email);
        $("#getPhone").text("Phone : " + data.phone);
        $("#getGender").text("Gender : " + data.gender);
        $("#getDob").text("Date of Birth : " + data.dob);
        $("#getCreated").text("Joined On : " + data.created_at);
        $("#getVerified").text("Verified : " + data.verified);

        if (data.photo != "") {
          $("#getImage").attr("src", "../" + data.photo);
        } else {
          $("#getImage").attr(
            "src",
            "https://www.pngarts.com/files/3/Avatar-Free-PNG-Image.png"
          );
        }
      },
    });
  });

  //Delete User Ajax Request
  $("body").on("click", ".deleteUserIcon", function (e) {
    e.preventDefault();

    del_id = $(this).attr("id");

    Swal.fire({
      title: "Are you sure?",
      text: "You won't be able to revert this!",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, delete it!",
    }).then((result) => {
      if (result.value) {
        $.ajax({
          url: "admin-action.php",
          method: "post",
          data: { del_id: del_id },
          success: function (response) {
            Swal.fire("Deleted!", "User  Deleted Successfuly!", "success");
            fetchAllUsers();
          },
        });
      }
    });
  });

  //Fetch Deleted Users Ajax Request

  fetchAllDeletedUsers();
  function fetchAllDeletedUsers() {
    $.ajax({
      url: "admin-action.php",
      method: "post",
      data: { action: "fetchAllDeletedUsers" },
      success: function (response) {
        $("#showAllDeletedUsers").html(response);
        $(".tableTwo").DataTable({
          order: [0, "desc"],
        });
      },
    });
  }

  //Restore Deleted Users Ajax Request

  $("body").on("click", ".restoreUserIcon", function (e) {
    e.preventDefault();

    restore_id = $(this).attr("id");

    Swal.fire({
      title: "Are you sure you want to restore this user?",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, restore it!",
    }).then((result) => {
      if (result.value) {
        $.ajax({
          url: "admin-action.php",
          method: "post",
          data: { restore_id: restore_id },
          success: function (response) {
            Swal.fire("Restored!", "User  Restored Successfuly!", "success");
            fetchAllDeletedUsers();
          },
        });
      }
    });
  });

  //Fetch All Notes From Users Ajax Request

  fetchAllNotes();
  function fetchAllNotes() {
    $.ajax({
      url: "admin-action.php",
      method: "post",
      data: { action: "fetchAllNotes" },
      success: function (response) {
        $("#showAllNotes").html(response);
        $(".tableThree").DataTable({
          order: [0, "desc"],
        });
      },
    });
  }

  //Delete User Note from dashboard Ajax Request

  $("body").on("click", ".deleteNoteIcon", function (e) {
    e.preventDefault();

    note_id = $(this).attr("id");

    Swal.fire({
      title: "Are you sure?",
      text: "You won't be able to revert this!",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, delete it!",
    }).then((result) => {
      if (result.value) {
        $.ajax({
          url: "admin-action.php",
          method: "post",
          data: { note_id: note_id },
          success: function (response) {
            Swal.fire("Deleted!", "Note  Deleted Successfuly!", "success");
            fetchAllNotes();
          },
        });
      }
    });
  });

  //Fetch Feedback Ajax Request

  fetchTotalFeedback();
  function fetchTotalFeedback() {
    $.ajax({
      url: "admin-action.php",
      method: "post",
      data: { action: "fetchTotalFeedback" },
      success: function (response) {
        $("#showTotalFeedback").html(response);
        $(".tableFour").DataTable({
          order: [0, "desc"],
        });
      },
    });
  }

  //Get The Current Row id and Feedback ID
  var uid;
  var fid;
  $("body").on("click", ".feedbackReplyIcon", function (e) {
    uid = $(this).attr("id");
    fid = $(this).attr("fid");
    //Send Feedback Reply Axaj Request
    $("#feedbackReplyBtn").click(function (e) {
      if ($("#feedback-reply-form")[0].checkValidity()) {
        let message = $("#message").val();
        e.preventDefault();
        $("#feedbackReplyBtn").val("Please wait...");

        $.ajax({
          url: "admin-action.php",
          method: "post",
          data: { uid: uid, message: message, fid: fid },
          success: function (response) {
            $("#feedbackReplyBtn").val("Send Reply");
            $("#displayReplyModal").modal("hide");
            $("#feedback-reply-form")[0].reset();

            Swal.fire(
              "Sent!",
              "Reply sent successfully to the user!",
              "success"
            );
            fetchTotalFeedback();
          },
        });
      }
    });
  });
  getAdminNotification();
  //Fetch Admin Notification Ajax Request
  function getAdminNotification() {
    $.ajax({
      url: "admin-action.php",
      method: "post",
      data: { action: "getNotification" },
      success: function (response) {
        $("#displayNotification").html(response);
      },
    });
  }
  //Display active Red Dot Admin Notification
  alertNotification();
  function alertNotification() {
    $.ajax({
      url: "admin-action.php",
      method: "post",
      data: { action: "alertNotification" },
      success: function (response) {
        $("#alertNotification").html(response);
      },
    });
  }

  //Remove Notification Ajax Request

  $("body").on("click", ".close", function (e) {
    e.preventDefault();

    notification_id = $(this).attr("id");
    $.ajax({
      url: "admin-action.php",
      method: "post",
      data: { notification_id: notification_id },
      success: function (response) {
        getAdminNotification();
        alertNotification();
      },
    });
  });
});
