/* Legend */

// #xyz_xyz ===> button to open modal
// .xyz___xyz ===> Modal Class

// #xyz_xyz ===> Form Id
// function xyz__xyz()  ===> Validate & Submit to server

/* Pull In Tables*/

$(document).ready(function() {

$('body').find('.dt-button').removeClass('dt-button').addClass('ui button');

$('div.dt-buttons').css({'margin-bottom':'15px'});

///Init Users Table
  usersTable = $('#tbl_users').DataTable({
      responsive: true,
      dom: 'Bfrtip',
      buttons: [
        'copy', 'excel', 'pdf'
      ]
    })
    ///Init Users Table
  jobNostable = $('#tbl_jobnos').DataTable({
      responsive: true,
      dom: 'Bfrtip',
      buttons: [
        'copy', 'excel', 'pdf'
      ]
    })
});



///// FORMS /////

/// SEND MAIL FORM

$('#send_mail').form({
      fields: {
        email     : 'email',
        subject   : ['minLength[5]', 'empty'],
        html      : 'empty',
        },
        onSuccess: function(event, fields) {
          event.preventDefault();
          $('.submit').addClass('loading disabled');
            $.ajax({
          type: 'post',
          url: '../../app/calls.php',
          data: $('#send_mail').serialize(),
          success: function (data) {
             if(data == 0){
                $('.server-status').html(""); 
          $('.server-status').fadeIn(300).delay(5000).fadeOut(1000);
          $('.server-status').prepend('<div class="ui negative message">  <i class="close icon"></i>  <div class="header">Oops!  </div><p>Unable to send email. </p></div>')
          $('.submit').removeClass("loading disabled");
             }
             else if(data == 1){
          $('.submit').removeClass("loading disabled");
          $('.server-status').html("");
          $('.server-status').fadeIn(100).delay(1000).fadeOut(100);
          $('.server-status').prepend('<div class="ui positive message"><i class="close icon"></i><div class="header">Success</div><p>Email has been sent.</p></div>');
          setTimeout(function(){
            $('.ui.modal').modal('hide');
          }, 2000);
          $('#send_mail').form('reset')
            }
          }
        });      
    }
  })

/// ADD USER FORM 

$('#add_user').form({
      fields: {
        user_name     : 'empty',
        user_email   : 'email',
        user_mobile : ['minLength[10]','maxLength[10]','number', 'empty'],
        user_password : ['minLength[6]', 'empty'],
        userType : 'empty'
        },
        onSuccess: function(event, fields) {
          event.preventDefault();
          $('.submit').addClass('loading disabled');
            $.ajax({
          type: 'post',
          url: '../../app/calls.php',
          data: $('#add_user').serialize(),
          success: function (data) {
             if(data == 0){
                $('.server-status').html(""); 
          $('.server-status').fadeIn(300).delay(5000).fadeOut(1000);
          $('.server-status').prepend('<div class="ui negative message">  <i class="close icon"></i>  <div class="header">Oops!  </div><p>This email is already registered </p></div>')
          $('.submit').removeClass("loading disabled");
             }
             else if(data == 1){
          $('.submit').removeClass("loading disabled");
          $('.server-status').html("");
          $('.server-status').fadeIn(100).delay(1000).fadeOut(100);
          $('.server-status').prepend('<div class="ui positive message"><i class="close icon"></i><div class="header">Success</div><p>User added.</p></div>');
            location.reload();        
          setTimeout(function(){
            $('.ui.modal').modal('hide');
          }, 2000);
          $('#add_user').form('reset')
             }
          }
        });      
    }
  })

/// EDIT USER FORM

$('#edit_user').form({
      fields: {
        user_name     : 'empty',
        user_email   : 'email',
        user_mobile : ['minLength[10]','maxLength[10]','number', 'empty'],
        user_password : ['minLength[6]', 'empty'],
        userType : 'empty'
        },
        onSuccess: function(event, fields) {
          event.preventDefault();
          $('.submit').addClass('loading disabled');
            $.ajax({
          type: 'post',
          url: '../../app/calls.php',
          data: $('#edit_user').serialize(),
          success: function (data) {
             if(data == 0){
          $('.server-status').html(""); 
          $('.server-status').fadeIn(300).delay(5000).fadeOut(1000);
          $('.server-status').prepend('<div class="ui negative message">  <i class="close icon"></i>  <div class="header">Oops!  </div><p>We ae unable to update this users information </p></div>')
          $('.submit').removeClass("loading disabled");
             }
             else if(data == 1){
                $('.submit').removeClass("loading disabled");
          $('.server-status').html("");
          $('.server-status').fadeIn(100).delay(1000).fadeOut(100);
          $('.server-status').prepend('<div class="ui positive message"><i class="close icon"></i><div class="header">Success!</div><p>User updated.</p></div>');
          location.reload();       
          setTimeout(function(){
            $('.ui.modal').modal('hide');
          }, 2000);
          $('#add_user').form('reset')
             }
          }
        });      
    }
  })


