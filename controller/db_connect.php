<?php 
$conn=mysqli_connect("localhost","root","","rsup_betun_naive_bayes");
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
