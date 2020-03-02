<?php 
   session_start();
   $conn =mysqli_connect('localhost','root','','color');  
  
   $id= $_GET['id'];
   $sql="delete from color where id=$id";
   $result=mysqli_query($conn,$sql);
   
   if($result){   

      $_SESSION['Color Status']='Color Code Delete Successfully...';

      header("Location: index.php");
   }


  //$studentView=mysqli_fetch_assoc($result);
  
  /* N:B: echo $studentView['name'];*/
?>