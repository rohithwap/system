/* ALL GETS */

function getUserTypes(){
	$.get("../../app/calls.php?action=getUserTypes", function(data){
		   user_types_data = JSON.parse(data);	
	});	
}

function getUserList(){
	$.get("../../app/calls.php?action=getUsers", function(data){
		   user_data = JSON.parse(data);	
	});
}

function getActiveUserList(){
	$.get("../../app/calls.php?action=getActiveUsers", function(data){
		   active_user_data = JSON.parse(data);	
	});
}


function getEventList(){
	$.get("../../app/calls.php?action=getEventList", function(data){
		   event_list_data = JSON.parse(data);	
	});
}

function getCityList(){
	$.get("../../app/calls.php?action=getCityList", function(data){
		   city_list_data = JSON.parse(data);	
	});
}

function getAllClientList(){
	$.get("../../app/calls.php?action=getAllClientList", function(data){
		   client_list_data = JSON.parse(data);	
	});
}

function getEstimates(){
	$.get("../../app/calls.php?action=getEstimates", function(data){
		   estimate_list_data = JSON.parse(data);	
	});
}

function getElements(estid,status){
	$.get("../../app/calls.php?action=getElements&estid="+estid+"&status="+status+"", function(data){
		   element_list_data = JSON.parse(data);
		   $('.view___elements > .content').html("");
    for(var i=0; i<element_list_data.length;i++){
        $('.view___elements > .content').append('<div class="ui raised segments"> <div class="ui segment"> <div class="ui right ribbon label status">'+ element_list_data[i]['approval_status']+'</div><p>'+ element_list_data[i]['element_name']+'</p></div><div class="ui horizontal segments"> <div class="ui segment"> <div class="ui top attached label">Element Description</div><div>'+ element_list_data[i]['element_desc']+'</div></div><div class="ui segment"> <div class="ui top attached label">Element Comments</div><div>'+ element_list_data[i]['element_comments']+'</div></div></div><div class="ui horizontal segments"> <div class="ui segment"> <div class="ui top attached label">Quantity</div><div>'+ element_list_data[i]['element_qty']+'</div></div><div class="ui segment"> <div class="ui top attached label">Inward Cost</div><div>'+ element_list_data[i]['inward_cost']+'</div></div><div class="ui segment"> <div class="ui top attached label">Outward Cost</div><div>'+ element_list_data[i]['outward_cost']+'</div></div></div><div class="ui horizontal segments"> <div class="ui segment"> <div class="ui top attached label">Vendor Name</div><div>'+ element_list_data[i]['vendor_reference']+'</div></div><div class="ui segment"> <div class="ui top attached label">Reason</div><div>'+ element_list_data[i]['approval_reason']+'</div></div></div></div>')
    }
    $('.view___elements .content').find('.ribbon').each(function () {
        var text = $(this).text();
            if(text == "approved"){
                $(this).addClass('green');
            }
            else if(text == "rejected"){
                $(this).addClass('red');
            }
            else if(text == "pending"){
                $(this).addClass('grey');
            }
        })

    $('.view___elements').modal('setting', {
        closable: false,
        transition: 'fade up',
        autofocus: false,
        observeChanges: true
    }).modal('show').addClass('scrolling active');
    $('body').addClass('scrolling');	
	});
}


function getSingleElement(element_id){
	$.get("../../app/calls.php?action=getSingleElement&id="+element_id+"", function(data){
	element_item_data = JSON.parse(data);
		$('#element_name').val(element_item_data[0]['element_name']);
		$('#element_desc').val(element_item_data[0]['element_desc']);
		$('#element_qty').val(element_item_data[0]['element_qty']);
		$('#element_comments').val(element_item_data[0]['element_comments']);	   

    $('.edit___element').modal('setting', {
        closable: false,
        transition: 'horizontal flip'
    }).modal('show').addClass('scrolling active');
    $('#element_id').val($(this).data('elementid'));
    $('body').addClass('scrolling');	
	});
}

