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
        $id= $_GET['threadid'];
        $sql = "SELECT * FROM `threads` WHERE thread_id=$id";
        $result = mysqli_query($conn,$sql);
        while ($row = mysqli_fetch_assoc($result)){
            $title = $row['thread_title'];
            $desc = $row['thread_desc'];
            $thread_user_id=$row['thread_user_id'];
            $sql2 = "SELECT user_email from `users` where sno='$thread_user_id'";
            $result2 = mysqli_query($conn,$sql2);
            $row2=mysqli_fetch_assoc($result2);
            $posted__by=$row2['user_email'];
        }
        
    ?>

    <?php
        $method  = $_SERVER['REQUEST_METHOD'];
        if($method=='POST'){
            $showAlert=false;
            $commentContent= $_POST['comment'];
            $commentContent= str_replace("<","&lt",$commentContent);
            $commentContent= str_replace(">","&gt",$commentContent);
            $commentContent= str_replace("'","\'",$commentContent);
            $commentContent= str_replace('"','\"',$commentContent);
            $sno=$_POST['sno'];
            $sql = "INSERT INTO `comments` (`comment_content`, `thread_id`, `comment_by`, `comment_time`) VALUES ('$commentContent', '$id', '$sno', current_timestamp())";
            $result = mysqli_query($conn,$sql);
            if($result){
                $showAlert=true;
            }
            if($showAlert){
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success! </strong> Your comment has been added.Thank you!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                      </div>';
            }
        }
    ?>
    <div class="container my-4">
        <div class="jumbotron">
            <h1 class="display-4"><?php echo $title; ?></h1>
            <p class="lead"><?php echo $desc; ?></p>
            <hr class="my-4">
            <p>This is peer to peer forum. Spam / Advertising / self-promote in the forum is not allowed. Do not post
                copyright-infrigring material. Do not post "offensive" post, link or images. Do not post cross
                questions. Remain respectfullwith otther members at all time.</p>
            <p>Posted by <b><em><?php echo $posted__by?></em></b></p>
        </div>
    </div>


    <?php
        if (isset($_SESSION['loggedin']) && ($_SESSION['loggedin'] == true)){
            echo '<div class="container">
            <h2 class="py-1">Post a Commment</h2>
            <form action="'.$_SERVER['REQUEST_URI'] .'" method="post">
                <div class="form-group">
                    <label for="comment">Type your comment</label>
                    <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                    <input type="hidden" name="sno" value="'.$_SESSION["sno"].'">
                </div>
                <button type="submit" class="btn btn-success">Post Commment</button>
            </form>
        </div>';
        }
        else{
            echo '<div class="container">
                    <h2 class="py-1">Post a Commment</h2>    
                    <p class="lead">You are not Logged in. Please log in to add a comment.</p>
                </div>';
        }
    ?>
    
    <div class="container mb-5 mt-4">
        <h1 class="py-3">Discussions</h1>
        <?php  
            $id= $_GET['threadid'];
            $sql = "SELECT * FROM `comments` WHERE thread_id=$id";
            $noResult = true;
            $result = mysqli_query($conn,$sql);
            while ($row = mysqli_fetch_assoc($result)){
                $noResult = false;
                $content = $row['comment_content'];
                $cid = $row['comment_id'];
                $commentTime = $row['comment_time'];
                $comment_by=$row['comment_by'];
                $sql2 = "SELECT user_email from `users` where sno='$comment_by'";
                $result2 = mysqli_query($conn,$sql2);
                $row2=mysqli_fetch_assoc($result2);
                $username=$row2['user_email'];
                echo '<div class="media my-3">
                    <img src="img/user-default.png" width="50rem" class="mr-3" alt="...">
                    <div class="media-body">
                    <p class="my-0 d-inline">Comment by: <b>' . $username .' </b>at '.$commentTime.'</p>
                        <p>' . $content.'</p>
                            </div>
                        </div>';
                    }
                    if($noResult){
                        // echo "<b>Be the first person to ask a question.</b>";
                        echo '<div class="jumbotron ">
                        <div class="container">
                          <h3 class="display-6">No comments Found</h3>
                          <p class="lead display-6">Be the first person to answer this question.fn</p>
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