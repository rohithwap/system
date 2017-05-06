<?php 

require('classes_lib.php');

if(function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc()) 
{ 
    function undo_magic_quotes_gpc(&$array) 
    { 
        foreach($array as &$value) 
        { 
            if(is_array($value)) 
            { 
                undo_magic_quotes_gpc($value); 
            } 
            else 
            { 
                $value = stripslashes($value); 
            } 
        } 
    } 
 
    undo_magic_quotes_gpc($_POST); 
    undo_magic_quotes_gpc($_GET); 
    undo_magic_quotes_gpc($_COOKIE); 
}

function convertDate($date, $arg){
    $newdate = DateTime::createFromFormat('d/m/Y', $date);
    if($arg == 'Y'){
        return $newdate->format('Y');
    }
    elseif ($arg == 'humanReadable'){
        return $newdate->format('H i d j Y');
    }
}


function get_job_no_table($usertype){

    if($usertype === "admin"){
        
        $html .= '
        <div class="ui icon buttons small">
        <button class="ui button add_estimate" 
        data-jobnumber="'.$row['job_no'].'" 
        data-name="'.$row['event_name'].'" 
        data-city="'.$row['city'].'" 
        data-venue="'.$row['venue'].'" 
        data-manager="'.$row['account_mgr'].'" 
        data-start="'.$row['start_date'].'" 
        data-end="'.$row['end_date'].'"  
        data-status="'.$row['status'].'">
        <i class="add icon"></i> New Estimate
        </button>
          
        <button class="ui button edit_jobno" 
        data-jobnumber="'.$row['job_no'].'" 
        data-name="'.$row['event_name'].'" 
        data-city="'.$row['city'].'" 
        data-venue="'.$row['venue'].'" 
        data-manager="'.$row['account_mgr'].'" 
        data-start="'.$row['start_date'].'" 
        data-end="'.$row['end_date'].'"  
        data-status="'.$row['status'].'">
        <i class="edit icon"></i> Edit Job No
        </button>
          
        <button class="ui button delete_jobno red" 
        data-jobnumber="'.$row['job_no'].'" 
        data-name="'.$row['event_name'].'" 
        data-city="'.$row['city'].'" 
        data-venue="'.$row['venue'].'" 
        data-manager="'.$row['account_mgr'].'" 
        data-start="'.$row['start_date'].'" 
        data-end="'.$row['end_date'].'"  
        data-status="'.$row['status'].'">
        <i class="Trash Outline icon"></i> Delete Job No
        </button>
        </div>          
        ';
       
       
    }

    return $html;

}

function addLog($action, $action_reference, $readable){
    
    $database = new Database();
    $database->query('INSERT INTO action_log (
        action, 
        user_id, 
        action_reference, 
        readable) VALUES (
        :action, 
        :user_id, 
        :action_reference, 
        :readable)');
    $database->bind(':action', $action);
    $database->bind(':user_id', $_SESSION['user']['user_id']);
    $database->bind(':action_reference', $action_reference);
    $database->bind(':readable', $readable);
    $database->execute();
    $count = $database->rowCount();
    if($count > 0){
        $database->endTransaction();
        echo "1";
    }
    else{
        $database->cancelTransaction();
        echo "0";
    }
    
} 

header('Content-Type: text/html; charset=utf-8');   
        
session_start(); 

?>