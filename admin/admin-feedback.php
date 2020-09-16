<?php
include_once('header-template.php');
?>

<div class="row">
    <div class="col-lg-12">
        <div class="card my-2 border-warning">
            <div class="card-header bg-warning text-white">
            <h4 class="m-0">Total Feedback from Users</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive" id="showTotalFeedback">
                <p class="text-center align-self-center lead">
                Please Wait...
                </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Design Reply Feedback Modal-->

<div class="modal fade" id="displayReplyModal">
    <div class="modal-dialog modal0dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title">Reply To This Feedback</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
            <form action="#" method="post" class="px-3" id="feedback-reply-form">
                <div class="form-group">
                <textarea name="message" id="message" class="form-control" rows="6" placeholder="Write Reply Here..." required></textarea>
                </div>

                <div class="form-group">
                <input type="submit" name="submit" value="Send Reply" class="btn btn-primary btn-block" id="feedbackReplyBtn">
                </div>
            
            
            </form>
            </div>
        </div>
    </div>
</div>


<!-- Design Reply Feedback Modal End-->

<!--Footer Area-->
        </div>
    </div>
</div>

<?php include_once('footer-template.php');?>
</body>
</html>