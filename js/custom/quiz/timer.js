function quizTimer()
{
    //reduce time
    window.time_left--;

    //if no more time - submit form
    if(window.time_left <= 0)
    {
        $j("#quiz-form").find("input[type=submit]").click();
        return true;
    }

    var min, sec;
    //convert seconds to min:sec
    if( window.time_left>= 60 )
    {
        min = parseInt(window.time_left/60);
        sec = window.time_left-min*60;
    }
    else
    {
        min = "0";
        sec = window.time_left;
    }

    if(sec<10) sec = "0"+sec;

    $j("#quiz-timer").html(min+":"+sec);

    setTimeout("quizTimer()",1000);
}