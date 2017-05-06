<?php 

    require("../../app/connect.php");
     
     
    if(empty($_SESSION['user'])) 
    { 
      
        header("Location: index.php"); 
         
        
        die("Redirecting to index.php"); 
    }

    $html="";
    $i=1;
    $database = new Database();
	$database->query('SELECT user_id,
	user_name,
	user_email,
	user_mobile,
	user_type,
	user_status FROM users');
	$database->execute();
	$rows = $database->resultset();
    foreach($rows as $row){
    	$html .= '<tr>
    	<td>'.$i.'</td>
        <td>'.$row['user_name'].'</td>
        <td>'.$row['user_email'].'</td>
        <td>'.$row['user_mobile'].'</td>
        <td>'.$row['user_type'].'</td>
        <td>'.$row['user_status'].'</td>
        <td>
        <button class="ui compact labeled icon button edit_user"
        data-id="'.$row['user_id'].'" 
        data-name="'.$row['user_name'].'" 
        data-email="'.$row['user_email'].'" 
        data-mobile="'.$row['user_mobile'].'" 
        data-type="'.$row['user_type'].'" 
        data-status="'.$row['user_status'].'" 
        >
        <i class="edit icon"></i>Edit</button>	
        </td></tr>';
        $i++;
    } 
    
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
						<button class="ui green right floated labeled icon button show-modal" id="add___user">
						  <i class="plus icon"></i>
						  Add User
						</button>
					</div>			
				</div>
				<div class="row">
					<div class="column">
						
					<!--// Data Tables //-->

					<table class="ui celled table data-tables" cellspacing="0" width="100%" id="tbl_users">
			        <thead>
			            <tr>
			            	<th>U.ID</th>
			                <th>Name</th>
			                <th>Email</th>
			                <th>Mobile</th>
			                <th>Type</th>
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
		
		<!-- // Add User -->
		<div class="ui modal small add___user">
		  <i class="close icon"></i>
		  <div class="header">
		    Add User
		  </div>
		  <div class="content" style="width: 60%; margin: 0px auto;">
		  		<form class="ui form"  id="add_user">
		  		<input type="hidden" name="action" value="addUser">	
		  		 <div class="ui form"><div class="required field"> <label>Name</label> <input type="text" placeholder="Enter User Name" name="user_name" id="user_name" autocomplete="off"></div></div><div class="ui form"><div class="required field"> <label>Password</label> <input type="text" placeholder="Enter User Password" name="user_password" id="user_password" autocomplete="off"></div></div><div class="ui form"><div class="required field"> <label>Email</label> <input type="text" placeholder="Enter User Email id" name="user_email" id="user_email" autocomplete="off"></div></div><div class="ui form"><div class="required field"> <label>Mobile</label> <input type="text" placeholder="Enter User Mobile" name="user_mobile" id="user_mobile" autocomplete="off"></div></div>
			  	
			  	<div class="field usertype">
	            <label>User Type</label>
	            <div class="ui search selection dropdown userType">
	              <input type="hidden"  name="userType">
	              <i class="dropdown icon"></i>
	              <input type="text" class="search">
	              <div class="default text">Select one...</div>
	              <div class="menu"></div>
	            </div>
	          </div>

		  		<div class="ui error message"></div><div class="server-status"></div></form>
		  </div>
		  <div class="actions">
		    <button class="ui animated button large green submit"  tabindex="0" type="submit" form="add_user"> <div class="visible content">Submit</div><div class="hidden content"><i class="right arrow icon"></i> </div></button>    
		  </div>
		</div>

		<!-- // Edit User -->
		<div class="ui modal small edit___user">
		  <i class="close icon"></i>
		  <div class="header">
		    Edit User
		  </div>
		  <div class="content" style="width: 60%; margin: 0px auto;">
		  		<form class="ui form"  id="edit_user" action="#">
		  		 <input type="hidden" name="action" value="editUser">
		  		 <input type="hidden" id="edit_user_id" name="user_id" value="">	
		  		 <div class="ui form"><div class="required field"> <label>Name</label> <input type="text" placeholder="Enter User Name" name="user_name" id="edit_user_name" value="" autocomplete="off"></div></div><div class="ui form"><div class="required field"> <label>Password</label> <input type="text" placeholder="Enter User Password" name="user_password" id="edit_user_password" autocomplete="off"></div></div><div class="ui form"><div class="required field"> <label>Email</label> <input type="text" placeholder="Enter User Email id" name="user_email" id="edit_user_email" autocomplete="off"></div></div><div class="ui form"><div class="required field"> <label>Mobile</label> <input type="text" placeholder="Enter User Mobile" name="user_mobile" id="edit_user_mobile" autocomplete="off"></div></div>
		  		
		  		<div class="field"> 
	            <label>User Type</label>
	            <div class="ui search selection dropdown editusertype">
	              <input type="hidden"  name="user_type">
	              <i class="dropdown icon"></i>
	              <input type="text" class="search">
	              <div class="default text">Select one...</div>
	              <div class="menu"></div>
	            </div>
	          	</div>

	          	<div class="field"> 
	            <label>User Status</label>
	            <div class="ui search selection dropdown edituserstatus">
	              <input type="hidden"  name="user_status">
	              <i class="dropdown icon"></i>
	              <input type="text" class="search">
	              <div class="default text">Select one...</div>
	              <div class="menu">
	              	<div class="item" data-value="Active">Active</div>
	              	<div class="item" data-value="Inactive">Inactive</div>
	              </div>
	            </div>
	          	</div>	

		  		<div class="ui error message"></div><div class="server-status"></div></form>
		  </div>
		  <div class="actions">
		  	<button class="ui animated button large red delete left floated" id="delete_user" tabindex="0"> <div class="visible content">Delete</div><div class="hidden content"><i class="right cancel icon"></i> </div></button>

		    <button class="ui animated button large green submit"  onclick="edit__user()" tabindex="0" type="submit" form="edit_user"> <div class="visible content">Submit</div><div class="hidden content"><i class="right arrow icon"></i> </div></button>    
		  </div>
		</div>
		
	<?php require("../../js.php"); ?>
	
	<script>
	getUserTypes();
	getUserList();	
	$(document).ready(function(){
					  
	})
	</script>
	</body>
</html>