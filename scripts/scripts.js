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

$("form.checking-form input").keypress(function(e) {
    //Enter key
    if (e.which == 13) {
      return false;
    }
  });

$(".checking-form").submit(function(e){
    if(e.keyCode == 13) {
        e.preventDefault();
        return false;
      }
    var form_data = $(".checking-form").serialize();
    formsubmit(form_data);
 
    function formsubmit(form_data){
       $.ajax({
       url : "xf.php",
       type: "post",
       data : form_data
       }).done(function(response){
           if(response == "success"){
               $(".checking-form").slideToggle();
               $(".checking-success").slideToggle();
               setTimeout(function(){
                   window.location = document.URL;
               }, 3000)
           }
       });
       console.log('potato');
    }
})

$(".character-edit-form").submit(function(event){
   event.preventDefault();
   var form_data = $(".character-edit-form").serialize();
   formsubmit(form_data);

   function formsubmit(form_data){
      $.ajax({
      url : "xf.php",
      type: "post",
      data : form_data
      }).done(function(response){
          if(response == "success"){
              $(".character-edit-form").slideToggle();
              $(".checking-success").slideToggle();
              setTimeout(function(){
                  window.location = "./check.php";
              }, 3000)
          }
      });
   }

})

