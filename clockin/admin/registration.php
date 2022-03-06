<?php

// Start Session
session_start();

// Database connection
require __DIR__ . '/config/db_connection.php';
$db = DB();

// Application library ( with DemoLib class )
require __DIR__ . '/library/library.php';
$app = new DemoLib($db);
$user = $app->UserDetails($_SESSION['user_id']);

require_once __DIR__ . '/GoogleAuthenticator/GoogleAuthenticator.php';
$pga = new LIS_GoogleAuthenticator();
$secret = $pga->createSecret();

$register_error_message = '';


// check Register request
if (!empty($_POST['btnRegister'])) {
    if ($_POST['name'] == "") {
        $register_error_message = 'Name field is required!';
    } else if ($_POST['email'] == "") {
        $register_error_message = 'Email field is required!';
    } else if ($_POST['username'] == "") {
        $register_error_message = 'Username field is required!';
    } else if ($_POST['password'] == "") {
        $register_error_message = 'Password field is required!';
    } else if ($_POST['badge'] == "") {
        $register_error_message = 'Badge ID field is required!';
    } else if ($_POST['IdEmp'] == "") {
        $register_error_message = 'Employee ID field is required!';
    } else if ($_POST['BDAY'] == "") {
        $register_error_message = 'Employee ID field is required!';
    } else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $register_error_message = 'Invalid email address!';
    } else if ($app->isEmail($_POST['email'])) {
        $register_error_message = 'Email is already in use!';
    } else if ($app->isUsername($_POST['username'])) {
        $register_error_message = 'Username is already in use!';
	} else if ($app->isBadge($_POST['badge'])) {
        $register_error_message = 'Badge is already in use!';
    } else if ($app->isEmpID($_POST['IdEmp'])) {
        $register_error_message = 'Employee ID is already in use!';
    } else {
        $perm="1";
        $user_id = $app->Register($_POST['name'], $_POST['email'], $_POST['username'], $_POST['password'], $secret, $_POST['badge'], $perm, $_POST['IdEmp'], $_POST['BDAY']);
        // set session and redirect user to the profile page
        $_SESSION['user_id'] = $user_id;
        $userpassword = $_POST['password'];
        header("Location: confirm_google_auth.php?=".$userpassword);
    }
}

function UsersExpand() {
    echo "Username    Badge_ID";
    echo "<br>";
    $servername = "127.0.0.1";
    $username = "academy";
    $password = "Dc4HjjtBWp";
    $dbname = "clockin";
    
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT username, badge, id, password, perm FROM clockin.users";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $disabled="disabled";
            // $admin="2";
            $currentepassword=$row["password"];
            // $permcheck=$row["perm"];
            // echo $permcheck;
            //   if ($disabled == $currentepassword && $permcheck == $admin) {
            //     echo " " . $row["username"]. " " . $row["badge"]. " " . " (Disabled) - Admin ". "<br>";
            // } 
            if ($disabled == $currentepassword) {
                echo " " . $row["username"]. " " . $row["badge"]. " " . " (Disabled) ".  "<br>";
            } 
            // else if ($disabled != $currentepassword && $permcheck == $admin) {
            //     echo " " . $row["username"]. " " . $row["badge"]. " " . " - **Active Admin** ".  "<br>";
            // } 
            else {
                echo " " . $row["username"]. " " . $row["badge"]. "<br>";
            }

        }
    } else {
        echo "0 results";
    }
    $conn->close();
    }

    function generatePassword($length = 6)
{
  $genpassword = "";
  $possible = "0123456789";
  $i = 0;
  while ($i < $length) {
    $char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
    if (!strstr($genpassword, $char)) {
      $genpassword .= $char;
      $i++;
    }
  }
  return $genpassword;
}

?>

<!doctype html>
<html lang="en">
<style>
body {
  background-image: url('css/BG01.jpg');
  background-repeat: no-repeat;
  background-attachment: fixed;
  background-size: 100% 100%;
}
div.opacity {
  opacity: 0.8;
  font-weight: 900;
}
/* Style the button that is used to open and close the collapsible content */
.collapsible {
  background-color: #eee;
  color: #444;
  cursor: pointer;
  padding: 18px;
  width: 100%;
  border: none;
  text-align: left;
  outline: none;
  font-size: 15px;
}

