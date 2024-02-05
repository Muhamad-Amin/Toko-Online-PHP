<?php
    require 'koneksi.php';

    $nama = htmlspecialchars($_GET['nama']);

    $queryProduk = mysqli_query($connect, "SELECT * FROM produk WHERE nama = '$nama'");
    $produk = mysqli_fetch_array($queryProduk);

    $queryProdukTerkait = mysqli_query($connect, "SELECT * FROM produk WHERE kategori_id = '$produk[kategori_id]' AND id != '$produk[id]' LIMIT 4");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Online | Detail Produk <?php echo $produk['nama']; ?></title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    
    <?php
        require 'navbar.php';
    ?>


    <main class="container-fluid py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <img src="image/<?php echo $produk['foto']; ?>" class="w-100" alt="<?php echo $produk['nama']; ?>">
                </div>
                <div class="col-lg-7 offset-lg-1">
                    <h1 class="my-3"><?php echo $produk['nama']; ?></h1>

                    <p class="fs-5">
                        <?php echo $produk['detail']; ?>
                    </p>

                    <p class="text-harga">
                        Rp <?php echo $produk['harga']; ?>
                    </p>

                    <p class="fs-5">Ketersediaan : <strong><?php echo $produk['ketersediaan_stok']; ?></strong></p>

                    <a href="https://whatsapp.com" class="btn btn-outline-success fs-5">
                        Beli <i class="fab fa-whatsapp"></i>
                    </a>
                </div>
            </div>
        </div>
    </main>


    <!-- Produk Terkait Start -->
    <section class="container-fluid py-5 warna2">
        <div class="container">
            <h2 class="text-center text-white mb-5">Produk Terkait</h2>

            <div class="row justify-content-center">
                <?php while ($produkTerkait = mysqli_fetch_array($queryProdukTerkait)) { ?>
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                        <a href="produk-detail.php?nama=<?php echo $produkTerkait['nama']; ?>">
                            <img src="image/<?php echo $produkTerkait['foto'] ?>" class="img-fluid img-thumbnail produk-terkait-image" alt="<?php echo $produkTerkait['nama'] ?>">
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
    <!-- Produk Terkait End -->


    <?php
        require 'footer.php';
    ?>

    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="fontawesome/js/all.min.js"></script>
</body>
</html>