function requiredField(theField, theDiv) {
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
        var data = {"team_id" : teamId, "f_name" : $('#pFName').val(), "l_name" : $('#pLName').val()};  
        //console.log(data);
        
        $.ajax({
            url: "insert_player.php",
            type: "POST",
            dataType: "json",
            data: data,
            error: function(jqXHR, textStatus, errorThrown) {
                // Fatal error on server
            },
            success: function(res){
                //console.log(res);
                var err = res.ERROR;
                
                if (err) {
                    $('#playerMsgDiv').html("Error: " + err);
                } else {
                    // success - display on page with id
                    $('#pFName').val('');
                    $('#pLName').val('');
                    $('#playerMsgDiv').html();
                    var li = document.createElement('li');
                    li.value = res.player_id;
                    var txtName = $('#pFName').val() + " " + $('#pLName').val();
                    var txtNode = document.createTextNode(txtName);
                    li.appendChild(txtNode);
                    
                    $('#playerList li:last-child').before(li);
                }
            }
        });
    }
  });
    
  $("#addPositionForm").submit(function(e){
    e.preventDefault();
    var theDiv = $('#positionMsgDiv');
    theDiv.html('');
      
    if (requiredField($('#position'), theDiv)) {
        var data = {"position_name" : $('#position').val()}; 
        //console.log(data);
        
        $.ajax({
            url: "insert_position.php",
            type: "POST",
            dataType: "json",
            data: data,
            error: function(jqXHR, textStatus, errorThrown) {
                // Fatal error on server
            },
            success: function(res){
                //console.log(res);
                var err = res.ERROR;
                
                if (err) {
                    $('#positionMsgDiv').html("Error: " + err);
                } else {
                    // success - display on page with id
                    $('#position').val('');
                    $('#positionMsgDiv').html();
                    var li = document.createElement('li');
                    li.value = res.position_id;
                    var txtName = $('#position').val();
                    var txtNode = document.createTextNode(txtName);
                    li.appendChild(txtNode);
                    
                    $('#positionList li:last-child').before(li);
                }
            }
        });
    }
  });
    
  $("#addGameForm").submit(function(e){
    e.preventDefault();
    var theDiv = $('#gameMsgDiv');
    theDiv.html('');

    if (requiredField($('#game'), theDiv)) {
        var data = {"team_id" : teamId, "game_name" : $('#game').val()}; 
        //console.log(data);
        
        $.ajax({
            url: "insert_game.php",
            type: "POST",
            dataType: "json",
            data: data,
            error: function(jqXHR, textStatus, errorThrown) {
                // Fatal error on server
            },
            success: function(res){
                //console.log(res);
                var err = res.ERROR;
                
                if (err) {
                    $('#gameMsgDiv').html("Error: " + err);
                } else {
                    // success - display on page with id
                    $('#game').val('');
                    $('#gameMsgDiv').html();
                    var li = document.createElement('li');
                    li.value = res.game_id;
                    var txtName = $('#game').val();
                    var txtNode = document.createTextNode(txtName);
                    li.appendChild(txtNode);
                    
                    $('#gameList li:last-child').before(li);
                }
            }
        });
    }
  });
});
