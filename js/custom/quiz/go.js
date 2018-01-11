$j(document).ready(function()
{
    var quizForm = $j("#quiz-form");
    //run timer
    setTimeout("quizTimer()",1000);
    
    //check if user set answer before submit
    quizForm.find("input[type=submit]").click(function()
    {
        var quizError = '';

        //digits3: start
        if(quizForm.find("input[name^=digits3]").length>0)
        {
            //clean checkboxes
            quizForm.find("input[name^=answers]:checked").prop('checked', false);//TODO: fix this
            //fill checkboxes based on digits in 3 inputs
            quizForm.find("input[name^=digits3]").each(function(index, element){
                var digit = element.value;
                if(digit!=='')
                {
                    //validate
                    if(!digit.match(/[1-7]/))
                    {
                        quizError = 'Should be number between 1 and 7';
                    }
                    //fill
                    else
                    {
                        quizForm.find("#digits3-"+digit+">input[name^=answers]").prop('checked', true);
                    }
                }
            });
        }
        //digits3: end

        if(quizError)
        {
            alert(quizError);
            return false;
        }

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