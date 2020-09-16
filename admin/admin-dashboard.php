<?php
include_once('header-template.php');
include_once('../classes/Admin.class.php');
$total = new Admin();
?>

<div class="row">
    <div class="col-lg-12">
        <div class="card-deck mt-3 text-light text-center font-weight-bold">
            
            <div class="card bg-primary">
                <div class="card-header">Total Users</div>
                <div class="card-body">
                <h1 class="display-4">
                <?= $total->totalCount('users');?>
                </h1>
                </div>
            </div>

            <div class="card bg-warning">
                <div class="card-header">Verified Users</div>
                <div class="card-body">
                <h1 class="display-4">
                <?= $total->verifyUsers(1);?>
                </h1>
                </div>
            </div>

            <div class="card bg-success">
                <div class="card-header">Unverified Users</div>
                <div class="card-body">
                <h1 class="display-4">
                <?= $total->verifyUsers(0);?>
                </h1>
                </div>
            </div>

            <div class="card bg-danger">
                <div class="card-header">Website Access</div>
                <div class="card-body">
                <h1 class="display-4">
                <?php $data = $total->siteAccess(); echo $data['hits'];?>
                </h1>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card-deck mt-3 text-light text-center font-weight-bold">
            
            <div class="card bg-danger">
                <div class="card-header">Total Notes</div>
                <div class="card-body">
                <h1 class="display-4">
                <?= $total->totalCount('notes');?>
                </h1>
                </div>
            </div>

            <div class="card bg-success">
                <div class="card-header">Total Feedback</div>
                <div class="card-body">
                <h1 class="display-4">
                <?= $total->totalCount('feedback');?>
                </h1>
                </div>
            </div>

            <div class="card bg-info">
                <div class="card-header">Total Notifications</div>
                <div class="card-body">
                <h1 class="display-4">
                <?= $total->totalCount('notification');?>
                </h1>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card-deck my-3">
            
            <div class="card border-success">
                <div class="card-header bg-success text-center text-white lead">
                Male/Female Users's Percentage
                </div>
                <div id="chartOne" style="width: 99%;height: 400px;">
                </div>
            </div>

            <div class="card border-info">
                <div class="card-header bg-info text-center text-white lead">
                Verified/Unverified Users's Percentage
                </div>
                <div id="chartTwo" style="width: 99%;height: 400px;">
                </div>
            </div>
        </div>
    </div>
</div>
<!--Footer Area-->
        </div>
    </div>
</div>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">

google.charts.load("current",{packages:["corechart"]});
google.charts.setOnLoadCallback(pieChart);
    function pieChart(){
        var data = google.visualization.arrayToDataTable([
            ['Gender','Number'],
            <?php
            $gender = $total->genderPercentage();
                foreach($gender as $row){
                    echo '["'.$row['gender'].'",'.$row['number'].'],';
                }
                ?>
        ]);
        var options = {
            is3D: false
        };
        var chart = new google.visualization.PieChart(document.getElementById('chartOne'));
        chart.draw(data,options);
    }


google.charts.load("current",{packages:["corechart"]});
google.charts.setOnLoadCallback(colChart);
    function colChart(){
        var data = google.visualization.arrayToDataTable([
            ['Verified','Number'],
            <?php
            $verified = $total->verifiedPercentage();
            foreach($verified as $row){
                if($row['verified'] == 0){
                    $row['verified'] = 'Unverified';
                }else{
                    $row['verified'] = 'Verified';
                }
                echo '["'.$row['verified'].'",'.$row['number'].'],';
            }
            ?>
        ]);
        var options = {
            pieHole: 0.4,
        };
        var chart = new google.visualization.PieChart(document.getElementById('chartTwo'));
        chart.draw(data,options);
    }

</script>
<?php include_once('footer-template.php');?>
</body>
</html>


