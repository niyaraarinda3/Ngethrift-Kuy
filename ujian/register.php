<?php
require('koneksi.php');
session_start();
 
$error = '';
$validate = '';
if( isset($_POST['submit']) ){
        // menghilangkan backshlases
        $username = stripslashes($_POST['username']);
        //cara sederhana mengamankan dari sql injection
        $username = mysqli_real_escape_string($conn, $username);
        $name     = stripslashes($_POST['name']);
        $name     = mysqli_real_escape_string($conn, $name);
        $email    = stripslashes($_POST['email']);
        $email    = mysqli_real_escape_string($conn, $email);
        $hp       = stripslashes($_POST['hp']);
        $hp       = mysqli_real_escape_string($conn, $hp);
        $password = stripslashes($_POST['password']);
        $password = mysqli_real_escape_string($conn, $password);
        $repass   = stripslashes($_POST['repassword']);
        $repass   = mysqli_real_escape_string($conn, $repass);
        if(!empty(trim($name)) && !empty(trim($username)) && !empty(trim($email)) && !empty(trim($password)) && !empty(trim($repass))){
            if($password == $repass){
                if( cek_nama($name,$conn) == 0 ){
                    //hashing password sebelum disimpan didatabase
                    $pass  = password_hash($password, PASSWORD_DEFAULT);
                    //insert data ke database
                    $query = "INSERT INTO users (username,name,email,hp, password ) VALUES ('$username','$name','$email','$hp','$pass')";
                    $result   = mysqli_query($conn, $query);

                    if ($result) {
                        $_SESSION['username'] = $username;
                        
                        header('Location: index.php');

                    } else {
                        $error =  'user registration failed';
                    }
                }else{
                        $error =  'username already taken';
                }
            }else{
                $validate = 'invalid field, please confirm password';
            }
             
        }else {
            $error =  'field cannot be empty';
        }
    } 

    function cek_nama($username,$con){
        $name = mysqli_real_escape_string($con, $username);
        $query = "SELECT * FROM users WHERE username = '$name'";
        if( $result = mysqli_query($con, $query) ) return mysqli_num_rows($result);
    }
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<link rel="stylesheet" href="stylee.css">
<title>UTS Ngethrift-Kuy</title>
</head>
<body background="img\tiga.jpg">
         <div class="kotak">
                <form class="form-container" action="register.php" method="POST"><br>
                    <h2 class="text-center font-weight-bold"><font color ="white">Register </h2>
                    <?php if($error != ''){ ?>
                        <div class="alert alert-danger" role="alert"><?= $error; ?></div>
                    <?php } ?>
                    
                    <div class="form-group">
                        <font color ="white"><label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Input Name">
                    </div>
                    <div class="form-group">
                        <label for="InputEmail">Email</label>
                        <input type="email" class="form-control" id="InputEmail" name="email" aria-describeby="emailHelp" placeholder="Email Address">
                    </div>
                    <div class="form-group">
                        <label for="InputHp">Phone Number</label>
                        <input type="text" class="form-control" id="InputHp" name="hp"  placeholder="Input Phone Number">
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Input Username">
                    </div>
                    <div class="form-group">
                        <label for="InputPassword">Password</label>
                        <input type="password" class="form-control" id="InputPassword" name="password" placeholder="Input Password">
                        <?php if($validate != '') {?>
                            <p class="text-danger"><?= $validate; ?></p>
                        <?php }?>
                    </div>
                    <div class="form-group">
                        <label for="InputPassword">Re-enterPassword</label>
                        <input type="password" class="form-control" id="InputRePassword" name="repassword" placeholder="Re-enter Password">
                        <?php if($validate != '') {?>
                            <p class="text-danger"><?= $validate; ?></p>
                        <?php }?>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary btn-block">Register</button>
                    <div class="form-footer mt-2">
                        <p> already have an account?</font><a href="login.php"> Login</a></p></font><br>
                    </div>
                </form>
            </section>
            </section>
        </section>
 
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>