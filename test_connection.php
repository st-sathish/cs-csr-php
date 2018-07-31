<?php
$servername   = "localhost";
$database = "csr";
$username = "csr";
$password = "csrAdmin123$";

// Create connection
$conn = new mysqli($servername, $username, $password, 'csr');
// Check connection
if ($conn->connect_error) {
   die("Connection failed: " . $conn->connect_error);
}
  echo "Connected successfully";
?>