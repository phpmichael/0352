var BUILDER = 
{
	//parse integer id from CSS id
	id_intval : function(id)
    {
        var arr = id.split("-").reverse();
    	return arr[0];
    },
    
    //show ajax response 
    show_response : function(message,css_class)
    {
    	$j("#ajax_response").html("<div class='"+css_class+"'>"+message+"</div>");
    	//scroll to top
    	$j("#screen").scrollTop(0);
    },
    
    //load item screen for edit
    load_item_screen : function(item)
    {
    	//get node edit url
		var a = $j(item).find('a:first');
        var url = $j(a).attr('href');
        if(url) $j("#screen").load(url);
    },
    
    //stored item for copy
    copy_item : false
};


$j(function () {
    
    //init sidebar accordion
	$j("#accordion").accordion();
	
	//show hide action buttons for selected part
	$j("#accordion h3").click(function() {
		var html_id = $j(this).attr('id');
		html_id = html_id.replace("-header","-buttons");
		
		$j("div[id$='-buttons']").hide();
		$j("#"+html_id).show();
	});
    
    
    //click PREVIEW FORM
    $j("#preview-form").click(function(){
        var li = $j("#form-tree").jstree("get_selected");
    	
    	if( li.length==1 )//if there is some item selected
    	{
    		//get item id
    		var item_id = BUILDER.id_intval($j(li).attr('id'));
    		
    		$j("#screen").load(URLS.preview_form+"/"+item_id);
    	}
    	else show_flash_msg("Select form for preview.",'error',"flash-messages-box",1,1);
    });
    
    //click EXPORT FORM
    $j("#export-form").click(function(){
        var li = $j("#form-tree").jstree("get_selected");
    	
    	if( li.length==1 )//if there is some item selected
    	{
    		//get item id
    		var item_id = BUILDER.id_intval($j(li).attr('id'));

    		//get database name
    		var dbname = prompt('Export to database: ');
    		
    		$j("#screen").load(URLS.export_form+"/"+item_id+"/"+dbname);
    	}
    	else show_flash_msg("Select form for export.",'error',"flash-messages-box",1,1);
    });
    
    //click CREATE TABLE for form
    $j("#create-table").click(function(){
        var li = $j("#form-tree").jstree("get_selected");
    	
    	if( li.length==1 )//if there is some item selected
    	{
    		//get item id
    		var item_id = BUILDER.id_intval($j(li).attr('id'));
    		
    		$j("#screen").load(URLS.create_table+"/"+item_id);
    	}
    	else show_flash_msg("Select form for create table.",'error',"flash-messages-box",1,1);
    });
    
    //click ADD ITEM
    $j(".add-item").click(function(){
    	//get clicked button id
        var btn_id = $j(this).attr('id');
        
        //url for adding 
        if( btn_id=='add-form' ) url = URLS.add_form;//clicked "add form"
        else if( btn_id=='add-container' ) url = URLS.add_container;//clicked "add container"
        else if( btn_id=='add-input' ) url = URLS.add_input;//clicked "add input"
        
        else if( btn_id=='add-answerset' ) url = URLS.add_answerset;//clicked "add answerset"
        else if( btn_id=='add-answerset-value' ) url = URLS.add_answerset_value;//clicked "add answerset value"
        
        if( btn_id=='add-form' || btn_id=='add-answerset' ) $j("#screen").load(url);
        else if( btn_id=='add-container' || btn_id=='add-input' )
        {
        	var li = $j("#form-tree").jstree("get_selected");
	        
	        if( li.length==1 && $j(li).attr('rel')!='input' )//check if item could be added
	        {
	            var path = $j("#form-tree").jstree("get_path",li,true);
        		//get form id
        		var form_id = path[0].toString().replace('li-form-','');
	        	
	        	if( $j(li).attr('rel')=='form' ) container_id = 0;//if form selected
	            else container_id = $j(li).attr('id').toString().replace('li-container-','');//if container selected
	            
	            $j("#screen").load(url+'/'+form_id+'/'+container_id);
	        }
	        else show_flash_msg("Container could be created just inside form or another container.",'error',"flash-messages-box",1,1);
        }
        else if( btn_id=='add-answerset-value' )
        {
        	var li = $j("#answerset-tree").jstree("get_selected");
	        
	        if( li.length==1 && $j(li).attr('rel')!='answersets_value' )//check if item could be added
	        {
	            var path = $j("#answerset-tree").jstree("get_path",li,true);
        		//get answerset id
        		var answerset_id = path[0].toString().replace('li-answerset-','');
	        	
	            $j("#screen").load(url+'/'+answerset_id);
	        }
	        else show_flash_msg("Answer value could be created just inside answerset.",'error',"flash-messages-box",1,1);
        }
    });
    
    //click REMOVE ITEM
    $j("#remove-forms-item, #remove-answersets-item").click(function(){
    	var tree_id = ($j(this).attr('id').indexOf('answersets')!=-1) ? 'answerset-tree' : 'form-tree';
        
        var li = $j("#"+tree_id).jstree("get_selected");
    	
    	if( li.length==1 )//if there is some item selected
    	{
    		if( confirm(MESSAGES.are_you_sure) )
    		{
	    		//get item id
	    		var item_id = BUILDER.id_intval($j(li).attr('id'));
	    		//get type
	    		var item_type = $j(li).attr('rel');
	    		//build remove url
	    		var remove_url = URLS.base+"/"+item_type+"s_remove/"+item_id;
	
	    		//do remove
	    		$j.get(remove_url,{},function(response){
	    			if(response) show_flash_msg(response,'error',"flash-messages-box",1,1);//if there is error or session expired
	    			else $j("#"+tree_id).jstree("remove");
	    		});
    		}
    	}
    	else show_flash_msg("Select item for remove.",'error',"flash-messages-box",1,1);
    });
    
    //click "COPY"
    $j("#copy-item").click(function(){
    	$j("#form-tree").jstree("copy");
    	
    	BUILDER.copy_item = $j("#form-tree").jstree("get_selected");
    	
    	$j("#paste-item").show();
    });
    
    //click "PASTE"
    $j("#paste-item").click(function(){
    	//$j("#form-tree").jstree("paste");
    	
    	var url = URLS.copy_form_item;
    	
    	var li = $j("#form-tree").jstree("get_selected");
	        
        if( li.length==1 && $j(li).attr('rel')!='input' )//check if item could be added
        {
            var path = $j("#form-tree").jstree("get_path",li,true);
    		//get form id
    		var form_id = path[0].toString().replace('li-form-','');
        	
        	if( $j(li).attr('rel')=='form' ) container_id = 0;//if form selected
            else container_id = $j(li).attr('id').toString().replace('li-container-','');//if container selcted
            
            post = {
            	item_type: $j(BUILDER.copy_item).attr('rel'),
            	item_id: BUILDER.id_intval($j(BUILDER.copy_item).attr('id')),
            	form_id: form_id,
            	container_id: container_id
            };
            
            $j.post(url,post,function(response){
            	
            	if(response.copy_id) 
            	{
            		$j("#form-tree").jstree("paste");
            		
            		var copy_item_id = $j(BUILDER.copy_item).attr('id');
            		var paste_item_id = 'copy_'+copy_item_id;
            		var paste_item = $j('#'+paste_item_id);
            		
            		paste_item_id = paste_item_id.replace('copy_','').replace(/[0-9]+$/,response.copy_id);
            		
            		$j(paste_item).attr('id',paste_item_id);
            		
            		paste_href = $j(paste_item).find('a:first').attr('href').replace(/inputs_edit\/[0-9]+\/[0-9]+\/[0-9]+/,'inputs_edit/'+post.form_id+'/'+post.container_id+'/'+response.copy_id);
            		$j(paste_item).find('a:first').attr('href',paste_href);
            	}
            },'json');
        }
        else show_flash_msg("Container could be copied just inside form or another container.",'error',"flash-messages-box",1,1);
    });
    
    //click ATTACH ANSWERSET
    $j("#attach-answerset").click(function(){
        var input_item = $j("#form-tree").jstree("get_selected");
        var answerset_item = $j("#answerset-tree").jstree("get_selected");
        
        if( $j(input_item).attr('rel')=='input' && $j(answerset_item).attr('rel')=='answerset' )
        {
            //get item id
    		var input_item_id = BUILDER.id_intval($j(input_item).attr('id'));
    		var answerset_item_id = BUILDER.id_intval($j(answerset_item).attr('id'));
            
            var attach_url = URLS.base+"/attach_answerset/"+answerset_item_id+'/'+input_item_id;
            
            //do attach
    		$j.get(attach_url,{},function(response){
    			if(response) show_flash_msg(response,'error',"flash-messages-box",1,1);//if there is error or session expired
    			else show_flash_msg("Answerset attached.",'success',"flash-messages-box",1,1);
    		});
        }
        else show_flash_msg("Please select input and answerset.",'error',"flash-messages-box",1,1);
    });
    
    //click DETACH ANSWERSET
    $j("#detach-answerset").click(function(){
        var input_item = $j("#form-tree").jstree("get_selected");
        
        if( $j(input_item).attr('rel')=='input' )
        {
            //get item id
    		var input_item_id = BUILDER.id_intval($j(input_item).attr('id'));
            
            var detach_url = URLS.base+"/detach_answerset/"+input_item_id;
            
            //do attach
    		$j.get(detach_url,{},function(response){
    			if(response) show_flash_msg(response,'error',"flash-messages-box",1,1);//if there is error or session expired
    			else show_flash_msg("Answerset detached.",'success',"flash-messages-box",1,1);
    		});
        }
        else show_flash_msg("Please select input.",'error',"flash-messages-box",1,1);
    });
    
    // --- Trees --- //
    
    //build forms tree
	$j("#form-tree").jstree({ 
	    
	    "themes" : {
            "theme" : "classic"
        },
        
        "ui" : {
            "select_limit" : 1//select not more than 1 item at once
        },
        
        "save_opened" : true,
        
        "crrm" : { 
            "move" : { 
                "check_move" : function (m) { 
                    
                    if( m.o.attr('rel')=='input' ) wrong_child_type = 'container';//input could not be dropped to container with containers
                    else if( m.o.attr('rel')=='container' ) wrong_child_type = 'input';//container could not be dropped to container with inputs
                    
                    if( $j(m.np).find(">ul>li[rel="+wrong_child_type+"]").length>0 ) return false;
                    return true;
                } 
            } 
        },
        
		"plugins" : [ "themes","html_data","ui","crrm","types","cookies","dnd" ],
		// Using types - most of the time this is an overkill
		// read the docs carefully to decide whether you need types
		"types" : {
			// I set both options to -2, as I do not need depth and children count checking
			// Those two checks may slow jstree a lot, so use only when needed
			"max_depth" : -2,
			"max_children" : -2,
			// I want only `form` nodes to be root nodes 
			// This will prevent moving or creating any other type as a root node
			"valid_children" : [ "form" ],
			"types" : {
				// The `input` type
				"input" : {
					// I want this type to have no children (so only leaf nodes)
					// In my case - those are `inputs`
					"valid_children" : "none",
					// If we specify an icon for the default type it WILL OVERRIDE the theme icons
					"icon" : {
						"image" : ICONS.input
					}
				},
				// The `container` type
				"folder" : {
					// can have `iputs` and other `containers` inside of it, but NOT `form` nodes
					"valid_children" : [ "input", "container" ]/*,
					"icon" : {
						"image" : "./img/container.png"
					}*/
				},
				// The `form` nodes 
				"form" : {
					// can have `inputs` and `containers` inside, but NOT other `forms` nodes
					"valid_children" : [ "input", "container" ],
					"icon" : {
						"image" : ICONS.form
					},
					// those prevent the functions with the same name to be used on `form` nodes
					// internally the `before` event is used
					"start_drag" : false,
					"move_node" : false
				}
			}
		}
	})
	.bind("select_node.jstree", function (event, data) {
		//get node
		var item = data.rslt.obj;
		
		BUILDER.load_item_screen(item);
		
		//show "remove" button
		$j("#remove-forms-item").show();
		
		//hide "preview-form" button
		$j("#preview-form").hide();
		//hide "export-form" button
		$j("#export-form").hide();
		//hide "create-table" button
		$j("#create-table").hide();
		//hide "copy/paste" buttons
		if( $j(item).attr('rel')=='form' ) $j("#copy-item").hide();
		else $j("#copy-item").show();
		if( !BUILDER.copy_item ) $j("#paste-item").hide();
        
        //hide "add" buttons if selected `input`
        //and show "attach" and "detach" buttons just for input
        if( $j(item).attr('rel')=='input' ) 
        {
        	$j("#add-container, #add-input").hide();
        	$j("#attach-answerset, #detach-answerset").show();
        }
        else 
        {
        	//show "preview-form", "export-form" buttons
        	if( $j(item).attr('rel')=='form' ) 
        	{
        		$j("#preview-form").show();
        		$j("#export-form").show();
        		$j("#create-table").show();
        	}
        	
        	if( $j(item).find(">ul>li[rel=input]").length>0 ) 
        	{
        	    $j("#add-input").show();
        	    $j("#add-container").hide();
        	}
        	else if( $j(item).find(">ul>li[rel=container]").length>0 ) 
        	{
        	    $j("#add-container").show();
        	    $j("#add-input").hide();
        	}
        	else $j("#add-container, #add-input").show();
        	
        	$j("#attach-answerset, #detach-answerset").hide();
        }
    })
    .bind("move_node.jstree", function (e, data) {
        data.rslt.o.each(function (i) {

        	if( data.rslt.cy!=1 ) //don't use move for copy now - move origin item in last place of its form
        	{
	        	$j.ajax({
	                async : false,
	                type: 'POST',
	                url: URLS.move_form_item,
	                data : 
	                {
	                    "item_type" : $j(this).attr("rel"),
	                    "item_id" : BUILDER.id_intval($j(this).attr("id")),
	                    "form_id" : BUILDER.id_intval($j(this).parents("li[rel=form]").attr("id")),
	                    "ref_type" : data.rslt.p=='last' ? BUILDER.id_intval(data.rslt.np.attr("rel")) : ( data.rslt.p=='before' ? BUILDER.id_intval(data.rslt.or.attr("rel")) : BUILDER.id_intval(data.rslt.r.attr("rel")) ),
	                    "ref_id" : data.rslt.p=='last' ? BUILDER.id_intval(data.rslt.np.attr("id")) : ( data.rslt.p=='before' ? BUILDER.id_intval(data.rslt.or.attr("id")) : BUILDER.id_intval(data.rslt.r.attr("id")) ),
	                    "move_type" : data.rslt.p
	                    /*"position" : data.rslt.cp + i,
	                    "copy" : data.rslt.cy ? 1 : 0*/
	                },
	                dataType : "json",
	                success : function (response) 
	                {
	                	if( !response.status ) 
	                    {
	                        $j.jstree.rollback(data.rlbk);
	                        
	                        //show not moved message
	                        //...
	                    }
	                    else 
	                    {
	                        //show moved message
	                        //...
	                        
	                        //refresh for copy nodes
	                        /*
	                        $j(data.rslt.oc).attr("id", "node_" + r.id);
	                        if(data.rslt.cy && $j(data.rslt.oc).children("UL").length) 
	                        {
	                            data.inst.refresh(data.inst._get_parent(data.rslt.oc));
	                        }
	                        */
	                    }
	                }
	            });
        	}
            
        });
    });

    
    //build answerset tree
	$j("#answerset-tree").jstree({ 
	    "themes" : {
            "theme" : "classic"
        },
        "ui" : {
            "select_limit" : 1//select not more than 1 item at once
        },
        "save_opened" : true,
		"plugins" : [ "themes","html_data","ui","crrm","types","cookies","dnd" ],
		// Using types - most of the time this is an overkill
		// read the docs carefully to decide whether you need types
		"types" : {
			// I set both options to -2, as I do not need depth and children count checking
			// Those two checks may slow jstree a lot, so use only when needed
			"max_depth" : -2,
			"max_children" : -2,
			// I want only `form` nodes to be root nodes 
			// This will prevent moving or creating any other type as a root node
			"valid_children" : [ "answerset" ],
			"types" : {
				// The `answersets_value` type
				"answersets_value" : {
					// I want this type to have no children (so only leaf nodes)
					// In my case - those are `inputs`
					"valid_children" : "none",
					// If we specify an icon for the default type it WILL OVERRIDE the theme icons
					"icon" : {
						"image" : ICONS.answerset_value
					}
				},
				// The `form` nodes 
				"answerset" : {
					// can have `inputs` and `containers` inside, but NOT other `forms` nodes
					"valid_children" : [ "answersets_value" ],
					// If we specify an icon for the default type it WILL OVERRIDE the theme icons
					"icon" : {
						"image" : ICONS.answerset
					},
					// those prevent the functions with the same name to be used on `form` nodes
					// internally the `before` event is used
					"start_drag" : false,
					"move_node" : false
				}
			}
		}
	})
	.bind("select_node.jstree", function (event, data) {
		//get node
		var item = data.rslt.obj;
		
		BUILDER.load_item_screen(item);
		
		//show "remove" button
		$j("#remove-answersets-item").show();
        
        //hide "add" buttons if selected `answerset value`
        if( $j(item).attr('rel')=='answersets_value' ) $j("#add-answerset-value").hide();
        else $j("#add-answerset-value").show();
    })
    .bind("move_node.jstree", function (e, data) {
        data.rslt.o.each(function (i) {

        	$j.ajax({
                async : false,
                type: 'POST',
                url: URLS.move_answerset_value,
                data : 
                {
                    "answer_id" : BUILDER.id_intval($j(this).attr("id")),
                    "answerset_id" : BUILDER.id_intval($j(this).parents("li[rel=answerset]").attr("id")),
                    "ref_type" : data.rslt.p=='last' ? BUILDER.id_intval(data.rslt.np.attr("rel")) : ( data.rslt.p=='before' ? BUILDER.id_intval(data.rslt.or.attr("rel")) : BUILDER.id_intval(data.rslt.r.attr("rel")) ),
                    "subling_id" : data.rslt.p=='last' ? BUILDER.id_intval(data.rslt.np.attr("id")) : ( data.rslt.p=='before' ? BUILDER.id_intval(data.rslt.or.attr("id")) : BUILDER.id_intval(data.rslt.r.attr("id")) ),
                    "move_type" : data.rslt.p
                },
                dataType : "json",
                success : function (response) 
                {
                	if( !response.status ) 
                    {
                        $j.jstree.rollback(data.rlbk);
                        
                        //show not moved message
                        //...
                    }
                    else 
                    {
                        //show moved message
                        //...
                    }
                }
            });
        });
    });
    
    
    // --- Processing "Item Add/Edit Form" --- //
    
    //container: 
    $j("#screen select[name=template]").live('change',function(){
    	var form = $j(this).parents('form');//get form object
    	
    	//show "selection amount columns" just if template="columns"
    	if( $j(this).val()=='columns' ) $j(form).find("select[name=columns]").parents('tr').show();
    	else $j(form).find("select[name=columns]").parents('tr').hide();
    	
    	//show "input for custom template" just if template="include"
    	if( $j(this).val()=='include' ) $j(form).find("input[name=template]").show().removeAttr('disabled');
        else $j(form).find("input[name=template]").hide().attr('disabled','disabled');
    });
    
    //input: hide some options depending from input type
    $j("#screen select[name=type]").live('change',function(){
    	var form = $j(this).parents('form');//get form object
    	
    	$j(form).find("input, select, textarea").parents('tr').show();
    	
    	switch( $j(this).val() )
    	{
    		case "submit":
    		case "button":
    			$j(form).find("input[name=height]").parents('tr').hide();
    			$j(form).find("input[name=width]").parents('tr').hide();
    			$j(form).find("input[name=value]").parents('tr').hide();
    			$j(form).find("input[name=validation]").parents('tr').hide();
    			$j(form).find("select[name=label_position]").parents('tr').hide();
    			$j(form).find("select[name=label_align]").parents('tr').hide();
    			$j(form).find("select[name=hide_label]").parents('tr').hide();
    			$j(form).find("input[name=label_width]").parents('tr').hide();
    			$j(form).find("select[name=label_width_units]").parents('tr').hide();
    			$j(form).find("select[name=show_on_list]").parents('tr').hide();
    			$j(form).find("input[name=hint]").parents('tr').hide();
    		break;
    		
    		case "content":
    			$j(form).find("input[name=name]").parents('tr').hide();
    			$j(form).find("input[name=html_id]").parents('tr').hide();
    			$j(form).find("input[name=height]").parents('tr').hide();
    			$j(form).find("input[name=width]").parents('tr').hide();
    			$j(form).find("input[name=value]").parents('tr').hide();
    			$j(form).find("input[name=validation]").parents('tr').hide();
    			$j(form).find("select[name=label_position]").parents('tr').hide();
    			$j(form).find("select[name=label_align]").parents('tr').hide();
    			$j(form).find("select[name=hide_label]").parents('tr').hide();
    			$j(form).find("input[name=label_width]").parents('tr').hide();
    			$j(form).find("select[name=label_width_units]").parents('tr').hide();
    			$j(form).find("select[name=show_on_list]").parents('tr').hide();
    			$j(form).find("input[name=hint]").parents('tr').hide();
    		break;
    		
    		case "password":
    		case "captcha":
    		case "file":
    			$j(form).find("input[name=value]").parents('tr').hide();
    		break;
    		
    		case "radio":
    		case "checkbox":
    			$j(form).find("input[name=height]").parents('tr').hide();
    			$j(form).find("input[name=width]").parents('tr').hide();
    			$j(form).find("input[name=hint]").parents('tr').hide();
    		break;
    		
    		case "hidden":
    			$j(form).find("input[name=html_id]").parents('tr').hide();
    			$j(form).find("input[name=height]").parents('tr').hide();
    			$j(form).find("input[name=width]").parents('tr').hide();
    			$j(form).find("select[name=align]").parents('tr').hide();
    			$j(form).find("select[name=label_position]").parents('tr').hide();
    			$j(form).find("select[name=label_align]").parents('tr').hide();
    			$j(form).find("select[name=hide_label]").parents('tr').hide();
    			$j(form).find("input[name=label_width]").parents('tr').hide();
    			$j(form).find("select[name=label_width_units]").parents('tr').hide();
    			$j(form).find("input[name=hint]").parents('tr').hide();
    			$j(form).find("input[name=html_class]").parents('tr').hide();
    		break;
    		
    		case "display":
    			$j(form).find("input[name=html_id]").parents('tr').hide();
    			$j(form).find("input[name=height]").parents('tr').hide();
    			$j(form).find("input[name=width]").parents('tr').hide();
    			$j(form).find("input[name=validation]").parents('tr').hide();
    		break;
    	}
    	
    	if( $j(this).val()!='file' ) $j(form).find("input[name^=image_], select[name^=image_]").parents('tr').hide();
    	if( $j(this).val()!='content' ) $j(form).find("textarea[name^=content]").parents('tr').hide();
    });
    
    //click save button on `form`, `container` or `input` form
    $j(".submit").live('click',function(){        
        var form = $j(this).parents('form');//get form object
        var form_action = $j(form).attr('action');//get form action
        
        var tree_id = (form_action.indexOf('answersets')!=-1) ? 'answerset-tree' : 'form-tree';
        
        //submit data
        $j.post( form_action, $j(form).serialize(), function(response){
            
            if( response.success )//successfully saved
            {
	            //get selected node
            	var node = $j("#"+tree_id).jstree("get_selected");
            	
            	//rename node if edit action
	            if( form_action.indexOf('edit/')!=-1 ) 
	            {
	            	$j("#"+tree_id).jstree("rename_node",node,response.item_title);
	            	
	            	//show success message
	            	BUILDER.show_response(response.success,'success');
	            }
	            //create node if add action
	            else 
	            {
	                var item_id = 'li-'+response.item_type+'-'+response.item_id;//build css id = li-[type]-[id]
	                
	                if( response.item_type=='form' || response.item_type=='answerset' ) 
	                {
	                	node = $j("#"+tree_id).find("li[rel="+response.item_type+"].jstree-last")
	                	if(node.length==1) position = 'after';
	                	else //empty tree
	                	{
	                		//create first node
	                		node = -1;
	                		position = false;
	                	}
	                }
	                else 
	                {
	                	position = 'last';
	                }
	                
	                $j("#"+tree_id).jstree("create_node",node,position,{'attr':{'id':item_id,'rel':response.item_type},'data':{'attr':{'href':response.item_url},'title':response.item_title}},function(){ 
	                	//deselect currently selected node
	                	$j("#"+tree_id).jstree("deselect_all"); 
	                	//select new added node
	                	$j("#"+tree_id).jstree("select_node","#"+item_id); 
	                });
	            }
            }
            else//there are errors
            {
	            //show errors
            	BUILDER.show_response(response.errors,'error');
            }
        },'json');
    });
    
    //click on input's attached answerset
    $j("#screen a.attached-answerset").live('click',function(){
    	//deselect currently selected node
	    $j("#answerset-tree").jstree("deselect_all"); 
    	//select (and load) answerset
	    $j("#answerset-tree").jstree("select_node","#li-answerset-"+$j(this).attr('answerset_id'));
    });
    
    //click on answerset's input
    $j("#screen a.attached-to-input").live('click',function(){
    	//deselect currently selected node
	    $j("#form-tree").jstree("deselect_all"); 
    	//select (and load) answerset
	    $j("#form-tree").jstree("select_node","#li-input-"+$j(this).attr('input_id'));
    });
    
     //click on "Generate from EN"
    $j("#screen a.generate-from-en-label").live('click',function(){
    	//get value of english label
	    var label = $j("#screen input[name='label[EN]']").val(); 
	    //make string lowercase
	    label = label.toLowerCase();
    	//replace spaces on underline
	    label = label.replace(/\s+/g,'_');
	    //remove all non alphanumeric chars
	    label = label.replace(/[^a-z0-9_]/g,'');
    	//set it as input name
    	$j(this).prev().val(label);
    });
    
    //protect from submit preview built form
    $j("#screen .fb-output-screen form").live('submit',function(){
        show_flash_msg("Could not submit form in preview mode.",'error',"flash-messages-box",1,1);
        return false;
    });
    
});