function getApprovedVendorList(){
	$.get("../../app/calls.php?action=getApprovedVendorList", function(data){
		   $('.vendors .menu').html("");	
		   approved_vendor_list = JSON.parse(data);
	});
}

function getUnaproovedElements(){
	$.get("../../app/calls.php?action=getUnaproovedElements", function(data){
		   $('#card-holder').html("");	
		   
		   unapproved_element_list = JSON.parse(data);
		   if(unapproved_element_list == 0){
		   		$('#card-holder').html("<img style='margin: 0px auto; padding:5%' src='../../img/done.jpg'>")
		   }
		   for(var i=0; i < unapproved_element_list.length; i++){
		   	var inCost = Number(unapproved_element_list[i]['inward_cost']).toLocaleString('en-IN');
		   	var outCost = Number(unapproved_element_list[i]['outward_cost']).toLocaleString('en-IN');
		   	$('#card-holder').append('<div class="card"> <div class="content"> <div class="header">'+ unapproved_element_list[i]['client_name']+'</div><div class="description">'+ unapproved_element_list[i]['event_name']+' - '+ unapproved_element_list[i]['city']+'</div><div class="ui clearing divider"></div><div class="quantity">Element: '+ unapproved_element_list[i]['element_name']+'</div><div class="quantity">Quantity: '+ unapproved_element_list[i]['element_qty']+'</div><div class="quantity">Description: '+ unapproved_element_list[i]['element_desc']+'</div><div class="ui clearing divider"></div><a class="fluid ui label basic"> <i class="arrow down icon"></i> Inward Cost : '+ inCost +'</a> <br><br><a class="fluid ui label basic"> <i class="arrow up icon"></i> Outward Cost : '+ outCost +'</a> <br><br></div><div class="extra content"> <div class="fluid ui buttons"> <div class="ui green button approve" data-id="'+ unapproved_element_list[i]['element_id'] +'" data-status="approve"> Approve</div><div class="ui floating labeled icon dropdown button red reject" data-id="'+ unapproved_element_list[i]['element_id'] +'" data_status="rejected"> <i class="chevron down icon"></i> <span class="text">Reject</span> <div class="menu"> <div class="header"> <i class="chevron right icon"></i> Reason </div><div class="divider"></div><div class="item"> In Cost </div><div class="item"> Out Cost </div><div class="item"> Item Canceled </div><div class="item"> Wrong Element </div><div class="item"> Bad Vendor </div></div></div></div></div></div>')
		  }
		$('.reject').dropdown('setting', 'onChange', function(){
    		
    		var selectedcard = $(this).closest('.card');
    		selectedcard.prepend('<div class="ui active inverted dimmer"> <div class="ui text loader">Loading</div></div>')	

		    var reason  =   $(this).dropdown('get value');    
		    var status  =   $(this).data('status');
		    var id      =   $(this).data('id');
		    
		    $.get("../../app/calls.php?action=rejectElement&id="+id+"&reason="+reason+"", function(data){
	        if(data == '0'){
	            console.log('error - not rejecting');
	        }
	        else if(data == '1'){
	            selectedcard.fadeOut("slow");
	        }
		    
			})   
		})
});
}

