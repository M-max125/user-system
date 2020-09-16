$(document).ready(function () {
  //Home.php script

  //Add New Note Ajax Request
  $("#addNoteBtn").click(function (e) {
    if ($("#add-note-form")[0].checkValidity()) {
      e.preventDefault();
      $("#addNoteBtn").val("Please wait...");
      $.ajax({
        url: "process.php",
        method: "post",
        data: $("#add-note-form").serialize() + "&action=add_note",
        success: function (response) {
          $("#addNoteBtn").val("Add New Note");
          $("#add-note-form")[0].reset();
          $("#addNoteModal").modal("hide");
          Swal.fire({
            title: "Note Added Successfuly!",
            type: "success",
          });
          displayAllNotes();
        },
      });
    }
  });

  //Edit Note of the User Ajax Request
  $("body").on("click", ".editBtn", function (e) {
    e.preventDefault();

    edit_id = $(this).attr("id"); //grabbing the id into the variable edit_id

    $.ajax({
      url: "process.php",
      method: "post",
      data: { edit_id: edit_id },
      success: function (response) {
        data = JSON.parse(response); // That enables the response to be a javascript object
        $("#id").val(data.id); //Selecting the id of the hidden input(from the edit modal) and adding the value id from data variable(the javascript object)
        $("#title").val(data.title); // Adding the value to title
        $("#note").val(data.note); // Adding value to note
      },
    });
  });

  //Editing/Updating the Note of the User
  $("#editNoteBtn").click(function (e) {
    if ($("#edit-note-form")[0].checkValidity()) {
      e.preventDefault();

      $.ajax({
        url: "process.php",
        method: "post",
        data: $("#edit-note-form").serialize() + "&action=update_note",
        success: function (response) {
          Swal.fire({
            title: "Note Updated Successfuly!",
            type: "success",
          });
          $("#edit-note-form")[0].reset;
          $("#editNoteModal").modal("hide");
          displayAllNotes(); // Whenever a note is updated in the table will be displayed the updated note
        },
      });
    }
  });

  //Delete User Note Ajax Request
  $("body").on("click", ".deleteBtn", function (e) {
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
          url: "process.php",
          method: "post",
          data: { del_id: del_id },
          success: function (response) {
            Swal.fire("Deleted!", "Note  Deleted Successfuly!", "success");
            displayAllNotes();
          },
        });
      }
    });
  });

  //Display A Note User Details Ajax Request
  $("body").on("click", ".infoBtn", function (e) {
    e.preventDefault();

    info_id = $(this).attr("id");

    $.ajax({
      url: "process.php",
      method: "post",
      data: { info_id: info_id },
      success: function (response) {
        data = JSON.parse(response);

        Swal.fire({
          title: "<strong>Note : ID(" + data.id + ")</strong>",
          type: "info",
          html:
            "<b>Title : </b>" +
            data.title +
            "<br><br><b>Content : </b>" +
            data.note +
            "<br><br><b>Created On :</b>" +
            data.created_at +
            "<br><br><b>Updated On : </b>" +
            data.updated_at,
          showCloseButton: true,
        });
      },
    });
  });

  displayAllNotes();

  //Displying the notes of the user
  function displayAllNotes() {
    $.ajax({
      url: "process.php",
      method: "post",
      data: { action: "display_notes" },
      success: function (response) {
        $("#showNote").html(response);
        $("table").DataTable({
          order: [0, "desc"],
        });
      },
    });
  }

  //Profile.php script
  //Profile Update Ajax Request
  $("#profile-update-form").submit(function (e) {
    e.preventDefault();
    $.ajax({
      url: "process.php",
      method: "post",
      processData: false,
      contentType: false,
      cache: false,
      data: new FormData(this),
      success: function (response) {
        location.reload(); //automatic refresh and displaying the updated profile
      },
    });
  });

  //Change Password Ajax Request
  $("#changePassBtn").click(function (e) {
    if ($("#change-pass-form")[0].checkValidity()) {
      e.preventDefault();
      $("#changePassBtn").val("Please wait...");

      if ($("#newpass").val() != $("#cnewpass").val()) {
        $("#changepassError").text("*Passwords do not match!");
        $("#changePassBtn").val("Change Password");
      } else {
        $.ajax({
          url: "process.php",
          method: "post",
          data: $("#change-pass-form").serialize() + "&action=change-pass",
          success: function (response) {
            $("#changepassAlert").html(response);
            $("#changePassBtn").val("Change Password");
            $("#changepassError").text("");
            $("#change-pass-form")[0].reset();
          },
        });
      }
    }
  });

  //Verify Email Ajax Request
  $("#verify-email").click(function (e) {
    e.preventDefault();
    $(this).text("Please wait..");

    $.ajax({
      url: "process.php",
      method: "post",
      data: { action: "verify-email" },
      success: function (response) {
        $("#verifyEmailAlert").html(response);
        $("#verify-email").text("Verify Now!");
      },
    });
  });

  //Feedback.php script

  //Send Feedback Ajax Request
  $("#feedbackBtn").click(function (e) {
    if ($("#feedback-form")[0].checkValidity()) {
      e.preventDefault();

      $(this).val("Please wait..");

      $.ajax({
        url: "process.php",
        method: "post",
        data: $("#feedback-form").serialize() + "&action=feedback",
        success: function (response) {
          $("#feedback-form")[0].reset();
          $("#feedbackBtn").val("Send Feedback");
          Swal.fire({
            title: "Feedback Successfully Sent!",
            type: "success",
          });
        },
      });
    }
  });

  //Notification.php script

  fetchNotification();

  //Fetch User Notification

  function fetchNotification() {
    $.ajax({
      url: "process.php",
      method: "post",
      data: { action: "fetchNotification" },
      success: function (response) {
        $("#showAllNotifications").html(response);
      },
    });
  }

  checkNotification();
  //Check IF there is any Notification
  function checkNotification() {
    $.ajax({
      url: "process.php",
      method: "post",
      data: { action: "checkNotification" },
      success: function (response) {
        $("#checkNotification").html(response);
      },
    });
  }

  //Remove Notification
  $("body").on("click", ".close", function (e) {
    e.preventDefault();
    notification_id = $(this).attr("id");

    $.ajax({
      url: "process.php",
      method: "post",
      data: { notification_id: notification_id },
      success: function (response) {
        checkNotification();
        fetchNotification();
      },
    });
  });
});
