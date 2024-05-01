<?php
session_start();

// Redirect to login if session variable is not set
if (!isset($_SESSION['customer_email'])) {
    echo "<script>window.open('login.php','_self')</script>";
    exit();
}

// Include database connection
include("includes/db.php");

$customer_email = $_SESSION['customer_email'];

// Fetch customer details for display (optional)
$get_user = "SELECT * FROM customers WHERE customer_email=?";
$stmt = mysqli_prepare($con, $get_user);
mysqli_stmt_bind_param($stmt, "s", $customer_email);
mysqli_stmt_execute($stmt);
$result_user = mysqli_stmt_get_result($stmt);

if (!$result_user) {
    die("Query Failed: " . mysqli_error($con));
}

$row_user = mysqli_fetch_array($result_user);
$customer_name = $row_user['customer_name'];

// Initialize variables
$shop_id = $shop_name = $shop_image = $shop_description = $shop_location = $shop_contact = $new_shop_image = '';

if (isset($_GET['edit_shop'])) {
    $edit_shop = $_GET['edit_shop'];

    // Fetch shop details based on shop_id and customer_name
    $get_shop = "SELECT * FROM shops WHERE shop_id=? AND customer_name=?";
    $stmt = mysqli_prepare($con, $get_shop);
    mysqli_stmt_bind_param($stmt, "is", $edit_shop, $customer_name);
    mysqli_stmt_execute($stmt);
    $result_shop = mysqli_stmt_get_result($stmt);

    if (!$result_shop) {
        die("Query Failed: " . mysqli_error($con));
    }

    if (mysqli_num_rows($result_shop) == 0) {
        echo "<script>alert('You do not have permission to edit this shop.')</script>";
        echo "<script>window.open('index.php','_self')</script>";
        exit();
    }

    // Fetch shop details into variables
    $row_shop = mysqli_fetch_array($result_shop);

    $shop_id = $row_shop['shop_id'];
    $shop_name = $row_shop['shop_name'];
    $shop_description = $row_shop['shop_description'];
    $shop_location = $row_shop['shop_location'];
    $shop_contact = $row_shop['shop_contact'];
    $shop_image = $row_shop['shop_image'];
    $new_shop_image = $row_shop['shop_image'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Customer Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container"><!-- container Starts -->
    <div class="row"><!-- row Starts -->
        <div class="col-lg-12"><!-- col-lg-12 Starts -->
            <ol class="breadcrumb"><!-- breadcrumb Starts -->
                <li class="active">
                    <i class="fa fa-dashboard"></i> Dashboard / Edit Shop
                </li>
            </ol><!-- breadcrumb Ends -->
        </div><!-- col-lg-12 Ends -->
    </div><!-- row Ends -->

    <div class="row"><!-- row Starts -->
        <div class="col-lg-12"><!-- col-lg-12 Starts -->
            <div class="panel panel-default"><!-- panel panel-default Starts -->
                <div class="panel-heading"><!-- panel-heading Starts -->
                    <h3 class="panel-title"><!-- panel-title Starts -->
                        <i class="fa fa-money fa-fw"> </i> Edit Shop
                    </h3><!-- panel-title Ends -->
                </div><!-- panel-heading Ends -->

                <div class="panel-body"><!-- panel-body Starts -->
                    <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data"><!-- form-horizontal Starts -->

                        <div class="form-group"><!-- form-group Starts -->
                            <label class="col-md-3 control-label"> Shop Name </label>
                            <div class="col-md-6">
                                <input type="text" name="shop_name" class="form-control" value="<?php echo htmlspecialchars($shop_name); ?>">
                            </div>
                        </div><!-- form-group Ends -->

                        <div class="form-group"><!-- form-group Starts -->
                            <label class="col-md-3 control-label"> Shop Description </label>
                            <div class="col-md-6">
                                <textarea name="shop_description" class="form-control"><?php echo htmlspecialchars($shop_description); ?></textarea>
                            </div>
                        </div><!-- form-group Ends -->

                        <div class="form-group"><!-- form-group Starts -->
                            <label class="col-md-3 control-label"> Shop Location </label>
                            <div class="col-md-6">
                                <input type="text" name="shop_location" class="form-control" value="<?php echo htmlspecialchars($shop_location); ?>">
                            </div>
                        </div><!-- form-group Ends -->

                        <div class="form-group"><!-- form-group Starts -->
                            <label class="col-md-3 control-label"> Shop Contact </label>
                            <div class="col-md-6">
                                <input type="text" name="shop_contact" class="form-control" value="<?php echo htmlspecialchars($shop_contact); ?>">
                            </div>
                        </div><!-- form-group Ends -->

                        <div class="form-group"><!-- form-group Starts -->
                            <label class="col-md-3 control-label"> Select Shop Image </label>
                            <div class="col-md-6">
                                <input type="file" name="shop_image" class="form-control">
                                <br>
                                <img src="other_images/<?php echo htmlspecialchars($shop_image); ?>" width="70" height="70">
                            </div>
                        </div><!-- form-group Ends -->

                        <div class="form-group"><!-- form-group Starts -->
                            <label class="col-md-3 control-label"></label>
                            <div class="col-md-6">
                                <input type="submit" name="update" class="form-control btn btn-primary" value=" Update Shop ">
                                <input type="hidden" name="shop_id" value="<?php echo $shop_id; ?>">
                            </div>
                        </div><!-- form-group Ends -->
                    </form><!-- form-horizontal Ends -->
                </div><!-- panel-body Ends -->
            </div><!-- panel panel-default Ends -->
        </div><!-- col-lg-12 Ends -->
    </div><!-- row Ends -->
</div><!-- container Ends -->

<?php

if (isset($_POST['update'])) {
    $shop_id = $_POST['shop_id'];
    $shop_name = $_POST['shop_name'];
    $shop_description = $_POST['shop_description'];
    $shop_location = $_POST['shop_location'];
    $shop_contact = $_POST['shop_contact'];
    $shop_image = $_FILES['shop_image']['name'];
    $tmp_name = $_FILES['shop_image']['tmp_name'];

    if (!empty($shop_image)) {
        move_uploaded_file($tmp_name, "other_images/$shop_image");
    } else {
        $shop_image = $new_shop_image;
    }

    // Update shop details in the database
    $update_shop = "UPDATE shops SET shop_name=?, shop_description=?, shop_location=?, shop_contact=?, shop_image=? WHERE shop_id=? AND customer_name=?";
    $stmt = mysqli_prepare($con, $update_shop);
    mysqli_stmt_bind_param($stmt, "sssssis", $shop_name, $shop_description, $shop_location, $shop_contact, $shop_image, $shop_id, $customer_name);
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        echo "<script>alert('Shop Has Been Updated')</script>";
        echo "<script>window.open('index.php?view_shops','_self')</script>";
    } else {
        echo "<script>alert('Failed to update shop.')</script>";
    }
}

?>
</body>
</html>
