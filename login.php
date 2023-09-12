<?php
    
    $User_mail  = $_POST['User_mail'];
    $u_Password = $_POST['u_Password'];






// Create connection
$con = new mysqli ("localhost","root","", "bithackreg");

if ($con->connect_error){
  die(
    "Failed to connect :".$con->connect_error
  );}
    else{
 
$stmt = $con->prepare("select * from userlogin  where User_mail = ?");
if ($stmt === false) {
  die("Error in prepare: " . $con->error);
}
$stmt->bind_param('s', $User_mail); 
$stmt->execute();  
$stmt_result=$stmt->get_result();
if($stmt_result->num_rows>0){
   $data=$stmt_result->fetch_assoc();
   if($data['u_Password']===$u_Password){

     session_start();
    $_SESSION['isLoggedIn'] = true;

    header("Location:https://www.dictionary.com/browse/aptitude#:~:text=noun,because%20of%20his%20general%20aptitude.");

    echo '<script type ="text/JavaScript">';  
    echo 'alert("success")';
   
  
    exit();
  }
   else{
    header("Location:login.html");
   echo json_encode(['success' => false, 'message' => 'Invalid credentials']);
   }
}
else{
  echo json_encode(['success' => false, 'message' => 'Invalid credentials']);
}
}

 

?>