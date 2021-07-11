<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
        integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">


    <title>iDiscuss - Coding Forums</title>
</head>

<body>
    <?php 
    include 'partials/_dbconnect.php';
    include 'partials/_header.php';
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

    <?php
        $showAlert = false;
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method=='POST') {
            // insert thread into db
            $th_title = $_POST['title'];
            $th_desc = $_POST['desc'];
            $sno = $_POST['sno'];

            $th_title = str_replace("<", "&lt;", $th_title);
            $th_title = str_replace("<", "&gt;", $th_title);

            $th_desc = str_replace("<", "&lt;", $th_desc);
            $th_desc = str_replace("<", "&gt;", $th_desc);

            $sql = "INSERT INTO `threads` (`thread_title`, `thread_desc`, `thread_cat_id`, `thread_user_id`, `timestamp`) VALUES ('$th_title', '$th_desc', '$id', '$sno', current_timestamp())";
            $result = mysqli_query($conn, $sql);
            $showAlert = true;
            if($showAlert) {
                echo '<div class = "alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success!</strong> Your thread has been added! Please wait for community to respond 
                        <button type="button" class="close" data-dismiss="alert" aria-label="close"> 
                        <span aria-hidden="true">&times;</span>
                        </button>
                      </div>';
            }

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

        <?php 
if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true) {

    echo   '<div class="container">
                <h1 class=py-2>Start a Discussion </h1>
                <form action="'.$_SERVER["REQUEST_URI"] .'" method="post">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Problem Title</label>
                        <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp" Required>
                        <small id="emailHelp" class="form-text text-muted">Keep your title as short and crips as
                            possible</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Ellaborate Your Concern</label>
                        <textarea class="form-control" id="desc" name="desc" rows="3" ></textarea>
                        <input type="hidden" class="hidden" name="sno" value="'. $_SESSION['sno'].'">
                    </div>

                    <button type="submit" class="btn btn-success">Submit</button>
                </form>
            </div>';
        } else {
            echo '<div class="container">
                <h1 class=py-2>Start a Discussion </h1>
                    <p class="lead">You are not logged in. Please login to be able to start a Discussion </p>
                </div>';
            }
            ?>
        <div class="container mb-5" style="min-height:333px">
            <h1 class=py-2> Browse Question</h1>
            <?php
                $id = $_GET['cat_id'];
                $sql = "SELECT * FROM `threads` WHERE thread_cat_id = $id ";
                $result = mysqli_query($conn, $sql);
                $noresult = true;
                while($row = mysqli_fetch_assoc($result)){
                    $noresult = false;
                    $id = $row['thread_id'];
                    $title = $row['thread_title'];
                    $desc = $row['thread_desc'];
                    $comment_time = $row['timestamp'];
                    $thread_user_id = $row['thread_user_id'];
                    
                    $sql2 = "SELECT user_email FROM `users` WHERE sno = $thread_user_id";
                    $result2 = mysqli_query($conn, $sql2);
                    $row2 = mysqli_fetch_assoc($result2);
                    echo    '<div class="media my-3">
                                <img src="img/user.jpg" width="40px" class="mr-3" alt="...">
                                <div class="media-body">
                                    <p class="font-weight-bold my-0"> ' .$row2['user_email']. ' at '. $comment_time .'</p>
                                        <h5 class="mt-0"><a class ="text-dark" href = "thread.php?threadid=' .$id. '">'.$title.'</a></h5>
                                    <p>'.$desc.'</p>
                                </div>
                             </div>';
                    }

    
    if($noresult){
        echo '<div class="jumbotron jumbotron-fluid">
                <div class="container">
                <p class="display-4">No Record Found</p>
                <p class="lead"> Be the first person to ask a question.</p>
                </div>
              </div>';
       
    }
            ?>

        </div>
    </div>

        <?php include 'partials/_footer.php'; ?>

        <!-- Optional JavaScript; choose one of the two! -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
            integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous">
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous">
        </script>
        <!-- Option 1: Bootstrap Bundle with Popper -->
        <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous">
        </script> -->

        <!-- Option 2: Separate Popper and Bootstrap JS -->
        <!--
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>
        -->
</body>

</html>