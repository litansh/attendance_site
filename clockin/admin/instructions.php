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
    <title>Instructions</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body><div class="opacity">
<div class="row jumbotron">
        <div class="col-md-12">
        
            <h1>
                ClockIn - Attendance Admin Guide
            </h1>
            <br>
            <p>
            <b>Welcome to ClockIn admin panel!</b><br><br>
            <b>Registration:</b> 
            Input username in both Name and Username, Email as users email address and badge ID from HR department.
            Password is generated automatically. Be sure to copy it to the email sent to the employee. Otherwise, 
            you may change the user's password and send seperatly. Scan the barcode (from the email link) pre sending the email and insert 
            to the validation page.<br><br>
            <b>Change user's password:</b> 
            Insert the username and badge ID (as seen in the View button) password is generated automatically and hashed.<br><br>
            <b>Admin permissions:</b> 
            Promote a regular user to admin access. the same instructions as in the Change user's password. It does not change the user's login to the regular clockin panel,
            but allows him to enter clockinadmin.<br><br>
            <b>Disable a user:</b> 
            Disables a user from entering any platform. May change to active if you change this user's password.<br>
            </p>
        </div>
    </div>
    </div>


</body>
</html>

