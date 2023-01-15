<?php
include_once 'config.php';
session_start();

if( !isset($_SESSION["login"])){
    echo "
        <script>
            alert('Perlu Login terlebih Dahulu');
            document.location.href = 'login.php';
        </script>
        ";
}

// pagination 


if(isset($_POST["pembeli"])){
    global $conn;
    $tanggal = htmlspecialchars($_POST["tanggal"]);
    $nama = htmlspecialchars($_POST["nama"]);
    $nomer_telfon = htmlspecialchars($_POST["nomer_telfon"]);
    $alamat = htmlspecialchars($_POST["alamat"]);
    $produk = htmlspecialchars($_POST["produk"]);
    $jumlah = htmlspecialchars($_POST["jumlah"]);
    $total = htmlspecialchars($_POST["total"]);

    $query = mysqli_query($conn, "INSERT INTO penjualan VALUES ('','$tanggal', '$nama','$nomer_telfon','$alamat','$produk','$jumlah','$total','')");

    if($_POST = 0) {
        echo " <script>
        alert('Data Tidak Boleh Kosong');
        document.location='data_penjualan.php';
        </script> ";
    } elseif ($query){
        echo " <script>
        alert('Data Berhasil Ditambahkan');
        document.location='data_penjualan.php';
        </script> ";
    }
}

if(isset($_POST["edit_pembeli"])){
    global $conn;
    $id = $_POST["id"];
    $tanggal = htmlspecialchars($_POST["tanggal"]);
    $nama = htmlspecialchars($_POST["nama"]);
    $nomer_telfon = htmlspecialchars($_POST["nomer_telfon"]);
    $alamat = htmlspecialchars($_POST["alamat"]);
    $produk = htmlspecialchars($_POST["produk"]);
    $jumlah = htmlspecialchars($_POST["jumlah"]);
    $total = htmlspecialchars($_POST["total"]);

    $query = mysqli_query($conn, "UPDATE penjualan SET tanggal = '$tanggal', nama = '$nama', nomer_telfon = '$nomer_telfon', alamat = '$alamat', produk = '$produk', jumlah = '$jumlah', total ='$total' WHERE id = $id");

    if($_POST = 0) {
        echo " <script>
        alert('Data Tidak Boleh Kosong');
        document.location='data_penjualan.php';
        </script> ";
    } elseif ($query){
        echo " <script>
        alert('Data Berhasil Diubah');
        document.location='data_penjualan.php';
        </script> ";
    }

}

if (isset($_POST["hapus_pembeli"])){
    global $conn;
    $id = $_POST["id"];

    $query = mysqli_query($conn, "DELETE FROM penjualan WHERE id = $id");

    if($query) {
        echo " <script>
        alert('Data Berhasil Dihapus');
        document.location='data_penjualan.php';
        </script> ";
    }
}



if (isset($_POST["truncate"])){
    global $conn;
    $product = mysqli_query($conn,"DELETE FROM penjualan WHERE kosong = 0");

    if($product){
        echo " <script>
        alert('Data Berhasil Dihapus');
        document.location='data_penjualan.php';
        </script> ";
    }
}



// View table
$jumlah_data_perhalaman = 5;
$jumlah_data = count(query("SELECT * FROM penjualan"));
$jumlahHalaman = ceil($jumlah_data / $jumlah_data_perhalaman);
$halaman_aktif = ( isset($_GET["page"]) ) ? $_GET["page"] : 1;

$awal_data = ($jumlah_data_perhalaman * $halaman_aktif) - $jumlah_data_perhalaman;

$product = query("SELECT * FROM penjualan LIMIT $awal_data, $jumlah_data_perhalaman");


function Search($keyword){
    $query = "SELECT * FROM penjualan 
    WHERE nama LIKE '%$keyword%' OR tanggal LIKE '%$keyword%' OR nomer_telfon LIKE '%$keyword%' OR alamat LIKE '%$keyword%' OR produk LIKE '%$keyword%'";
    //mengambil funciton query yang diatas
    return query($query);
}

if (isset($_POST["mencari"])) {
    $product = Search($_POST["keyword"]);
}

if (isset($_POST["reset"])){
    $product = query("SELECT * FROM penjualan LIMIT $awal_data, $jumlah_data_perhalaman");
}

if (isset($_POST["desc"])){
    $product = query("SELECT * FROM penjualan ORDER BY total DESC");
}

