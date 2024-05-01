<?php


if(!isset($_SESSION['admin_email'])){

echo "<script>window.open('login.php','_self')</script>";

}

else {


?>

<?php

if(isset($_GET['edit_shop'])){

$edit_shop = $_GET['edit_shop'];

$get_shop = "select * from shops where shop_id='$edit_shop'";

$run_shop = mysqli_query($con,$get_shop);

$row_shop = mysqli_fetch_array($run_shop);

$m_id = $row_shop['shop_id'];

$m_title = $row_shop['shop_name'];

$m_top = $row_shop['shop_top'];

$m_image = $row_shop['shop_image'];

$new_m_image = $row_shop['shop_image'];


}


?>

<div class="row"><!-- 1 row Starts -->

<div class="col-lg-12"><!-- col-lg-12 Starts -->

<ol class="breadcrumb"><!-- breadcrumb Starts -->

<li class="active">

<i class="fa fa-dashboard"></i> Dashboard / Edit shop

</li>

</ol><!-- breadcrumb Ends -->

</div><!-- col-lg-12 Ends -->

</div><!-- 1 row Ends -->


<div class="row"><!-- 2 row Starts -->

<div class="col-lg-12"><!-- col-lg-12 Starts -->

<div class="panel panel-default"><!-- panel panel-default Starts -->

<div class="panel-heading"><!-- panel-heading Starts -->

<h3 class="panel-title"><!-- panel-title Starts -->

<i class="fa fa-money fa-fw"> </i> Edit shop

</h3><!-- panel-title Ends -->

</div><!-- panel-heading Ends -->

<div class="panel-body"><!-- panel-body Starts -->

<form class="form-horizontal" action="" method="post" enctype="multipart/form-data"><!-- form-horizontal Starts -->

<div class="form-group"><!-- form-group Starts -->

<label class="col-md-3 control-label"> shop Name </label>

<div class="col-md-6">

<input type="text" name="shop_name" class="form-control" value="<?php echo $m_title; ?>">

</div>

</div><!-- form-group Ends -->

<div class="form-group"><!-- form-group Starts -->

<label class="col-md-3 control-label"> Show as Top shops </label>

<div class="col-md-6">

<input type="radio" name="shop_top" value="yes" 
<?php if($m_top == 'no'){}else{ echo "checked='checked'"; } ?> >

<label> Yes </label>

<input type="radio" name="shop_top" value="no" 
<?php if($m_top == 'no'){ echo "checked='checked'"; }else{} ?> >

<label> No </label>

</div>

</div><!-- form-group Ends -->

<div class="form-group"><!-- form-group Starts -->

<label class="col-md-3 control-label"> Select shop Image </label>

<div class="col-md-6">

<input type="file" name="shop_image" class="form-control" >

<br>

<img src="other_images/<?php echo $m_image; ?>" width="70" height="70">

</div>

</div><!-- form-group Ends -->

<div class="form-group"><!-- form-group Starts -->

<label class="col-md-3 control-label"> </label>

<div class="col-md-6">

<input type="submit" name="update" class="form-control btn btn-primary" value=" Update shop " >

</div>

</div><!-- form-group Ends -->

</form><!-- form-horizontal Ends -->

</div><!-- panel-body Ends -->

</div><!-- panel panel-default Ends -->

</div><!-- col-lg-12 Ends -->

</div><!-- 2 row Ends -->

<?php

if(isset($_POST['update'])){

$shop_name = $_POST['shop_name'];

$shop_top = $_POST['shop_top'];

$shop_image = $_FILES['shop_image']['name'];

$tmp_name = $_FILES['shop_image']['tmp_name'];

move_uploaded_file($tmp_name,"other_images/$shop_image");

if(empty($shop_image)){

$shop_image = $new_m_image;

}

$update_shop = "update shops set shop_title='$shop_name',shop_top='$shop_top',shop_image='$shop_image' where shop_id='$m_id'";

$run_shop = mysqli_query($con,$update_shop);

if($run_shop){

echo "<script>alert('shop Has Been Updated')</script>";

echo "<script>window.open('index.php?view_shops','_self')</script>";

}

}

?>

<?php } ?>