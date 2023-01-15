<?php
include_once 'config.php';
session_start();



if(isset($_COOKIE['id']) && isset($_COOKIE['key'])) {
    global $conn;
    $id = $_COOKIE['id'];
    $key = $_COOKIE['key'];

    // ambil username berdasarkan id
    $result = mysqli_query($conn, "SELECT username FROM user_admin WHERE
        id = '$id'");
    $row = mysqli_fetch_assoc($result);

    // cek cookie dan username
    if($key === hash('crc32b', $row['username'])){
        $_SESSION['login'] = true;
    }
}

if( isset($_SESSION["login"])){
    echo "
        <script>
            alert('Perlu Login terlebih Dahulu');
            document.location.href = 'cms_wax.php';
        </script>
        ";
}

if (isset($_POST["login"])){
    global $conn;
    $user = htmlspecialchars($_POST["username"]);
    $pass = htmlentities($_POST["password"]);
    // cek username
    $result = mysqli_query($conn, "SELECT * FROM user_admin where username = '$user'");

    if (!$user || !$pass){
        echo " <script>
                alert('Username atau Password Salah');
                </script> "
            ;
        return false;
    } else if( mysqli_num_rows($result) === 1){

        // cek Password
        $row = mysqli_fetch_assoc($result);
        if (password_verify($pass, $row["password"])){
            // set session
            $_SESSION["login"] = true;
            // cek remeber me
            if (isset($_POST['remember'])){

                setcookie('id', $row['id']);
                setcookie('key', hash('crc32b', $row['username']));
                
            }

            echo " <script>
                alert('Login Berhasil');
                document.location='cms_wax.php';
                </script> "
            ;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
    <!-- My Style -->
    <link rel="stylesheet" href="assets/Style/style.css">
    <link rel="stylesheet" href="assets/Style/responsive.css">

    <!-- Title -->
    <title>Aescentetik</title>

    <!-- Internal CSS -->
    <style>
        #login {
            width: 100vw;
            height: 100vh;
            background-image: url("assets/Style/Background.jpg");
            background-repeat: no-repeat;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        #login-section {
        min-width: 300px;
        min-height: 300px;
        background: rgba(255, 255, 255, 0.38);
        border-radius: 16px;
        box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
        backdrop-filter: blur(3.5px);
        -webkit-backdrop-filter: blur(3.5px);
        padding: 20px 10px;
        box-sizing: border-box;
    }
    </style>
</head>
<body id="login">
    <div id="login-section">
        <div class="text-center text-light" ><h1>Login</h1></div>
        <form action="" method="post">
            <div class="col mt-2">
                <label class="text-light mb-2" for="">Username</label>
                <input class="form-control" type="text" id="username" name="username">
            </div>
            <div class="col mt-2">
                <label class="text-light mb-2" for="">Password</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="bi bi-eye-slash" id="togglePassword"></i>
                        </div>
                    </div>
                    <input class="form-control" type="password" id="password" name="password">
                </div>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                <label class="form-check-label" for="remember">
                    Remember me
                </label>
            </div>
            <div class="col mt-3 d-flex justify-content-end">
                <button class="btn btn-primary flex-end" name="login" type="submit">Masuk</button>
            </div>
        </form>
    </div>

<script>
    const togglePassword = document.querySelector("#togglePassword");
        const password = document.querySelector("#password");
        const togglekonfirmasi = document.querySelector("#togglekonfirmasi_password");
        const konfirmasi= document.querySelector("#konfirmasi_password");

        togglePassword.addEventListener("click", function () {
            // toggle the type attribute
            const type = password.getAttribute("type") === "password" ? "text" : "password";
            password.setAttribute("type", type);
            
            // toggle the icon
            this.classList.toggle("bi-eye");
        });

        togglekonfirmasi.addEventListener("click", function () {
            // toggle the type attribute
            const type = konfirmasi.getAttribute("type") === "password" ? "text" : "password";
            konfirmasi.setAttribute("type", type);
            
            // toggle the icon
            this.classList.toggle("bi-eye");
        });

        // prevent form submit
        const form = document.querySelector("form");
        form.addEventListener('submit', function (e) {
            e.preventDefault();
        });
</script>
</body>
</html>