if($(".inputShell > div").length){
    
    $(".inputShell:has(div)").children("input").addClass("input-alert"); 
    
    
} else { 
    
    $(".inputShell:has(div)").children("input").removeClass("input-alert"); 
    
    
} 



$(".logSignSwitch").click(function(){
   
    $(".logInElements").toggle(); 
   
    $(".signUpElements").toggle(); 
    
}); 



$("#emailUpdate").click(function(){
    
    $("#emailPopup").toggle(); 
    
}) 
    

$("#nameUpdate").click(function(){
        
    $("#namePopup").toggle(); 
        
}) 
    
    
    
$(".planSelect").click(function(){
    
    $(".planSelect").removeClass("selectButton-active"); 
    $(this).addClass("selectButton-active"); 
    
}); 


$(".sessionSelect").click(function(){
    
    
    $(".sessionSelect").removeClass("selectButton-active");
    $(this).addClass("selectButton-active"); 
    
}); 

$(".planSelect").click(function(){
    
    $(".planSelect > input").prop("checked", false);
    
    $(this).children("input").prop("checked", true); 
    
    
}); 


$(".sessionSelect").click(function(){
    
    $(".sessionSelect > input").prop("checked", false); 
    
    $(this).children("input").prop("checked", true); 
    
    
}); 



$(function () {
    
    $('[data-toggle="popover"]').popover() 
    
}); 




$("#start").click(function(){ 
    
    localStorage.setItem('restInterval', 0); 
    
});


    
let rest = $("#rest").val(); 

let restTime = localStorage.getItem("restInterval"); 

if($("#set").html() == " Set: 1 "){
 alert("hi");
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

$("#measurementUpdate").click(function(){
          
    $("#measurementPopUp").toggle();
          
});


