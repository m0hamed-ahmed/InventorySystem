<?php
 include 'connection.php';
 $error = array(
         'id' => '',
               );
if(isset($_GET['submit']))
{
  if(empty($_GET['id']))
    $error['id'] = "<span style='color:red'>* ID is Required</span>";
}
?>

 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
     <title>Search in DB</title>
     <link rel="stylesheet" href="style1.css">
   </head>
   <body>
      <form>
          <table>
            <tr>
              <td>ID Number</td>
              <td> <input type="number" name="id" placeholder="1 , 2 , 3 , 4 , 5 , 6 , 7 , ... "></td>
              <td><?php  echo $error['id'];?><br></td>
            </tr>
            <tr>
              <td colspan="3"></td>
            </tr>
            <tr>
              <td colspan="3" align="center"> <input type="submit" name="submit" value="Search"> </td>
            </tr>
          </table>

  </form>
     <div class="SearchId">
  <?php


if(!empty($_GET['id']))
{
    $ID = $_GET['id'];
    $sql = "SELECT * FROM product WHERE id = ?";
    $stmt = $conn -> prepare($sql);
    $stmt -> execute(array($ID));

    $sql2 = "SELECT * FROM product WHERE id = ?";
    $stmt2 = $conn -> prepare($sql2);
    $stmt2 -> execute(array($ID));
    $number = $stmt2 -> rowCount();
     if($number > 0)
       {
             echo "<table border = 1>";
             echo "<tr>
             <th style='text-align:center'>ID</th>
             <th style='text-align:center'>Product Name</th>
             <th style='text-align:center'>Product Price</th>
             <th style='text-align:center'>Product Stored</th>
             <th style='text-align:center'>Product Minimum</th>
             </tr>";
             while($row = $stmt->fetch())
             {
               echo "<tr>";
               echo "<td style='text-align:center'>$row[0]</td>";
               echo "<td style='text-align:center'>$row[1]</td>";
               echo "<td style='text-align:center'>$row[2]</td>";
               echo "<td style='text-align:center'>$row[3]</td>";
               echo "<td style='text-align:center'>$row[4]</td>";
               echo "</tr>";
             }
       }
       else
       {
         echo "<span class='error'>The Data of ID [ $ID ] is Not Found or You Don't Have Permission To Read</span><br>";
       }

}




  ?>
</div>

    </div>
      </article>
</body>
</html>
