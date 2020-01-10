<?php
function secure($value)
{
  $value = htmlentities($value, ENT_QUOTES);
  return $value;
}

include 'connection.php';
$error = array(
          'ssn'  => '',
        );
if(isset($_GET['submit']))
{

  if(empty($_GET['ssn']))
    $error['ssn'] = "<span style='color:red'>SSN is Required</span>";
  else
    $ssn = secure($_GET['ssn']);
}

?>

<!DOCTYPE html>
<html>
<head>
  <title></title>
  <link rel="stylesheet" href="style1.css">
</head>
<body>

  <form>
    <table>
      <tr>
        <td>SSN</td>
        <td> <input type="number" name="ssn" placeholder="1293713123 ..."> </td>
      </tr>
      <tr><td colspan="2"></td></tr>
      <tr>
        <td colspan="2" align="center"> <input type="submit" name="submit" value="Check out"> </td> 
      </tr>
    </table>
  </form>

</body>
</html>

<?php
$sum = 0;
if(isset($_GET['submit']))
{
  if(!empty($ssn))
  {
    $sql = "SELECT username,users_ssn,product_id,product_name,product_quantity,product_price FROM users_product UP, product P , users U WHERE U.ssn = UP.users_ssn AND P.id = UP.product_id AND ssn = ?";
    $stmt = $conn -> prepare($sql);
    $stmt -> execute(array($ssn));

    echo "<table border=2>
    <tr>
    <td>User</td>
    <td>USER SSN</td>
    <td>Product ID</td>
    <td>Product Name</td>
    <td>Product Quantity</td>
    <td>Product Price</td>
    <td>Total Product Price</td>
    </tr>
    ";
    while ($row = $stmt -> fetch())
    {
      $sum += $row[5]*$row[4];
      echo
      "
      <tr>
      <td>$row[0]</td>
      <td>$row[1]</td>
      <td>$row[2]</td>
      <td>$row[3]</td>
      <td>$row[4]</td>
      <td>$row[5]</td>
      <td>".$row[5]*$row[4]."</td>
      </tr>
      ";
    }
    echo "</table><br> Total Price = $sum";
  }
}

?>