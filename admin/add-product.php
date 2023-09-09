<?php
session_start();
// error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['imsaid'] == 0)) {
  header('location:logout.php');
} else {
  if (isset($_POST['submit'])) {
    $pname = $_POST['pname'];
    $bname = $_POST['bname'];
    $stock = $_POST['stock'];
    $price = $_POST['price'];
    $status = $_POST['status'];
    $specification = $_POST['specification'];
    //Product  Image 1
    $pic1 = $_FILES["image1"]["name"];
    $extension1 = substr($pic1, strlen($pic1) - 4, strlen($pic1));
    //Product  Image 2
    $pic2 = $_FILES["image2"]["name"];
    $extension2 = substr($pic2, strlen($pic2) - 4, strlen($pic2));
    //Product  Image 3
    $pic3 = $_FILES["image3"]["name"];
    $extension3 = substr($pic3, strlen($pic3) - 4, strlen($pic3));
    // allowed extensions
    $allowed_extensions = array(".jpg", "jpeg", ".png", ".gif");
    if (!in_array($extension1, $allowed_extensions)) {
      echo "<script>alert('Product image1 has Invalid format. Only jpg / jpeg/ png /gif format allowed');</script>";
    }
    if (!in_array($extension2, $allowed_extensions)) {
      echo "<script>alert('Product image2 has Invalid format. Only jpg / jpeg/ png /gif format allowed');</script>";
    }
    if (!in_array($extension3, $allowed_extensions)) {
      echo "<script>alert('Product image3 has Invalid format. Only jpg / jpeg/ png /gif format allowed');</script>";
    } else {
      $propic1 = md5($pic1) . time() . $extension1;
      $propic2 = md5($pic2) . time() . $extension2;
      $propic3 = md5($pic3) . time() . $extension3;
      move_uploaded_file($_FILES["image1"]["tmp_name"], "images/" . $propic1);
      move_uploaded_file($_FILES["image2"]["tmp_name"], "images/" . $propic2);
      move_uploaded_file($_FILES["image3"]["tmp_name"], "images/" . $propic3);
      $query = mysqli_query($con, "insert into tblproducts(ProductName,BrandName,Stock,Price,Status,Specification,Image1,Image2,Image3) value('$pname','$bname','$stock','$price','$status','$specification','$propic1','$propic2','$propic3')");
      if ($query) {

        echo '<script>alert("Product has been created.")</script>';
      } else {
        echo '<script>alert("Something Went Wrong. Please try again")</script>';
      }
    }
  }
?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <title>Agriculture equipment store|| Add Products</title>
    <?php include_once('includes/cs.php'); ?>

  </head>

  <body>

    <!--Header-part-->
    <?php include_once('includes/header.php'); ?>
    <?php include_once('includes/sidebar.php'); ?>


    <div id="content">
      <div id="content-header">
        <div id="breadcrumb"> <a href="dashboard.php" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="add-product.php" class="tip-bottom">Add Product</a></div>
        <h1>Add Product</h1>
      </div>
      <div class="container-fluid">
        <hr>
        <div class="row-fluid">
          <div class="span12">
            <div class="widget-box">
              <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
                <h5>Add Product</h5>
              </div>
              <div class="widget-content nopadding">
                <form method="post" class="form-horizontal" enctype="multipart/form-data">
                  <div class="control-group">
                    <label class="control-label">Product Name :</label>
                    <div class="controls">
                      <input type="text" class="span11" name="pname" id="pname" value="" required='true' placeholder="Enter Product Name" />
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label">Brand Name: :</label>
                    <div class="controls">
                      <select type="text" class="span11" name="bname" id="bname" value="" required='true' />
                      <option value="">Select Brand</option>
                      <?php $query1 = mysqli_query($con, "select * from tblbrand where Status='1'");
                      while ($row1 = mysqli_fetch_array($query1)) {
                      ?>
                        <option value="<?php echo $row1['BrandName']; ?>"><?php echo $row1['BrandName']; ?></option><?php } ?>
                      </select>
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label">Specification :</label>
                    <div class="controls">
                      <textarea type="text" class="textarea_editor span12" name="specification" id="specification" value="" required="true" placeholder="Specification" /></textarea>
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label">Image1 :</label>
                    <div class="controls">
                      <input type="file" class="span11" name="image1" id="image1" value="" required="true" />
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label">Image2 :</label>
                    <div class="controls">
                      <input type="file" class="span11" name="image2" id="image2" value="" required="true" />
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label">Image3 :</label>
                    <div class="controls">
                      <input type="file" class="span11" name="image3" id="image3" value="" required="true" />
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label">Stock(units) :</label>
                    <div class="controls">
                      <input type="text" class="span11" name="stock" id="stock" value="" required="true" placeholder="Enter Stock" />
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label">Price(perunits) :</label>
                    <div class="controls">
                      <input type="text" class="span11" name="price" id="price" value="" required="true" placeholder="Enter Price" />
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label">Status :</label>
                    <div class="controls">
                      <input type="checkbox" name="status" id="status" value="1" required="true" />
                    </div>
                  </div>

                  <div class="form-actions">
                    <button type="submit" class="btn btn-success" name="submit">Add</button>
                  </div>
                </form>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
    <?php include_once('includes/footer.php'); ?>
    <?php include_once('includes/js.php'); ?>
  </body>

  </html>
<?php } ?>