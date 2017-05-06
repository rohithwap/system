// All functions for UI Experience

//Toggle Mobile Menu
$('.mobile-toggle').click(function(){
	$('.mobile-hidden').toggleClass( "visible-custom" );
})

// Init Modal
$('.ui.modal').modal({
    onHide : function() {
      $('form').form('reset')
    }
});

$('.ui.dropdown').dropdown();

$('.ui.progress').progress();

function GetURLParameter(sParam){
    var sPageURL = window.location.search.substring(1);
    var sURLVariables = sPageURL.split('&');
    for (var i = 0; i < sURLVariables.length; i++)
    {
        var sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] == sParam)
        {
            return sParameterName[1];
       }
}
}


////////// MODALS //////////

/// SEND MAIL

$('#send___mail').click(function(){
    $('.send___mail').modal({
        closable: false,
        transition: 'horizontal flip'
     }).modal('show').addClass('scrolling active');
    $('body').addClass('scrolling');

})


/// ADD USER

$('#add___user').click(function(){
	$('.add___user').modal({
        closable: false,
        transition: 'horizontal flip',
         onApprove : function() {
                return false; //Return false as to not close modal dialog
            }
    }).modal('show');

    $('.userType .ui.dropdown').dropdown();

    $('.userType .menu').html('');   
    for(var i=0; i< user_types_data.length;i++){           	
   	    $('.userType .menu').append('<div class="item" data-value="'+ user_types_data[i]['user_type']+'">'+ user_types_data[i]['user_type']+'</div>')
    } 
})

/// EDIT USER

$('.edit_user').on('click', function(){

    $('.edit___user').modal({
            closable: false,
            transition: 'horizontal flip'
         }).modal('show');   
    $('#edit_user_id').val($(this).data('id'));
    $('#edit_user_name').val($(this).data('name'));
    $('#edit_user_email').val($(this).data('email'));
    $('#edit_user_mobile').val($(this).data('mobile'));    
    $('.editusertype .menu').html(''); 
    for(var i=0; i< user_types_data.length;i++){            
        $('.editusertype .menu').append('<div class="item" data-value="'+ user_types_data[i]['user_type']+'">'+ user_types_data[i]['user_type']+'</div>')
      }   
    $('.editusertype .ui.dropdown').dropdown();
    $('.editusertype').dropdown('set selected',$(this).data('type'));

    $('.edituserstatus .ui.dropdown').dropdown();
    $('.edituserstatus').dropdown('set selected',$(this).data('status'));

    })  

/// DELETE USER

$('#delete_user').click(function(){
$('.delete').addClass("loading disabled");    
var user_id = $('#edit_user_id').val()
$.get("app/calls.php?action=deleteUser&id="+user_id+"", function(data){
    if(data == 0){
          $('.server-status').html(""); 
          $('.server-status').fadeIn(300).delay(5000).fadeOut(1000);  
          $('.server-status').prepend('<div class="ui negative message">  <i class="close icon"></i>  <div class="header">Oops!  </div><p>We ae unable to delete this users information </p></div>')
          $('.delete').removeClass("loading disabled");

    }
    else if(data == 1){
        $('.delete').removeClass("loading disabled");
        $('.server-status').html("");
          $('.server-status').fadeIn(100).delay(1000).fadeOut(100);
          $('.server-status').prepend('<div class="ui positive message"><i class="close icon"></i><div class="header">Success!</div><p>User Deleted.</p></div>');
          usersTable.ajax.reload();       
          setTimeout(function(){
            $('.ui.modal').modal('hide');
          }, 2000);
          $('#add_user').form('reset')

    }   
});
})


/// ADD JOB NOS

$('#add___jobno').click(function(){
    $('.add___jobno').modal('setting', {
            closable: false,
            transition: 'horizontal flip'
    }).modal('show').addClass('scrolling active');
    $('body').addClass('scrolling');

    $('.event_name .menu').html(''); 
        for(var i=0; i < event_list_data.length; i++){            
    $('.event_name .menu').append('<div class="item" data-value="'+ event_list_data[i]['event_name']+'">'+ event_list_data[i]['event_name']+'</div>')
    }
    $('.city_name .menu').html(''); 
        for(var i=0; i < city_list_data.length; i++){
        $('.city_name .menu').append('<div class="item" data-value="'+ city_list_data[i]['city_name']+'">'+ city_list_data[i]['city_name']+'</div>')
    }
    $('.account_mgr .menu').html(''); 
        for(var i=0; i < active_user_data.length; i++){
        $('.account_mgr .menu').append('<div class="item" data-value="'+ active_user_data[i]['user_id']+'">'+ active_user_data[i]['user_name']+'</div>')
    }


})

/// EDIT JOB NOS

$('.edit_jobno').click(function(){
        $('.edit___jobno').modal('setting', {
        closable: false,
        transition: 'horizontal flip',
        autofocus: false
    }).modal('show').addClass('scrolling active');
    $('body').addClass('scrolling');

    $('.edit_event_name .menu').html(''); 
        for(var i=0; i < event_list_data.length; i++){            
    $('.edit_event_name .menu').append('<div class="item" data-value="'+ event_list_data[i]['event_name']+'">'+ event_list_data[i]['event_name']+'</div>')
    }
    $('.edit_city_name .menu').html(''); 
        for(var i=0; i < city_list_data.length; i++){
        $('.edit_city_name .menu').append('<div class="item" data-value="'+ city_list_data[i]['city_name']+'">'+ city_list_data[i]['city_name']+'</div>')
    }
    $('.edit_account_mgr .menu').html(''); 
        for(var i=0; i < active_user_data.length; i++){
        $('.edit_account_mgr .menu').append('<div class="item" data-value="'+ active_user_data[i]['user_id']+'">'+ active_user_data[i]['user_name']+'</div>')
    }

    
    $('#edit_start_date input').val($(this).data('start'));
    $('#edit_end_date input').val($(this).data('end'));
    $('#edit_venue').val($(this).data('venue'));
    $('#jobnoval').val($(this).data('jobnumber'));
    $('.edit_status').dropdown('set selected',$(this).data('status'));
    $('.edit_event_name').dropdown('set selected',$(this).data('name'));
    $('.edit_city_name').dropdown('set selected',$(this).data('city'));
    $('.edit_account_mgr').dropdown('set selected',$(this).data('manager'));

}) 


