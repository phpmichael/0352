<?if($novaposhta_apiKey):?>
    <tr>
        <th colspan="2"><b>Нова Пошта</b></th>
    </tr>
    <tr>
        <td style="vertical-align:top">API Key</td>
        <td><?=form_input('novaposhta_apiKey',@$novaposhta_apiKey)?></td>
    </tr>
    <tr>
        <td style="vertical-align:top">Відправник</td>
        <td><?=form_input('novaposhta_Sender',@$novaposhta_Sender)?></td>
    </tr>
    <tr>
        <td style="vertical-align:top">Місто</td>
        <td><?=form_input('novaposhta_CitySender',@$novaposhta_CitySender)?></td>
    </tr>
    <tr>
        <td style="vertical-align:top">Адреса (відділення)</td>
        <td><?=form_input('novaposhta_SenderAddress',@$novaposhta_SenderAddress)?></td>
    </tr>
<?endif?>