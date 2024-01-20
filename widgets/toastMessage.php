<?php
function toastMessage($product,$link,$imgSrc,$title,$message,$time){
    $HTML = <<<HTML
        <div class="toastMessage z-index-1100">
        <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <img src="$imgSrc" class="rounded me-2" alt="">
                <strong class="me-auto">$product $title</strong>
                <small class="text-muted">$time mins ago</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                <a href="$link" class="d-block w-100">
                    $message
                </a>
            </div>
        </div>
    </div>
    HTML;
    return $HTML;
}
?>