/// ADD ESTIMATES

$('.add_estimate').click(function(){
    $('.add___estimate').modal('setting', {
        closable: false,
        transition: 'horizontal flip'
    }).modal('show').addClass('scrolling active');
    $('#jobno_val').val($(this).data('jobnumber'));
    $('body').addClass('scrolling');
    
    $('.client_name .menu').html(''); 
        for(var i=0; i < client_list_data.length; i++){
    $('.client_name .menu').append('<div class="item" data-value="'+ client_list_data[i]['client_id']+'">'+ client_list_data[i]['client_name']+'</div>')
    }
})


/// ADD ELEMENT

$('.add_element').click(function(){
    $('.add___element').modal('setting', {
        closable: false,
        transition: 'horizontal flip'
    }).modal('show').addClass('scrolling active');
    $('#estimate_ref').val($(this).data('estid'));
    $('body').addClass('scrolling');
})

/// VIEW ELEMENT

$('.view_elements').click(function(){
    var count = +($(this).text());
    if(count > 0){
        var estid = $(this).data('estid');
        var status = $(this).data('status');
        getElements(estid,status);
    }  
})

/// ADD COSTING

$('.add_costing').click(function(){ 

    $('.vendors .menu').html("");

    for(var i=0; i < approved_vendor_list.length; i++){
        $('.vendors .menu').append('<div class="item" data-value='+ approved_vendor_list[i]['vendor_id'] +'>'+ approved_vendor_list[i]['name'] +'</div>')
    }
    $('.add___costing').modal('setting', {
        closable: false,
        transition: 'horizontal flip'
    }).modal('show').addClass('scrolling active');    
    $('body').addClass('scrolling');

    $('#element_id').val($(this).data('elementid'));
    $('#inward_cost').val($(this).data('inwardcost'));
    $('#outward_cost').val($(this).data('outwardcost')); 
    $(".ui.dropdown").dropdown("refresh");
    $('.ui.dropdown').dropdown('set selected',$(this).data('vendor'));   
})

/// EDIT ELEMENT

$('.edit_element').click(function(){
    var element_id = $(this).data('elementid');
    $('.element_id').val($(this).data('elementid'));
    getSingleElement(element_id);
})

/// APPROVE ELEMENT
$('body').on('click','.approve',function(){
    var selectedcard = $(this).closest('.card');
   selectedcard.prepend('<div class="ui active inverted dimmer"> <div class="ui text loader">Loading</div></div>')
    var id = $(this).data('id');   
    $.get("../../app/calls.php?action=approveElement&id="+id+"", function(data){
        if(data == '0'){
            console.log('error - not approving');
        }
        else if(data == '1'){
            selectedcard.fadeOut("slow");
        }
    })  
})

/// TOGGLE LOG BOX

$('.log').click(function(){ 
    $('#notifications').html('<div class="ui active inverted dimmer"><div class="ui text loader">Loading</div></div>');   
    $('.log-slider').toggleClass('log-slider-visible');
    getLog();
    if(($( ".log-slider" ).hasClass( "log-slider-visible" )) == true){
        fetch = setInterval(getLog, 30000);
    }
})

$('.close-log').click(function(){   
    $('.log-slider').toggleClass('log-slider-visible');
    if(($( ".log-slider" ).hasClass( "log-slider-visible" )) == false){
        clearInterval(fetch)
    }
})

/// TOGGLE PO BOX

$('#generatePo').click(function(){ 
    $('#podata').append('<div class="ui active inverted dimmer"><div class="ui text loader">Loading</div></div>');   
    $('.po-slider').toggleClass('po-slider-visible');
    $('#filtered-results .list').html('');
    $('.dropdown').dropdown('restore defaults');
    $('#makePo').remove();
    getPo();    
})

$('.close-po').click(function(){ 
     $('.po-slider').toggleClass('po-slider-visible');
     $('.dropdown').dropdown('restore defaults');
     $('#filtered-results .list').html('');
})

$('.po-vendor').dropdown('setting', 'onChange', function(){
   var selected = $('.po-vendor').dropdown('get value');
    var result = _.filter(po_vendor_list, {vendor_reference: selected});
    $('#filtered-results .list').html('');
    $('#makePo').remove();
    for(var i = 0; i < result.length; i++){        
        $('#filtered-results .list').append('<a class="item"> <i class="right triangle icon"></i> <div class="content"> <div class="header">'+result[i]['element_name']+'</div><div class="description">'+result[i]['element_desc']+'</div></div></a>')
    }

    var estid = GetURLParameter('token');

    $('#podata').append('<button class="ui labeled green icon button" id="makePo" data-vendor="'+ selected +'" data-estid="'+ estid +'"> <i class="file icon"></i> Generate PO</button>')

})

$('#podata').on('click','#makePo',function(){    
    makePo();
})