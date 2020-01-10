<?php
function secure($value)
{
  $value = htmlentities($value, ENT_QUOTES);
  return $value;
}

include 'connection.php';
$error = array(
          'name'         => '',
          'id'           => '',
          'price'        => '',
          'quantity'     => '',
          'minimum'      => 2,
        );
if(isset($_GET['submit']))
{
  if(empty($_GET['product_id']))
    $error['id'] = "<span style='color:red'>Product id Must not Empty</span>";
  else
    $product_id = secure($_GET['product_id']);

  if(empty($_GET['product_name']))
    $error['name'] = "<span style='color:red'>Product Name Must not Empty</span>";
  else
    $product_name = secure($_GET['product_name']);

  if(empty($_GET['product_price']))
    $error['price'] = "<span style='color:red'>Product Price Must not Empty</span>";
  else
    $product_price = secure($_GET['product_price']);

  if(empty($_GET['product_quantity']))
    $error['quantity'] = "<span style='color:red'>Product Quentity Must not Empty</span>";
  else
    $product_quantity = secure($_GET['product_quantity']);

  if(empty($_GET['product_minimum']))
    $product_minimum = 2;
  else
    $product_minimum = secure($_GET['product_minimum']);

}

 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Project 2</title>
    <link rel="stylesheet" href="style1.css">
  </head>
  <body>
    <form>
      <table>
        <tr>
          <td>Product ID</td>
          <td> <input type="number" name="product_id" placeholder="127313172"></td>
          <td><?php echo $error['id']; ?></td>
        </tr>

        <tr>
          <td>Product Name</td>
          <td> <input type="text" name="product_name" placeholder="Samsung , Lenovo ..."></td>
          <td><?php echo $error['name']; ?></td>
        </tr>

        <tr>
          <td>price</td>
          <td> <input type="number" name="product_price" placeholder="1000 , 2000 ...."  step="0.1"></td>
          <td><?php echo $error['price']; ?></td>
        </tr>

        <tr>
          <td>Product Quantity</td>
          <td> <input type="number" name="product_quantity" placeholder="10 , 20 ...."></td>
          <td><?php echo $error['quantity']; ?></td>
        </tr>

        <tr>
          <td>Minimum Quantity</td>
          <td> <input type="number" name="product_minimum" placeholder="10 , 20 ...."></td>
          <td><?php echo "<span style='color:blue'> * Defualt Minimum Quantity is ".$error['minimum']."</span>"; ?></td>
        </tr>
        <tr>
          <td colspan="3" align="center"> <input type="submit" name="submit" value="Submit"></td>
        </tr>
      </table>
    </form>
  </body>
</html>

<?php

if(!empty($product_id) && !empty($product_name) && !empty($product_minimum) && !empty($product_quantity) && !empty($product_price))
{
  $sql = "INSERT INTO product VALUES(?,?,?,?,?)";
  $stmt = $conn -> prepare($sql);
  $stmt -> execute(array($product_id,$product_name,$product_price,$product_quantity,$product_minimum));
  echo "<script>alert('Data Inserted Successfully')</script>";
}

 ?>