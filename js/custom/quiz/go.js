$j(document).ready(function()
{
    var quizForm = $j("#quiz-form");
    //run timer
    setTimeout("quizTimer()",1000);
    
    //check if user set answer before submit
    quizForm.find("input[type=submit]").click(function()
    {
        if(
            window.time_left <= 0 ||
            ( quizForm.find("input[name=custom_answer]").val() && quizForm.find("input[name=custom_answer]").val()!=undefined ) ||
            quizForm.find("input[name^=answers]:checked").length > 0 ||
            quizForm.find("input[name=answer]:checked").length > 0
        )
        {
            quizForm.submit();
            return true;
        }
        else
        {
            //show confirm box if user didn't answer
            if( confirm(window.are_you_sure) )
            {
                quizForm.submit();
                return true;
            }
        }
        
        return false;
    });
});