<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
        integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <title>Hello, world!</title>
</head>

<body>
    <?php 
    include 'partials/_header.php';
    include 'partials/_dbconnect.php';
    ?>
    <?php

        $id = $_GET['cat_id'];
        $sql = "SELECT * FROM `categories` WHERE cat_id = $id ";
        $result = mysqli_query($conn, $sql);

        while($row = mysqli_fetch_assoc($result)){

                $catname = $row['cat_name'];
                $catdesc = $row['cat_description'];
                
            }

    ?>
    <div class="container my-4">

        <div class="jumbotron">
            <h1 class="display-4">Welcome to <?php echo $catname; ?> forum</h1>
            <p class="lead"><?php  echo $catdesc; ?></p>
            <hr class="my-4">
            <p>This is a peer to peer forum for sharing knowladge with each other.</p>
            <a class="btn btn-success btn-lg" href="#" role="button">Learn more</a>
        </div>
        <div class="container" style="min-height:333px">
            <h1 class=py-2> Browse Question</h1>
            <?php
                $id = $_GET['cat_id'];
                $sql = "SELECT * FROM `threads` WHERE thread_id = $id ";
                $result = mysqli_query($conn, $sql);

                while($row = mysqli_fetch_assoc($result)){

                    $id = $row['thread_id'];
                    $title = $row['thread_title'];
                    $desc = $row['thread_desc'];

                    echo    '<div class="media my-3">
                    <img src="img/user.jpg" width="40px" class="mr-3" alt="...">
                    <div class="media-body">
                        <h5 class="mt-0"><a class ="text-dark" href = "thread.php?threadid=' .$id. '">'.$title.'</a></h5>
                        <p>'.$desc.'</p>
                    </div>
                </div>';
    }

        
            ?>

        </div>

        <?php include 'partials/_footer.php'; ?>
        <!-- Optional JavaScript; choose one of the two! -->

        <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
            integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous">
        </script>

        <!-- Option 2: Separate Popper and Bootstrap JS -->
        <!--
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
    -->
    </div>
</body>

</html>