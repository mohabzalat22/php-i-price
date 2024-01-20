<?php
function product_c($company,$link,$img_link,$decription,$price,$price_symbol,$rating){
    $HTML = <<<HTML
    <div class="card card-shadow item-card mx-2 my-1 d-flex">
                <span class="skeletonLoader card-img-top mt-1 rounded center">
                    <img src="$img_link" alt="" class="card-img-top">
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
                        <div class="col-4 pw-reset d-flex justify-content-end"><a class="btn btn-indigo buy-button" href="$link">Buy now</a></div>
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
function product_r($company,$link,$img_link,$decription,$price,$price_symbol,$rating){
        $HTML = <<<HTML
            <div class="card card-shadow mx-2 my-1 d-flex w-100 mx-auto flex-row">
                    <span class="skeletonLoader card-img-top mt-1 rounded center flex-2 mx-1 my-2">
                        <img src="$img_link" alt="" class="card-img-top">
                    </span>
                    <div class="card-body flex-5 d-flex flex-column justify-content-between">
                        <div class="card-title h6 text-muted lh-base mt-2 mt-md-4">
                            $decription
                        </div>
                        <!-- price inside card -->
                        <div class="card-title d-flex align-items-center my-2">
                            <div class="card-arrow"></div>
                            <div class="text-muted"><p class="m-0">$company</p></div>
                            <div class="text-muted h6 ms-auto my-0"><p class="m-0">$price $price_symbol</p></div>
                        </div>
            
                        <div class="row text-center card-bottom flex-row-reverse">
                            <div class="col-4 d-flex justify-content-end"><a class="btn btn-indigo buy-button" href="$link">Buy now</a></div>
                            <div class="col-6">
                                <span class="align-self-end stars">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                </span>
                            </div>
                            <div class="col-2">
                                <div class="rating bg-secondary rounded-pill text-white text-center ">$rating</div>
                            </div>
                            
                        </div>
                    </div>
                </div>
    
        HTML;
        return $HTML;
    }; 
?>