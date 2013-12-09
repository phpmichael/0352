<style type="text/css">
#request_call .errors{color:#f00;text-align:left;}
#request_call .success{text-align:left;}
</style>

<div id="request_call">

    <div class="success"></div>
    <div class="errors"></div>
    
    <form id="request_call_form" action="#" method="post">
    
    <table>
        <tr>
            <td><?=$BC->_getFieldTitle("name")?>:</td> <td><?=form_input('name')?></td>
        </tr>
        <tr>
            <td><?=$BC->_getFieldTitle("phone")?>:</td> <td><?=form_input('phone')?></td>
        </tr>
    </table>
    
    </form>

</div>