if (isset($_POST["asc"])){
    $product = query("SELECT * FROM penjualan ORDER BY total ASC");
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
     <script src="https://kit.fontawesome.com/308efbf9d4.js" crossorigin="anonymous"></script>


    <title>Data Penjualan</title>

    <style>
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
        .table-bg{
            width: 95%;
            padding: 10px; 
            background: rgba(255, 255, 255, 0.2); 
            border-radius: 16px; 
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1); 
            -webkit-backdrop-filter-: blur(5px);
            
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
        table {
            border-radius: 10px;
            overflow: hidden;
        }
        
        @media print {
            .aksi-print {
                display: none;
            }
        }
    </style>
</head>
<body id="crud">
    <div class="table-bg">
        <div>
            <div class="text-center text-light col" >
            <h1>Data Penjualan</h1>
        </div>
        <form action="" method="post">
            <div class="button col d-flex justify-content-between mb-2">
                <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#menu_bar" aria-controls="offcanvasExample">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <div class="col d-flex justify-content-center gap-2">
                    <button class="btn btn-success" type="submit"  id="desc" name="desc">
                    <i class="fa-solid fa-arrow-trend-up"></i>
                    </button>
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#truncate">
                    <i class="fa-solid fa-trash"></i>
                    </button>
                    <button class="btn btn-warning" type="submit"  id="asc" name="asc">
                    <i class="fa-solid fa-arrow-trend-down"></i>
                    </button>
                </div>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambah_pembeli">
                    <i class="fa-solid fa-plus"></i>
                </button>
            </div>
            <div class=" w-100 d-flex justify-content-center mb-2 mt-2">
                <div style="width: 80%;" class="input-group">
                    <button class="btn btn-secondary" type="submit" name="mencari"><i class="fa-solid fa-search"></i></button>
                    <input type="text" class="form-control" name="keyword" placeholder="" aria-label="Example text with button addon" aria-describedby="button-addon1">
                    <button class="btn btn-secondary" type="submit" name="reset"><i class="fa-solid fa-arrows-rotate"></i></button>
                </div>
            </div>
        </form>
        </div>
        <div class="tabel-overflow">
            <table class="table table-light table-hover table-responsive">
                <thead>
                    <td class="text-center">Tanggal</td>
                    <td class="text-center">Nama</td>
                    <td class="text-center">No Telfon</td>
                    <td class="text-center">Alamat</td>
                    <td class="text-center">Produk</td>
                    <td class="text-center">Jumlah</td>
                    <td class="text-center">Total</td>
                    <td class="text-center">Aksi</td>
                </thead>
                <?php
                $no = 1;
                    foreach($product as $row) :
                ?>
                <tbody>
                    <td style="display: none;" class="text-center"><?= $no ?></td>
                    <td class="text-center"><?= tgl_indo(date('Y-m-d', strtotime($row["tanggal"]))) ?></td>
                    <td class="text-center"><?= $row["nama"] ?></td>
                    <td class="text-center"><?= $row["nomer_telfon"] ?></td>
                    <td class="text-center"><?= $row["alamat"] ?></td>
                    <td class="text-center"><?= $row["produk"] ?></td>
                    <td class="text-center"><?= $row["jumlah"] ?></td>
                    <td class="text-center"><?= $row["total"] ?></td>
                    <td class="text-center aksi-print">
                        <button type="button" class="btn btn-warning mb-2" data-bs-toggle="modal" data-bs-target="#edit_pembeli<?= $no ?>">
                            <i class="fa-solid fa-pen-to-square text-light"></i>
                        </button>
                        <button type="button" class="btn btn-danger mb-2" data-bs-toggle="modal" data-bs-target="#hapus_pembeli<?= $no ?>">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </td>
                </tbody>

                <!--Modal edit -->
                <div class="modal fade" id="edit_pembeli<?= $no ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="edit_pembeliLabel" aria-hidden="true">
                    <div class="modal-dialog">
                    <div class="modal-content">
                        <div style="background-color: #D4C5E3;" class="modal-header">
                        <h5 class="modal-title text-light" id="edit_pembeliLabel">Edit Pembeli</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                        <form action="" method="post" enctype="multipart/form-data">
                                <input type="hidden" id="id" name="id" value="<?= $row["id"] ?>">
                                <div class="col mt-2">
                                    <label class="mb-2" for="">Tanggal</label>
                                    <input class="form-control" id="tanggal" name="tanggal" type="date" value="<?= $row["tanggal"] ?>" required>
                                </div>
                                <div class="col mt-2">
                                    <label class="mb-2" for="">Nama</label>
                                    <input class="form-control" id="nama" name="nama" type="text" value="<?= $row["nama"] ?>" required>
                                </div>
                                <div class="col mt-2">
                                    <label class="mb-2" for="">Nomer Telfon</label>
                                    <input class="form-control" id="nomer_telfon" name="nomer_telfon" type="number" value="<?= $row["nomer_telfon"] ?>" required>
                                </div>
                                <div class="col mt-2">
                                    <label class="mb-2" for="">Alamat</label>
                                    <textarea class="form-control" id="alamat" name="alamat" rows="3" value="<?= $row["alamat"] ?>" required></textarea>
                                </div>
                                <div class="col mt-2">
                                    <label class="mb-2" for="">Produk</label>
                                    <input class="form-control" id="produk" name="produk" type="text" value="<?= $row["produk"] ?>" required>
                                </div>
                                <div class="col mt-2">
                                    <label class="mb-2" for="">Jumlah</label>
                                    <input class="form-control" id="jumlah" name="jumlah" type="number" value="<?= $row["jumlah"] ?>" required>
                                </div>
                                <div class="col mt-2">
                                    <label class="mb-2" for="">Total</label>
                                    <input class="form-control" id="total" name="total" type="number" value="<?= $row["total"] ?>" required>
                                </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-end gap-2 flex-row">
                            <button type="button" class="btn btn-warning" data-bs-dismiss="modal">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                            <button type="submit" class="btn btn-success" id="edit_pembeli" name="edit_pembeli">Ubah</button>
                        </form>
                        </div>
                    </div>
                    </div>
                </div>

                <!--Modal Hapus -->
                <form action="" method="post">
                    <div class="modal fade" id="hapus_pembeli<?= $no ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="hapus_pembeliLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header" style="background-color: #D4C5E3;">
                                <h5 class="modal-title text-light" id="hapus_pembeliLabel">Hapus Product</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="id" id="id" value="<?= $row["id"] ?>">
                                <h3>Tetap Semangat 💪 walau di Ghosting 👻<?= $row["nama"] ?>!!</h3>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-warning" data-bs-dismiss="modal"><i class="fa-solid fa-print"></i></button>  
                                <button class="btn btn-success" type="submit" id="hapus_pembeli" name="hapus_pembeli">💪 Semangat </button>
                            </div>
                            </div>
                        </div>
                    </div>
                </form>
                <?php
                    $no++;
                endforeach;
                ?>
            </table>
        </div>
        <div class="d-flex justify-content-end w-100 gap-2">

            <?php if ($halaman_aktif > 1 ) : ?>
                <a href="?page=<?= $halaman_aktif - 1 ?>">
                    <button class="btn"><i class="fa-solid fa-chevron-left"></i></button>
                </a>
            <?php endif ; ?>

            <?php for($i = 1 ; $i <= $jumlahHalaman; $i++) : ?>
                <?php if ($i == $halaman_aktif): ?>
                    <a href="?page=<?= $i ?>">
                        <button class="btn"><?= $i ?></button>
                    </a>
                    <?php else : ?>
                    <a href="?page=<?= $i ?>">
                        <button class="btn btn-secondary"><?= $i ?></button>
                    </a> 
                <?php endif; ?>
            <?php endfor; ?>

            <?php if ($halaman_aktif < $jumlahHalaman ) : ?>
                <a href="?page=<?= $halaman_aktif + 1 ?>">
                    <button class="btn"><i class="fa-solid fa-chevron-right"></i></button>
                </a>
            <?php endif ; ?>


        </div>
    </div>

    <!--Modal Tambah -->
    <div class="modal fade" id="tambah_pembeli" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="tambah_pembeliLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div style="background-color: #D4C5E3;" class="modal-header">
              <h5 class="modal-title text-light" id="tambah_pembeliLabel">Tambah Produk Wax</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form action="" method="post" enctype="multipart/form-data">
                    <div class="col mt-2">
                        <label class="mb-2" for="">Tanggal</label>
                        <input class="form-control" id="tanggal" name="tanggal" type="date" required >
                    </div>
                    <div class="col mt-2">
                        <label class="mb-2" for="">Nama</label>
                        <input class="form-control" id="nama" name="nama" type="text" placeholder="Masukkan nama pembeli" required >
                    </div>
                    <div class="col mt-2">
                        <label class="mb-2" for="">Nomer Telfon</label>
                        <input class="form-control" id="nomer_telfon" name="nomer_telfon" type="number" placeholder="Masukkan nomer telfon pastikan whatsapp aktif" required >
                    </div>
                    <div class="col mt-2">
                        <label class="mb-2" for="">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="3" placeholder="Masukkan Alamat dan tanyakan patokan agar mudah di cari kurir." required ></textarea>
                    </div>
                    <div class="col mt-2">
                        <label class="mb-2" for="">Produk</label>
                        <input class="form-control" id="produk" name="produk" type="text" placeholder="Nama Produk sesuai pesanan" required >
                    </div>
                    <div class="col mt-2">
                        <label class="mb-2" for="">Jumlah</label>
                        <input class="form-control" id="jumlah" name="jumlah" type="number" placeholder="Jumlah pesanan" required >
                    </div>
                    <div class="col mt-2">
                        <label class="mb-2" for="">Total</label>
                        <input class="form-control" id="total" name="total" type="number" placeholder="total" required >
                    </div>
            </div>
            <div class="modal-footer d-flex justify-content-end gap-2 flex-row">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                    <i class="fa-solid fa-xmark"></i>
                </button>
                <button type="submit" class="btn btn-success" id="pembeli" name="pembeli">Tambahkan</button>
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
            <div class="col">
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



    <!-- Modal Truncate -->
    <div class="modal fade" id="truncate" tabindex="-1" aria-labelledby="truncateLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header bg-warning" >
            <h5 class="modal-title text-light" id="truncateLabel">Kosongkan Table</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <h3>Print Data Terlebih Dahulu Sebelum Mengosongkan</h3>
        </div>
        <div class="modal-footer">
            <form action="" method="post">
                <a href="print.php" target="_blank"><button type="button" class="btn btn-warning" data-bs-dismiss="modal">Print <i class="fa-solid fa-print"></i></button></a>
                <button class="btn btn-danger" type="submit"  id="" name="truncate">
                  Kosongkan  
                </button>
            </form>
        </div>
        </div>
    </div>
    </div>
</body>
</html>