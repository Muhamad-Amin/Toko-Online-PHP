<?php
    require 'koneksi.php';

    $queriKategori = mysqli_query($connect, "SELECT * FROM kategori");
    
    // get produk by nama produk/keyword
    if (isset($_GET['keyword'])) {
        $queryProduk = mysqli_query($connect, "SELECT * FROM produk WHERE nama LIKE '%$_GET[keyword]%'");
    }

    // get produk by kategori
    else if (isset($_GET['kategori'])) {
        $queryGetKategoriId = mysqli_query($connect, "SELECT id FROM kategori WHERE nama='$_GET[kategori]'");
        $kategoriId = mysqli_fetch_array($queryGetKategoriId);

        $queryProduk = mysqli_query($connect, "SELECT * FROM produk WHERE kategori_id = '$kategoriId[id]'");
    }
    
    // get produk default
    else {
        $queryProduk = mysqli_query($connect, "SELECT * FROM produk");
    }

    $countData = mysqli_num_rows($queryProduk);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Online | Produk</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php
        require 'navbar.php';
    ?>


    <!-- Banner Start -->
    <section class="container-fluid banner-produk d-flex align-items-center">
        <div class="container">
            <h1 class="text-white text-center">Produk</h1>
        </div>
    </section>
    <!-- Banner End -->


    <!-- Body Start -->
    <section class="container-fluid py-5">
        <div class="container">
            <div class="row">

                <div class="col-lg-3">
                    <ul class="list-group">
                        <a href="produk.php" class="text-decoration-none">
                            <li class="list-group-item">
                                All
                            </li>
                        </a>
                        <?php while ($kategori = mysqli_fetch_array($queriKategori)) { ?>
                            <a href="produk.php?kategori=<?php echo $kategori['nama'];?>" class="text-decoration-none">
                                <li class="list-group-item">
                                    <?php echo $kategori['nama']; ?>
                                </li>
                            </a>
                        <?php } ?>
                    </ul>
                </div>

                <div class="col-lg-9">
                    <h3 class="text-center my-3">Produk</h3>

                    <div class="row">

                        <?php if ($countData < 1) {
                            ?>
                                <h4 class="text-center my-5">Produk Yang Anda Cari Tidak Tersedia</h4>
                            <?php
                        } ?>

                        <?php while ($produk = mysqli_fetch_array($queryProduk)) { ?>
                            <div class="col-sm-6 col-md-4 mb-3">
                                <div class="card h-100">
                                    <div class="image-box">
                                        <img src="image/<?php echo $produk['foto'] ?>" class="card-img-top" alt="<?php echo $produk['nama'] ?>">
                                    </div>
                                    <div class="card-body">
                                        <h4 class="card-title"><?php echo $produk['nama'] ?></h4>
                                        <p class="card-text text-truncate">
                                        <?php echo $produk['detail'] ?>
                                        </p>
                                        <p class="card-text text-harga">Rp <?php echo $produk['harga'] ?></p>
                                        <a href="produk-detail.php?nama=<?php echo $produk['nama'] ?>" class="btn warna2 text-white">Lihat Detail</a>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- Body End -->


    <?php
        require 'footer.php';
    ?>

    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="fontawesome/js/all.min.js"></script>
</body>
</html>