<?php
include("includes/db.php"); // Include the database connection

if (!isset($_SESSION['customer_email'])) {
    echo "<script>window.open('login.php','_self')</script>";
} else {
    $customer_email = $_SESSION['customer_email'];
    $get_customer = "SELECT * FROM customers WHERE customer_email='$customer_email'";
    $run_customer = mysqli_query($con, $get_customer);
    $row_customer = mysqli_fetch_array($run_customer);
    $customer_name = $row_customer['customer_name'];

    // Check if the customer has any shops registered
    $check_shop = "SELECT * FROM shops WHERE customer_name='$customer_name'";
    $run_check_shop = mysqli_query($con, $check_shop);
    $has_shop = mysqli_num_rows($run_check_shop) > 0;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title> Register Shop </title>
</head>
<body>
    <div class="row"><!-- 1 row Starts -->
        <div class="col-lg-12"><!-- col-lg-12 Starts -->
            <ol class="breadcrumb"><!-- breadcrumb Starts -->
                <li class="active">
                    <i class="fa fa-dashboard"></i> Shop Menu
                    <?php if ($has_shop) { ?>
                        <button onclick="window.location.href='view_shops.php'" class="btn btn-primary btn-sm">View Shop(s)</button>
                    <?php } ?>
                </li>
            </ol><!-- breadcrumb Ends -->
        </div><!-- col-lg-12 Ends -->
    </div><!-- 1 row Ends -->

    <div class="row"><!-- 2 row Starts -->
        <div class="col-lg-12"><!-- col-lg-12 Starts -->
            <div class="panel panel-default"><!-- panel panel-default Starts -->
                <div class="panel-heading"><!-- panel-heading Starts -->
                    <h3 class="panel-title"><!-- panel-title Starts -->
                        <i class="fa fa-money fa-fw"> </i> Insert Shop
                    </h3><!-- panel-title Ends -->
                </div><!-- panel-heading Ends -->
                <div class="panel-body"><!-- panel-body Starts -->
                    <form class="form-horizontal" action="" method="post" enctype="multipart/form-data"><!-- form-horizontal Starts -->
                        <div class="form-group"><!-- form-group Starts -->
                            <label class="col-md-3 control-label"> Shop Name </label>
                            <div class="col-md-6">
                                <input type="text" name="shop_name" class="form-control" required>
                            </div>
                        </div><!-- form-group Ends -->
                        <div class="form-group"><!-- form-group Starts -->
                            <label class="col-md-3 control-label"> Select Shop Image </label>
                            <div class="col-md-6">
                                <input type="file" name="shop_image" class="form-control" required>
                            </div>
                        </div><!-- form-group Ends -->
                        <div class="form-group"><!-- form-group Starts -->
                            <label class="col-md-3 control-label"> Shop Description </label>
                            <div class="col-md-6">
                                <textarea name="shop_description" class="form-control" rows="6" required></textarea>
                            </div>
                        </div><!-- form-group Ends -->
                        <div class="form-group"><!-- form-group Starts -->
                            <label class="col-md-3 control-label"> Shop Location </label>
                            <div class="col-md-6">
                                <input type="text" name="shop_location" class="form-control" required>
                            </div>
                        </div><!-- form-group Ends -->
                        <div class="form-group"><!-- form-group Starts -->
                            <label class="col-md-3 control-label"> Shop Contact </label>
                            <div class="col-md-6">
                                <input type="text" name="shop_contact" class="form-control" required>
                            </div>
                        </div><!-- form-group Ends -->
                        <div class="form-group"><!-- form-group Starts -->
                            <label class="col-md-3 control-label"> </label>
                            <div class="col-md-6">
                                <input type="submit" name="submit" class="form-control btn btn-primary" value=" Insert Shop ">
                            </div>
                        </div><!-- form-group Ends -->
                    </form><!-- form-horizontal Ends -->
                </div><!-- panel-body Ends -->
            </div><!-- panel panel-default Ends -->
        </div><!-- col-lg-12 Ends -->
    </div><!-- 2 row Ends -->
</body>
</html>

<?php

if (isset($_POST['submit'])) {
    $shop_name = $_POST['shop_name'];
    $shop_image = $_FILES['shop_image']['name'];
    $shop_description = $_POST['shop_description'];
    $shop_location = $_POST['shop_location'];
    $shop_contact = $_POST['shop_contact'];

    $tmp_name = $_FILES['shop_image']['tmp_name'];

    move_uploaded_file($tmp_name, "shop_images/$shop_image");

    $insert_shop = "INSERT INTO shops (shop_name, shop_image, shop_description, shop_location, shop_contact, customer_name) VALUES ('$shop_name', '$shop_image', '$shop_description', '$shop_location', '$shop_contact', '$customer_name')";

    $run_shop = mysqli_query($con, $insert_shop);

    if ($run_shop) {
        echo "<script>alert('New Shop Has Been Inserted');</script>";
        echo "<script>window.open('view_shops.php','_self');</script>";
    }
}
?>
