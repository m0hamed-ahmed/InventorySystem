<?php

function secure($value)
{
  $value = htmlentities($value, ENT_QUOTES);
  return $value;
}

include 'connection.php';
$error = array(
          'ssn'               => '',
          'product_id'        => '',
          'product_quantity'  => 1,
        );
if(isset($_GET['submit0']))
{
  if(empty($_GET['ssn']))
    $error['ssn'] = "<span style='color:red'>SSN is Required</span>";
  else
    $ssn = secure($_GET['ssn']);

  if(empty($_GET['product_id']))
    $error['product_id'] = "<span style='color:red'>Product ID is Required</span>";
  else
    $product_id = secure($_GET['product_id']);

  if(empty($_GET['product_quantity']))
    $product_quantity = 1;
  else
    $product_quantity = secure($_GET['product_quantity']);
}
 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="style1.css">
  </head>
  <body>
    <form class="buy_product_form">
      <div class="div2">
          <iframe src="show_product.php" width="500px"></iframe>
      </div>
      <div class="div1">
        <table border="0">
          <tr>
            <td>SSN</td>
            <td> <input type="number" name="ssn" placeholder="17424923489 ...."> </td>
            <td><?php echo $error['ssn'];?></td>
          </tr>
          <tr>
            <td>Product ID</td>
            <td> <input type="number" name="product_id" placeholder="1,2,3,4 ...."> </td>
            <td><?php echo $error['product_id'];?></td>
          </tr>
          <tr>
            <td>Product Quantity</td>
            <td> <input type="number" name="product_quantity" placeholder="1,2,3,4 ...."> </td>
            <td><?php echo "<span style='color:blue'>Defualt Quantity is ".$error['product_quantity']."</span>";?></td>
          </tr>
          <tr>
            <td colspan="3" align="center"> <input type="submit" name="submit0" value="Buy"> </td>
          </tr>
          <tr><td colspan="3"></td></tr>
          <tr>
            <td colspan="3">
            <a href="add_user.php" target="_blank" class="buy_product_a">Create Account</a>
            </td>
          </tr>
          <tr>
            <td colspan="3">
<?php
if(isset($_GET['submit0']))
{
  if(!empty($product_id) && !empty($product_quantity) && !empty($ssn) && $product_quantity > 0)
  {
    // Check if ssn user is exist or no
    $sql = "SELECT COUNT(*) FROM users WHERE ssn = ?";
    $stmt = $conn -> prepare($sql);
    $stmt -> execute(array($ssn));
    $row = $stmt -> fetch();
    $count = $row[0];
    if($count > 0)
    {
      $sql0 = "SELECT COUNT(*) FROM users_product WHERE users_ssn = ? AND product_id = ?";
      $stmt0 = $conn -> prepare($sql0);
      $stmt0 -> execute(array($ssn,$product_id));
      $row0 = $stmt0 -> fetch();
      $count0 = $row0[0];
      if($count0 < 1)
      {
        // Insert New Product

        $sql4 = "SELECT * FROM product WHERE id = ?";
        $stmt4 = $conn -> prepare($sql4);
        $stmt4 -> execute(array($product_id));
        $rows = $stmt4 -> fetch();
        $counts = $rows[3];
        if($product_quantity <= $counts)
        {
          $sql2 = "INSERT INTO users_product VALUES(?,?,?)";
          $stmt2 = $conn -> prepare($sql2);
          $stmt2 -> execute(array($product_id,$ssn,$product_quantity));
          
          $sql3 = "UPDATE product SET product_stored = product_stored - ? WHERE id = ?";
          $stmt3 = $conn -> prepare($sql3);
          $stmt3 -> execute(array($product_quantity,$product_id));
        }
        else
        {
            echo "[-] Sorry We Have only $counts From $rows[1]";
        }

      }
      else
      {
        // Update Quantity of Product if it's Exist

        $sql4 = "SELECT * FROM product WHERE id = ?";
        $stmt4 = $conn -> prepare($sql4);
        $stmt4 -> execute(array($product_id));
        $rows = $stmt4 -> fetch();
        $counts = $rows[3];
        if($product_quantity <= $counts)
        {
          $sql2 = "UPDATE users_product set product_quantity = product_quantity + ? WHERE product_id = ? AND users_ssn = ?";
          $stmt2 = $conn -> prepare($sql2);
          $stmt2 -> execute(array($product_quantity,$product_id,$ssn));

          $sql3 = "UPDATE product SET product_stored = product_stored - ? WHERE id = ?";
          $stmt3 = $conn -> prepare($sql3);
          $stmt3 -> execute(array($product_quantity,$product_id));
        }
        else
        {
            echo "[-] Sorry We Have only $counts From $rows[1]";
        }


      }
    }
    else {
      echo "<p>User SSN Doesn't Exist</p>";
    }
  }
}
 ?>
            </td>
          </tr>
        </table>
      </div><br><br>

 </form>
</body>
</html>
