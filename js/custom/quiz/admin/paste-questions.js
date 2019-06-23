$j(document).ready(function(){
    var selectedIds;
    if(selectedIds = localStorage.getItem('selectedIds')){
        selectedIds = JSON.parse(selectedIds);
        if(selectedIds.length > 0){
            $j('form[name=form]').prepend('<p><a id="paste-questions" href="#">Paste questions</a></p>')

            $j('#paste-questions').click(function(){
                var checkboxes = $j('form[name=form]').find('input[name^=check]:checked');
                if(checkboxes.length !== 1){
                    alert('Select just exactly one quiz');
                    return false;
                }

                var quizId = checkboxes[0].name.replace('check[','').replace(']','');
                var post = {
                    questionsIds: selectedIds,
                    quizId: quizId
                };
                $j.post(window.quizCopyQuestionsUrl, post, function (response) {
                    alert(response.message);
                },'json');

                //clean
                localStorage.removeItem('selectedIds');
                $j('#paste-questions').remove();
            });
        }
    }
});