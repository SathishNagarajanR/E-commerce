<?php
$User_Name = $_POST['User_Name'];
$User_mail = $_POST['User_mail'];
$u_Password = $_POST['u_Password'];

if (!empty($User_Name) || !empty($User_mail) || !empty($u_Password)) {

    $host = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "bithackreg";

    // Create connection
    $conn = new mysqli('localhost', 'root', '', 'bithackreg');

    if (mysqli_connect_error()) {
        die('Connect Error (' . mysqli_connect_errno() . ') '
            . mysqli_connect_error());
    } else {
        $SELECT = "SELECT User_mail FROM userlogin WHERE User_mail = ? LIMIT 1";
        $INSERT = "INSERT INTO userlogin (User_Name, User_mail, u_Password) VALUES (?, ?, ?)";

        // Prepare statement
        $stmt = $conn->prepare($SELECT);
        $stmt->bind_param("s", $User_mail);
        $stmt->execute();
        $stmt->bind_result($User_mail);
        $stmt->store_result();
        $rnum = $stmt->num_rows;

        // Checking username
        if ($rnum == 0) {
            $stmt->close();
            $stmt = $conn->prepare($INSERT);
            $stmt->bind_param("sss", $User_Name, $User_mail, $u_Password);
            $stmt->execute();
            
            // Close the database connection before redirecting
            $stmt->close();
            $conn->close();
            
            // Redirect to index.html
            // C:\xampp\htdocs\Cyber (17-08)\Login Form\login.html

           header("Location: login.html");
           $goodMessage = "Someone already registered using this email";
            exit(); // Important to stop further script execution
        } else {
        
          $errorMessage = "Someone already registered using this email";
          header("Location: register.html");
          echo 'alert("This is an alert generated using PHP!");';
        }
        
        $stmt->close();
        $conn->close();
    }
}
?>
