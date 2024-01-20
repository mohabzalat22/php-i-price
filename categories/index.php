<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>iprice</title>
        <!-- fav-icon -->
        <link rel="icon" href="iprice/../../../imgs/favicon.png" >
        <!-- google fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300&family=Dancing+Script:wght@500&family=Playfair+Display:wght@400;600&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
        <!-- icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <!-- bootstrap -->
        <link rel="stylesheet" href="iprice/../../../styles/bootstrap.min.css">
        <script src="iprice/../../../scripts/bootstrap.bundle.min.js"></script>
        <!-- local style -->
        <link rel="stylesheet" href="iprice/../../../styles/style.css">
        <link rel="stylesheet" href="../style.css">
    </head>
    <body>
<?php
// header
include "../../widgets/header.php";
// navbar
include "../../widgets/navbar.html";
// offcanvas
include "../../widgets/offcanvas.html";
// daatabase
include "../../database.php";
function product($company,$link,$img_link,$decription,$price,$price_symbol,$rating){
    $HTML = <<<HTML
    <div class="card card-shadow item-card mx-2 my-1 d-flex">
                <span class="skeletonLoader card-img-top mt-1 rounded center">
                    <img src="$img_link" alt="" class="card-img-top" loading="lazy">
                </span>
                <div class="card-body">
                    <div class="card-title h6 text-muted lh-base description">
                       $decription
                    </div>
                    <!-- price inside card -->
                    <div class="card-title d-flex align-items-center my-2">
                        <div class="card-arrow"></div>
                        <div class="text-muted"><p class="m-0">$company</p></div>
                        <div class="text-muted h6 ms-auto my-0"><p class="m-0">$price $price_symbol</p></div>
                    </div>
        
                    <div class="row text-center card-bottom align-items-end">
                        <div class="col-4 pw-reset d-flex justify-content-end"><a class="btn btn-indigo buy-button rounded-pill" href="$link">Buy now</a></div>
                        <div class="col-6 justify-content-center">
                            <span class="align-self-end stars">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </span>
                        </div>
                        <div class="col-2 pw-reset">
                            <div class="rating bg-secondary rounded-pill text-white text-center">$rating</div>
                        </div>
                        
                    </div>
                </div>
            </div>
            <!-- card end -->
    HTML;
    return $HTML;
}
?>
    <!-- rangeSearch Section -->
    <div class="container-xxl mt-5" id="rangesearch">
        <div class="row">
            <!-- seacrh -->
            <div class="col-12 col-lg-3 d-flex justify-content-center" id="rangeSearchFilter">
                <div class="card w-100 p-2">
                    <div class="card-body">
                        <div class="d-flex scroll-wheel my-1">
                            <?php
                            for($i=0;$i<count($name);$i++){
                                echo "<a href = '/iprice/search/index.php?q=$name[$i]' class='nostyle rounded-pill bg-light border text-center px-3 m-1'><small class='text-nowrap'>$name[$i]</small></a>";
                            }
                            ?>
   
                        </div>
                        <form action="" method="get" id="categoryForm">
                            <div class="input-group">
                                <input type="text" class="form-control w-75 mx-auto" placeholder="search in category." name="search" id="search">
                            </div>
                            <label for="" class="text-black-50 my-2">Price Range</label>
                            <div class="input-range">
                                <div class="range-slider"><div class="range-selected" id="range-selected"></div></div>
                                    <input type="range" id="r1" value="40" class="d-block w-100 r1">
                                    <input type="range" id="r2" value = "60" class="d-block w-100 r2">
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" name="m-rated" id="mostrated"  class="form-check-input" checked>
                                    <label for="mostrated" class="form-check-label">Most Rated</label>
                                </div>
                            <div class="d-flex align-items-center mt-3">
                                <div class="input-group">
                                    <input type="number" class="form-control" name="r1" min="0" max="50000" value="20000" id="minValue">
                                </div>
                                <div class="tex-muted mx-1">To</div>
                                <div class="input-group ms-1">
                                    <input type="number" class="form-control" name="r2" min="0" max="50000" value="30000" id="maxValue">
                                </div>
                            </div>
                            <input type="submit" value="Find" class="btn btn-indigo mt-2 w-100 ">
                        </form>
                    </div>
                </div>
            </div>
            <!-- results -->
            <div class="col-12 col-lg-9">
                <div class="d-flex">
                    <div class="h5 text-muted m-0">RESULTS</div>
    <?php
    $results = count($name);
    echo "<small class='text-muted ms-1 mt-1'>($results)</small>";
    ?>
    <hr class="w-100 mx-2">
                    <div class="ms-3">
                        <div class="text-start">
                            <div class="btn p-0" id="style">
                                <img src="../../imgs/columns.png" class="img-fluid" alt="">
                            </div>
                        </div>
                    </div>
                    <!-- <div class="ms-2 spinner" id="spinner"></div> -->
                </div>
                <div class="col-12">
                    <div class="row row-card-style justify-content-center">
    <?php
     if($_SERVER["REQUEST_METHOD"] == "GET"){
        if(isset($_GET["search"]) and isset($_GET["r1"]) and isset($_GET["r2"])){
             $SEARCH = $_GET["search"];
             $MIN = $_GET["r1"];
             $MAX = $_GET["r2"];
            //  echo $MIN .'---'. $MAX; 
             $DATABASE_CONN = new database();
             $DATABASE_CONN->connect('localhost:3806','root','','products');
             $QUERY = "SELECT * FROM products WHERE product = '$SEARCH' AND product_price BETWEEN $MIN AND $MAX";
             if(isset($_GET["m-rated"]) and $_GET["m-rated"]=="on"){
                 $QUERY .= " ORDER BY product_rating DESC";
             }
             // SET QUERY LIMIT
             $QUERY .= " LIMIT 50"; 
             $products_data = $DATABASE_CONN->exec($QUERY);
             // echo "<pre>";
             // print_r($products_data);
             // echo "</pre>";
     
         }
     }
    // echo isset($products_data);
    if(isset($products_data)){
        if( $products_data != NULL){
            $results = count($products_data);
            for($i=0;$i<count($products_data);$i++){
                echo product($products_data[$i]['product_company'],$products_data[$i]['product_link'],$products_data[$i]['product_imgSrc'],$products_data[$i]['product_description'],$products_data[$i]['product_price'],$products_data[$i]['product_priceSymbol'],$products_data[$i]['product_rating']);
            }
        } 
    } else {
            // echo "<pre>";
            // print_r($name);
            // echo "</pre>";
            $RANDOM_PRODUCT = $name[rand(0,count($name)-1)];
            echo "<div class='h6 text-muted center'>Search For Something !</div>";
            $DATABASE_CONN = new database();
            $DATABASE_CONN->connect('localhost:3806','root','','products');
            $QUERY = "SELECT * FROM products WHERE product = '$RANDOM_PRODUCT' LIMIT 50";
            $products_data = $DATABASE_CONN->exec($QUERY);
            if( $products_data != NULL){
                for($i=0;$i<count($products_data);$i++){
                    echo product($products_data[$i]['product_company'],$products_data[$i]['product_link'],$products_data[$i]['product_imgSrc'],$products_data[$i]['product_description'],$products_data[$i]['product_price'],$products_data[$i]['product_priceSymbol'],$products_data[$i]['product_rating']);
                }
            } 

    }
    ?>
    
    <script src="price/../../../scripts/script.js"></script>
    <script src="../script.js"></script>
    <!-- footer -->
    </body>
</html>
