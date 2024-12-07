function resizeMoving() {
  var height = $(".background").height();
  $("#moving-background").css("height", height);
}
$('input[list]').on('input', function (e) {
  var $input = $(e.target),
    $options = $('#' + $input.attr('list') + ' option'),
    $hiddenInput = $('#' + $input.attr('id') + '-hidden'),
    label = $input.val();

  $hiddenInput.val(label);

  for (var i = 0; i < $options.length; i++) {
    var $option = $options.eq(i);

    if ($option.text() === label) {
      $hiddenInput.val($option.attr('data-value'));
      break;
    }
  }
});

// For debugging purposes
// $("#checkinout-form").on('submit', function(e) {
//   $('#result').html( $('#mission_leader-hidden').val() );
//   e.preventDefault();
// });

function resetIfInvalid(el){
  //just for beeing sure that nothing is done if no value selected
  if (el.value == "")
      return;
  var options = el.list.options;
  for (var i = 0; i< options.length; i++) {
      if (el.value == options[i].value)
          //option matches: work is done
          return;
  }
  //no match was found: reset the value
  el.value = "";
}


$(document).ready(function () {
  setTimeout(function () {
    resizeMoving();
  }, 30)
});

$(window).resize(function () {
  resizeMoving();
})

$("form.checkinout-form input").keypress(function (e) {
  //Enter key
  if (e.which == 13) {
    return false;
  }
});

$(".checkinout-form").submit(function(e){
  e.preventDefault();
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
                 window.location = '/eos_shuttlebay';
             }, 3000)
         }
     });
  }
})


