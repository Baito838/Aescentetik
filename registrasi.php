<?php
include_once 'config.php';
if(isset($_POST["register"])){


    if( registrasi($_POST) > 0){
        echo "
        <script>
            alert('Data Berhasil Diinput');
            document.location.href = 'registrasi.php';
        </script>
        ";
    } else {
        echo mysqli_error($conn);
    }
}

function registrasi($data){
    global $conn;
    $username = strtolower(stripslashes(htmlspecialchars($data["username"])));
    $password = mysqli_real_escape_string($conn,$data["password"]);
    $konfirmasi_password = mysqli_real_escape_string($conn,$data["konfirmasi_password"]);
    
    // cek kalo ada username atau password yang sama
    $result =  mysqli_query($conn, "SELECT username FROM user_admin WHERE username = '$username'");

    if(mysqli_fetch_assoc($result)){
        echo "<script>
            alert('Username sudah terdaftar')
        </script>
        ";
        return false;
    }
    // cek password dan konfirmasi harus sama
    if($password !== $konfirmasi_password){
        echo "
            <script>
                alert('Konfirmasi Password Tidak Sesuai');
            </script>
            ";
        return false;
    }
    $password = password_hash($password, PASSWORD_DEFAULT);
    // query
    $query = "INSERT INTO user_admin VALUES ('','$username','$password')";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
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
            min-height: 350px;
            background: rgba(255, 255, 255, 0.38);
            border-radius: 16px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(3.5px);
            -webkit-backdrop-filter: blur(3.5px); 
            padding: 20px 10px;
            box-sizing: border-box;
        }
        form i {
            cursor: pointer;
        }
    </style>
</head>
<body id="login">
    <div id="login-section">
        <div class="text-center text-light" ><h1>Registrasi</h1></div>
        <form action="" method="post">
            <div class="col mt-2">
                <label class="text-light mb-2" for="">Username :</label>
                <input class="form-control" type="text" id="username" name="username" maxlength="25" required oninvalid="this.setCustomValidity('Masukkan Username')" oninput="this.setCustomValidity('')" placeholder="Masukkan Username">
            </div>
            <div class="col mt-2">
                <label class="text-light mb-2" for="">Password :</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="bi bi-eye-slash" id="togglePassword"></i>
                        </div>
                    </div>
                    <input class="form-control" type="password" id="password" name="password" max="25" required  oninvalid="this.setCustomValidity('Masukkan Passwrod')" oninput="this.setCustomValidity('')"  placeholder="Masukkan Password">
                </div>
            </div>
            <div class="col mt-2">
                <label class="text-light mb-2" for="">Konfirmasi Password :</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="bi bi-eye-slash" id="togglekonfirmasi_password"></i>
                        </div>
                    </div>
                    <input class="form-control" type="password" id="konfirmasi_password" name="konfirmasi_password" maxlength="25" required  oninvalid="this.setCustomValidity('Konfirmasi Password')" oninput="this.setCustomValidity('')" placeholder="Konfirmasi Password">
                </div>
            </div>
            <div class="col mt-3 d-flex justify-content-between">
                <a href="login.php">
                    <button class="btn btn-success" type="button">Login</button>
                </a>
                <button class="btn btn-primary" type="submit" id="register" name="register">Daftar</button>
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

        
    </script>
</body>
</html>

