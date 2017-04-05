$(document).ready(function() {
  $('.tab-panels .tabs li').on('click', function(){
    var $panel = $(this).closest('.tab-panels');

    $panel.find('.tabs li.active').removeClass('active');
    $(this).addClass('active');


    //slect panel to show
    var panelToShow = $(this).attr('rel');

    //hide panel
    $panel.find('.panel.active').slideUp(300, showNextPanel );


    //Show next panel
    function showNextPanel(){
      $(this).removeClass('active');

      $('#'+panelToShow).slideDown(300, function(){
        $(this).addClass('active');
      });
    }
  });
});

$(document).ready(function(){
  $(".callInput").click(function(){
    $(".popUpWindow").show();
  });

  $(".close").click(function(){
    $(".popUpWindow").hide();
  });
});
