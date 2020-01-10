<?php
function secure($value)
{
  $value = htmlentities($value, ENT_QUOTES);
  return $value;
}

include 'connection.php';
$error = array(
          'ssn'         => '',
          'username'    => '',
        );
if(isset($_GET['submit']))
{
  if(empty($_GET['ssn']))
    $error['ssn'] = "<span style='color:red'>SSN Must not Empty</span>";
  else
    $ssn = secure($_GET['ssn']);

  if(empty($_GET['username']))
    $error['username'] = "<span style='color:red'>Username Must not Empty</span>";
  else
    $username = secure($_GET['username']);

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
    <form>
      <table>
        <tr>
          <td>SSN</td>
          <td> <input type="number" name="ssn" placeholder="127313172"></td>
          <td><?php echo $error['ssn']; ?></td>
        </tr>

        <tr>
          <td>Username</td>
          <td> <input type="text" name="username" placeholder="Mohamed , Ahmed , Omar ..."></td>
          <td><?php echo $error['username']; ?></td>
        </tr>

        <tr>
          <td colspan="3" align="center"> <input type="submit" name="submit" value="Submit"></td>
        </tr>
      </table>
    </form>
  </body>
</html>

<?php

if(!empty($username) && !empty($ssn))
{
  $sql = "INSERT INTO users VALUES(?,?)";
  $stmt = $conn -> prepare($sql);
  $stmt -> execute(array($ssn,$username));
  echo "<script>alert('User Inserted Successfully')</script>";
}







 ?>
