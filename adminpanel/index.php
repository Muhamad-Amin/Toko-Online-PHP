<?php
    require 'session.php';
    require '../koneksi.php';

    $queryKategori = mysqli_query($connect, "SELECT * FROM kategori");
    $jumlahKategori = mysqli_num_rows($queryKategori);

    $queryProduk = mysqli_query($connect, "SELECT * FROM produk");
    $jumlahProduk = mysqli_num_rows($queryProduk);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/fontawesome.min.css">
    <style>
        .summary-kategory{
            background-color: #0a6b4a;
            border-radius: 15px;
        }

        .summary-produk {
            background-color: #0a516b;
            border-radius: 15px;
        }
    </style>
</head>
<body>
    <?php
        require 'navbar.php';
    ?>

    <section class="container mt-5">
        <nav aria-label="breadcrumb" style="--bs-breadcrumb-divider: '>' ;">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                    <a href="index.php" class="text-decoration-none text-secondary">
                        <i class="fas fa-home"></i> Home
                    </a>
                </li>
            </ol>
        </nav>
        <h2>Halo <?php echo $_SESSION['username']; ?></h2>

        <div class="container mt-5">
            <div class="row">

                <div class="col-lg-4 col-md-6 col-12 mb-3">
                    <div class="summary-kategory p-3">
                        <div class="row">
                            <div class="col-6">
                                <i class="fas fa-align-justify fa-7x text-black-50"></i>
                            </div>
                            <div class="col-6 text-white">
                                <h3 class="fs-2">Kategori</h3>
                                <p class="fs-4"><?php echo $jumlahKategori ?> Kategori</p>
                                <p>
                                    <a href="kategori.php" class="text-white text-decoration-none">Lihat detail</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-12 mb-3">
                    <div class="summary-produk p-3">
                        <div class="row">
                            <div class="col-6">
                                <i class="fas fa-box fa-7x text-black-50"></i>
                            </div>
                            <div class="col-6 text-white">
                                <h3 class="fs-2">Produk</h3>
                                <p class="fs-4"><?php echo $jumlahProduk ?> produk</p>
                                <p>
                                    <a href="produk.php" class="text-white text-decoration-none">Lihat detail</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome/js/all.min.js"></script>
</body>
</html>