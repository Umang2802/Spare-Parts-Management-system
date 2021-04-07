<?php
 $con =mysqli_connect('localhost','root','','spare_parts');

 
if (isset($_POST['proceed'])) {
    $nam=$_POST['cname'];
 $add=$_POST['cadd'];
 $phone=$_POST['pnum'];
 $phonee=$_POST['apnum'];
 $email=$_POST['cmail'];

 $sql = "INSERT INTO cust_info (cname,cadd,pnum,apnum,cmail) VALUES ('$nam','$add','$phone','$phonee','$email')";
mysqli_query($con,$sql);
 header("location: order.php");
}

?>