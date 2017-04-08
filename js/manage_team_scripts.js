function requiredField(theField, theDiv) {
    console.log(theField);
    var success = true;
    if (theField.val() == "") {
        theField.focus();

        var $label = $("label[for='"+theField.attr('id')+"']")
        theDiv.html($label.html() + " is required.");   
        
        success = false;
    }
    return success;
}

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
    
  $(".callInput").click(function(){
    $(".popUpWindow").show();
  });

  $(".close").click(function(){
    $(".popUpWindow").hide();
  });
    
  $("#playerTabAdd").click(function(){
    $("#pFName").focus();
  });
    
  $("#positionTabAdd").click(function(){
    $("#position").focus();
  });
    
  $("#gameTabAdd").click(function(){
    $("#game").focus();
  });
    
  $("#addPlayerForm").submit(function(e){
    e.preventDefault();
    var theDiv = $('#playerMsgDiv');
    theDiv.html('');
    if (requiredField($('#pFName'), theDiv) && requiredField($('#pLName'), theDiv)) {
        // ToDo: Submit form data via AJAX
    }
  });
    
  $("#addPositionForm").submit(function(e){
    e.preventDefault();
    var theDiv = $('#positionMsgDiv');
    theDiv.html('');
    if (requiredField($('#position'), theDiv)) {
        // ToDo: Submit form data via AJAX
    }
  });
    
  $("#addGameForm").submit(function(e){
    e.preventDefault();
    var theDiv = $('#gameMsgDiv');
    theDiv.html('');
    if (requiredField($('#game'), theDiv)) {
        // ToDo: Submit form data via AJAX
    }
  });
    
});
