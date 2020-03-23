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
    $("#emailPopup").slideToggle(); 
}) 

    

$("#nameUpdate").click(function(){
    $("#namePopup").slideToggle(); 
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


$("#measurementUpdate").click(function(){
    $("#measurementPopUp").slideToggle();
});



$("#keyLiftUpdate").click(function(){
    $("#keyLiftPopUp").slideToggle();
});



$("#editBTN").click(function(){
    $(".editTable").toggle();
    $(".displayTable").toggle();
})


$('.workoutNotification').click(function (){
        
    $(this).children("form").submit();
        
});
        
$("#cookieButton").click(function(){
            
    $("#cookieConsent").hide();
            
})


