<?php 

    require("../../routing.php");
    
    $id = $_GET['token'];

    $html="";
    
    $database = new Database();
	$database->query('SELECT * FROM event_elements  
		INNER JOIN estimates ON estimates.`estimate_id` = event_elements.`estimate_reference` 
		INNER JOIN job_nos ON job_nos.`job_no` = estimates.`job_number`
		INNER JOIN users ON users.`user_id` = job_nos.`account_mgr`
		WHERE estimate_reference=:estimate_reference');
	$database->bind(':estimate_reference', $id);
	$database->execute();
	$rows = $database->resultset();	
	foreach($rows as $row){	

		if($row['approval_status'] == "rejected"){
			$status = '
			<div class="rej" data-position="right center" data-inverted="" data-tooltip="'.$row['approval_reason'].'">rejected</div>';
		}
		else{
			$status = $row['approval_status'];
		}

		$menu ='
		<button class="ui button basic red">		 
		  Not Authorised
		</button>';

		if($_SESSION['user']['user_type'] == "operations"){
			$menu ='
			<button class="ui button add_costing basic blue" 
	        data-jobnumber="'.$row['job_no'].'"
	        data-estid="'.$row['estimate_id'].'"
	        data-elementid="'.$row['element_id'].'"  
	        data-name="'.$row['event_name'].'" 
	        data-city="'.$row['city'].'" 
	        data-venue="'.$row['venue'].'" 
	        data-manager="'.$row['account_mgr'].'" 
	        data-inwardcost="'.$row['inward_cost'].'"  
	        data-outwardcost="'.$row['outward_cost'].'"  
	        data-status="'.$row['status'].'" data-tooltip="Add Costing" data-inverted="">
	        <i class="add icon"></i> 
	        </button>
			';
		}

		if($row['user_name'] == $_SESSION['user']['user_name']){
		$menu = '
			<button class="ui button add_costing basic blue" 
	        data-jobnumber="'.$row['job_no'].'"
	        data-estid="'.$row['estimate_id'].'"
	        data-elementid="'.$row['element_id'].'"  
	        data-name="'.$row['event_name'].'" 
	        data-city="'.$row['city'].'" 
	        data-venue="'.$row['venue'].'" 
	        data-manager="'.$row['account_mgr'].'" 
	        data-inwardcost="'.$row['inward_cost'].'"  
	        data-outwardcost="'.$row['outward_cost'].'"  
	        data-status="'.$row['status'].'" data-tooltip="Add Costing" data-inverted="">
	        <i class="add icon"></i> 
	        </button>
	          
	        <button class="ui button edit_element basic green"
	        data-jobnumber="'.$row['job_no'].'"
	        data-estid="'.$row['estimate_id'].'" 
	        data-elementid="'.$row['element_id'].'" 
	        data-name="'.$row['event_name'].'" 
	        data-city="'.$row['city'].'" 
	        data-manager="'.$row['account_mgr'].'" 
	        data-status="'.$row['status'].'" 
	        data-tooltip="Edit element" data-inverted="">
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
	        data-status="'.$row['status'].'" data-tooltip="Delete Element" data-inverted="">
	        <i class="Trash Outline icon"></i> 
	        </button>
			';
		}

		if($_SESSION['user']['user_type'] == "admin" || $_SESSION['user']['user_type'] == "accounts"){
			$menu = '
			<button class="ui button add_costing basic blue" 
	        data-jobnumber="'.$row['job_no'].'"
	        data-estid="'.$row['estimate_id'].'"
	        data-elementid="'.$row['element_id'].'"  
	        data-name="'.$row['event_name'].'" 
	        data-city="'.$row['city'].'" 
	        data-venue="'.$row['venue'].'" 
	        data-manager="'.$row['account_mgr'].'" 
	        data-inwardcost="'.$row['inward_cost'].'"  
	        data-outwardcost="'.$row['outward_cost'].'"  
	        data-vendor="'.$row['vendor_reference'].'"  
	        data-status="'.$row['status'].'" data-tooltip="Add Costing" data-inverted="">
	        <i class="add icon"></i> 
	        </button>
	          
	        <button class="ui button edit_element basic green"
	        data-jobnumber="'.$row['job_no'].'"
	        data-estid="'.$row['estimate_id'].'" 
	        data-elementid="'.$row['element_id'].'" 
	        data-name="'.$row['event_name'].'" 
	        data-city="'.$row['city'].'" 
	        data-manager="'.$row['account_mgr'].'" 
	        data-status="'.$row['status'].'" 
	        data-tooltip="Edit element" data-inverted="">
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
	        data-status="'.$row['status'].'" data-tooltip="Delete Element" data-inverted="">
	        <i class="Trash Outline icon"></i> 
	        </button>
			';
		}

    	$html .= '<tr>        
        <td>'.$row['element_name'].'</td>
        <td>'.$row['element_desc'].'</td>
        <td>'.$row['element_qty'].'</td>        
        <td>'.$row['inward_cost'].'</td>
        <td>'.$row['outward_cost'].'</td>
        <td>'.$row['po_id'].'</td>
        <td>'.$status.'</td>        
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
		<div style="margin-top: 100px;">

			<div class="ui grid container">
				<div class="row">
					<div class="column">
						<div id="progress" class="ui indicating progress" data-value="1" data-total="100" id="example5">
						  <div class="bar">
						    <div class="progress"></div>
						  </div> 
						</div>
					</div>
				</div>	
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
			            	<th>Element Name</th>			                
			                <th>Description</th>
			                <th>Qty</th>		                
			                <th>Inward Cost</th>  
			                <th>Outward Cost</th>
			                 <th>PO No</th>
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
				<div class="row">
					<div class="column">
						<button class="ui labeled icon button" id="generatePo" data-id="<?php echo $id; ?>">
						  <i class="file icon"></i>
						  Purchase Order
						</button>
					</div>
				</div>
			</div>			
		</div> <!--// Main Container End //-->


		<!-- // PO BOX  -->
		<div class="po-slider" id="poBox">
			<div class="close-po">
				<button class="circular ui icon basic button">
						 <i class="close icon"></i>
				</button>
			</div>
			<div class="heading">Generate PO</div>
			<div class="po-slider-content" id="po-slider-content">
				<div class="ui very relaxed list" id="podata">
				
					<div class="required field">
						<label>Select Vendor</label>
						<div class="ui fluid search selection dropdown po-vendor required">
						  <input type="hidden" name="vendor">
						  <i class="dropdown icon"></i>
						  <div class="default text">Select Vendor</div>
						  <div class="menu">
						  </div>
 						</div>	
					</div>
					<div class="ui icon message small">
					  <i class="inbox icon"></i>
					  <div class="content">
					    <div class="header">
					      Items that will appear in the PO
					    </div>
					  </div>
					</div>
					<div id="filtered-results">
						<div class="ui relaxed list">

						</div>
					</div>		

				</div>	
			</div>
		</div>
		
		
<!-- // Modals -->
		
		<!-- // Add costing -->
		<div class="ui modal small add___costing">
		  <i class="close icon"></i>
		  <div class="header">
		    Add Costing
		  </div>
		  <div class="content" style="width: 60%; margin: 0px auto;">
		  			<form class="ui form" id="add_costing"> 
		  			<!--// Start Form //-->
						<input type="hidden" name="action" value="addCosting">
						<input type="hidden" name="element_id" id="element_id" value="">
						<div class="ui form">
							<div class="required field"> <label>Inward Costing</label> 
								<input type="number" placeholder="Enter Cost" name="inward_cost" id="inward_cost" 
								value="">
							</div>
						</div>

						<div class="ui form">
							<div class="required field"> <label>Outward Costing</label> 
								<input type="number" placeholder="Enter Cost" name="outward_cost" id="outward_cost" 
								value="">
							</div>
						</div>

						<div class="required field">
						<label>Vendor</label>
							<div class="ui fluid search selection dropdown vendors required">
						  <input type="hidden" name="vendor">
						  <i class="dropdown icon"></i>
						  <div class="default text">Select Vendor</div>
						  <div class="menu">
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
		    <button class="ui animated button large green submit" tabindex="0" type="submit" form="add_costing"> <div class="visible content">Submit</div><div class="hidden content"><i class="right arrow icon"></i> </div></button>    
		  </div>
		</div>


		<!-- // Edit Element -->
		<div class="ui modal small edit___element">
		  <i class="close icon"></i>
		  <div class="header">
		    Edit Element
		  </div>
		  <div class="content" style="width: 60%; margin: 0px auto;">
		  			<form class="ui form" id="edit_element"> 
		  			<!--// Start Form //-->
						<input type="hidden" name="action" value="editElement">

						<input type="hidden" name="element_id" class="element_id" value="">

						<div class="ui form" data-tooltip="This field will show in the final bill sent to customer" data-inverted="" data-position="right center">
							<div class="required field"> <label>Element Name</label> 
								<input type="text" placeholder="Enter Element Name" name="element_name" id="element_name" value="">
							</div>
						</div>

						<div class="ui form" data-tooltip="This field will show in the final bill sent to customer" data-inverted="" data-position="right center">
						<div class="required field">
						    <label>Element Description</label>
						    <textarea name="element_desc" rows="3" id="element_desc"></textarea>
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
						    <textarea name="comments" id="element_comments" rows="3"></textarea>
						 </div>
						</div>

						

						<div class="ui form" style="margin-top:20px;">
							<div class="ui error message"></div>
							<div class="server-status"></div>
						</div>
					</form><!--// End Form //-->

		  </div>
		  <div class="actions">
		    <button class="ui animated button large green submit" tabindex="0" type="submit" form="edit_element"> <div class="visible content">Submit</div><div class="hidden content"><i class="right arrow icon"></i> </div></button>    
		  </div>
		</div>


		
		<?php require("../../js.php"); ?>
		
		<script>
		$(document).ready(function(){
		getApprovedVendorList();
			
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

		totalCount = 0;
		pendingCount = 0;
		
		var table = $('tbody');
		table.find('tr').each(function (i, el) {
		totalCount++
        pendingCount++	
        var tds = $(this).find('td');
        var value = tds.eq(3).text();
           	if(value){
        		tds.eq(7).find('.edit_element').removeClass('green').addClass('disabled grey');        		
            }
        var value = tds.eq(6).text();
           	if(value == "approved"){
        		tds.eq(7).find('.edit_element, .add_costing').removeClass('green blue').addClass('disabled grey');
        		pendingCount--
        		
            }
        var value = tds.eq(6).find('.rej').text();
           	if(value == "rejected"){
        		tds.eq(7).find('.edit_element, .add_costing').removeClass('green blue').addClass('disabled grey');
        		tds.eq(6).find('.feedback').css({'display':'block'})
        		pendingCount--
            }       
    	}) 
		var remaining = (pendingCount/totalCount)*100 ;
    	var completed = (100 -  remaining) ; 	
		$('#progress').data('value',completed);	
		$('.ui.progress').progress();	
		})


		
		</script>
	</body>
</html>