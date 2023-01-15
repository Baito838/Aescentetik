<?php
session_start();
include_once 'config.php';

// -----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
 //Scanted Candle
// -----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
if( !isset($_SESSION["login"])){
    echo "
        <script>
            alert('Perlu Login terlebih Dahulu');
            document.location.href = 'login.php';
        </script>
        ";
}

function cms_scanted($data){
    global $conn;
    $nama_product = htmlspecialchars($data["nama_product"]);
    $harga_product = htmlspecialchars($data["harga_product"]);
    $deskripsi = htmlspecialchars($data["deskripsi"]);

    $foto_product = upload_scanted();

    // Cek Jika Foto Tidak Diupload
    if( !$foto_product){
        return false;
    }

    $query = "INSERT INTO products_scanted VALUES ('','$nama_product', '$harga_product', '$foto_product', '$deskripsi')";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);

}


function upload_scanted(){
    $nama_file = $_FILES['foto_product']['name'];
    $ukuran_file = $_FILES['foto_product']['size'];
    $error = $_FILES['foto_product']['error'];
    $tmp_file = $_FILES['foto_product']['tmp_name'];

    // cek apakah tidak ada gambar yang diupload
    if($error === 4){
        echo "
        <script> alert('Pilih Foto Terlebih Dahulu!') </script>
        ";
        return false;
    }

    // cek apakah yang diupload gambar
    $extensi_gambar_valid = ['jpg', 'jpeg', 'png'];
    $extensi_gambar = explode('.', $nama_file);
    $extensi_gambar = strtolower(end($extensi_gambar));

    if( !in_array($extensi_gambar, $extensi_gambar_valid)){
        echo "
        <script> alert('Yang anda Upload bukan gambar') </script>
        ";
        return false;
    }

    // cek Jika Ukurannya file terlalu besar
    if($ukuran_file > 5000000){
        echo "
        <script> alert('Ukuran File Terlalu besar') </script>
        ";
        return false;
    }

    // File Lolos Pengecekan
    move_uploaded_file($tmp_file, 'upload_gambar/' . $nama_file);
    return $nama_file;
}

if (isset($_POST['cms_scanted_edit'])){
    global $conn;
    $id = htmlspecialchars($_POST["id"]);
    $nama_product = htmlspecialchars($_POST["nama_product"]);
    $harga_product = htmlspecialchars($_POST["harga_product"]);
    $deskripsi = htmlspecialchars($_POST["deskripsi"]);
    $foto_lama = htmlspecialchars($_POST["foto_lama"]);

    // Cek Jika Foto Tidak Diupload
    if( $_FILES["foto_product"]["error"] === 4){
        $foto_product = $foto_lama;
    } else {
        $result = mysqli_query($conn, "SELECT foto_product FROM products_scanted WHERE id = $id");
	    $file = mysqli_fetch_assoc($result);
        $fileName = implode('.', $file);
		unlink('upload_gambar/' . $fileName);
        $foto_product = upload_scanted();
    }

    $ubah = mysqli_query($conn, "UPDATE products_scanted SET nama_product = '$nama_product', harga_product = '$harga_product' , foto_product = '$foto_product', deskripsi = '$deskripsi' WHERE id = '$_POST[id]'");

    if($_POST = 0) {
        echo " <script>
        alert('Data Tidak Boleh Kosong');
        document.location='cms_scanted.php';
        </script> ";
    } elseif ($ubah){
        echo " <script>
        alert('Data Berhasil Diubah');
        document.location='cms_scanted.php';
        </script> ";
    }
}

if (isset($_POST['hapus_scanted'])){
    global $conn;
    $id = $_POST["id"];
    $result = mysqli_query($conn, "SELECT foto_product FROM products_scanted WHERE id = $id");
    $file = mysqli_fetch_assoc($result);
	$fileName = implode('.', $file);
	$location = "upload_gambar/$fileName";

    if (file_exists($location)) {
		unlink('upload_gambar/' . $fileName);
	}

    $hapus = mysqli_query($conn, "DELETE FROM products_scanted WHERE id = '$_POST[id]'");

    if($_POST = 0) {
        echo " <script>
        alert('Data Tidak Boleh Kosong');
        document.location='cms_scanted.php';
        </script> ";
    } elseif ($hapus){
        echo " <script>
        alert('Data Berhasil Dihapus');
        document.location='cms_scanted.php';
        </script> ";
    }
}

