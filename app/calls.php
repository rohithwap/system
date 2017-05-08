<?php

include('connect.php');

if($_POST){
	$action = $_POST['action'];
}
else {
	$action = $_GET['action'];
}

switch($action){	

	/* All Get Requests */
	case ($action === "getClients"):
			$database = new Database();
			$database->query('SELECT * FROM clients');
			$database->execute();
			$rows = $database->resultset();
			$data = ["data" => $rows];
			echo json_encode($data);
			break;
		
	case ($action === "getJobnos"):
			$database = new Database();
			$database->query('SELECT * FROM job_nos');
			$database->execute();
			$rows = $database->resultset();
			$data = ["data" => $rows];
			echo json_encode($data);
			break;

	case ($action === "getUserTypes"):
			$database = new Database();
			$database->query('SELECT * FROM user_types');
			$database->execute();
			$rows = $database->resultset();			
			echo json_encode($rows);
			break;

	case ($action === "getActiveUsers"):
			$database = new Database();
			$database->query('SELECT user_id,
			user_name,
			user_email,
			user_mobile,
			user_type,
			user_status FROM users WHERE user_status="Active"');
			$database->execute();
			$rows = $database->resultset();			
			echo json_encode($rows);
			break;		

	case ($action === "getUsers"):
			$database = new Database();
			$database->query('SELECT user_id,
			user_name,
			user_email,
			user_mobile,
			user_type,
			user_status FROM users');
			$database->execute();
			$rows = $database->resultset();
			echo json_encode($rows);
			break;

	case ($action === "getEventList"):
			$database = new Database();
			$database->query('SELECT * FROM event_list');
			$database->execute();
			$rows = $database->resultset();			
			echo json_encode($rows);
			break;

	case ($action === "getCityList"):
			$database = new Database();
			$database->query('SELECT * FROM city_list');
			$database->execute();
			$rows = $database->resultset();			
			echo json_encode($rows);
			break;

	case ($action === "getAllClientList"):
			$database = new Database();
			$database->query('SELECT * FROM clients');
			$database->execute();
			$rows = $database->resultset();			
			echo json_encode($rows);
			break;

	case ($action === "getElements"):			
			$database = new Database();
			$database->query('SELECT * FROM event_elements WHERE estimate_reference=:estimate_reference AND approval_status=:approval_status');
			$database->bind(':estimate_reference', $_GET['estid']);
			$database->bind(':approval_status', $_GET['status']);
			$database->execute();
			$rows = $database->resultset();			
			echo json_encode($rows);
			break;

	case ($action === "getSingleElement"):			
			$database = new Database();
			$database->query('SELECT * FROM event_elements WHERE element_id=:element_id');
			$database->bind(':element_id', $_GET['id']);			
			$database->execute();
			$rows = $database->resultset();			
			echo json_encode($rows);
			break;

	case ($action === "getApprovedVendorList"):			
			$database = new Database();
			$database->query('SELECT * FROM vendors');
			$database->execute();
			$rows = $database->resultset();			
			echo json_encode($rows);
			break;

	case ($action === "getUnaproovedElements"):
			$status = "pending";			
			$database = new Database();
			$database->query('SELECT * FROM event_elements 
			INNER JOIN estimates e ON e.`estimate_id` = event_elements.`estimate_reference` 
			INNER JOIN clients c ON c.`client_id` = e.`client_id` 
			INNER JOIN job_nos ON job_nos.`job_no` = e.`job_number`
			WHERE (inward_cost IS NOT NULL AND outward_cost IS NOT NULL) AND approval_status=:approval_status 
			');
			$database->bind(':approval_status',$status);
			$database->execute();
			$rows = $database->resultset();			
			echo json_encode($rows);
			break;

	case ($action === "getLog"):				
			$database = new Database();
			$list = [];
			$array=[];
			$i = 0;
			$database->query('SELECT * FROM action_log 
				LEFT OUTER JOIN estimates e ON e.`estimate_id` = action_log.`action_reference` 
				LEFT OUTER JOIN event_elements ON event_elements.`element_id` = action_log.`action_reference` 
				LEFT OUTER JOIN job_nos ON job_nos.`job_no` = e.`job_number` 
				LEFT OUTER JOIN clients c ON c.`client_id` = e.`client_id` 
				LEFT OUTER JOIN users ON users.`user_id` = action_log.`user_id` 
				ORDER BY log_date DESC');
			$database->execute();
			$rows = $database->resultset();
			foreach ($rows as $row) {

				$array['user_name'] = $row['user_name'];
				$array['client_name'] = $row['client_name'];				
				$array['event_name'] = $row['event_name'];
				$array['city'] = $row['city'];
				$array['readable'] = $row['readable'];
				$array['job_number'] = $row['job_number'];
				$array['estimate_name'] = $row['estimate_name'];
				$array['element_name'] = $row['element_name'];
				$array['element_desc'] = $row['element_desc'];
				$array['action'] = $row['action'];
				$array['approval_status'] = $row['approval_status'];
				$array['log_date'] = $row['log_date'];
				$array['log_id'] = $row['log_id'];

				array_push($list,$array);
			}
			$i++;
			echo json_encode($list);
			break;			

	case ($action === "getPo"):
			$id= $_GET['id'];
			$status = "approved";
			$database = new Database();
			$database->query('SELECT * FROM event_elements 
				INNER JOIN vendors ON vendors.`vendor_id` = event_elements.`vendor_reference` 
				WHERE approval_status=:approval_status AND estimate_reference=:estimate_reference
				AND po_id IS NULL');
			$database->bind(':approval_status', $status);
			$database->bind(':estimate_reference', $id);
			$database->execute();
			$rows = $database->resultset();			
			echo json_encode($rows);
			break;

	case ($action === "makePo"):
			$estid= $_GET['estid'];
			$vendor_id= $_GET['vendor_id'];
			$status = "approved";
			$database = new Database();
			$database->query('SELECT * FROM event_elements 
				INNER JOIN vendors ON vendors.`vendor_id` = event_elements.`vendor_reference` 
				WHERE approval_status=:approval_status AND estimate_reference=:estimate_reference
				AND vendor_id = :vendor_id AND po_id IS NULL');
			$database->bind(':approval_status', $status);
			$database->bind(':estimate_reference', $estid);
			$database->bind(':vendor_id', $vendor_id);
			$database->execute();
			$rows = $database->resultset();			
			echo json_encode($rows);
			break;		

	case ($action === "getInvoices"):
			$sql = "SELECT * FROM invoices";
			$stmt = $db->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetchAll();
			$data = ["data" => $result];
			echo json_encode($data);
			break;

	/* All Inserts */	

	case ($action === "addUser"):			
			$database = new Database();
			$userStatus = "Active";
			$database->query('SELECT 1 FROM users WHERE user_email = :user_email');
			$database->bind(':user_email', $_POST['user_email']);
            $database->execute();
			$row = $database->single(); 
			if($row){
				 echo "0";
			}
			else{
				$salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647)); 
				$password = hash('sha256', $_POST['user_password'] . $salt);
				for($round = 0; $round < 65536; $round++) 
				{ 
					$password = hash('sha256', $password . $salt); 
				}
				$database->query('INSERT INTO users (
					user_name,
					user_email,
					user_password,
					user_salt,
					user_mobile,
					user_type,
					user_status) VALUES (
					:user_name,
					:user_email,
					:user_password,
					:user_salt,
					:user_mobile,
					:user_type,
					:user_status)');
				$database->bind(':user_name', $_POST['user_name']);
				$database->bind(':user_email', $_POST['user_email']);
				$database->bind(':user_password', $password);
				$database->bind(':user_salt', $salt);
				$database->bind(':user_mobile', $_POST['user_mobile']);
				$database->bind(':user_type', $_POST['userType']);
				$database->bind(':user_status', $userStatus);					
				$database->execute();				
				$count = $database->rowCount(); 
				if($count > 0){
					 echo "1";
				}
			}	
			break;	
	
	case ($action === "editUser"):
			$salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647)); 
			$password = hash('sha256', $_POST['user_password'] . $salt);
			for($round = 0; $round < 65536; $round++) 
			{ 
				$password = hash('sha256', $password . $salt); 
			}
			$database = new Database();
			$database->query('UPDATE users SET 
					user_name=:user_name,
					user_email=:user_email,
					user_password=:user_password,
					user_salt=:user_salt,
					user_mobile=:user_mobile,
					user_type=:user_type,
					user_status=:user_status WHERE user_id=:user_id');
			$database->bind(':user_id', $_POST['user_id']);
			$database->bind(':user_name', $_POST['user_name']);
			$database->bind(':user_email', $_POST['user_email']);
			$database->bind(':user_password', $password);
			$database->bind(':user_salt', $salt);
			$database->bind(':user_mobile', $_POST['user_mobile']);
			$database->bind(':user_type', $_POST['user_type']);
			$database->bind(':user_status', $_POST['user_status']);		
			$database->execute();				
			$count = $database->rowCount();
			$action_reference = $this->dbh->lastInsertId();
			if($count > 0){

				$readable = "".$_SESSION['user']['user_name']." has added a new user - ".$_POST['user_name']."";
				addLog('Add User', $action_reference, $readable);				

			}else{
				echo "0";
			}
			break;

	case ($action === "addJobNo"):
			$database = new Database();
			$database->beginTransaction();
			$status = "active";
			$year = convertDate($_POST['start_date'], 'Y');
			$database->query('SELECT * FROM job_nos WHERE event_name = :event_name AND city=:city');
			$database->bind(':event_name', $_POST['event_name']);
			$database->bind(':city', $_POST['city_name']);
			$database->execute();
			$rows = $database->resultset(); 
			if($rows){
				foreach($rows as $row){
				 	if(convertDate($row['start_date'], 'Y') == $year){
				 		echo "0";
				 		exit;
				 	}
				}
			}

			$database->query('INSERT INTO job_nos (
	 		event_name,
			city,
			venue,
			status,
			account_mgr,
			start_date,
			end_date) VALUES (
			:event_name,
			:city,
			:venue,
			:status,
			:account_mgr,
			:start_date,
			:end_date)');
			$database->bind(':event_name', $_POST['event_name']);
			$database->bind(':city', $_POST['city_name']);
			$database->bind(':venue', $_POST['venue']);
			$database->bind(':status', $status);
			$database->bind(':account_mgr', $_POST['account_mgr']);
			$database->bind(':start_date', $_POST['start_date']);
			$database->bind(':end_date', $_POST['end_date']);
			$database->execute();
			$action_reference =$database->lastInsertId();				
			$count = $database->rowCount();
			if($count > 0){
				
				$readable = " ".$_SESSION['user']['user_name']." has added a job number for ".$_POST['event_name']."-".$_POST['city_name']." ";
				addLog($action, $action_reference, $readable);	

			}else{
				echo "0";
			}
			
			break;		


	case ($action === "editJobNo"):
			$database = new Database();
			$database->beginTransaction();
			$database->query('UPDATE job_nos SET 
			event_name = :event_name,
			city = :city,
			venue = :venue,
			status = :status,
			account_mgr = :account_mgr,
			start_date = :start_date,
			end_date = :end_date WHERE job_no=:job_no');
			$database->bind(':event_name', $_POST['event_name']);
			$database->bind(':city', $_POST['city_name']);
			$database->bind(':venue', $_POST['venue']);
			$database->bind(':status', $_POST['status']);
			$database->bind(':account_mgr', $_POST['account_mgr']);
			$database->bind(':start_date', $_POST['start_date']);
			$database->bind(':end_date', $_POST['end_date']);
			$database->bind(':job_no', $_POST['jobno']);
			$database->execute();				
			$count = $database->rowCount();
			$action_reference = $_POST['jobno'];
			if($count > 0){
				 
	$readable = " ".$_SESSION['user']['user_name']." has edited job number - ".$_POST['event_name']."-".$_POST['city_name']." ";
	addLog($action, $action_reference, $readable);

			}else{
				echo "0";
			}
			break;	

	case ($action === "addEstimate"):
			$database = new Database();
			$database->beginTransaction();
			$database->query('INSERT INTO estimates (			
			client_id, 
			estimate_name,
			estimate_desc,
			job_number) VALUES(
			:client_id, 
			:estimate_name,
			:estimate_desc,
			:job_number)');
			$database->bind(':client_id', $_POST['client_name']);			
			$database->bind(':estimate_name', $_POST['estimate_name']);
			$database->bind(':estimate_desc', $_POST['estimate_desc']);
			$database->bind(':job_number', $_POST['job_no']);
			$database->execute();				
			$count = $database->rowCount();
			$action_reference =$database->lastInsertId();
			if($count > 0){
				 
		$readable = " ".$_SESSION['user']['user_name']." has created a new estimate under job no ".$_POST['job_no']."";
		addLog($action, $action_reference, $readable);		

			}else{
				echo "0";
			}

			break;	

	case ($action === "addElement"):
			$status = "pending";
			$database = new Database();
			$database->beginTransaction();
			$database->query('INSERT INTO event_elements (
			estimate_reference,
			element_name,
			element_desc,
			element_qty,
			element_comments,
			approval_status) VALUES(
			:estimate_reference,
			:element_name,
			:element_desc,
			:element_qty,
			:element_comments,
			:approval_status)');
			$database->bind(':estimate_reference', $_POST['estimate_ref']);
			$database->bind(':element_name', $_POST['element_name']);
			$database->bind(':element_desc', $_POST['element_desc']);
			$database->bind(':element_qty', $_POST['element_qty']);
			$database->bind(':element_comments', $_POST['comments']);
			$database->bind(':approval_status', $status);
			$database->execute();				
			$count = $database->rowCount();
			$action_reference =$database->lastInsertId();
			if($count > 0){
				 
		$readable = " ".$_SESSION['user']['user_name']." has added a new element to estimate ".$_POST['estimate_ref']." 
		 - ".$_POST['element_name']."";
		addLog($action, $action_reference, $readable);		

			}else{
				echo "0";
			}

			break;	

	case ($action === "editElement"):			
			$database = new Database();
			$database->beginTransaction();
			$database->query('UPDATE event_elements SET 
			element_name = :element_name,
			element_desc = :element_desc,
			element_qty = :element_qty,
			element_comments = :element_comments
			WHERE element_id=:element_id');	
			$database->bind(':element_id', $_POST['element_id']);		
			$database->bind(':element_name', $_POST['element_name']);
			$database->bind(':element_desc', $_POST['element_desc']);
			$database->bind(':element_qty', $_POST['element_qty']);
			$database->bind(':element_comments', $_POST['comments']);			
			$database->execute();				
			$count = $database->rowCount();
			$action_reference = $_POST['element_id'];
			if($count > 0){
				 
		$readable = " ".$_SESSION['user']['user_name']." has edited  
		 - ".$_POST['element_name']."";
		addLog($action, $action_reference, $readable);		

			}else{
				echo "0";
			}

			break;	

	case ($action === "addCosting"):	
			if(!$_POST['outward_cost']){
				$_POST['outward_cost'] = NULL;
			}
			if(!$_POST['inward_cost']){
				$_POST['inward_cost'] = NULL;
			}
			if(!$_POST['vendor']){
				echo "0";
				exit;
			}

			$database = new Database();
			$database->beginTransaction();
			$database->query('UPDATE event_elements SET 
			inward_cost = :inward_cost, 
			outward_cost = :outward_cost,
			vendor_reference = :vendor_reference 
			WHERE element_id=:element_id');
			$database->bind(':element_id', $_POST['element_id']);			
			$database->bind(':inward_cost', $_POST['inward_cost']);
			$database->bind(':outward_cost', $_POST['outward_cost']);
			$database->bind(':vendor_reference', $_POST['vendor']);
			$database->execute();				
			$count = $database->rowCount();
			$action_reference = $_POST['element_id'];
			if($count > 0){
				
$readable = " ".$_SESSION['user']['user_name']." has updated costing for element - ".$_POST['element_id']."";
			addLog($action, $action_reference, $readable);		

			}else{
				echo "0";
			}

			break;

	case ($action === "approveElement"):
			$status = "approved";			
			$database = new Database();
			$database->beginTransaction();
			$database->query('UPDATE event_elements SET 
			approval_status = :approval_status			
			WHERE element_id=:element_id');
			$database->bind(':element_id', $_GET['id']);		
			$database->bind(':approval_status', $status);
			$database->execute();				
			$count = $database->rowCount();
			$action_reference = $_GET['id'];
			if($count > 0){
				 
			$readable = " ".$_SESSION['user']['user_name']." has approved element - ".$_GET['id']."";
			addLog($action, $action_reference, $readable);	

			}else{
				echo "0";
			}

			break;									

	case ($action === "rejectElement"):
			$status = "rejected";			
			$database = new Database();
			$database->beginTransaction();
			$database->query('UPDATE event_elements SET 
			approval_status = :approval_status,
			approval_reason = :approval_reason 				
			WHERE element_id=:element_id');
			$database->bind(':element_id', $_GET['id']);	
			$database->bind(':approval_status', $status);
			$database->bind(':approval_reason', $_GET['reason']);
			$database->execute();				
			$count = $database->rowCount();
			$action_reference = $_GET['id'];
			if($count > 0){
				
				$readable = " ".$_SESSION['user']['user_name']." has rejected element - ".$_GET['id']."";
				addLog($action, $action_reference, $readable);

			}else{
				echo "0";
			}

			break;		
	/* Delete Queries */

	case ($action === "deleteUser"):
			$id = $_GET['id'];
			$sql = "DELETE FROM users WHERE user_id=:user_id";
			$stmt = $db->prepare($sql);
			$stmt->bindParam(':user_id', $id, PDO::PARAM_STR);
			$stmt->execute();
			$count = $stmt->rowCount(); 
			if($count > 0){
				 echo "1";
			}else{
				echo "0";
			}
			
			break;

	/* General Functions */
	
	case ($action === "sendMail"):
		$email = $_POST['email'];
		$subject = $_POST['subject'];
		$html = $_POST['html'];
		
		// Authorization Creds
		include('mail-auth.php');

		//removed the user and password params - no longer needed
		$params = array(
		    'to'        => $email,     
		    'subject'   => $subject,
		    'html'      => $html,
		    'from'      => 'noreply@iitmindia.com',
		);

		$request =  $url.'api/mail.send.json';
		$headr = array();
		// set authorization header
		$headr[] = 'Authorization: Bearer '.$pass;

		$session = curl_init($request);
		curl_setopt ($session, CURLOPT_POST, true);
		curl_setopt ($session, CURLOPT_POSTFIELDS, $params);
		curl_setopt($session, CURLOPT_HEADER, false);
		curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

		//Turn off SSL
		curl_setopt($session, CURLOPT_SSL_VERIFYPEER, false);//New line
		curl_setopt($session, CURLOPT_SSL_VERIFYHOST, false);//New line

		// add authorization header
		curl_setopt($session, CURLOPT_HTTPHEADER,$headr);

		$response = curl_exec($session);
		$response = json_decode($response, true);
		if($response['message'] == 'success'){
			echo "1";
		}
		else{
			echo "0";
		}		
		// print everything out
		//var_dump($response,curl_error($session),curl_getinfo($session));
		curl_close($session);			
		break;		

	case ($action === "addInvoice"):
			
			$sql = "INSERT INTO invoices(jobno,
					invoiceno,					
					invoice_date,
					executive,
					clientid,					
					event,
					city,
					area,
					netamount,
					taxamount,
					description) VALUES (
					:jobno,
					:invoiceno,					
					:invoice_date,
					:executive,
					:clientid,					
					:event,
					:city,
					:area,
					:netamount,
					:taxamount,
					:description)";
		
			$stmt = $db->prepare($sql);                                             
			$stmt->bindParam(':jobno', $_POST['jobno'], PDO::PARAM_STR);
			$stmt->bindParam(':invoiceno', $_POST['invoiceno'], PDO::PARAM_STR);
			$stmt->bindParam(':invoice_date', $_POST['invoicedate'], PDO::PARAM_STR);
			$stmt->bindParam(':executive', $_POST['executive'], PDO::PARAM_STR);
			$stmt->bindParam(':clientid', $_POST['client'], PDO::PARAM_STR);			
			$stmt->bindParam(':event', $_POST['eventname'], PDO::PARAM_STR);
			$stmt->bindParam(':city', $_POST['city'], PDO::PARAM_STR);
			$stmt->bindParam(':area', $_POST['area'], PDO::PARAM_STR);
			$stmt->bindParam(':netamount', $_POST['netamount'], PDO::PARAM_STR);
			$stmt->bindParam(':taxamount', $_POST['taxamount'], PDO::PARAM_STR);
			$stmt->bindParam(':description', $_POST['description'], PDO::PARAM_STR);			
			$stmt->execute(); 
			$rows = $stmt->rowCount();
			
			if($rows == 0){
				echo "0";
			}
			else{
				echo "1";
			}			
			break;

				

	/* */
	case ($action === "getEventInfo"):
			$jobno = $_POST['jobno'];
			$sql = "SELECT * FROM jobno WHERE jobno=:jobno";
			$stmt = $db->prepare($sql);
			$stmt->bindParam(':jobno', $jobno, PDO::PARAM_STR);
			$stmt->execute();
			$result = $stmt->fetchAll();
			echo json_encode($result);
			break;
		
	case ($action === "addClient"):
			$client = $_POST['client'];
			$sql = "INSERT INTO clients(clientname) Values (:clientname)";
			$stmt = $db->prepare($sql);
			$stmt->bindParam(':clientname', $client, PDO::PARAM_STR);
			$stmt->execute();
			$rows = $stmt->rowCount();
			
			if($rows == 0){
				echo "0";
			}
			else{
				echo "1";
			}			
			break;
	
	case ($action === "getClientList"):
			$client = $_GET['q'];
			$sql = "SELECT clientname FROM clients WHERE clientname LIKE '%$client%'";
			$stmt = $db->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetchAll();
			echo json_encode($result);
			break;
	
		
}	


?>