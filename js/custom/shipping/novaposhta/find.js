$j(document).ready(function(){
    var novaposhta = {
        api: {
            key: ''
        },
        inputs: {
            city: ".fb-output-screen input[name=city]",
            city_ref: ".fb-output-screen input[name=city_ref]",
            department: ".fb-output-screen select[name=department]",
            department_ref: ".fb-output-screen input[name=department_ref]",
        },
        fillCity: function(){
            $j(novaposhta.inputs.city).autocomplete({
                source: function (request, response) {
                    $j.ajax({
                        url: "https://api.novaposhta.ua/v2.0/json/",
                        contentType: "application/json",
                        dataType: 'jsonp',
                        data: {
                            modelName: "Address",
                            calledMethod: "getCities",
                            methodProperties: {FindByString: $j(novaposhta.inputs.city).val()},
                            apiKey: novaposhta.api.key
                        },
                        xhrFields: {
                            withCredentials: false
                        }
                    })
                    .done(function (data) {
                        response($j.map(data.data, function (item) {
                            return {
                                label: item.Description,
                                value: item.Description,
                                id: item.CityID,
                                Ref: item.Ref

                            };
                        }));
                    })
                    .fail(function (xhr, textStatus, errorThrown) {
                        alert(xhr.responseText);
                        //alert(textStatus);
                    });
                },
                //CITY SELECTED - FILL DEPARTMENTS
                select: function (event, ui) {
                    var cityRef = ui.item.Ref;

                    //fill hidden input
                    $j(novaposhta.inputs.city_ref).val(cityRef);

                    //fill departments dropdown
                    novaposhta.fillDepartment(cityRef);
                }
            });

            //clean on edit city
            $j(novaposhta.inputs.city).keydown(function () {
                $j(novaposhta.inputs.city_ref).val('');
                $j(novaposhta.inputs.department).empty();
                $j(novaposhta.inputs.department_ref).val('');
            });
        },
        fillDepartment: function(cityRef){
            $j.ajax({
                url: "https://api.novaposhta.ua/v2.0/json/",
                contentType: "application/json",
                dataType: 'jsonp',
                data: {
                    modelName: "Address",
                    calledMethod: "getWarehouses",
                    methodProperties: {CityRef: cityRef},
                    apiKey: novaposhta.api.key
                },
                xhrFields: {
                    withCredentials: false
                }
            })
            .done(function (data) {
                var departmentRef = $j(novaposhta.inputs.department_ref).val();//get saved value

                $j(novaposhta.inputs.department).empty();

                var i, item, option;
                for(i in data.data){
                    item = data.data[i];

                    option = new Option(item.Description, item.Description);
                    option.setAttribute('data-ref', item.Ref);
                    if(item.Ref == departmentRef) {
                        option.setAttribute('selected', true);
                    }
                    $j(novaposhta.inputs.department).append(option);
                }

                $j(novaposhta.inputs.department).change(function(){
                    var departmentRef = $j(this).find('option:selected').data('ref');
                    //fill hidden input
                    $j(novaposhta.inputs.department_ref).val(departmentRef);
                });
            })
            .fail(function (xhr, textStatus, errorThrown) {
                alert(xhr.responseText);
                //alert(textStatus);
            });
        }
    };

    //ON LOAD
    novaposhta.fillCity();

    var cityRef = $j(novaposhta.inputs.city_ref).val();
    if( cityRef !== ''){//fill department if saved
        novaposhta.fillDepartment(cityRef);
    }

});