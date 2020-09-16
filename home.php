<?php
include_once('header.php');
//In case user is deleted by admin
if(!$cuser->currentUser($_SESSION['user'])){
    $cuser->logout();
    header('location:index.php');
}
?>

<div class="container">
    <div class="row">
        <div class="col-lg-12">
        <?php if($verified == 'Not Verified!'): ?>
            <div class="alert alert-danger alert-dismissible text-center mt-2 m-0">
            <button class="close" type="button" data-dismiss="alert">&times;</button>
            <strong>Your E-mail is not verified! We've sent you an E-mail verification link on your E-mail,
            check & verify now!</strong>
            </div>
        <?php endif;?>
        <h4 class="text-center text-primary mt-2">Writes your notes here <i class="fas fa-pencil-alt fa-lg"></i></h4>
        </div>
    </div>
            <div class="card border-primary">
                <h5 class="card-header bg-primary d-flex justify-content-between">
                <span class="text-light lead align-self-center">All Notes</span>
                <a href="#" class="btn btn-light" data-toggle="modal" data-target="#addNoteModal">
                <i class="fas fa-plus-circle fa-lg"></i>&nbsp;Add New Note</a>
                </h5>
                    <div class="card-body">
                        <div class="table-responsive" id="showNote">
                           
                          
                            
                        </div>
                    
                    </div>
            </div>
</div>

<!-- Add Note Modal Start-->

<div class="modal fade" id="addNoteModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h4 class="modal-title text-light">Add New Note</h4>
                <button type="button" class="close text-light" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <form action="#" method="post" id="add-note-form" class="px-3">
                    <div class="form-group">
                        <input type="text" name="title" class="form-control form-control-lg" placeholder="Enter Title" required>
                    </div>

                    <div class="form-group">
                        <textarea name="note" class="form-control form-control-lg" placeholder="Write Your Note Here" 
                        rows="6" required></textarea>
                    </div>

                    <div class="form-group">
                        <input type="submit" name="addNote" id="addNoteBtn" value="Add New Note"
                        class="btn btn-success btn-block btn-lg">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--Add Note Modal End-->

<!--Note Edit Modal Start-->

<div class="modal fade" id="editNoteModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h4 class="modal-title text-light">Edit Note</h4>
                <button type="button" class="close text-light" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <form action="#" method="post" id="edit-note-form" class="px-3">
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <input type="text" name="title" id="title" class="form-control form-control-lg" placeholder="Enter Title" required>
                    </div>

                    <div class="form-group">
                        <textarea name="note" id="note" class="form-control form-control-lg" placeholder="Write Your Note Here" 
                        rows="6" required></textarea>
                    </div>

                    <div class="form-group">
                        <input type="submit" name="editNote" id="editNoteBtn" value="Edit Your Note"
                        class="btn btn-info btn-block btn-lg">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--Note Edit Modal End-->






<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/js/all.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.21/datatables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<script type="text/javascript" src="assets/js/userArea.js"></script>


</body>
</html>
