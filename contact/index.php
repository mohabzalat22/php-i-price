<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>contact us</title>
    <!-- fav-icon -->
    <link rel="icon" href="../imgs/favicon.png" >
    <!-- animate css -->
    <link rel="stylesheet" href="../styles/animate.min.css">
    <!-- google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300&family=Dancing+Script:wght@500&family=Playfair+Display:wght@400;600&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <!-- styles -->
    <link rel="stylesheet" href="../styles/bootstrap.min.css">
    <link rel="stylesheet" href="../styles/style.css">
    <link rel="stylesheet" href="./style.css">
    <!-- js -->
    <script src="../scripts/bootstrap.bundle.min.js"></script>
</head>
<body>
    <!-- header -->
    <?php include "../widgets/header.php"?>
    <!-- navbar -->
    <?php include "../widgets/navbar.html"?>
    <!-- offcanvas -->
    <?php include "../widgets/offcanvas.html"?>
    <!-- Contact Section  -->
    <div class="container-xxl mt-5">
        <div class="row">
            <div class="col-12 col-md-9 offset-md-1 col-lg-8 offset-lg-2 border rounded">
                <div class="d-flex flex-column flex-md-row">
                    <div class="col-12 col-md-6 col-lg-7 p-3 m-1 center">
                        <img src="../imgs/contact.jpg" alt="" class="img-fluid" id="contact">
                    </div>
                    <div class="d-flex flex-column justify-content-evenly col-12 col-md-6 col-lg-5 mt-2 px-3">
                        <form action="" class="" method="get">
                            <input type="text" id="Email" class="form-control w-100 my-2" placeholder="email@website.com" name="email">
                            <input type="text" id="Password" class="form-control w-100" placeholder="Password" name="password">
                            <input class="btn btn-outline-dark my-1" type="submit">
                        </form>
                        <div class="col-12 d-flex justify-content-center">
                            <a href="https://www.facebook.com/profile.php?id=100092600917352" class="mx-1"><img src="../imgs/facebook.svg" alt="" class="img-fluid"></a>
                            <a href="https://www.tiktok.com/@dev_mohab" class="mx-1"><img src="../imgs/tiktok.svg" alt="" class="img-fluid"></a>
                            <a href="" class="mx-1"><img src="../imgs/whatsapp.svg" alt="" class="img-fluid"></a>
                            <a href="" class="mx-1"><img src="../imgs/instagram.svg" alt="" class="img-fluid"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- footer -->
    <?php include "../widgets/footer.html";?>
    <!-- js -->  
    <script src="../scripts/script.js"></script>
</body>
</html>