/// ADD JOB NO FORM

$('#add_jobno')
  .form({
    fields: {
      event_name  : 'empty',
      city_name   : 'empty',
      venue       : 'empty',
      account_mgr : 'empty',
      start_date  : 'empty',
      end_date    : 'empty'      
      },
   onSuccess: function(event, fields) {
          event.preventDefault();
          $('.submit').addClass('loading disabled');
            $.ajax({
          type: 'post',
          url: '../../app/calls.php',
          data: $('#add_jobno').serialize(),
          success: function (data) {
             if(data == 0){
                $('.server-status').html(""); 
          $('.server-status').fadeIn(300).delay(5000).fadeOut(1000);
          $('.server-status').prepend('<div class="ui negative message">  <i class="close icon"></i>  <div class="header">Oops!  </div><p>Job already exists. </p></div>')
          $('.submit').removeClass("loading disabled");
             }
             else if(data == 1){
          $('.submit').removeClass("loading disabled");
          $('.server-status').html("");
          $('.server-status').fadeIn(100).delay(1000).fadeOut(100);
          $('.server-status').prepend('<div class="ui positive message"><i class="close icon"></i><div class="header">Success!</div><p>Job Number added..</p></div>');
          location.reload(); 
          setTimeout(function(){
            $('.ui.modal').modal('hide');
          }, 2000);
          $('#job_number').form('reset')
            }
          }
        });      
    }    
  });


  /// EDIT JOB NO FORM

$('#edit_jobno')
  .form({
    fields: {
      event_name  : 'empty',
      city_name   : 'empty',
      venue       : 'empty',
      account_mgr : 'empty',
      start_date  : 'empty',
      end_date    : 'empty',
      status      : 'empty'      
      },
   onSuccess: function(event, fields) {
          event.preventDefault();
          $('.submit').addClass('loading disabled');
            $.ajax({
          type: 'post',
          url: '../../app/calls.php',
          data: $('#edit_jobno').serialize(),
          success: function (data) {
             if(data == 0){
                $('.server-status').html(""); 
          $('.server-status').fadeIn(300).delay(5000).fadeOut(1000);
          $('.server-status').prepend('<div class="ui negative message">  <i class="close icon"></i>  <div class="header">Oops!  </div><p>Unable to edit. </p></div>')
          $('.submit').removeClass("loading disabled");
             }
             else if(data == 1){
          $('.submit').removeClass("loading disabled");
          $('.server-status').html("");
          $('.server-status').fadeIn(100).delay(1000).fadeOut(100);
          $('.server-status').prepend('<div class="ui positive message"><i class="close icon"></i><div class="header">Success!</div><p>Job edited.</p></div>');
          location.reload(); 
          setTimeout(function(){
            $('.ui.modal').modal('hide');
          }, 2000);
          $('#edit_jobno').form('reset')
            }
          }
        });      
    }    
  });

/// ADD ESTIMATE FORM

$('#add_estimate')
  .form({
    fields: {
      estimate_name  : 'empty',
      estimate_desc  : 'empty',
      client_name    : 'empty'         
      },
   onSuccess: function(event, fields) {
          event.preventDefault();
          $('.submit').addClass('loading disabled');
            $.ajax({
          type: 'post',
          url: '../../app/calls.php',
          data: $('#add_estimate').serialize(),
          success: function (data) {
             if(data == 0){
                $('.server-status').html(""); 
          $('.server-status').fadeIn(300).delay(5000).fadeOut(1000);
          $('.server-status').prepend('<div class="ui negative message">  <i class="close icon"></i>  <div class="header">Oops!  </div><p>Unable to add estimate. </p></div>')
          $('.submit').removeClass("loading disabled");
             }
             else if(data == 1){
          $('.submit').removeClass("loading disabled");
          $('.server-status').html("");
          $('.server-status').fadeIn(100).delay(1000).fadeOut(100);
          $('.server-status').prepend('<div class="ui positive message"><i class="close icon"></i><div class="header">Success!</div><p>Estimate Created.</p></div>');
          document.location = "manage_estimates.php";
          setTimeout(function(){
            $('.ui.modal').modal('hide');
          }, 2000);
          $('#job_number').form('reset')
            }
          }
        });      
    }    
  });

  /// ADD ESTIMATE FORM

