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

    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="img/slider-1.jpg" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="img/slider-2.jpg" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="img/slider-3.jpg" class="d-block w-100" alt="...">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-target="#carouselExampleIndicators" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-target="#carouselExampleIndicators" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </button>
    </div>


    <div class="container  my-3">
        <h2 class="text-center   my-4">
            <hr class="my-2 border-success">iDiscuss - Browse Categories
            <hr class="my-2 border-success">
        </h2>
        <div class="row my-4">

            <?php
                require "partials/_dbconnect.php";
                $sql = "SELECT * FROM `categories`";
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                  // echo $row['category_id'] . $row['category_name'] . "<br>";
                  echo '<div class="col-md-4 my-2">
                                <div class="card" style="width: 18rem;">
                                  <img src="https://source.unsplash.com/500x400/?' . $row['category_name'] . ',coding" class="card-img-top" alt="...">
                                  <div class="card-body">
                                    <h5 class="card-title"><a href="threadlist.php?catid=' . $row['category_id'] . '">' . $row['category_name'] . '</a></h5>
                                    <p class="card-text">' . substr($row['category_description'], 0, 80) . '...</p>
                                    <a href="threadlist.php?catid=' . $row['category_id'] . '" class="btn btn-primary">View Threades</a>
                                  </div>
                                </div>
                              </div>';
                }
            ?>

        </div>
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