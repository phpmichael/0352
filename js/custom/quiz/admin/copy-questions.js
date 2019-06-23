$j(document).ready(function(){
    $j('#copy-questions').click(function(){
        var checkboxes = $j('form[name=form]').find('input[name^=check]:checked');
        if(checkboxes.length === 0){
            alert('Please select at least one question');
            return false;
        }

        var selectedIds = [];
        $j.each(checkboxes, function(i, checkbox){
            selectedIds.push(checkbox.name.replace('check[','').replace(']',''));
            localStorage.setItem('selectedIds', JSON.stringify(selectedIds));
            location.href = window.quizListUrl;
        });
    });
});