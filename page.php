<!-- php -->
<?php
include "webscraping.php";
$localhost = 'localhost:3806';
$username = 'root';
$password = '';
$database = 'products';
function product($company,$link,$img_link,$decription,$price,$price_symbol,$rating){
    $HTML = <<<HTML
    <div class="card card-shadow item-card mx-2 my-1 d-flex">
        <!-- <div class="heart-icon"><i class="fa fa-solid fa-heart-o"></i></div> -->
                <div class="skeletonLoader loading-animation card-img-top mt-1 rounded center">
                    <img src="$img_link" alt="" class="card-img-top" loading = "lazy">
                </div>
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
                        <div class="col-4 pw-reset"><a class="btn btn-indigo buy-button rounded-pill" href="$link">Buy now</a></div>
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

if($_SERVER["REQUEST_METHOD"] == "GET"){
    if(isset($_GET["search"])){
        $SEARCH = $_GET["search"];
        // $scrap = new scrap();
        // $scrap->amazon($SEARCH);
        // $scrap->ebay($SEARCH);
        // $scrap->jumia($SEARCH);
        $DATABASE_CONN = new database();
        $DATABASE_CONN->connect('localhost:3806','root','','products');
        $QUERY = "SELECT * FROM products WHERE product = '$SEARCH'";
        $DATA = $DATABASE_CONN->exec($QUERY);
        if($DATA != NULL){
            echo "<pre>";
            print_r($DATA);
            echo "</pre>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en" id="main">
<head>
    
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IPRICE</title>
    <!-- fav-icon -->
    <link rel="icon" href="imgs/favicon.png" >
    <!-- animate css -->
    <link rel="stylesheet" href="styles/animate.min.css">
    <!-- google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300&family=Dancing+Script:wght@500&family=Playfair+Display:wght@400;600&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <!-- icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="styles/bootstrap.min.css">
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script> -->
    <script src="scripts/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body> 
    <!-- toastMessage -->
    <?php 
    include "./widgets/toastMessage.php";
    $DATABASE_CONN = new database();
    $DATABASE_CONN->connect('localhost:3806','root','','products');
    $data = $DATABASE_CONN->exec("SELECT * FROM products WHERE product_price > 5000 ORDER BY rand() LIMIT  1");
    // echo "<pre>";
    // print_r($data);
    // echo "</pre>";
    // $DATE_FORMAT = date(,strtotime($data[0]['product_date']));
    $DATE_FORMAT = "Y-m-d H:i:s";
    $DATE_OLD = new DateTime($data[0]['product_date']);
    $TIME_OLD = $DATE_OLD->format("H:i:s");
    // new date
    $DATE_NEW = new DateTime();
    $DATE_NEW->format($DATE_FORMAT);
    // 
    // echo $DATE_OLD->format($DATE_FORMAT) . '<br>';
    // echo $DATE_NEW->format($DATE_FORMAT) . '<br>';
    // 
    $DATE_DIFF = $DATE_OLD->diff($DATE_NEW);
    // echo $DATE_DIFF->format('%i');
    echo toastMessage($data[0]['product'],$data[0]['product_link'],$data[0]['product_imgSrc'],$data[0]['product_company'],$data[0]['product_description'],$DATE_DIFF->format('%i'));
    ?>
    <!-- scrollToTop -->
    <?php include "./widgets/scrollToTop.html"?>
    <!-- modal -->
    <?php include "./widgets/modal.html";?>
    <!-- offcanvas -->
    <?php include "widgets/offcanvas.html";?>
    <!-- header -->
    <?php include "widgets/header.php";?>
    <!-- navbar -->
    <?php include "widgets/navbar.html";?>
    <!-- categories -->
    <?php include "widgets/categories.html";?>
    <!-- Most popular -->
    <div class="container-xxl" id ="mostpopular-section">
        <div class="d-flex justify-content-between align-items-center pt-5">
            <div><p class="d-inline h5 text-muted">Most Popular</p></div>
            <div><a href="search/index.php?q=iphone+14" class="d-inline fw-bold text-black-50 nostyle">SEE ALL</a></div>
        </div>
        <hr class="w-100">
        <!-- content -->
        <div class="row ps-2 flex-nowrap scroll pb-2 row-card-style">
            <?php 
            // database connection
            $DATA_CONN = new database();
            $DATA_CONN->connect($localhost,$username,$password,$database);
            $SQL_QUERY = "SELECT * FROM products WHERE product_price > 20000 AND product_rating > 4 LIMIT 10";
            $products_data = $DATA_CONN->exec($SQL_QUERY);
            // echo '<pre>';
            // print_r($products_data);
            // echo '</pre>';
            if($products_data != NULL){
                for($i=0;$i<count($products_data);$i++){
                    echo product($products_data[$i]['product_company'],$products_data[$i]['product_link'],$products_data[$i]['product_imgSrc'],$products_data[$i]['product_description'],$products_data[$i]['product_price'],$products_data[$i]['product_priceSymbol'],$products_data[$i]['product_rating']);
                }
            }
            ?>
        </div>
    </div>
    <!-- recomended -->
    <div class="container-xxl" id ="mostpopular-section">
        <div class="d-flex justify-content-between align-items-center pt-5">
            <div><p class="d-inline h5 text-muted">Recommended</p></div>
            <div><a href="search/index.php?q=macbook+air" class="d-inline fw-bold text-black-50 nostyle">SEE ALL</a ></div>
        </div>
        <hr class="w-100">
        <!-- content -->
        <div class="row ps-2 flex-nowrap scroll pb-2 row-card-style">
            <?php 
            $DATA_CONN = new database();
            $DATA_CONN->connect($localhost,$username,$password,$database);
            $SQL_QUERY = "SELECT * FROM products WHERE product_price BETWEEN 40000 AND 50000 AND product_rating > 4.5 LIMIT 10";
            $products_data = $DATA_CONN->exec($SQL_QUERY);
            if($products_data != NULL){
                for($i=0;$i<count($products_data);$i++){
                    echo product($products_data[$i]['product_company'],$products_data[$i]['product_link'],$products_data[$i]['product_imgSrc'],$products_data[$i]['product_description'],$products_data[$i]['product_price'],$products_data[$i]['product_priceSymbol'],$products_data[$i]['product_rating']);
                }
            }
            ?>
        </div>
    </div>
    <!-- footer -->
    <?php include "widgets/footer.html";?>
    <!-- js -->  
    <script src="scripts/script.js"></script>
</body>
</html>
