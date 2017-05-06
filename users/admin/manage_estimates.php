<?php 

     require("../../routing.php");
    
    $html="";
    
    $database = new Database();
	$database->query('SELECT * FROM estimates 
		INNER JOIN job_nos ON estimates.`job_number` = job_nos.`job_no` 
		INNER JOIN clients ON clients.`client_id` = estimates.`client_id` 
		INNER JOIN users ON users.`user_id` = job_nos.`account_mgr`');
	$database->execute();
	$rows = $database->resultset();
	foreach($rows as $row){

		$estimate_reference = $row['estimate_id'];

		$appStatus="approved";
		$database->query('SELECT 1 FROM event_elements WHERE estimate_reference= :estimate_reference AND approval_status = :approval_status');
		$database->bind(':estimate_reference', $row['estimate_id']);
		$database->bind(':approval_status', $appStatus);
		$database->execute();
		$approved = $database->rowCount();

		$appStatus="rejected";
		$database->query('SELECT 1 FROM event_elements WHERE estimate_reference= :estimate_reference AND approval_status = :approval_status');
		$database->bind(':estimate_reference', $row['estimate_id']);
		$database->bind(':approval_status', $appStatus);
		$database->execute();
		$rejected = $database->rowCount();

		$appStatus="pending";
		$database->query('SELECT 1 FROM event_elements WHERE estimate_reference= :estimate_reference AND approval_status = :approval_status');
		$database->bind(':estimate_reference', $row['estimate_id']);
		$database->bind(':approval_status', $appStatus);
		$database->execute();
		$pending = $database->rowCount();

		$crypt = new Crypt;
		$encoded = $crypt->encrypt($row['estimate_id']);

		$menu ='
		<button class="ui button basic red">		 
		  Not Authorised
		</button>';

		if($_SESSION['user']['user_type'] == "operations"){
			$menu ='
			<button class="ui button edit_jobno basic green" 
	        data-jobnumber="'.$row['job_no'].'" 
	        data-name="'.$row['event_name'].'" 
	        data-city="'.$row['city'].'" 
	        data-venue="'.$row['venue'].'" 
	        data-manager="'.$row['account_mgr'].'" 
	        data-start="'.$row['start_date'].'" 
	        data-end="'.$row['end_date'].'"  
	        data-status="'.$row['status'].'" data-tooltip="Manage elements" data-inverted="">
	        <i class="List icon"></i> 
	        </button>
			';
		}

		if($row['user_name'] == $_SESSION['user']['user_name']){
		$menu = '
			<button class="ui button add_element basic blue" 
	        data-jobnumber="'.$row['job_no'].'" 
	        data-estid="'.$row['estimate_id'].'"  
	        data-name="'.$row['event_name'].'" 
	        data-city="'.$row['city'].'" 
	        data-venue="'.$row['venue'].'" 
	        data-manager="'.$row['account_mgr'].'" 
	        data-start="'.$row['start_date'].'" 
	        data-end="'.$row['end_date'].'"  
	        data-status="'.$row['status'].'" data-tooltip="Add Elements" data-inverted="">
	        <i class="add icon"></i> 
	        </button>
	          
	        <a class="ui button edit_jobno basic green" 
	        data-jobnumber="'.$row['job_no'].'" 
	        data-name="'.$row['event_name'].'" 
	        data-city="'.$row['city'].'" 
	        data-venue="'.$row['venue'].'" 
	        data-manager="'.$row['account_mgr'].'" 
	        data-start="'.$row['start_date'].'" 
	        data-end="'.$row['end_date'].'"  
	        data-status="'.$row['status'].'" data-tooltip="Manage elements" data-inverted="">
	        <i class="List icon"></i> 
	        </a>
	          
	        <button class="ui button delete_jobno basic red" 
	        data-jobnumber="'.$row['job_no'].'" 
	        data-name="'.$row['event_name'].'" 
	        data-city="'.$row['city'].'" 
	        data-venue="'.$row['venue'].'" 
	        data-manager="'.$row['account_mgr'].'" 
	        data-start="'.$row['start_date'].'" 
	        data-end="'.$row['end_date'].'"  
	        data-status="'.$row['status'].'" data-tooltip="Delete Estimate" data-inverted="">
	        <i class="Trash Outline icon"></i> 
	        </button>          
        ';
		}

		if($_SESSION['user']['user_type'] == "admin" || $_SESSION['user']['user_type'] == "accounts"){
			$menu = '
			<button class="ui button add_element basic blue" 
	        data-jobnumber="'.$row['job_no'].'" 
	        data-estid="'.$row['estimate_id'].'"  
	        data-name="'.$row['event_name'].'" 
	        data-city="'.$row['city'].'" 
	        data-venue="'.$row['venue'].'" 
	        data-manager="'.$row['account_mgr'].'" 
	        data-start="'.$row['start_date'].'" 
	        data-end="'.$row['end_date'].'"  
	        data-status="'.$row['status'].'" data-tooltip="Add Elements" data-inverted="">
	        <i class="add icon"></i> 
	        </button>
	          
	        <a class="ui button edit_jobno basic green" 
	        href="manage_elements.php?token='.$encoded.'"
	        data-jobnumber="'.$row['job_no'].'" 
	        data-name="'.$row['event_name'].'" 
	        data-city="'.$row['city'].'" 
	        data-venue="'.$row['venue'].'" 
	        data-manager="'.$row['account_mgr'].'" 
	        data-start="'.$row['start_date'].'" 
	        data-end="'.$row['end_date'].'"  
	        data-status="'.$row['status'].'" data-tooltip="Manage elements" data-inverted="">
	        <i class="List icon"></i> 
	        </a>
	          
	        <button class="ui button delete_jobno basic red" 
	        data-jobnumber="'.$row['job_no'].'" 
	        data-name="'.$row['event_name'].'" 
	        data-city="'.$row['city'].'" 
	        data-venue="'.$row['venue'].'" 
	        data-manager="'.$row['account_mgr'].'" 
	        data-start="'.$row['start_date'].'" 
	        data-end="'.$row['end_date'].'"  
	        data-status="'.$row['status'].'" data-tooltip="Delete Estimate" data-inverted="">
	        <i class="Trash Outline icon"></i> 
	        </button>
			';
		}

    	$html .= '<tr>
        <td>'.$row['estimate_id'].'</td>
        <td>'.$row['estimate_name'].'</td>
        <td>'.$row['estimate_desc'].'</td>
        <td>'.$row['client_name'].'</td>
        <td>'.$row['event_name'].'</td>
        <td>'.$row['city'].'</td>
        <td style="text-align: center">
        	<a class="ui green label view_elements" data-estid='.$row['estimate_id'].' data-status="approved">'.$approved.'</a>
			<a class="ui red label view_elements" data-estid='.$row['estimate_id'].' data-status="rejected">'.$rejected.'</a>
			<a class="ui grey label view_elements" data-estid='.$row['estimate_id'].' data-status="pending">'.$pending.'</a>
        </td>
        <td style="text-align: center;">
        <div class="ui icon buttons small">
        '.$menu.'
        </div>          
        </td></tr>';        
    } 
    
?> 
<html>
	<?php require("../../css.php"); ?>
	<body>
		
		<?php include('menu.php') ?>
		
		<!--// Main Container Start //-->	
		<div style="margin-top: 75px;">
			<div class="ui grid container">
				<!--div class="column row button-section">
					<div class="right floated column">
						<button class="ui green right floated labeled icon button show-modal" id="add___jobno">
						  <i class="plus icon"></i>
						  Add Job Number
						</button>
					</div>			
				</div-->
				<div class="row">
					<div class="column">
						
					<!--// Data Tables //-->

					<table class="ui celled table data-tables" cellspacing="0" width="100%" id="tbl_jobnos">
			        <thead>
			            <tr>	
			            	<th>Estimate Id</th>
			                <th>Name</th>
			                <th>Description</th>
			                <th>Client</th>			                
			                <th>Event</th>
			                <th>City</th>
			                <th>Approval</th>
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
		
		<!-- // Add Element -->
		<div class="ui modal small add___element">
		  <i class="close icon"></i>
		  <div class="header">
		    Add An Element
		  </div>
		  <div class="content" style="width: 60%; margin: 0px auto;">
		  			<form class="ui form" id="add_element"> 
		  			<!--// Start Form //-->
						<input type="hidden" name="action" value="addElement">

						<input type="hidden" name="estimate_ref" id="estimate_ref" value="">

						<div class="ui form" data-tooltip="This field will show in the final bill sent to customer" data-inverted="" data-position="right center">
							<div class="required field"> <label>Element Name</label> 
								<input type="text" placeholder="Enter Element Name" name="element_name" id="element_name" value="">
							</div>
						</div>

						<div class="ui form" data-tooltip="This field will show in the final bill sent to customer" data-inverted="" data-position="right center">
						<div class="required field">
						    <label>Element Description</label>
						    <textarea name="element_desc" rows="3"></textarea>
						 </div>
						</div>

						<div class="ui form" data-tooltip="This field will show in the final bill sent to customer" data-inverted="" data-position="right center">
							<div class="required field"> <label>Quantity</label> 
								<input type="number" placeholder="Enter Qty" name="element_qty" id="element_qty" value="">
							</div>
						</div>

						<div class="ui form">
						<div class="field">
						    <label>Internal Comments (If Any)</label>
						    <textarea name="comments" rows="3"></textarea>
						 </div>
						</div>

						

						<div class="ui form" style="margin-top:20px;">
							<div class="ui error message"></div>
							<div class="server-status"></div>
						</div>
					</form><!--// End Form //-->

		  </div>
		  <div class="actions">
		    <button class="ui animated button large green submit" tabindex="0" type="submit" form="add_element"> <div class="visible content">Submit</div><div class="hidden content"><i class="right arrow icon"></i> </div></button>    
		  </div>
		</div>


		<!-- // View Elements -->
		<div class="ui modal large view___elements">
		  <i class="close icon"></i>
		  <div class="header">
		    View Elements
		  </div>
		  <div class="content" style="width: 90%; margin: 0px auto;">
		  		
		  		<div class="ui raised segments">
			  		<div class="ui segment">
			  			<div class="ui red right ribbon label">Element Name</div>
				    	<p>Hello</p>
				  	</div>
			  		<div class="ui horizontal segments">
					    <div class="ui segment">
					      <div class="ui top  attached label">Element Description</div>	
					      <p>Element Comments</p>
					       <p>Element Comments</p>
					        <p>Element Comments</p>
					    </div>
					    <div class="ui segment">
					    	<div class="ui top  attached label">Element Comments</div>	
					      <p>Element Comments</p>
					    </div>					    
				  	</div>
				  	<div class="ui horizontal segments">
					    <div class="ui segment">
					    	<div class="ui top  attached label">Quantity</div>
					      	<p></p>
					    </div>
					    <div class="ui segment">
					    	<div class="ui top attached label">Inward Cost</div>
					      	<p>Inward Cost</p>
					    </div>
					    <div class="ui segment">
					    	<div class="ui top  attached label">Outward Cost</div>
					      <p>Outward Cost</p>
					    </div>						    
				  	</div>
				  	<div class="ui segment">
				  		<div class="ui top  attached label">Vendor Name</div>
				    	<p>Vendor Name</p>
				  	</div>
			  	</div>

			  	<div class="ui raised segments">
			  		<div class="ui segment">
			  			<div class="ui red right ribbon label">Element Name</div>
				    	<p>Hello</p>
				  	</div>
			  		<div class="ui horizontal segments">
					    <div class="ui segment">
					      <div class="ui top  attached label">Element Description</div>	
					      <p>Element Comments</p>
					       <p>Element Comments</p>
					        <p>Element Comments</p>
					    </div>
					    <div class="ui segment">
					    	<div class="ui top  attached label">Element Comments</div>	
					      <p>Element Comments</p>
					    </div>					    
				  	</div>
				  	<div class="ui horizontal segments">
					    <div class="ui segment">
					    	<div class="ui top  attached label">Quantity</div>
					      	<p></p>
					    </div>
					    <div class="ui segment">
					    	<div class="ui top attached label">Inward Cost</div>
					      	<p>Inward Cost</p>
					    </div>
					    <div class="ui segment">
					    	<div class="ui top  attached label">Outward Cost</div>
					      <p>Outward Cost</p>
					    </div>						    
				  	</div>
				  	<div class="ui segment">
				  		<div class="ui top  attached label">Vendor Name</div>
				    	<p>Vendor Name</p>
				  	</div>
			  	</div>
		  			

		  </div>
		  <div class="actions">
		    <button class="ui ui cancel button animated button large red" tabindex="0"> <div class="visible content">Close</div><div class="hidden content"><i class="right close icon"></i> </div></button>    
		  </div>
		</div>
		
		<?php require("../../js.php"); ?>	
			
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
		
		})
		</script>
	</body>
</html>