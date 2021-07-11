<?php
include '_dbconnect.php';

$sql = "SELECT cat_name FROM `categories` ";
                $result = mysqli_query($conn, $sql);
                

                while($row = mysqli_fetch_assoc($result)){
                // echo $row['comment_content'];
                echo $row['cat_name'];
                echo '<br>';
                
                }
?>