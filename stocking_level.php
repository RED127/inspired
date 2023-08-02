<?php
require_once("config.php");
require_once("functions.php");
$page_name = "Stocking Levels";
require_once("assets.php");
$week_start = date('Y-m-d', strtotime("this week"));
$week_end = date('Y-m-d', strtotime("+6 days", strtotime($week_start)));
?>
<link rel="stylesheet" href="assets/css/bootstrap-datetimepicker.min.css">
<!-- DataTables -->
<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

<style>
    #low_content {
        padding: 2%;
    }

    .low-item {
        text-align: center;
        background: #efa3a3;
        padding: 10px 0 5px 0;
        margin: 2%;
        width: 130px;
        height: 105px;
    }

    #high_content {
        padding: 2%;
    }

    .high-item {
        text-align: center;
        background: #d5efa7;
        padding: 10px 0 5px 0;
        margin: 2%;
        width: 130px;
        height: 105px;
    }
</style>

<body class="hold-transition sidebar-collapse layout-top-nav" onload="startTime()">
    <div class="wrapper">
        <?php include("header.php"); ?>
        <?php include("menu.php"); ?>
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-12" style="text-transform: uppercase; text-align:center;">
                            <h1 class="m-0" style="display: inline"><?php echo $page_name; ?></h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6" style="border-right:1px solid; height:75vh">
                            <div class="col-sm-12" style="text-transform: uppercase; text-align:center;">
                                <h2 class="m-0" style="display: inline">HIGH</h2>
                            </div>
                            <div class="col-sm-9" style="text-transform: uppercase; text-align:center;background-color:#d5efa7;padding:5%;">
                                <h3 class="m-0" style="display: inline">HIGH OVERVIEW TOTAL: <span id="high_count">0</span></h3>
                            </div>
                            <div id="high_content" class="row">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="col-sm-12" style="text-transform: uppercase; text-align:center;">
                                <h2 class="m-0" style="display: inline">LOW</h2>
                            </div>
                            <div class="col-sm-9" style="text-transform: uppercase; text-align:center;background-color:#efa3a3;padding:5%;">
                                <h3 class="m-0" style="display: inline">LOW OVERVIEW TOTAL: <span id="high_count">15</span></h3>
                            </div>
                            <div id="low_content" class="row col-sm-12">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.content-wrapper -->
        <?php include("footer.php"); ?>
    </div>

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="plugins/moment/moment.min.js"></script>
    <script src="assets/js/bootstrap-datetimepicker.min.js"></script>
    <!-- DataTables  & Plugins -->
    <script src="plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="plugins/jszip/jszip.min.js"></script>
    <script src="plugins/pdfmake/pdfmake.min.js"></script>
    <script src="plugins/pdfmake/vfs_fonts.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <!-- AdminLTE App -->
    <script src="assets/js/adminlte.min.js"></script>
    <script src="assets/js/custom.js"></script>
    <script>
        $(document).ready(function() {
            read_stock_level();

            function read_stock_level() {
                $.ajax({
                    url: "actions.php",
                    method: "post",
                    data: {
                        action: 'read_stock_level'
                    }
                }).done(function(res) {
                    res = JSON.parse(res);
                    $('#low_content').html(res.min);
                    $('#high_content').html(res.max);
                });
            }

        });
    </script>
</body>

</html>