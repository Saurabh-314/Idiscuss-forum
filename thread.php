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

        $id = $_GET['threadid'];
        $sql = "SELECT * FROM `threads` WHERE thread_id = $id ";
        $result = mysqli_query($conn, $sql);
       
        while($row = mysqli_fetch_assoc($result)){
           
                $title = $row['thread_title'];
                $desc = $row['thread_desc'];
                $user_id = $row['thread_user_id'];
                }
    ?>
    
    <?php
        $showAlert = false;
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method=='POST') {
            // insert into comment db
            $comment = $_POST['comment'];
            $sno = $_POST['sno'];
            $comment = str_replace("<", "&lt;", $comment);
            $comment = str_replace("<", "&gt;", $comment);

            
            $sql = "INSERT INTO `comments` (`comment_content`, `thread_id`, `comment_by`, `comment_time`) 
            VALUES ('$comment', '$id', '$sno', current_timestamp())";
            $result = mysqli_query($conn, $sql);
            $showAlert = true;
            if($showAlert) {
                echo '<div class = "alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success!</strong> Your Comment has been added!  
                        <button type="button" class="close" data-dismiss="alert" aria-label="close"> 
                        <span aria-hidden="true">&times;</span>
                        </button>
                      </div>';
            }

        }

    ?>
        <?php
        $sql3 = "SELECT user_email FROM `users` WHERE sno = $user_id";
        $result3 = mysqli_query($conn, $sql3);
        $row3 = mysqli_fetch_assoc($result3);
        $user_email= $row3['user_email'];

        ?>
    <div class="container my-4">
        <div class="jumbotron">
            <h1 class="display-4"><?php  echo $title;  ?></h1>
            <p class="lead"><?php  echo $desc; ?></p>
            <hr class="my-4">
            <p>This is a peer to peer forum for sharing knowladge with each other.</p>
            <p>Posted by: <b> <?php echo $user_email; ?> </b></p>
        </div>

        <!-- insert comment to comment table  -->

        <!-- hear comment form start  -->
        <?php
        if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true) {

      echo '<div class="container">
            <h1 class=py-2>Post a comment </h1>
            <form action="'.$_SERVER["REQUEST_URI"].'" method="post">

                <div class="form-group">
                    <label for="exampleFormControlTextarea1"> Type your comment </label>
                    <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                    <input type="hidden" class="hidden" name="sno" value="'. $_SESSION['sno'].'">
                </div>

                <button type="submit" class="btn btn-success">Post Comment</button>
            </form>
        </div>';
        }
         else {
            echo '
                <div class="container">
                <h1 class=py-2>Post a comment </h1>
                <p class="lead">You are not logged in. please login to be able to post comment.</p>
                </div>';
            }
        ?>

        <div class="cantainer" style="min-height:333px">
            <h1 class=py-2> Discussions </h1>

            <!-- fetch comment to comments table  -->
            <?php
                $id = $_GET['threadid'];
                $sql = "SELECT * FROM `comments` WHERE thread_id = $id ";
                $result = mysqli_query($conn, $sql);
                $noresult = true;

                while($row = mysqli_fetch_assoc($result)){
                    $noresult = false;

                        $id = $row['comment_id'];
                        $content = $row['comment_content'];
                        $comment_time = $row['comment_time'];
                        $thread_user_id = $row['comment_by'];

                        $sql2 = "SELECT user_email FROM `users` WHERE sno = $thread_user_id";
                        $result2 = mysqli_query($conn, $sql2);
                        $row2 = mysqli_fetch_assoc($result2);
                        $user_email= $row2['user_email'];

                echo    '<div class="media my-3">
                            <img src="img/user.jpg" width="40px" class="mr-3" alt="...">
                            <div class="media-body">
                                <p class="font-weight-bold my-0">' .$user_email. ' at '. $comment_time .'</p>
                                <p>'.$content.'</p>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
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