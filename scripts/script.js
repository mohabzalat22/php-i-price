// staring
let start_rating = function(){
    let rating = (document.querySelectorAll('.card-bottom'));
    // console.log(rating)
    rating.forEach((e)=> {
        let rate = +e.querySelector('.rating').innerHTML;
        if(rate !== 0 && rate <= 5){
            if(Number.isInteger(rate)){
                let numberOfStars = rate;
                let stars = e.querySelectorAll('.stars i');
                for(let i = 0 ; i < stars.length;i++){
                    stars[i].classList.add('active');
                    if(i == Math.floor(rate) - 1){break;}
                }
            }
            else{
                let numberOfStars = Math.floor(rate) + 0.5;
                let stars = e.querySelectorAll('.stars i');
                if(numberOfStars==0.5){
                    stars[0].classList.add('fa-star-half-o');
                    stars[0].classList.add('active');
                }
                else{
                    for(let i = 0 ; i < stars.length;i++){
                        stars[i].classList.add('active');
                        if(i == Math.floor(rate) - 1){
                            stars[i+1].classList.remove('fa-star');
                            stars[i+1].classList.add('fa-star-half-o');
                            stars[i+1].classList.add('active');
                            break;
                        };
                    }
                }
            
            }
            
        }
    });
};
start_rating();
// wheel scroll
let wheelScrolls = document.querySelectorAll(".scroll-wheel");
wheelScrolls.forEach((e)=>{
    e.addEventListener('wheel',(evt)=>{
        evt.preventDefault();
        e.scrollLeft += evt.deltaY;
    });
});
// drag scroll
let sliders = document.querySelectorAll(".scroll");
sliders.forEach((slider)=>{
    let isDown = false;
    let startX;
    let scrollLeft;
    slider.addEventListener('mousedown', (e) => {
        slider.style.cursor = 'grabbing';
        isDown = true;
        startX = e.pageX - slider.offsetLeft;
        scrollLeft = slider.scrollLeft;
    });
    slider.addEventListener('mouseleave', () => {
      isDown = false;
    });
    slider.addEventListener('mouseup', () => {
      isDown = false;
      slider.style.cursor = 'pointer';
    });
    slider.addEventListener('mousemove', (e) => {
      if(!isDown) return;
      e.preventDefault();
      const x = e.pageX - slider.offsetLeft;
      const walk = (x - startX) * 1.2; //scroll-fast
      slider.scrollLeft = scrollLeft - walk;
    });
});
// modal
let myModal = new bootstrap.Modal(document.getElementById('mainModal'));
let localStorage_data = window.localStorage;
if(localStorage_data.hasOwnProperty('data')){
} else{
    localStorage_data.setItem('data','false');
    if(localStorage_data.getItem('data') == 'false'){
        myModal.show();
        // console.log(document.getElementById('mainModal'));
        localStorage_data.setItem('data','true');
    }
};
// scroll to top
let scrollToTop = document.querySelector("#scrollToTop");
scrollToTop.addEventListener('click',(e)=>{
    window.scrollTo({
        top:0,
        behavior:'smooth',
    });
});
// navbar toggler
let navbarToggler = document.querySelector("#navbar-toggler");
navbarToggler.addEventListener('mouseover',(e)=>{
    let spans = navbarToggler.querySelectorAll(".navbar-icon");
    spans[0].style.width = '20px';
    spans[1].style.width = '30px';
    spans[2].style.width = '35px';
});
navbarToggler.addEventListener('mouseout',(e)=>{
    let spans = navbarToggler.querySelectorAll(".navbar-icon");
    spans[0].style.width = '80%';
    spans[1].style.width = '100%';
    spans[2].style.width = '60%';


});
document.addEventListener('scroll',()=>{
    let scrollToTop = document.querySelector("#scrollToTop");
    // console.log('scroll : '+window.scrollY);
    // console.log('page : '+window.innerHeight);
    if(window.scrollY > window.innerHeight / 2){
        if(scrollToTop.classList.contains('d-none')){
            scrollToTop.classList.remove('d-none');
            scrollToTop.classList.add('d-block');
        }
    }
    else{
        if(scrollToTop.classList.contains('d-block')){
            scrollToTop.classList.remove('d-block');
            scrollToTop.classList.add('d-none');
        }
    }

});
//check cache
function is_cached(src){
    img = new Image();
    img.src = src;
    return img.complete;
}
// 
let skeletonloader = document.querySelectorAll(".card .skeletonLoader");
skeletonloader.forEach((el)=>{
    if(is_cached(el.querySelector('img').src)){
        el.classList.remove('loading-animation');  
    } else {
        el.querySelector('img').addEventListener('load',()=>{
            el.classList.remove('loading-animation');  
        });
    }
});
// console.log(skeletonloader);
let counter = document.querySelectorAll("#countdown-draft div");
// console.log(Date);