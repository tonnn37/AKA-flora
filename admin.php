<?php
$admin = true;
require_once './helpers/connect.php';
require_once './helpers/url.php';
require_once './components/head.php';
require_once './components/sidenav.php';
?>
<div class="main-content">
    <?php $page = (isset($_GET['page']) && $_GET["page"] != '') ? $_GET['page'] : "index"; ?>
    <?php require_once './components/navbar.php' ?>
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <?php
                        @session_start();
                        if ($_SESSION['userlevel']=='') {
                            echo "<script>
                                 
                                window.location = '" . base_url("login.php") . "'
                                    </script>";
                        } else {
                            $file = 'pages/' . $page . '.php';
                        }

                        if (file_exists($file)) {
                            require_once $file;
                        } else {
                            exit("<script>
                                alert('Error 404 : ขออภัย ไม่พบหน้าที่คุณเรียก');
                                window.location = '" . base_url("login.php") . "'
                            </script>");
                        }

                        ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php

require_once './components/scripts.php';
?>

