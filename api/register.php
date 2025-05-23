<?php 
include("connect.php");

$name = $_POST['name'];
$mobile = $_POST['mobile'];
$password = $_POST['password'];
$password = $_POST['password'];
$address = $_FILES['name']['photo'];
$tmp_name = $_Files['tmp_name']['photo'];
$role = $_POST['role'];

if($password==$password){
   move_uploaded_file($tmp_name, "../uploads/$image");
   $insert = mysqli_query($connect, "INSERT INTO user (name, mobile, address, password, photo, role, status, votes) VALUES ('$name', '$mobile', '$password', '$address', '$image', '$role', 0, 0)")
   if($insert){
    echo '
    <script>
    alert(Registration Scucessfull!);
    window.location = "../"
    </script>
    ';
   }
   else{
   echo'
    <script>
    alert("Some error occured!");
    window.location = "../";
    </script>
    ';
}
}
else{
    echo'
    <script>
    alert("Passsword and Confirm password does not match!");
    window.location = "../routes/register.html";
    </script>';
}

?>