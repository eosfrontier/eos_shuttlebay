function resizeMoving(){
    var height = $(".background").height();
    $("#moving-background").css("height", height);
}

$( document ).ready(function() {
    setTimeout(function(){
        resizeMoving();
    }, 30)
});

$(window).resize(function(){
    resizeMoving();
})

$("form.checkinout-form input").keypress(function(e) {
    //Enter key
    if (e.which == 13) {
      return false;
    }
  });

$(".checkinout-form").submit(function(e){
    if(e.keyCode == 13) {
        e.preventDefault();
        return false;
      }
    var form_data = $(".checkinout-form").serialize();
    formsubmit(form_data);
 
    function formsubmit(form_data){
       $.ajax({
       url : "xf.php",
       type: "post",
       data : form_data
       }).done(function(response){
           if(response == "success"){
               $(".checkinout-form").slideToggle();
               $(".checking-success").slideToggle();
               setTimeout(function(){
                   window.location = document.URL;
               }, 3000)
           }
       });
       console.log('potato');
    }
})


