<?php 

    require("../../app/connect.php");
     
     
    if(empty($_SESSION['user'])) 
    { 
      
        header("Location: index.php"); 
         
        
        die("Redirecting to index.php"); 
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

					<div class="ui top attached tabular menu">
					  <a class="item active" data-tab="first">Event Elements</a>
					  <a class="item" data-tab="second">Vendors</a>
					  <a class="item" data-tab="third">Travel</a>
					  <a class="item" data-tab="fourth">Expenses</a>
					</div>
					<div class="ui bottom attached tab segment active" data-tab="first">
						<div class="ui three stackable cards" id="card-holder">							
						</div>
					</div>	
					<div class="ui bottom attached tab segment" data-tab="second">
					Vendors 
					</div>
					<div class="ui bottom attached tab segment" data-tab="third">
					Travel
					</div>
					<div class="ui bottom attached tab segment" data-tab="fourth">
					Sundry
					</div>
					<!--// End Column //-->		
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


		
		
		<?php require("../../js.php"); ?>
		
		<script>
		$(document).ready(function(){			
			getUnaproovedElements();
			$('.menu .item').tab();			  
		})
		</script>
	</body>
</html>