if (isset($_POST["cms_scanted"])) {
    if ($_POST < 1) {
        echo "
        <script>
            alert('Data Tidak Boleh kosong');
        </script>
        ";
    } else if (cms_scanted($_POST) > 0) {
        echo "
        <script>
            alert('Data Berhasil Diinput');
            document.location.href = 'cms_scanted.php';
        </script>
        ";
    }
}

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

    <!-- Title -->
    <title>CMS Scanted Candle</title>

    <!-- Internal CSS -->
    <!-- Internal CSS -->
    <style>
        
    a {
        text-decoration: none;
        color: white;
        font-weight: 400;
    }

    a:hover {
        color: white;
        font-weight: 400;
    }


    #crud-content {
        overflow: visible;
        background: rgba(176, 176, 176, 0.52);
        border-radius: 16px;
        box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
        backdrop-filter: blur(7.9px);
        -webkit-backdrop-filter: blur(7.9px);
    }

    .modal-header {
        background-color: #BE9ABE;
    }

    .foto {
        height: 50px;
        display: flex;
        justify-content: center;
    }

    .foto_product {
        width: 50px;
        height: 50px;
        transition: 1s ease-in-out;
    }

    .foto_product:hover {
        position: absolute;
        transform: scale(2);
    }

        body::-webkit-scrollbar {
            width: 10px;
        }

        body::-webkit-scrollbar-track {
            box-shadow: inset 0 0 6px rgba(0, 0, 0, 0);
        }

        body::-webkit-scrollbar-thumb {
            border-radius: 10px;
            background-color: #A97A44;
            outline: 1px solid #A97A44;
        }
        #crud {
            min-width: 100vw;
            min-height: 100vh;
            background-color: #c8a2c8;
            background-image: url(http://www.transparenttextures.com/patterns/brick-wall-dark.png);
            object-fit: cover;
            background-repeat: repeat;
            background-attachment: fixed;
            display: flex;
            justify-content: center;
            padding: 20px;
        }
        a {
            text-decoration: none;
            color: white;
            font-weight: 400;
        }

        a:hover{
            color: white;
            font-weight: 400;
        }

        .edit_foto {
            width: 100px;
            height: 100px;
            background-size: contain;
        }

        .btn {
            width: max-content;
            padding: 8px;
        }

        .table-bg{
            width: 95%;
            padding: 20px 10px; 
            background: rgba(255, 255, 255, 0.2); 
            border-radius: 16px; 
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1); 
            -webkit-backdrop-filter-: blur(5px);
        }
        table {
            border-radius: 10px;
            overflow: hidden;
        }
        .tabel-overflow {
            width: 100%;
            overflow-x: scroll;
        }
        .tabel-overflow::-webkit-scrollbar {
            width: 10px;
        }

        .tabel-overflow::-webkit-scrollbar-track {
            box-shadow: inset 0 0 6px rgba(0, 0, 0, 0);
        }

        .tabel-overflow::-webkit-scrollbar-thumb {
            border-radius: 10px;
            background-color: rgba(255, 255, 255, 0.562);
            outline: 1px solid rgba(255, 255, 255, 0.562);
        }

        
        .title-product {
            background-color: #BE9ABE;
            padding: 5px 20px;
            border-radius: 50px;
            display: inline;
            margin-top: 10px;
        }
    </style>