$('#add_element')
  .form({
    fields: {
      element_name  : 'empty',
      element_desc  : 'empty',
      element_qty    : 'empty'         
      },
   onSuccess: function(event, fields) {
          event.preventDefault();
          $('.submit').addClass('loading disabled');
            $.ajax({
          type: 'post',
          url: '../../app/calls.php',
          data: $('#add_element').serialize(),
          success: function (data) {
             if(data == 0){
                $('.server-status').html(""); 
          $('.server-status').fadeIn(300).delay(5000).fadeOut(1000);
          $('.server-status').prepend('<div class="ui negative message">  <i class="close icon"></i>  <div class="header">Oops!  </div><p>Unable to add element. </p></div>')
          $('.submit').removeClass("loading disabled");
             }
             else if(data == 1){
          $('.submit').removeClass("loading disabled");
          $('.server-status').html("");
          $('.server-status').fadeIn(100).delay(1000).fadeOut(100);
          $('.server-status').prepend('<div class="ui positive message"><i class="close icon"></i><div class="header">Success!</div><p>Element added.</p></div>');          
          setTimeout(function(){
            $('.ui.modal').modal('hide');
            $('#add_element').form('reset');
            window.location.reload();
            }, 2000);                    
            }
          }
        });      
    }    
  });

  /// EDIT ELEMENT FORM
  $('#edit_element')
  .form({
    fields: {
      element_name  : 'empty',
      element_desc  : 'empty',
      element_qty    : 'empty'         
      },
   onSuccess: function(event, fields) {
          event.preventDefault();
          $('.submit').addClass('loading disabled');
            $.ajax({
          type: 'post',
          url: '../../app/calls.php',
          data: $('#edit_element').serialize(),
          success: function (data) {
             if(data == 0){
                $('.server-status').html(""); 
          $('.server-status').fadeIn(300).delay(5000).fadeOut(1000);
          $('.server-status').prepend('<div class="ui negative message">  <i class="close icon"></i>  <div class="header">Oops!  </div><p>Unable to edit element. </p></div>')
          $('.submit').removeClass("loading disabled");
             }
             else if(data == 1){
          $('.submit').removeClass("loading disabled");
          $('.server-status').html("");
          $('.server-status').fadeIn(100).delay(1000).fadeOut(100);
          $('.server-status').prepend('<div class="ui positive message"><i class="close icon"></i><div class="header">Success!</div><p>Element edited successfully.</p></div>');          
          setTimeout(function(){
            $('.ui.modal').modal('hide');
            $('#add_element').form('reset');
            window.location.reload();
            }, 2000);                    
            }
          }
        });      
    }    
  });

   /// EDIT ELEMENT FORM
  $('#add_costing')
  .form({
    fields: {
      inward_cost   :   'empty',     
      vendor        :   'empty'         
      },
   onSuccess: function(event, fields) {
          event.preventDefault();
          $('.submit').addClass('loading disabled');
            $.ajax({
          type: 'post',
          url: '../../app/calls.php',
          data: $('#add_costing').serialize(),
          success: function (data) {
             if(data == 0){
                $('.server-status').html(""); 
          $('.server-status').fadeIn(300).delay(5000).fadeOut(1000);
          $('.server-status').prepend('<div class="ui negative message">  <i class="close icon"></i>  <div class="header">Oops!  </div><p>Unable to add costing. </p></div>')
          $('.submit').removeClass("loading disabled");
             }
             else if(data == 1){
          $('.submit').removeClass("loading disabled");
          $('.server-status').html("");
          $('.server-status').fadeIn(100).delay(1000).fadeOut(100);
          $('.server-status').prepend('<div class="ui positive message"><i class="close icon"></i><div class="header">Success!</div><p>Cost Updated.</p></div>');          
          setTimeout(function(){
            $('.ui.modal').modal('hide');
            $('#add_element').form('reset');
            window.location.reload();
            }, 2000);                    
            }
          }
        });      
    }    
  });

