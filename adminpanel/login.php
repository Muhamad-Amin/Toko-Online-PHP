<?php

    session_start();
    require '../koneksi.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <style>
        .main{
            height: 100vh;
        }

        .login-box {
            width: 500px;
            height: 300px;
            box-sizing: border-box;
            border-radius: 10px;
        }
    </style>
</head>
<body>
    
    <main class="main d-flex flex-column justify-content-center align-items-center">

        <section class="login-box p-5 shadow">
            <form action="#" method="post">
                <div class="mb-3">
                    <label for="username" class="form-label">username</label>
                    <input type="text" class="form-control" name="username" autocomplete="off">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">password</label>
                    <input type="password" class="form-control" name="password" autocomplete="off">
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-success form-control" name="loginbtn">Login</button>
                </div>
            </form>
        </section>

        <section class="mt-3" style="width:500px;">
            <?php
                if (isset($_POST['loginbtn'])) {
                    $username = htmlspecialchars($_POST['username']);
                    $password = htmlspecialchars($_POST['password']);

                    $query = mysqli_query($connect, "SELECT * FROM users WHERE username='$username'");
                    $countdata = mysqli_num_rows($query);
                    // mysqli_num_rows = menghitung berapa users yang diketikkan
                    $data = mysqli_fetch_array($query);
                    
                    if($countdata>0) {
                        if (password_verify($password, $data['password'])) {
                            $_SESSION['username'] = $data['username'];
                            $_SESSION['login'] = true;
                            header('location:index.php');
                        } else {
                            ?>
                                <div class="alert alert-warning" role="alert">
                                    Password salah
                                </div>
                            <?php  
                        }
                    } else {
                        ?>
                            <div class="alert alert-warning" role="alert">
                                Akun tidak tersedia
                            </div>
                        <?php   
                    }
                }
            ?>
        </section>
    </main>



<script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>