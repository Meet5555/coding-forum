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
    <title>iDiscuss | Coding Forums</title>
</head>

<body>

    <?php 
        require 'partials/_dbconnect.php';
        require 'partials/_header.php';
    ?>


    
    <div class="container my-4">
        <h2 class="my-4">Search results for <b><em>"<?php echo $_GET['search']?>"</em></b></h2>

        <?php
        $noresults= true;
            $query = $_GET["search"];
            $sql = "SELECT * FROM `threads` WHERE MATCH(thread_title,thread_desc) against ('$query')";
            $result = mysqli_query($conn,$sql);
            while ($row = mysqli_fetch_assoc($result)){
                $noresults= false;
                $title = $row['thread_title'];
                $desc = $row['thread_desc'];
                $thread_id = $row['thread_id'];
                $url='/forum/thread.php?threadid='.$thread_id;
                echo '<div class="result">
                <h4><a href="'.$url.'" class="py-1 text-dark">'.$title.'</a></h4>
                <p>'.$desc.'</p>
            </div>';
            }
            if($noresults){
                echo '<div class="jumbotron ">
                        <div class="container">
                        <h3 class="display-6">No Results Found</h3>
                        <p class="lead display-6">Suggestions:<ul>
                            <li>Make sure that all words are spelled correctly.</li>
                            <li>Try different keywords.</li>
                            <li>Try more general keywords.</li></ul>
                        </p>
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