<?php
include_once('header.php');
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8 mt-3">
        <?php if($verified == 'Verified!'):?>
            <div class="card border-primary">
                <div class="card-header lead text-center bg-primary text-white">Send Feedback to Admin!</div>
                <div class="card-body">
                <form action="#" method="post" class="px-4" id="feedback-form">
                    <div class="form-group">
                    <input type="text" name="subject" placeholder="Write Your Subject"
                    class="form-control-lg form-control rounded-0" required>
                    </div>

                    <div class="form-group">
                    <textarea name="feedback" placeholder="Write Your Feedback Here..." rows="8"
                    class="form-control-lg form-control rounded-0" required></textarea>
                    </div>

                    <div class="form-group">
                    <input type="submit" name="feedbackBtn" id="feedbackBtn" value="Send Feedback"
                    class="btn btn-primary btn-block btn-lg rounded-0">
                    </div>
                
                </form>
                </div>
            </div>
        <?php else:?>
        <h1 class="text-center text-secondary mt-5">Verify Your E-Mail First to Send Feedback to Admin!</h1>
        <?php endif;?>
        </div>
    </div>
</div>



<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/js/all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<script type="text/javascript" src="assets/js/userArea.js"></script>
</body>
</html>