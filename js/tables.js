// All Tables Init

// Users Table

    



// Job Nos Table

function getjobNostable(){
	
    var jobNostable = $('#tb_jobnos').DataTable({
    	responsive: true,
    	 ajax: {
	        url: 'app/calls.php?action=getJobnos',
	        dataSrc: 'data'
	    },
    	columns: [
    		{ "data": "job_no" },
            { "data": "event_name" },
            { "data": "city" },
            { "data": "start_date" },
            { "data": "end_date" }, 
            { "data": "account_mgr" },
            { "data": "venue" }             
        ]        

});
}    