function getLog(){	
	var logId = $.cookie('readlogs');
	$.get("../../app/calls.php?action=getLog&id="+logId+"", function(data){		  
		   log_list = JSON.parse(data);
		   var maxIndex = Math.max.apply(Math,log_list.map(function(o){return o.log_id;}));
		   document.cookie = "readlogs="+maxIndex+"";
			$('#notifications').html("");
			for(var i=0; i < log_list.length; i++){
				if(log_list[i]['action'] == "addEstimate"){
					$('#notifications').append('<div class="item"> <img class="ui mini image" src="../../img/new_estimate.png"> <div class="content"> <div class="header"><span>'+ log_list[i]['user_name'] +'</span> has created an estimate for '+ log_list[i]['estimate_name'] +' for '+ log_list[i]['client_name'] +' at '+ log_list[i]['event_name'] +' '+ log_list[i]['city'] +' </div><div class="description">'+ log_list[i]['log_date'] +'</div></div></div>')
				}
				else if(log_list[i]['action'] == "addJobNo"){
					$('#notifications').append('<div class="item"> <img class="ui mini image" src="../../img/new_job.png"> <div class="content"> <div class="header"><span>'+ log_list[i]['user_name'] +'</span> has added a job number for '+ log_list[i]['event_name'] +' '+ log_list[i]['city'] +' </div><div class="description">'+ log_list[i]['log_date'] +'</div></div></div>')
				}
				else if(log_list[i]['action'] == "editJobNo"){
					$('#notifications').append('<div class="item"> <img class="ui mini image" src="../../img/log.png"> <div class="content"> <div class="header"><span>'+ log_list[i]['user_name'] +'</span> has edited the job number for '+ log_list[i]['event_name'] +' '+ log_list[i]['city'] +' </div><div class="description">'+ log_list[i]['log_date'] +'</div></div></div>')
				}
				else if(log_list[i]['action'] == "addElement"){
					$('#notifications').append('<div class="item"> <img class="ui mini image" src="../../img/new_element.png"> <div class="content"> <div class="header"><span>'+ log_list[i]['user_name'] +'</span> has added element - '+ log_list[i]['element_name'] +' - '+ log_list[i]['element_desc'] +'</div><div class="description">'+ log_list[i]['log_date'] +'</div></div></div>')
				}				
				else if(log_list[i]['action'] == "editElement"){
					$('#notifications').append('<div class="item"> <img class="ui mini image" src="../../img/log.png"> <div class="content"> <div class="header"><span>'+ log_list[i]['user_name'] +'</span> has edited element - '+ log_list[i]['element_name'] +' - '+ log_list[i]['element_desc'] +'</div><div class="description">'+ log_list[i]['log_date'] +'</div></div></div>')
				}
				else if(log_list[i]['action'] == "addCosting"){
					$('#notifications').append('<div class="item"> <img class="ui mini image" src="../../img/add_costing.png"> <div class="content"> <div class="header"><span>'+ log_list[i]['user_name'] +'</span> has added costing to '+ log_list[i]['element_name'] +' - '+ log_list[i]['element_desc'] +'</div><div class="description">'+ log_list[i]['log_date'] +'</div></div></div>')
				}
				else if(log_list[i]['action'] == "approveElement"){
					$('#notifications').append('<div class="item"> <img class="ui mini image" src="../../img/approve.png"> <div class="content"> <div class="header"><span>'+ log_list[i]['user_name'] +'</span> has approved '+ log_list[i]['element_name'] +' - '+ log_list[i]['element_desc'] +'</div><div class="description">'+ log_list[i]['log_date'] +'</div></div></div>')
				}
				else if(log_list[i]['action'] == "rejectElement"){
					$('#notifications').append('<div class="item"> <img class="ui mini image" src="../../img/reject.png"> <div class="content"> <div class="header"><span>'+ log_list[i]['user_name'] +'</span> has rejected '+ log_list[i]['element_name'] +' - '+ log_list[i]['element_desc'] +'</div><div class="description">'+ log_list[i]['log_date'] +'</div></div></div>')
				}
			}	   
	});
}

function getPo(){
	var id = $('#generatePo').data('id');
	$.get("../../app/calls.php?action=getPo&id="+ id +"", function(data){
		$('.po-vendor .menu').html("");	
		po_vendor_list = JSON.parse(data);		
		$('#podata .dimmer').remove();
		var dropdown = [];
		for(var i=0; i < po_vendor_list.length; i++){
			dropdown.push('<div class="item" data-value='+ po_vendor_list[i]['vendor_id'] +'>'+ po_vendor_list[i]['name'] +'</div>')        	
    	}
    	$('.po-vendor .menu').append(_.uniq(dropdown));

    		
	})
};

function makePo(){
	var vendor = $('#makePo').data('vendor');
    var estid = $('#makePo').data('estid');
	$.get("../../app/calls.php?action=makePo&vendor_id="+ vendor +"&estid="+ estid +"", function(data){

	})
}



