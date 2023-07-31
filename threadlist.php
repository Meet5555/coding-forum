<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">

    <title>Threads | iDiscuss</title>
</head>

<body>
    <?php 
    require 'partials/_dbconnect.php';
    require 'partials/_header.php';
    ?>

    <?php  
        $id= $_GET['catid'];
        $sql = "SELECT * FROM `categories` WHERE category_id=$id";
        $result = mysqli_query($conn,$sql);
        while ($row = mysqli_fetch_assoc($result)){
            $catname = $row['category_name'];
            $catdesc = $row['category_description'];
        }   
    ?>

    <?php
        $method  = $_SERVER['REQUEST_METHOD'];
        if($method=='POST'){
            $showAlert=false;
            $th_title=$_POST['title'];
            $th_desc=$_POST['desc'];
            $sno=$_POST['sno'];
            $th_title= str_replace("<","&lt",$th_title);
            $th_title= str_replace(">","&gt",$th_title);
            $th_title= str_replace("'","\'",$th_title);
            $th_title= str_replace('"','\"',$th_title);
            $th_desc= str_replace("<","&lt",$th_desc);
            $th_desc= str_replace(">","&gt",$th_desc);
            $th_desc= str_replace("'","\'",$th_desc);
            $th_desc= str_replace('"','\"',$th_desc);
            $sql = "INSERT INTO `threads` (`thread_title`, `thread_desc`, `thread_cat_id`, `thread_user_id`, `timestamp`) VALUES ('$th_title', '$th_desc', '$id', '$sno', current_timestamp())";
            $result = mysqli_query($conn,$sql);
            if($result){
                $showAlert=true;
            }
            if($showAlert){
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success! </strong> Your Question has been added.Please wait for community to respond!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                      </div>';
            }
        }
    ?>
    <div class="container my-4">
        <div class="jumbotron">
            <h1 class="display-4">Welcome to <?php echo $catname; ?> Forum</h1>
            <p class="lead"><?php echo $catdesc; ?></p>
            <hr class="my-4">
            <p>This is peer to peer forum. Spam / Advertising / self-promote in the forum is not allowed. Do not post
                copyright-infrigring material. Do not post "offensive" post, link or images. Do not post cross
                questions. Remain respectfullwith otther members at all time.</p>
            <a class="btn btn-success btn-lg" href="#" role="button">Learn more</a>
        </div>
    </div>

    <?php
        if (isset($_SESSION['loggedin']) && ($_SESSION['loggedin'] == true)){
            echo '<div class="container">
            <h2 class="py-2">Start a Discussion</h2>    
            <form action=" ' .$_SERVER["REQUEST_URI"].'" method="post">
                <div class="form-group">
                    <label for="title">Problem Title</label>
                    <input type="text" class="form-control" id="title" name="title">
                    <small id="emailHelp" class="form-text text-muted">keep your title as short and crips as
                        possible</small>
                </div>
                <div class="form-group">
                    <label for="desc">Elaborate your problem</label>
                    <textarea class="form-control" id="desc" name="desc" rows="3"></textarea>
                    <input type="hidden" name="sno" value="'.$_SESSION["sno"].'">
                </div>
                <button type="submit" class="btn btn-success">Post Question</button>
            </form>
        </div>';
        }
        else{
            echo '<div class="container">
                    <h2 class="py-2">Start a Discussion</h2>    
                    <p class="lead">You are not Logged in. Please log in to start a Discussion or posting any Questions</p>
                </div>';
        }
    ?>

    <div class="container mb-5 my-5">
        <h1 class="py-2">Browse Questions</h1>
        <?php  
            $id= $_GET['catid'];
            $sql = "SELECT * FROM `threads` WHERE thread_cat_id=$id";
            $result = mysqli_query($conn,$sql);
            $noResult =true;
            while ($row = mysqli_fetch_assoc($result)){
                $noResult = false;
                $title = $row['thread_title'];
                $desc = $row['thread_desc'];
                $tid = $row['thread_id'];
                $threadTime = $row['timestamp'];
                $thread_user_id = $row['thread_user_id'];
                $sql2 = "SELECT user_email from `users` where sno='$thread_user_id'";
                $result2 = mysqli_query($conn,$sql2);
                $row2=mysqli_fetch_assoc($result2);
                $username=$row2['user_email'];
                echo '<div class="media ">
                    <img src="img/user-default.png" width="50rem" class="mr-3" alt="...">
                    <div class="media-body">
                        <h5 class="mt-0"><a class="text-dark" href="thread.php?threadid='.$tid.'">' . $title.'</a></h5>
                        <p>' . $desc.'</p>
                        </div>
                        <small><p class="my-0 d-inline">asked by: <b>' . $username .' </b>at '.$threadTime.'</p></small>
                        </div>';
            }
            if($noResult){
                // echo "<b>Be the first person to ask a question.</b>";
                echo '<div class="jumbotron ">
                <div class="container">
                  <h4 class="display-6">No questions for this category.</h4>
                  <p class="lead display-6">Be the first person to ask a question.</p>
                </div>
              </div>';
            }
            ?>
    </div>



    <?php require 'partials/_footer.php'?>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous">
    </script>
    <script src="partials/script.js"></script>

</body>

</html>