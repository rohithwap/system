<?php 

    // First we execute our common code to connection to the database and start the session 
    require("app/connect.php"); 
     
    // This variable will be used to re-display the user's username to them in the 
    // login form if they fail to enter the correct password.  It is initialized here
    // to an empty value, which will be shown if the user has not submitted the form.
    $submitted_username = ''; 

    // First Check for Login Cookies

    if(isset($_COOKIE['username']) && isset($_COOKIE['token'])) {

        $cookie_username=urldecode($_COOKIE['username']);
        $cookie_token=urldecode($_COOKIE['token']);
        
        $database = new Database();
        $database->query('SELECT user_id,user_type,user_email, user_name, user_token FROM users WHERE user_email=:user_email');         
        $database->bind(':user_email', $cookie_username);
        $database->execute();
        $row = $database->single();
        
        if($row['user_email'] == $cookie_username && $row['user_token'] == $cookie_token) {

           unset($row['user_token']);  // Remove Token From Session Data
           
           $_SESSION['user'] = $row;
           
           header("location: users/".$row['user_type']."/dashboard.php");
           
           die();
        }
        else {
            die("Something Went Wrong. Please Contact The Administrator.");
        }
    }
    else {
     
    // This if statement checks to determine whether the login form has been submitted 
    // If it has, then the login code is run, otherwise the form is displayed 
    if(!empty($_POST))  { 
        try 
        { 
            $database = new Database(); 
            $database->query('SELECT user_id, user_name, user_password, user_salt, user_email, user_token FROM users WHERE user_email = :user_email');
            $database->bind(':user_email',$_POST['user_email']);
            $database->execute();
            $result = $database->resultset();
        } 
        catch(PDOException $ex) 
        { 
            // Note: On a production website, you should not output $ex->getMessage(). 
            // It may provide an attacker with helpful information about your code.  
            die("Failed to run query: " . $ex->getMessage()); 
        } 
         
        // This variable tells us whether the user has successfully logged in or not.
        // We initialize it to false, assuming they have not. 
        // If we determine that they have entered the right details, then we switch it to true. 
        $login_ok = false; 
         
        // Retrieve the user data from the database.  If $row is false, then the username 
        // they entered is not registered. 
        $row = $database->single(); 
        if($row) 
        { 
            // Using the password submitted by the user and the salt stored in the database, 
            // we now check to see whether the passwords match by hashing the submitted password 
            // and comparing it to the hashed version already stored in the database.
            $check_password = hash('sha256', $_POST['user_password'] . $row['user_salt']); 
            for($round = 0; $round < 65536; $round++) 
            { 
                $check_password = hash('sha256', $check_password . $row['user_salt']); 
            } 
             
            if($check_password === $row['user_password']) 
            { 
                // If they do, then we flip this to true 
                $login_ok = true; 
            } 
        } 
         
        // If the user logged in successfully, then we send them to the private members-only page 
        // Otherwise, we display a login failed message and show the login form again
        if($login_ok) 
        { 
            // Here I am preparing to store the $row array into the $_SESSION by 
            // removing the salt and password values from it.  Although $_SESSION is 
            // stored on the server-side, there is no reason to store sensitive values 
            // in it unless you have to.  Thus, it is best practice to remove these 
            // sensitive values first. 
            

            unset($row['user_salt']); 
            unset($row['user_password']); 
            
            // This stores the user's data into the session at the index 'user'. 
            // We will check this index on the private members-only page to determine whether 
            // or not the user is logged in.  We can also use it to retrieve 
            // the user's details. 
            $_SESSION['user'] = $row; 

            if(isset($_POST['rememberMe'])) {
            
            // Create Unique Token
            $user_token = base64_encode(mcrypt_create_iv(30));
            $user_token = password_hash($user_token, PASSWORD_DEFAULT);                
            
            // Update Users Token in database
            $database->query('UPDATE users SET user_token=:user_token WHERE user_id=:user_id');
            $database->bind(':user_id', $row['user_id']);
            $database->bind(':user_token', $user_token);
            $result = $database->execute(); 
            
            $tok_email = $_POST['user_email'];
            //set the cookies to remember user for 7 days            
            setcookie('token', $user_token, time() + 7*24*60*60);
            setcookie('username', $tok_email, time() + 7*24*60*60);
            
            } 
            else {
            //destroy any previously set cookie
            setcookie('username', '', time() - 7*24*60*60);
            setcookie('token', '', time() - 7*24*60*60);

            $user_token = "";
            $database->query("UPDATE users SET user_token=:user_token WHERE user_id=:user_id");
            $database->bind(':user_id', $row['user_id'], PDO::PARAM_STR);
            $database->bind(':user_token', $user_token, PDO::PARAM_STR);
            $result = $database->execute();  
            }
             
            // Redirect the user to the private members-only page.
            header('Logged In - Moving To Dash'); 
            header("Location: users/".$row['user_type']."/dashboard.php"); 
            die("Redirecting to: users/".$row['user_type']."/dashboard.php"); 
        } 
        else 
        { 
            // Tell the user they failed 
            $login_status = "Login Failed"; 
             
            // Show them their username again so all they have to do is enter a new 
            // password.  The use of htmlentities prevents XSS attacks.  You should 
            // always use htmlentities on user submitted values before displaying them 
            // to any users (including the user that submitted them).  For more information: 
            // http://en.wikipedia.org/wiki/XSS_attack 
            $submitted_username = htmlentities($_POST['user_email'], ENT_QUOTES, 'UTF-8'); 
        } 
    }
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
        <style type="text/css">
        .ui.toggle.checkbox .box:before, .ui.toggle.checkbox label:before {
            display: block;
            position: absolute;
            content: '';
            z-index: 1;
            -webkit-transform: none;
            transform: none;
            border: none;
            top: 0rem;
            background: rgba(244, 67, 54, 0.84);
            box-shadow: none;
            width: 3.5rem;
            height: 1.5rem;
            border-radius: 500rem;
        }
        .ui.toggle.checkbox .box:hover::before, .ui.toggle.checkbox label:hover::before {
            background-color: rgb(255, 0, 0);
            border: none;
        }
        .rememberMe{
            display: none;
        }
        

        </style>
    </head>
    <body style="background-image: url(./img/login_bg.jpg); background-size: cover;">

    <div class="ui middle aligned center aligned grid">
        <div class="column">
            <div class="login-container ui">
                <img src="./img/logo.gif" style="width: 280px; margin-top: 40px;">
                <div class="login_failed"><?php if(!empty($login_status)){echo $login_status;}  ?></div>
                <form action="index.php" method="post"> 
                    <div class="field" style="padding-top: 20px;">
                      <div class="ui left icon input">
                        <i class="user icon"></i>
                        <input type="text" name="user_email" placeholder="E-mail address" value="<?php echo $submitted_username; ?>">
                      </div>
                    </div>
                    <br /> 
                    <div class="field">
                      <div class="ui left icon input">
                        <i class="lock icon"></i>
                        <input type="password" name="user_password" placeholder="Password">
                      </div>
                    </div>
                   
                    
                    <br /><br /> 
                    <div class="inline field" style="width: 50%; float: left; padding: 15px;">
                        <div class="ui checkbox">
                          <input type="checkbox" tabindex="0" class="hidden">
                          <label>Remember Me</label>
                        </div>
                    </div>
                    
                    <button class="ui button large">
                      <i class="power icon"></i>
                      Login
                      <input type="submit" value="Login" style="visibility: hidden; width: 1px;"/>
                    </button>
                    <br><br><br><br>
                    <span>Forgot Password?</span>
                     
                    </form>
            </div>
        </div>
    </div>    

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
        <script src="js/get.js"></script>
        <script src="dist/semantic/semantic.js"></script>
        <script src="dist/semantic/components/dropdown.min.js"></script>
        <script src="dist/semantic/components/form.min.js"></script>
        <script src="https://cdn.rawgit.com/mdehoog/Semantic-UI-Calendar/76959c6f7d33a527b49be76789e984a0a407350b/dist/calendar.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/v/dt/jszip-2.5.0/pdfmake-0.1.18/dt-1.10.13/b-1.2.4/b-colvis-1.2.4/b-html5-1.2.4/b-print-1.2.4/r-2.1.1/datatables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.13/js/dataTables.semanticui.min.js"></script>
        <script type="text/javascript">
            
        $('.button').click(function(){
            $('.button').addClass('loading');
        })

        $('.ui.checkbox').checkbox();

        $('.ui.checkbox').click(function() {
        if ($('.ui.checkbox').checkbox('is checked')) {
            $('form').remove('.rememberMe')
            $('form').append('<input type="text" value="checked" class="rememberMe" name="rememberMe">')
        }
        else {
            $('form').remove('.rememberMe')
            $('form').append('<input type="text" value="unchecked" class="rememberMe" name="rememberMe">')
        }
        });
        

       
        </script>
    </body>
    </html>