</head>
<body id="crud">
    <div class="table-bg">
        <div class="text-center text-light col" >
            <h1 class="title-product">Scanted Candle</h1>
        </div>
        <div class="button col d-flex justify-content-between mb-2">
            <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#menu_bar" aria-controls="offcanvasExample">
                <i class="fa-solid fa-bars"></i>
            </button>
            <button type="submit" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambah_product">
                <i class="fa-solid fa-plus"></i>
            </button>
        </div>
        <div class="tabel-overflow">
            <table class="table table-light table-hover table-responsive">
                <thead>
                    <td style="display: none;">No</td>
                    <td class="text-center">Nama</td>
                    <td class="text-center">Harga</td>
                    <td class="text-center">Gambar</td>
                    <td class="text-center">Deskripsi</td>
                    <td class="text-center">Aksi</td>
                </thead>
                <?php $no = 1; ?>
                <?php foreach ($product as $row) : ?>
                <tbody class="table-warning">
                    <td style="display: none;"><?= $no ?></td>
                    <td style="display: none;"><?= $row["id"] ?></td>
                    <td class="text-center"><?= $row["nama_product"] ?></td>
                    <td class="text-center"><?= $row["harga_product"] ?></td>
                    <td class="text-center"><div class="foto"><img class="foto_product" src="upload_gambar/<?= $row["foto_product"] ?>" alt=""></div></td>
                    <td class="text-center"><?= $row["deskripsi"] ?></td>
                    <td class="text-center justify-content-center flex-wrap gap-2">
                        <button type="button" class="btn btn-warning mb-2 mx-2" data-bs-toggle="modal" data-bs-target="#edit<?= $no ?>">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>
                        <button type="button" class="btn btn-danger mb-2" data-bs-toggle="modal" data-bs-target="#hapus_product<?= $no ?>">
                            <i class="fa-solid fa-trash"></i></i>
                        </button>               
                    </td>
                </tbody>

                
            
                    <!--Modal Edit -->
                    <div class="modal fade" id="edit<?= $no ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header edit">
                                    <h5 class="modal-title text-light" id="editLabel">Edit Produk Scanted</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                <form action="" method="post" enctype="multipart/form-data">
                                        <input type="hidden" name="id" value="<?= $row["id"] ?>">
                                        <input type="hidden" name="foto_lama" id="foto_lama" value="<?= $row["foto_product"] ?>">
                                        <div class="col mt-2">
                                            <label class="mb-2" for="">Nama Produk</label>
                                            <input class="form-control" id="nama_product" name="nama_product" type="text" maxlength="20" value="<?= $row["nama_product"] ?>">
                                        </div>
                                        <div class="col mt-2">
                                            <label class="mb-2" for="">Harga Produk</label>
                                            <input class="form-control" id="harga_product" name="harga_product" type="number" value="<?= $row["harga_product"] ?>">
                                        </div>
                                        <div class="col mt-2">
                                            <label class="mb-2" for="">Deskripsi Produk</label>
                                            <textarea class="form-control w-100" id="deskripsi" name="deskripsi" rows="4" maxlength="100" value="<?= $row["deskripsi"] ?>"></textarea>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col d-flex justify-content-center">
                                                <img class="edit_foto" src="upload_gambar/<?= $row["foto_product"] ?>" alt="">
                                            </div>
                                            <div class="col-6">
                                                <label class="mb-2" for="">Foto Produk</label>
                                                <input class="form-control " type="file" name="foto_product" id="foto_product">
                                                <p style="font-size: 10px;">Ukuran File Harus Dibawah 5mb dan Ektensi File (jpg, png, jpeg)</p>
                                            </div>
                                        </div>
                                </div>
                                <div class="modal-footer d-flex justify-content-end gap-2" style="flex-direction: row;">
                                    <div class="d-flex justify-content-center align-items-center ">
                                        <button type="button" class="btn btn-warning" data-bs-dismiss="modal">
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>
                                        <button type="submit" class="btn btn-success" id="cms_wax_edit" name="cms_wax_edit">Ubah</button>
                                    </div>
                                </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Hapus-->
                    <form action="" method="post">
                    <div class="modal fade" id="hapus_product<?= $no ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="hapus_productLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="hapus_productLabel">Hapus Product</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="id" id="id" value="<?= $row["id"] ?>">
                                <h3>Yakin ingin menghapus product <?= $row["nama_product"] ?>!!</h3>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-warning" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i></button>  
                                <button class="btn btn-danger" type="submit" id="hapus_scanted" name="hapus_scanted">Hapus</button>
                            </div>
                            </div>
                        </div>
                    </div>
                    </form>

                    <?php $no++; ?>
                <?php endforeach; ?>
            </table>
        </div>
    </div>

    <!--Modal Tambah -->
    <div class="modal fade" id="tambah_product" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="tambah_productLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header tambah">
              <h5 class="modal-title text-light" id="tambah_productLabel">Tambah Produk Scanted</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form action="" method="post" enctype="multipart/form-data">
                    <div class="col mt-2">
                        <label class="mb-2" for="">Nama Produk</label>
                        <input class="form-control" id="nama_product" name="nama_product" type="text" maxlength="20" placeholder="Masukkan Nama Produk">
                    </div>
                    <div class="col mt-2">
                        <label class="mb-2" for="">Harga Produk</label>
                        <input class="form-control" id="harga_product" name="harga_product" type="number" placeholder="Masukkan Harga Produk">
                    </div>
                    <div class="col mt-2">
                        <label class="mb-2" for="">Deskripsi Produk</label>
                        <textarea class="form-control w-100" id="deskripsi" name="deskripsi" rows="4" maxlength="100" placeholder="Masukkan Deskripsi Produk, Maks 100 karakter."></textarea>
                    </div>
                    <div class="col mt-3">
                        <label class="mb-2" for="">Foto Produk</label>
                        <input class="form-control " type="file" name="foto_product" id="foto_product">
                        <p style="font-size: 10px;">Ukuran File Harus Dibawah 5mb dan Ektensi File (jpg, png, jpeg)</p>
                    </div>
            </div>
            <div class="modal-footer d-flex justify-content-end gap-2 flex-row">
                <button type="button" class="btn btn-warning" data-bs-dismiss="modal">
                    <i class="fa-solid fa-xmark"></i>
                </button>
                <button type="submit" class="btn btn-success" id="cms_scanted" name="cms_scanted">Tambahkan</button>
            </form>
            </div>
          </div>
        </div>
      </div>

      <!-- Menu bars -->
        <div class="offcanvas offcanvas-start" tabindex="-1" id="menu_bar" aria-labelledby="offcanvasExampleLabel">
            <div class="offcanvas-header" style="background-color: #D4C5E3;">
                <h5 class="offcanvas-title text-light" id="offcanvasExampleLabel">Menu Bar</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body" style="background-color: #D4C5E3;">
                <div>
                    <div style="margin-bottom: 10px;"><a style="font-size: large; " class="link" href="cms_wax.php">Wax Sachet</a></div>
                    <div style="margin-bottom: 10px;"><a style="font-size: large; " class="link" href="cms_scanted.php">Scanted Candle</a></div>
                    <div style="margin-bottom: 10px;"><a style="font-size: large; " class="link" href="data_penjualan.php">Data Penjualan</a></div>
                </div>
                <div style="height: 80%;" class="col d-flex w-100 justify-content-end align-items-end">
                    <form action="logout.php" method="post">
                        <button class="btn btn-danger" type="submit" id="logout" name="logout"><i class="fa-solid fa-right-from-bracket"></i></button>
                    </form>
                </div>
            </div>
        </div>
</body>
</html>