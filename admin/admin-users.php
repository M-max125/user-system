<?php
include_once('header-template.php');
?>
<div class="row">
    <div class="col-lg-12">
        <div class="card my-2 border-success">
            <div class="card-header bg-success text-white">
            <h4 class="m-0">Total Registered Users</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive" id="showAllUsers">
                <p class="text-center align-self-center lead">
                Please Wait...
                </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Display User Detail Modal-->
<div class="modal fade" id="showUsersDetailsModal">
    <div class="modal-dialog modal-dialog-centered mw-100 w-50">
        <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title" id="getName"></h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <div class="card-deck">
                    <div class="card border-primary">
                        <div class="card-body">
                            <p id="getEmail"></p>
                            <p id="getPhone"></p>
                            <p id="getDob"></p>
                            <p id="getGender"></p>
                            <p id="getCreated"></p>
                            <p id="getVerified"></p>
                        </div>
                    </div>

                    <div class="card align-self-center" >
                        <img src="https://www.pngarts.com/files/3/Avatar-Free-PNG-Image.png" 
                        class="img-thumbnail img-fluid align-self-center" id="getImage" width="280px"
                        alt="avatar">
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss = "modal">Close</button>
            </div>
        </div>
    </div>
</div>

            
<!--User Detail Modal End-->

<!--Footer Area-->
        </div>
    </div>
</div>

<?php include_once('footer-template.php');?>
</body>
</html>