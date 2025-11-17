<?php 
include("connect.php");

$name = $_POST['name'];
$mobile = $_POST['mobile'];
$password = $_POST['password'];
$cpassword = $_POST['cpassword'];
$address = $_POST['address'];
$role = $_POST['role'];

// Check if photo is uploaded
$image = '';
if(isset($_FILES['photo']) && $_FILES['photo']['error'] == 0){
   $tmp_name = $_FILES['photo']['tmp_name'];
   $image = $_FILES['photo']['name'];
   move_uploaded_file($tmp_name, "../uploads/$image");
}

if($password==$cpassword){
   $insert = mysqli_query($connect, "INSERT INTO user (name, mobile, address, password, photo, role, status, votes) VALUES ('$name', '$mobile', '$address', '$password', '$image', '$role', 0, 0)");
   if($insert){
    echo '
    <script>
    alert("Registration Successful!");
    window.location = "../"
    </script>
    ';
   }
   else{
   $error = mysqli_error($connect);
   if(strpos($error, 'Duplicate entry') !== false && strpos($error, 'mobile') !== false){
      echo'
      <script>
      alert("This mobile number is already registered! Please use a different mobile number.");
      window.location = "../routes/register.html";
      </script>
      ';
   } else {
      echo'
      <script>
      alert("Some error occurred: ' . addslashes($error) . '");
      window.location = "../routes/register.html";
      </script>
      ';
   }
}
}
else{
    echo'
    <script>
    alert("Password and Confirm password does not match!");
    window.location = "../routes/register.html";
    </script>';
}

?>
