<?php 

    require("app/connect.php");
     
     
    if(empty($_SESSION['user'])) 
    { 
      
        header("Location: index.php"); 
         
        
        die("Redirecting to index.php"); 
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

					<div class="ui top attached tabular menu">
					  <a class="item active" data-tab="first">Event Elements</a>
					  <a class="item" data-tab="second">Vendors</a>
					  <a class="item" data-tab="third">Third</a>
					</div>
					<div class="ui bottom attached tab segment active" data-tab="first">
						<div class="ui three stackable cards" id="card-holder"></div>
						<div class="ui bottom attached tab segment" data-tab="second">Vendors </div>
						<div class="ui bottom attached tab segment" data-tab="third">Travel</div>
					</div><!--// End Column //-->		
				</div>
			</div>			
		</div> <!--// Main Container End //-->
		
		
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
								<input type="text" placeholder="Enter Cost" name="outward_cost" id="outward_cost" 
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
			getUnaproovedElements();
			$('.menu .item').tab();			  
		})
		</script>
	</body>
</html>