<?php

include("includes/db.php");

if (isset($_GET['shop_id'])) {
    $shop_id = $_GET['shop_id'];

    $delete_shop = "DELETE FROM shops WHERE shop_id='$shop_id'";
    $run_delete = mysqli_query($con, $delete_shop);

    if ($run_delete) {
        echo "<script>alert('Shop has been deleted successfully')</script>";
        echo "<script>window.open('view_shops.php','_self')</script>";
    }
}
?>
