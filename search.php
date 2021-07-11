<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <style>
        #maincontainer {
            min-height:80vh;
        }
    </style>
    <title>iDiscuss - Coding Forums</title>
</head>

<body>
    <?php include 'partials/_dbconnect.php';?>
    <?php include 'partials/_header.php';?>
    

    <!-- Search Results  -->

    <div class="container my-3" id="maincontainer">
        <h1 class="py-2">Search result for <em>"<?php echo $_GET['search'] ?>"</em> </h1>
        <?php
        $query = $_GET["search"];
            $noresult=true;
            $sql = "SELECT * FROM `threads` WHERE MATCH(thread_title, thread_desc) against ('$query')";
            $result = mysqli_query($conn, $sql);
            while($row = mysqli_fetch_assoc($result)){
                $noresult=false;
                    $title = $row['thread_title'];
                    $desc = $row['thread_desc'];
                    $thread_id = $row['thread_id'];
                    $url ="thread.php?threadid=".$thread_id;

        echo    '<div class="result">
                    <h3> <a href="'.$url.'" class="text-dark">'. $title .' </a> </h3>
                    <p>'. $desc .'</p>
                </div>';
            }
        if($noresult){
            echo'<div class="jumbotron jumbotron-fluid">
                    <div class="container">
                    <p class="display-4">No Record Found</p>
                    <p class="lead">"Suggestions:"<ul>
                                                    <li>make sure that all words are spelled correctly.</li>
                                                    <li>Try different Keywords</li>
                                                    <li>Try more general keywords</li> 
                                                </ul>
                    </p>
                    </div>
                </div>';
            }
        ?>
        
    </div>


    <?php include 'partials/_footer.php'; ?>



    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous">
    </script>  -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>


    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>
    -->
</body>

</html>