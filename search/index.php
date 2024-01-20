<?php
include "../database.php";
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
// function product($company,$link,$img_link,$decription,$price,$price_symbol,$rating){
//     $HTML = <<<HTML
//         <div class="card card-shadow mx-2 my-1 d-flex w-100 mx-auto flex-row">
//                 <span class="skeletonLoader card-img-top mt-1 rounded center flex-2 mx-1 my-2">
//                     <img src="$img_link" alt="" class="card-img-top">
//                 </span>
//                 <div class="card-body flex-5 d-flex flex-column justify-content-between">
//                     <div class="card-title h6 text-muted lh-base mt-2 mt-md-4">
//                         $decription
//                     </div>
//                     <!-- price inside card -->
//                     <div class="card-title d-flex align-items-center my-2">
//                         <div class="card-arrow"></div>
//                         <div class="text-muted"><p class="m-0">$company</p></div>
//                         <div class="text-muted h6 ms-auto my-0"><p class="m-0">$price $price_symbol</p></div>
//                     </div>
        
//                     <div class="row text-center card-bottom flex-row-reverse">
//                         <div class="col-4 d-flex justify-content-end"><a class="btn btn-indigo buy-button" href="$link">Buy now</a></div>
//                         <div class="col-6">
//                             <span class="align-self-end stars">
//                                 <i class="fa fa-star"></i>
//                                 <i class="fa fa-star"></i>
//                                 <i class="fa fa-star"></i>
//                                 <i class="fa fa-star"></i>
//                                 <i class="fa fa-star"></i>
//                             </span>
//                         </div>
//                         <div class="col-2">
//                             <div class="rating bg-secondary rounded-pill text-white text-center ">$rating</div>
//                         </div>
                        
//                     </div>
//                 </div>
//             </div>

//     HTML;
//     return $HTML;
// };

if($_SERVER["REQUEST_METHOD"] == "GET"){
    if(isset($_GET["q"])){
        $SEARCH = $_GET["q"];
        $r1 = isset($_GET["r1"])? $_GET["r1"]:0;
        $r2 = isset($_GET["r2"])? $_GET["r2"]:50000;
        $mrated = isset($_GET["m-rated"]);
        $DATABASE_CONN = new database();
        $DATABASE_CONN->connect('localhost:3806','root','','products');
        $QUERY = "SELECT * FROM products WHERE product = '$SEARCH' AND product_price BETWEEN $r1 AND $r2";
        if($mrated=="on"){
            $QUERY .= " ORDER BY product_rating DESC";
        }
        // SET QUERY LIMIT
        $QUERY .= " LIMIT 50"; 
        $products_data = $DATABASE_CONN->exec($QUERY);
    } else{

    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iprice</title>
    <!-- fav-icon -->
    <link rel="icon" href="../imgs/favicon.png" >
    <!-- google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300&family=Dancing+Script:wght@500&family=Playfair+Display:wght@400;600&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <!-- icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="../styles/bootstrap.min.css">
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script> -->
    <script src="../scripts/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../styles/style.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- offcanvas -->
    <?php include "../widgets/offcanvas.html";?>
    <!-- header -->
    <?php include "../widgets/header.php";?>
    <!-- navbar -->
    <?php include "../widgets/navbar.html";?>
    <!-- categories -->
    <div class="container-xxl mt-5" id="rangesearch">
        <div class="row">
            <!-- seacrh -->
            <div class="col-12 col-lg-3 d-flex justify-content-center" id = "rangeSearchFilter">
                <div class="card w-100 p-2">
                    <div class="card-body">
                        <form action="" method="get" id="categoryForm">
                            <label for="" class="text-black-50 my-2">Price Range</label>
                            <div class="input-range">
                                <div class="range-slider"><div class="range-selected" id="range-selected"></div></div>
                                    <input type="range" id="r1" value="40" class="d-block w-100 r1">
                                    <input type="range" id="r2" value = "60" class="d-block w-100 r2">
                                    <input type="text" name="q" value =  "<?php echo $SEARCH ?>" class="d-none">
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
                    if(isset($products_data)){
                        if($products_data != NULL){
                            $results = count($products_data);
                            echo "<small class='text-muted ms-1 mt-1'>($results)</small>";
                        }
                    }
                    ?>
                    <hr class="w-100 mx-2">
                    <div class="ms-3">
                        <div class="text-start">
                            <div class="btn p-0" id="style">
                                <img src="../imgs/columns.png" class="img-fluid" alt="">
                            </div>
                        </div>
                    </div>
                    <!-- <div class="ms-2 spinner" id="spinner"></div> -->
                </div>
                <div class="col-12">
                    <div class="row row-card-style justify-content-center">
                        <?php
                        if(isset($products_data)){
                            if( $products_data != NULL){
                                for($i=0;$i<count($products_data);$i++){
                                    echo product($products_data[$i]['product_company'],$products_data[$i]['product_link'],$products_data[$i]['product_imgSrc'],$products_data[$i]['product_description'],$products_data[$i]['product_price'],$products_data[$i]['product_priceSymbol'],$products_data[$i]['product_rating']);
                                }
                            } 
                        } else {
                                echo "<div class='h6 text-muted center'>Search For Something !</div>";
                        }
                        ?>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    <script src="../scripts/script.js"></script>
    <script src="script.js"></script>
</body>
</html>