/* Add a background color to the button if it is clicked on (add the .active class with JS), and when you move the mouse over it (hover) */
.active, .collapsible:hover {
  background-color: #ccc;
}

/* Style the collapsible content. Note: hidden by default */
.content {
  padding: 0 18px;
  display: none;
  overflow: hidden;
  background-color: #f1f1f1;
}
/* Style the buttons that are used to open and close the accordion panel */
.accordion {
  background-color: #eee;
  color: #444;
  cursor: pointer;
  padding: 18px;
  width: 100%;
  text-align: left;
  border: none;
  outline: none;
  transition: 0.4s;
}

/* Add a background color to the button if it is clicked on (add the .active class with JS), and when you move the mouse over it (hover) */
.active, .accordion:hover {
  background-color: #ccc;
}

/* Style the accordion panel. Note: hidden by default */
.panel {
  padding: 0 18px;
  background-color: white;
  display: none;
  overflow: hidden;
}

</style>
<head>
    <meta charset="UTF-8">
    <title>Registration</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>

<div class="container">
<div class="opacity">
    <div class="row jumbotron">
        <div class="col-md-12">
        <h1>
                ClockIn - Admin
            </h1>
            <br>
<h2>
            Registration
</h2>

            <!-- <p>
            First time? Forgot how?.. Press for <a target="_blank" href="https://clockinadmin.cglms.com/instructions.php">Instructions</a>
            </p> -->
            
        </div>
    </div>
    <div class="row">
        <div class="col-md-5 col-md-offset-3 well">
            <h4>Register</h4>
            <?php
            if ($register_error_message != "") {
                echo '<div class="alert alert-danger"><strong>Error: </strong> ' . $register_error_message . '</div>';
            }
            ?>
            <form action="registration.php" method="post">
                <div class="form-group">
                    <label for="">Real Name (FirstName LastName)</label>
                    <input type="text" name="name" class="form-control"/>
                </div>
                <div class="form-group">
                    <label for="">Email</label>
                    <input type="email" name="email" class="form-control"/>
                </div>
                <div class="form-group">
                    <label for="">Stage Name\Real Name (FirstName.LastName)</label>
                    <input type="text" name="username" class="form-control"/>
                </div>
                <div class="form-group">
                    <label for="">Password</label>
                    <input name="password" type="text" class="form-control" value="<?php echo generatePassword(); ?>"/>
                </div>
                <div class="form-group">
                    <label for="">Badge ID</label>
                    <input type="badge" name="badge" class="form-control"/>
                </div>
                <div class="form-group">
                    <label for="">Employee ID</label>
                    <input type="IdEmp" name="IdEmp" class="form-control"/>
                </div>
                <div class="form-group">
                    <label for="">Employee's Birthday ( Insert Month and Day. Insert YEAR ALWAYS 0000 )</label>
                    <input type="date" name="BDAY" class="form-control"/>
                </div>
                <div class="form-group">
                    <input type="submit" name="btnRegister" class="btn btn-primary" value="Register"/>
                </div>
            </form>
                 </div>
                 <div>
      
                 </div>
    </div>
    <div class="row">
        <div class="col-md-5 col-md-offset-3 well">
        <button class="accordion" onclick="myFunction()">Click here to view all users</button>
        <button class="accordion" onClick="window.location.reload();">Close View</button>
<p id="expand"></p>

<script>
function myFunction() {
  document.getElementById("expand").innerHTML = "<?php UsersExpand(); ?>";
}

</script>

</form>

</div>
              
               
                </div>
            </form>
    <hr>

    <div class="row">
    <div class="col-md-12 alert alert-success">
                Admin Panel <a href="adminpanel.php">Press Here</a>
            </div>
    <div class="col-md-12 alert alert-success">
                Disable a user? <a href="disableuser.php">Press Here</a>
            </div>
            <div class="col-md-12 alert alert-success">
                Change user password? <a href="changepassword.php">Press Here</a>
            </div>

    </div>
    </div>
</div>
</div>
</body>
</html>