<!-- Argon Scripts -->
<!-- Core -->
<script src="<?php echo base_url("assets/vendor/jquery/dist/jquery.min.js"); ?>"></script>

<script src="<?php /*echo base_url("assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"); */ ?>"></script>

<!-- Argon JS -->
<script src="<?php echo base_url("assets/js/argon.js?v=1.0.0"); ?>"></script>

<script type="text/javascript" src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="https://earthchie.github.io/jquery.Thailand.js/jquery.Thailand.js/dependencies/JQL.min.js"></script>
<script type="text/javascript" src="https://earthchie.github.io/jquery.Thailand.js/jquery.Thailand.js/dependencies/typeahead.bundle.js"></script>
<link rel="stylesheet" href="https://earthchie.github.io/jquery.Thailand.js/jquery.Thailand.js/dist/jquery.Thailand.min.css">
<script type="text/javascript" src="https://earthchie.github.io/jquery.Thailand.js/jquery.Thailand.js/dist/jquery.Thailand.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.2/css/responsive.dataTables.css" />
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.2/js/dataTables.responsive.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/rowreorder/1.2.5/js/dataTables.rowReorder.min.js"></script>


<?php
if ($admin) {
  echo "<script src='" . base_url("assets/DataTables/datatables.min.js") . "'></script>";
  if ($page == 'user') {
    echo "<script src='" . base_url("assets/js/apps/users.js") . "'></script>";
  } else if ($page == 'permissions') {
    echo "<script src='" . base_url("assets/js/apps/permission.js") . "'></script>";
  } else if ($page == 'settings') {
    echo "<script src='" . base_url("assets/js/apps/setting.js") . "'></script>";
  } else if ($page == 'drug') {
    echo "<script src='" . base_url("assets/js/apps/drug.js") . "'></script>";
  } else if ($page == 'drugformula') {
    echo "<script src='" . base_url("assets/js/apps/drugformula.js") . "'></script>";
  } else if ($page == 'material') {
    echo "<script src='" . base_url("assets/js/apps/material.js") . "'></script>";
  } else if ($page == 'plant') {
    echo "<script src='" . base_url("assets/js/apps/plant.js") . "'></script>";
  } else if ($page == 'planting') {
    echo "<script src='" . base_url("assets/js/apps/planting_list.js") . "'></script>";
  } else if ($page == 'order') {
    echo "<script src='" . base_url("assets/js/apps/order.js") . "'></script>";
  } else if ($page == 'stock_handover') {
    echo "<script src='" . base_url("assets/js/apps/stock_handover.js") . "'></script>";
  } else if ($page == 'stock') {
    echo "<script src='" . base_url("assets/js/apps/stock.js") . "'></script>";
  } else if ($page == 'stock_recieve') {
    echo "<script src='" . base_url("assets/js/apps/stock_recieve.js") . "'></script>";
  } else if ($page == 'customer') {
    echo "<script src='" . base_url("assets/js/apps/customer.js") . "'></script>";
  }
  
  
}
?>
</body>

</html>