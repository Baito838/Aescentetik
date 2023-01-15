<?php
include_once 'config.php';

$product = query("SELECT * FROM products_scanted");

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
    <script src="https://kit.fontawesome.com/308efbf9d4.js" crossorigin="anonymous"></script>
    <!-- My Style -->
    <link rel="stylesheet" href="assets/Style/style.css">
    <link rel="stylesheet" href="assets/Style/responsive.css">
    <link rel="shortcut icon" href="assets/Style/Esscentes.png" type="image/x-icon">
    <!-- Title -->
    <title>Scanted Candle</title>

    <!-- Internal CSS -->
    <style>
        #index {
            z-index: 1;
            padding: 50px 10px auto 10px;
            min-width: 100vw;
            min-height: 100vh;
            background-color: #c8a2c8;
            background-image: url(http://www.transparenttextures.com/patterns/brick-wall-dark.png);
            object-fit: cover;
            background-repeat: repeat;
            background-attachment: fixed;
            display: flex;
            justify-content: center;
            align-items: start;
            padding: 130px 20px 20px 20px;
            box-sizing: border-box;
        }

        section {
            z-index: 2;
            gap: 10px;
            display: flex;
            justify-content: start;
            flex-wrap: wrap;
            position: relative;
            box-sizing: border-box;
            justify-content: center;
            min-height: min-content;
            min-width: 80%;
            background: rgba(255, 252, 252, 0.22);
            border-radius: 10px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(7.9px);
            -webkit-backdrop-filter: blur(7.9px);
            padding: 100px 30px 30px 30px;
            box-sizing: border-box;
        }
        .card {
            max-width: 18rem;
            min-width: 200px;
            min-height: 295px;
            max-height: 295px;
            overflow: hidden;
            border: none;
            background: rgba(255, 252, 252, 0.58);
            border-radius: 16px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(3.3px);
            -webkit-backdrop-filter: blur(3.3px);
        }
        .card-body {
            display: flex;
            flex-direction: column;
            justify-content: space-around;
        }
        .show_product {
            height: 200px;
            object-fit: cover;
        }

        h5 {
            padding: 0;
            margin: 0;
        }

        .card-title {
            top: 135px;
            position: absolute;
            background-color: azure;
            display: block;
            justify-content: center;
            padding: 3px 5px;
            border-radius: 5px;
        }
        .title-nama{
            display: flex;
            justify-content: center;
        }

        body::-webkit-scrollbar {
        width: 10px;
        }
        
        body::-webkit-scrollbar-track {
        box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
        }
        
        body::-webkit-scrollbar-thumb {
        border-radius: 10px;
        background-color: #A97A44;
        outline: 1px solid #A97A44;
        }
        
        .btn {
            width: 30px;
            height: 30px;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: visible;
        } 

        .harga {
            font-size: 13px;
        }
        
        p {
            margin: 0;
            margin-bottom: 10px;
            padding: 0;
            font-size: 15px;
            text-align: center;
        }

        .logo-title {
            position: absolute;
            top : -80px;
            z-index: 3;
            border-radius: 50%;
            overflow: hidden;
        }

        .logo-title img {
            width: 150px;
            height: 150px;
        }

        @media (max-width: 600px) {
            #index {
                padding: 80px 0px;
                background-position: auto;
            }
            .show_product {
                height: 50px;
                object-fit: cover;
            }
            .btn {
                width: 30px;
                height: 30px;
                margin: 0;
                padding: 0;
                display: flex;
                justify-content: center;
                align-items: center;
                overflow: visible;
            } 

            .harga {
                font-size: 13px;
            }
            .card {
                min-width: 40%;
                max-width: 40%;
                min-height: 265px;
                max-height: 265px;
            }
            .card-title {
                top: 140px;
                position: absolute;
                background-color: azure;
                display: block;
                justify-content: center;
                font-size: 15px;
                padding: 3px 5px;
                border-radius: 5px;
            }
            .title-nama{
                display: flex;
                justify-content: center;
            }
            .card-body {
                padding: 20px 10px;
                height: 50px;
                justify-content: space-between;
            }
            p {
                margin: 0;
                margin-bottom: 10px;
                padding: 0;
                font-size: 11px;
                text-align: center;
            }
            section {
                margin-top: 50px;
                border-radius: 0px;
                padding: 80px 10px;
                justify-content: space-evenly;
                min-height: min-content;
                min-width: 95%;
            }
            .logo {
                width: 150px;
                height: 150px;
                position: absolute;
                background-color: white;
                border-radius: 50%;
                top: -75px;
            }
        }

        * {
            box-sizing: border-box;
        }
    </style>
</head>
<body id="index">
    <section>
        <div class="logo-title">
            <img src="assets/Style/home_scanted.png" alt="">
        </div>    
        <?php $no = 1; ?>
            <?php foreach ($product as $row) : ?>
            <div class="card">
                <img class="show_product" style="height: 150px;" src="upload_gambar/<?= $row["foto_product"] ?>" class="card-img-top" alt="...">
                <div class="title-nama"><h5 class="card-title"><?= $row["nama_product"] ?></h5></div>
                <div class="card-body">
                    <p class="card-text"><?= $row["deskripsi"] ?></p>
                    <div class="d-flex justify-content-between align-items-center p-0 m-0">
                        <h5 class="harga"><?= "IDR ". number_format($row["harga_product"],0, ".", ".") .".00"?></h5>
                        <a href="https://api.whatsapp.com/send?phone=6282320430534&text=*Halo%2C%20Kak%20%E2%98%BA%EF%B8%8F*.%20Boleh%20tanya-tanya%20tentang%20candle%3F">
                            <button class="btn btn-success">
                                <i class="fa-solid fa-bounce fa-sm fa-cart-shopping"></i>
                            </button>
                        </a>
                    </div> 
                </div>
            </div>
            <?php $no++; ?>
        <?php endforeach; ?>
    </section>
</body>
</html>