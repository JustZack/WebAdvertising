$(document).ready(function(){
    validate("input[name='hostname']");
    $("input[name='hostname']").keyup(function(){
        validate("input[name='hostname']");
    });
    function validate(CurrentElement)
    {
        var currentHostName = $(CurrentElement).val().trim();
        var match = false;
        $("div.host").each(function(){
            if($(this).text() == currentHostName)
            {
                $(this).css('background-color', 'red');                                                     
                match = true;
            }
            else
            {
                $(this).css('background-color', '#BCC16F');                       
            }
        });
        if(match)
        {
            error("That Hostname is already registered");
            $("input[type='submit']").prop('disabled', true)
        } else {
            clearErrors()
            $("input[type='submit']").prop('disabled', false)
        }
    }

    $("#Groups div").click(function(){
        if($("input[name='groups']").val().indexOf($(this).text()) == -1){
            if($("input[name='groups']").val().length == 0){
                $("input[name='groups']").val($(this).text() + " ");
            } else {            
                $("input[name='groups']").val(($("input[name='groups']").val() + " " + $(this).text() + " "));                
            }
        }
    });
    //wayfindingCheckedHandler()
    function wayfindingCheckedHandler()
    {
        if($("input[type='checkbox']").is(':checked')){
            $("div.WayfindingNameWrapper").css("display", "block");
        } else if(!$("input[type='checkbox']").is(':checked')){
            $("div.WayfindingNameWrapper").css("display", "none");        
        }

    }
    $("input[type='checkbox']").change(wayfindingCheckedHandler);

    function error(Message)
    {
        clearErrors();
        $("#Errors").prepend("<div class=\"error-message\">" + Message + "</div>");
    }
    function clearErrors()
    {
        $(".error-message").remove();
    }
});