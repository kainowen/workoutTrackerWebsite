$("#start").click(function(){ 
    
    localStorage.setItem('restInterval', 0); 
    
});


    
let rest = $("#rest").val(); 

let restTime = localStorage.getItem("restInterval"); 

if($("#set").html() == " Set: 1 "){

    $("#restTimer").html("start");
    
} else{
 
setInterval(function(){ 
    
    restTime = restTime - 1; 
    
    if (restTime > 0){ 
        
        $('#restTimer').html(restTime + " seconds"); 
        
    } else {
        
        $('#restTimer').html('start'); 
        
        
    } 
    
    if (restTime === 10 || restTime === 3 || restTime === 2 || restTime === 1|| restTime === 0){
        
        $("audio#beep")[0].play(); 
        
    } 
    
}, 1000);

};




$("#completeBTN, #confirm").click(function(){

    localStorage.clear();

});