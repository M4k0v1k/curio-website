<?php


if(!isset($_SESSION['admin_email'])){

echo "<script>window.open('login.php','_self')</script>";

}

else {


?>

<?php

if(isset($_GET['delete_shop'])){

$delete_id = $_GET['delete_shop'];

$delete_shop = "delete from shops where shop_id='$delete_id'";

$run_shop = mysqli_query($con,$delete_shop);

if($run_shop){

echo "<script>alert('One shop Has Been Deleted')</script>";
echo "<script>window.open('index.php?view_shops','_self')</script>";

}

}


?>


<?php } ?>