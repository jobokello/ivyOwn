<?php
  session_start();
  //gives variable for creating the connection
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "ivyproject";

  // Create connection
  
  $conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
  if (!$conn){
      die("Connection failed: " . mysqli_connect_error());
  }
  else
  {
    echo "Connected successfully";

    if(isset($_POST['submit'])){

    	echo 'submit is working';

      if(empty($_POST['email']) || empty($_POST['password'])){
          $error = 'something is missing';
      }
      else{
        $trpAgentEmail = $_POST['email'];
        $trpAgentPassword = $_POST['password'];
        $trpAgentEmail = stripslashes($trpAgentEmail);
        $trpAgentPassword = stripslashes($trpAgentPassword);
        $trpAgentEmail = mysqli_real_escape_string($conn, $trpAgentEmail);
        $trpAgentPassword = mysqli_real_escape_string($conn, $trpAgentPassword);
        $trpAgentPassword = md5($trpAgentPassword);

        $sql="SELECT trpAgentID, trpAgentUsername FROM trpAgentinfo WHERE trpAgentEmail = '$trpAgentEmail' AND trpAgentPassword = '$trpAgentPassword'";

        $result=mysqli_query($conn, $sql);

        $row=mysqli_fetch_array($result,MYSQLI_ASSOC);

        if(mysqli_num_rows($result) == 1){

          //taking session variables
          $_SESSION['trpAgentID'] = $row['trpAgentID'];
          $_SESSION['trpAgentUsername'] = $row['trpAgentUsername'];

          header("location: ../html/trpAgentHome.php"); // Redirecting To Other Page
        }
        else{
          $error = "Incorrect username or password.";
        }
      }
    }
  } 
?>
