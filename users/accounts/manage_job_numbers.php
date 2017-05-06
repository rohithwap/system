<?php 

    require("app/connect.php");
     
     
    if(empty($_SESSION['user'])) 
    { 
      
        header("Location: index.php"); 
         
        
        die("Redirecting to index.php"); 
    } 
    
    $html="";
    $i=1;
    
    $database = new Database();
	$database->query('SELECT *
	FROM users 
	INNER JOIN job_nos
	ON users.`user_id` = job_nos.`account_mgr`;');
	$database->execute();
	$rows = $database->resultset();
	foreach($rows as $row){
		$menu ='
		<button class="ui labeled icon button basic red">
		  <i class="remove icon"></i>
		  Not Authorised
		</button>';
		if($row['user_name'] == $_SESSION['user']['user_name']){
		$menu = '<button class="ui labeled icon button add_estimate basic green" 
        data-jobnumber="'.$row['job_no'].'" 
        data-name="'.$row['event_name'].'" 
        data-city="'.$row['city'].'" 
        data-venue="'.$row['venue'].'" 
        data-manager="'.$row['account_mgr'].'" 
        data-start="'.$row['start_date'].'" 
        data-end="'.$row['end_date'].'"  
        data-status="'.$row['status'].'" data-tooltip="New Estimate" data-inverted="">
        <i class="add icon"></i> New Estimate
        </button>          
        ';
		}

		if($_SESSION['user']['user_type'] == "admin" || $_SESSION['user']['user_type'] == "accounts"){
			$menu = '
			<button class="ui button add_estimate basic green" 
	        data-jobnumber="'.$row['job_no'].'" 
	        data-name="'.$row['event_name'].'" 
	        data-city="'.$row['city'].'" 
	        data-venue="'.$row['venue'].'" 
	        data-manager="'.$row['account_mgr'].'" 
	        data-start="'.$row['start_date'].'" 
	        data-end="'.$row['end_date'].'"  
	        data-status="'.$row['status'].'" data-tooltip="New Estimate" data-inverted="">
	        <i class="add icon"></i> 
	        </button>
	          
	        <button class="ui button edit_jobno basic blue" 
	        data-jobnumber="'.$row['job_no'].'" 
	        data-name="'.$row['event_name'].'" 
	        data-city="'.$row['city'].'" 
	        data-venue="'.$row['venue'].'" 
	        data-manager="'.$row['account_mgr'].'" 
	        data-start="'.$row['start_date'].'" 
	        data-end="'.$row['end_date'].'"  
	        data-status="'.$row['status'].'" data-tooltip="Edit Job No" data-inverted="">
	        <i class="edit icon"></i> 
	        </button>
	          
	        <button class="ui button delete_jobno basic red" 
	        data-jobnumber="'.$row['job_no'].'" 
	        data-name="'.$row['event_name'].'" 
	        data-city="'.$row['city'].'" 
	        data-venue="'.$row['venue'].'" 
	        data-manager="'.$row['account_mgr'].'" 
	        data-start="'.$row['start_date'].'" 
	        data-end="'.$row['end_date'].'"  
	        data-status="'.$row['status'].'" data-tooltip="Delete Job No" data-inverted="">
	        <i class="Trash Outline icon"></i> 
	        </button>
			';
		}


    	$html .= '<tr>        
        <td>'.$row['job_no'].'</td>
        <td>'.$row['event_name'].'</td>
        <td>'.$row['city'].'</td>
        <td>'.$row['user_name'].'</td>
        <td>'.$row['status'].'</td>
        <td style="text-align: center;">
        <div class="ui icon buttons small">
        '.$menu.'
        </div>          
        </td></tr>';
        $i++;
    } 
    
?> 
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
		<link rel="stylesheet" href="dist/semantic/semantic.css">
		<link rel="stylesheet" href="dist/semantic/components/dropdown.min.css">
		<link rel="stylesheet" href="dist/semantic/components/form.min.css">
		<link href="https://cdn.rawgit.com/mdehoog/Semantic-UI-Calendar/76959c6f7d33a527b49be76789e984a0a407350b/dist/calendar.min.css" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jszip-2.5.0/pdfmake-0.1.18/dt-1.10.13/b-1.2.4/b-colvis-1.2.4/b-html5-1.2.4/b-print-1.2.4/r-2.1.1/datatables.min.css"/>
		<link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" href="css/responsive.css">
		
	</head>
	<body>
		
		<?php include('menu.php') ?>
		
		<!--// Main Container Start //-->	
		<div style="margin-top: 75px;">
			<div class="ui grid container">
				<div class="column row button-section">
					<div class="right floated column">
						<button class="ui green right floated labeled icon button show-modal" id="add___jobno">
						  <i class="plus icon"></i>
						  Add Job Number
						</button>
					</div>			
				</div>
				<div class="row">
					<div class="column">
						
					<!--// Data Tables //-->

					<table class="ui celled table data-tables" cellspacing="0" width="100%" id="tbl_jobnos">
			        <thead>
			            <tr>            
			                <th>Job No</th>
			                <th>Event</th>
			                <th>City</th>			                
			                <th>Account Manager</th>
			                <th>Status</th>
			                <th>Actions</th>
			            </tr>
			        </thead>
			        <tbody>
			            <?php echo $html; ?>
			        </tbody>
    				</table><!--// End Data Tables //-->

					</div><!--// End Column //-->		
				</div>
			</div>			
		</div> <!--// Main Container End //-->
		
		
<!-- // Modals -->
		
		<!-- // Add Jobno -->
		<div class="ui modal small add___jobno">
		  <i class="close icon"></i>
		  <div class="header">
		    Add Job Number
		  </div>
		  <div class="content" style="width: 60%; margin: 0px auto;">
		  			<form class="ui form" id="add_jobno"> 
		  			<!--// Start Form //-->
						<input type="hidden" name="action" value="addJobNo">
						<div class="ui form">
						  <div class="field">
						      <label>Event Name</label>
						      <div class="ui selection dropdown event_name">
						          <input type="hidden" name="event_name">
						          <i class="dropdown icon"></i>
						          <div class="default text">Event</div>
						          <div class="menu">
						          </div>
						      </div>
						  </div>
						</div>

						<div class="ui form">
						  <div class="field">
						      <label>City Name</label>
						      <div class="ui selection dropdown city_name">
						          <input type="hidden" name="city_name">
						          <i class="dropdown icon"></i>
						          <div class="default text">Event</div>
						          <div class="menu">
						          </div>
						      </div>
						  </div>
						</div>

						<div class="ui form">
						<div class="field">
						    <label>Venue</label>
						    <textarea name="venue" rows="2"></textarea>
						 </div>
						</div>

						<div class="ui form">
						  <div class="field">
						      <label>Account Manager</label>
						      <div class="ui selection dropdown account_mgr">
						          <input type="hidden" name="account_mgr">
						          <i class="dropdown icon"></i>
						          <div class="default text">Account Manager</div>
						          <div class="menu">
						          </div>
						      </div>
						  </div>
						</div>   					
						
						<div class="ui form">
							<div class="required field">	
								<label>Start Date</label>
								  <div class="ui calendar fluid" id="start_date">
									<div class="ui input left icon fluid">
									  <i class="calendar icon"></i>
									  <input type="text" placeholder="Date" name="start_date" value="">
									</div>
								  </div>
							</div>	
						</div> 						 
						
						<div class="ui form">
							<div class="required field">	
								<label>End Date</label>
								  <div class="ui calendar fluid" id="end_date">
									<div class="ui input left icon fluid">
									  <i class="calendar icon"></i>
									  <input type="text" placeholder="Date" name="end_date"  value="">
									</div>
								  </div>
							</div>	
						</div> 

						<div class="ui form" style="margin-top:20px;">
							<div class="ui error message"></div>
							<div class="server-status"></div>
						</div>
					</form><!--// End Form //-->

		  </div>
		  <div class="actions">
		    <button class="ui animated button large green submit" tabindex="0" type="submit" form="add_jobno"> <div class="visible content">Submit</div><div class="hidden content"><i class="right arrow icon"></i> </div></button>    
		  </div>
		</div>

		<!-- // EDIT Jobno -->
		<div class="ui modal small edit___jobno">
		  <i class="close icon"></i>
		  <div class="header">
		    Edit Job Number
		  </div>
		  <div class="content" style="width: 60%; margin: 0px auto;">
		  			<form class="ui form" id="edit_jobno"> 
		  			<!--// Start Form //-->
						<input type="hidden" name="action" value="editJobNo">
						<input type="hidden" name="jobno" id="jobnoval" value="">
						<div class="ui form">
						  <div class="field">
						      <label>Event Name</label>
						      <div class="ui selection dropdown edit_event_name">
						          <input type="hidden" name="event_name">
						          <i class="dropdown icon"></i>
						          <div class="default text">Event</div>
						          <div class="menu">
						          </div>
						      </div>
						  </div>
						</div>

						<div class="ui form">
						  <div class="field">
						      <label>City Name</label>
						      <div class="ui selection dropdown edit_city_name">
						          <input type="hidden" name="city_name">
						          <i class="dropdown icon"></i>
						          <div class="default text">Event</div>
						          <div class="menu">
						          </div>
						      </div>
						  </div>
						</div>

						<div class="ui form">
						<div class="field">
						    <label>Venue</label>
						    <textarea id="edit_venue" name="venue" rows="2"></textarea>
						 </div>
						</div>

						<div class="ui form">
						  <div class="field">
						      <label>Account Manager</label>
						      <div class="ui selection dropdown edit_account_mgr">
						          <input type="hidden" name="account_mgr">
						          <i class="dropdown icon"></i>
						          <div class="default text">Account Manager</div>
						          <div class="menu">
						          </div>
						      </div>
						  </div>
						</div>   					
						
						<div class="ui form">
							<div class="required field">	
								<label>Start Date</label>
								  <div class="ui calendar fluid" id="edit_start_date">
									<div class="ui input left icon fluid">
									  <i class="calendar icon"></i>
									  <input type="text" placeholder="Date" name="start_date" value="">
									</div>
								  </div>
							</div>	
						</div> 						 
						
						<div class="ui form">
							<div class="required field">	
								<label>End Date</label>
								  <div class="ui calendar fluid" id="edit_end_date">
									<div class="ui input left icon fluid">
									  <i class="calendar icon"></i>
									  <input type="text" placeholder="Date" name="end_date"  value="">
									</div>
								  </div>
							</div>	
						</div> 

						<div class="ui form">
						  <div class="field">
						      <label>Status</label>
						      <div class="ui selection dropdown edit_status">
						          <input type="hidden" name="status">
						          <i class="dropdown icon"></i>
						          <div class="default text">Account Manager</div>
						          <div class="menu">
						          	<div class="item" value="Active">Active</div>
									<div class="item" value="Inactive">Inactive</div>
						          </div>
						      </div>
						  </div>
						</div>  



						<div class="ui form" style="margin-top:20px;">
							<div class="ui error message"></div>
							<div class="server-status"></div>
						</div>
					</form><!--// End Form //-->

		  </div>
		  <div class="actions">
		    <button class="ui animated button large green submit" tabindex="0" type="submit" form="edit_jobno"> <div class="visible content">Submit</div><div class="hidden content"><i class="right arrow icon"></i> </div></button>    
		  </div>
		</div>
		
		<!-- // Add Estimates -->
		<div class="ui modal small add___estimate">
		  <i class="close icon"></i>
		  <div class="header">
		    Create A New Estimate
		  </div>
		  <div class="content" style="width: 60%; margin: 0px auto;">
		  			<form class="ui form" id="add_estimate"> 
		  			<!--// Start Form //-->
						<input type="hidden" name="action" value="addEstimate">

						<input type="hidden" name="job_no" id="jobno_val" value="">

						<div class="ui form">
							<div class="field">
							    <label>Estimate Name</label>
							    <input name="estimate_name" >
							 </div>
						</div>

						<div class="ui form">
						<div class="field">
						    <label>Estimate Description</label>
						    <textarea name="estimate_desc" rows="3"></textarea>
						 </div>
						</div>

						<div class="ui form">
						  <div class="field">
						      <label>Client Name</label>
						      <div class="ui selection dropdown client_name">
						          <input type="hidden" name="client_name">
						          <i class="dropdown icon"></i>
						          <div class="default text">Please Select</div>
						          <div class="menu">
						          </div>
						      </div>
						  </div>
						</div>

						<div class="ui form" style="margin-top:20px;">
							<div class="ui error message"></div>
							<div class="server-status"></div>
						</div>
					</form><!--// End Form //-->

		  </div>
		  <div class="actions">
		    <button class="ui animated button large green submit" tabindex="0" type="submit" form="add_estimate"> <div class="visible content">Submit</div><div class="hidden content"><i class="right arrow icon"></i> </div></button>    
		  </div>
		</div>
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
		<script src="dist/semantic/semantic.js"></script>
		<script src="dist/semantic/components/dropdown.min.js"></script>
		<script src="dist/semantic/components/form.min.js"></script>
		<script type="text/javascript" src="https://cdn.datatables.net/v/dt/jszip-2.5.0/pdfmake-0.1.18/dt-1.10.13/b-1.2.4/b-colvis-1.2.4/b-html5-1.2.4/b-print-1.2.4/r-2.1.1/datatables.min.js"></script>
		<script src="https://cdn.rawgit.com/mdehoog/Semantic-UI-Calendar/76959c6f7d33a527b49be76789e984a0a407350b/dist/calendar.min.js"></script>
		<script src="js/get.js"></script>
		<script src="js/app.js"></script>
		<script src="js/functions.js"></script>
		<script src="js/tables.js"></script>
		
		<script>
		$(document).ready(function(){

		$('#start_date, #end_date, #edit_start_date, #edit_end_date').calendar({
  			type: 'date',
			monthFirst: false,
			  formatter: {
				date: function (date, settings) {
				  if (!date) return '';
				  var day = date.getDate();
				  var month = date.getMonth() + 1;
				  var year = date.getFullYear();
				  formatted =  day + '/' + month + '/' + year;
				  return formatted;
				}
			},
			
		});	

		var table = $('tbody');
		table.find('tr').each(function (i, el) {
        var tds = $(this).find('td');
        var status = tds.eq(4).text();
           	if(status == 'inactive'){
        		tds.eq(5).find('.add_estimate').removeClass('blue').addClass('disabled grey');
            }
    	})

		getEventList();
		getCityList();
		getActiveUserList()
		getAllClientList()
							  
		})
		</script>
	</body>
</html>