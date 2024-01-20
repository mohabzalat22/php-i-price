<div class="container-xxl  g-0 py-4">
        <div class="text-center">
            <!-- <p class="m-0 text-white bg-indigo">
                <small>Hourly Updated Prices</small>
            </p> -->
            <div class="countdown-draft d-flex align-items-center justify-content-center" id="countdown-draft">
                <span id="time" class="d-none">
                    <?php $time = date("h:i:s");echo $time;?>
                </span>
                <p class="m-0 p-0 pe-2">TIME FOR NEW UPDATE</p>
                <div class="h5 minutes text-white bg-indigo p-2 m-0">00</div>
                <div class="h5 seconds text-white bg-indigo p-2 m-2">00</div>
            </div>
        </div>
</div>
<script>
    let time = document.querySelector("#time").innerHTML.trim();
    let counters = document.querySelectorAll("#countdown-draft div");
    let time_arr = time.split(':');
    // console.log(time_arr);
    let minutes = 60 - time_arr[1];
    let seconds = 60 - time_arr[2];
    counters[0].innerHTML = minutes;
    counters[1].innerHTML = seconds;
    // let minutes_counter = setInterval(() => {
    //     if(minutes==0){clearInterval(minutes_counter)}
    //     counters[0].innerHTML = minutes;
        
    // }, 60000);
    let seconds_counter = setInterval(() => {
        if(seconds==0){
            if(minutes == 0){
                minutes = 60;
            }else{
                minutes -=1;
                seconds = 60;
            }
            counters[0].innerHTML = minutes;
            
        } else{
            seconds -=1;
        }
        counters[1].innerHTML = seconds;
    }, 1000);
</script>
