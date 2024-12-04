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

$(".checkinout-form").submit(function (e) {
  if (e.keyCode == 13) {
    e.preventDefault();
    return false;
  }
  var form_data = $(".checkinout-form").serialize();
  formsubmit(form_data);

  function formsubmit(form_data) {
    $.ajax({
      url: "xf.php",
      type: "post",
      data: form_data
    }).done(function (response) {
      if (response == "success") {
        $(".checkinout-form").slideToggle();
        $(".checking-success").slideToggle();
        setTimeout(function () {
          console.log('potato');
          window.location = document.URL;
        }, 3000)
      }
    });
  }
})


