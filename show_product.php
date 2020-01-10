<?php

include 'connection.php';
$sql2 = "SELECT * FROM product";
$stmt2 = $conn -> prepare($sql2);
$stmt2 -> execute();

         echo "<table border = 1>";
         echo "<tr>
         <th style='text-align:center'>ID</th>
         <th style='text-align:center'>Product Name</th>
         <th style='text-align:center'>Product Price</th>
         <th style='text-align:center'>Product Stored</th>
         <th style='text-align:center'>Product Minimum</th>
         </tr>";
         while($row = $stmt2->fetch())
         {
           if($row[4] < $row[3])
           {
             echo "<tr>";
             echo "<td style='text-align:center'>$row[0]</td>";
             echo "<td style='text-align:center'>$row[1]</td>";
             echo "<td style='text-align:center'>$row[2]</td>";
             echo "<td style='text-align:center'>$row[3]</td>";
             echo "<td style='text-align:center'>$row[4]</td>";
             echo "</tr>";
           }
           else
           {
             echo "<tr style='background-color:red'>";
             echo "<td style='text-align:center'>$row[0]</td>";
             echo "<td style='text-align:center'>$row[1]</td>";
             echo "<td style='text-align:center'>$row[2]</td>";
             echo "<td style='text-align:center'>$row[3]</td>";
             echo "<td style='text-align:center'>$row[4]</td>";
             echo "</tr>";
           }

         }


 ?>
