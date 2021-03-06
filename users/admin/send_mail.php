<?php

require("../../routing.php");

?>


<html>
	<?php require("../../css.php"); ?>
	<body>
		
		<?php include('menu.php') ?>
		
		<!--// Main Container Start //-->	
		<div style="margin-top: 75px;">
			<div class="ui grid container">
				<div class="column row button-section">
					<div class="right floated column">
						<button class="ui green right floated labeled icon button show-modal" id="send___mail">
						  <i class="plus icon"></i>
						  Send Mail
						</button>
					</div>			
				</div>
				<div class="row">
					<div class="column">
						
					<!--// Data Tables //-->

					<table class="ui celled table data-tables" cellspacing="0" width="100%" id="tbl_jobnos">
			        <thead>
			            <tr>
			                <th>Sl</th>
			                <th>Job No</th>
			                <th>Event</th>
			                <th>City</th>
			                <th>Start date</th>
			                <th>End date</th>
			                <th>Actions</th>
			            </tr>
			        </thead>
			        <tbody>
			            <tr>
			                <td></td>
			                <td>System Architect</td>
			                <td>Edinburgh</td>
			                <td>61</td>
			                <td>2011/04/25</td>
			                <td>2011/04/25</td>
			                <td><button id="edit___jobno" class="ui compact labeled icon button"><i class="edit icon"></i>Edit</button></td>
			            </tr>
			        </tbody>
    				</table><!--// End Data Tables //-->

					</div><!--// End Column //-->		
				</div>
			</div>			
		</div> <!--// Main Container End //-->
		
		
<!-- // Modals -->
		
		<!-- // Add Jobno -->
		<div class="ui modal small send___mail">
		  <i class="close icon"></i>
		  <div class="header">
		    Send Mail
		  </div>
		  <div class="content" style="width: 60%; margin: 0px auto;">
		  			<form class="ui form" id="send_mail">
		  			<!--// Start Form //-->
						<input type="hidden" name="action" id="action" value="sendMail">
						<div class="ui form">
							<div class="required field">
							  <label>Email id</label>
							  <input type="text" placeholder="Enter Email" name="email" id="email">
							</div>
						</div>

						<div class="ui form">
							<div class="required field">
							  <label>Subject</label>
							  <input type="text" placeholder="Enter Event" name="subject" id="subject">
							</div>
						</div>
						
						<div class="ui form">
						  <div class="field">
						    <label>HTML</label>
						    <textarea name="html" id="html"></textarea>
						  </div>						  
						</div>					
						
						<div class="ui form" style="margin-top:20px;">
							<div class="ui error message"></div>
							<div class="server-status"></div>
						</div>
					</form><!--// End Form //-->

		  </div>
		  <div class="actions">
		    <button class="ui animated button large green submit"  tabindex="0" type="submit" form="send_mail"> <div class="visible content">Submit</div><div class="hidden content"><i class="right arrow icon"></i> </div></button>    
		  </div>
		</div>

		<!-- // Edit User -->
		<div class="ui modal small edit___jobno">
		  <i class="close icon"></i>
		  <div class="header">
		    Edit Job Number
		  </div>
		  <div class="content" style="width: 60%; margin: 0px auto;">
		  			<form class="ui form" id="edit_jobno"> 
		  			<!--// Start Form //-->
						
						<div class="ui form">
							<div class="required field">
							 <input type="hidden" name="action" id="action" value="addJobNo">	
							  <label>Event Name</label>
							  <input type="text" placeholder="Enter Event" name="event" id="event" autocomplete="off">
							</div>
						</div>
						
						<div class="ui form">
							<div class="required field">							 
							  <label>City</label>
							  <input type="text" placeholder="Enter Event" name="city" id="city" autocomplete="off">
							</div>
						</div>
						
						<div class="ui form">
							<div class="required field">	
								<label>Start Date</label>
								  <div class="ui calendar fluid" id="eventdate">
									<div class="ui input left icon fluid">
									  <i class="calendar icon"></i>
									  <input type="text" placeholder="Date" name="start_date" id="eventdate" value="">
									</div>
								  </div>
							</div>	
						</div>
						
						<div class="ui form">
							<div class="required field">	
								<label>End Date</label>
								  <div class="ui calendar fluid" id="eventdate">
									<div class="ui input left icon fluid">
									  <i class="calendar icon"></i>
									  <input type="text" placeholder="Date" name="end_date" id="eventdate" value="">
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
		    <button class="ui animated button large green submit"  onclick="edit__jobno()" tabindex="0" type="submit" form="edit_jobno"> <div class="visible content">Submit</div><div class="hidden content"><i class="right arrow icon"></i> </div></button>    
		  </div>
		</div>
		
		
		
		<?php require("../../js.php"); ?>
		<script>
		$(document).ready(function(){
			
		$('#eventdate').calendar({
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