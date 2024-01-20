let style = document.querySelector('#style'); //styleButton
style.addEventListener('click',(e)=>{
    // change image inside button
    let gridStyleImg = style.querySelector('img').getAttribute('src');
    if( gridStyleImg == '../imgs/columns.png' ){
        style.querySelector('img').src = '../imgs/rows.png';  
    } else{
        style.querySelector('img').src = '../imgs/columns.png'; 
    }
    // 
    let mainRow = document.querySelectorAll('.row-card-style');
    mainRow.forEach((row)=>{
        // row.classList.contains('max-row-card-style')?row.classList.remove('max-row-card-style'):row.classList.add('max-row-card-style');
        // ['ps-2','flex-nowrap','scroll','pb-2'].every((e)=>{return row.classList.value.split(' ').indexOf(e)!= -1 ? true:false;}) ? row.classList.remove('ps-2','flex-nowrap','scroll','pb-2'):row.classList.add('ps-2','flex-nowrap','scroll','pb-2');
        row.querySelectorAll('.card').forEach((card)=>{
            ['w-100','mx-auto','flex-row'].every((e)=>{return card.classList.value.split(' ').indexOf(e)!= -1 ? true:false;})? card.classList.remove('w-100','mx-auto','flex-row'): card.classList.add('w-100','mx-auto','flex-row');
            ['flex-2','mx-1','my-2'].every((e)=>{return card.classList.value.split(' ').indexOf(e)!= -1 ? true:false;})? card.querySelector('.rounded').classList.remove('flex-2','mx-1','my-2'):card.querySelector('.rounded').classList.add('flex-2','mx-1','my-2');
            ['mt-1','skeletonLoader','card-img-top'].every((e)=>{return card.classList.value.split(' ').indexOf(e)!= -1 ? true:false;})?card.querySelector('.rounded').classList.remove('mt-1','skeletonLoader','card-img-top'):card.querySelector('.rounded').classList.add('mt-1','skeletonLoader','card-img-top');
            let cardBody = card.querySelector('.card-body');
            ['flex-5','d-flex','flex-column','justify-content-between'].every((e)=>{return cardBody.classList.value.split(' ').indexOf(e)!= -1 ? true:false;})?cardBody.classList.remove('flex-5','d-flex','flex-column','justify-content-between'):cardBody.classList.add('flex-5','d-flex','flex-column','justify-content-between');
            let cardTitle = cardBody.querySelector('.card-title');
            cardTitle.classList.contains('mt-2')?cardTitle.classList.remove('mt-2'):cardTitle.classList.add('mt-2');
            cardTitle.classList.contains('mt-md-4')?cardTitle.classList.remove('mt-md-4'):cardTitle.classList.add('mt-md-4');
            let cardBottom = cardBody.querySelector('.card-bottom');
            ['flex-row-reverse','align-items-center'].every((e)=>{return cardBottom.classList.value.split(' ').indexOf(e)!= -1 ? true:false;})?cardBottom.classList.remove('flex-row-reverse','align-items-center'):cardBottom.classList.add('flex-row-reverse','align-items-center');
            cardBottom.classList.contains('align-items-end')?cardBottom.classList.remove('align-items-end'):cardBottom.classList.add('align-items-end');
            cardBottom.querySelector('.col-4').classList.contains('pw-reset')?cardBottom.querySelector('.col-4').classList.remove('pw-reset'):cardBottom.querySelector('.col-4').classList.add('pw-reset');
            cardBottom.querySelector('.col-2').classList.contains('pw-reset')?cardBottom.querySelector('.col-2').classList.remove('pw-reset'):cardBottom.querySelector('.col-2').classList.add('pw-reset');
        });
    })
});
// style end
let inputRange = document.querySelectorAll('.input-range input');
let range = document.querySelector('.range-selected');
inputRange.forEach((input)=>{
    input.addEventListener('input',(e)=>{
        let minRange = parseFloat(inputRange[0].value);
        let maxRange = parseFloat(inputRange[1].value);
        let deltaRange = maxRange - minRange;
        if(deltaRange > 0){
            let RVALUE = 50000;
            if(e.target.id == 'r1'){
                console.log(minRange);
                document.querySelector('#minValue').value = minRange * RVALUE / 100;
                range.style.left = (minRange + "%");

            } else if(e.target.id == 'r2') {
                console.log(maxRange);
                document.querySelector('#maxValue').value = maxRange * RVALUE / 100;
                range.style.right = (100 - maxRange + "%");
            } 
        } else{
        }

    });

});

// mobile category rows
let deviceWidth = window.innerWidth;
if(deviceWidth < 768){
    style.click();
}
