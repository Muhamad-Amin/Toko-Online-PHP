<?php
    require 'koneksi.php';

    $queryProduk = mysqli_query($connect, "SELECT id, nama, harga, foto, detail FROM produk LIMIT 6");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Online | Home</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php
        require 'navbar.php';
    ?>

    <!-- Banner Start -->
    <section class="container-fluid d-flex align-items-center banner">
        <div class="container text-center text-white">
            <h1>Toko Online</h1>
            <h3>Mau Cari Apa?</h3>
            <div class="col-md-8 offset-md-2">
                <form action="produk.php" method="get">
                    <div class="input-group input-group-lg my-4">
                        <input type="text" class="form-control" placeholder="Nama Barang" aria-label="Nama Barang" aria-describedby="basic-addon2" name="keyword" autocomplete="off">
                        <button type="submit" class="input-group-text btn warna2 text-white">Telusuri</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- Banner End -->


    <!-- Higlighted Kategori Start -->
    <section class="container-fluid py-5">
        <div class="container text-center">
            <h3>Kategori Terlaris</h3>

            <div class="row mt-5">

                <div class="col-md-4 mb-3">
                    <div class="highlighted-kategori kategori-baju-pria d-flex align-items-center justify-content-center">
                        <h4>
                            <a href="produk.php?kategori=Baju Pria" class="text-decoration-none text-white">Baju Pria</a>
                        </h4>
                    </div>
                </div>
                
                <div class="col-md-4 mb-3">
                    <div class="highlighted-kategori kategori-baju-wanita d-flex align-items-center justify-content-center">
                        <h4>
                            <a href="produk.php?kategori=Baju Wanita" class="text-decoration-none text-white">Baju Wanita</a>
                        </h4>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="highlighted-kategori kategori-sepatu d-flex align-items-center justify-content-center">
                        <h4>
                            <a href="produk.php?kategori=Sepatu" class="text-decoration-none text-white">Sepatu</a>
                        </h4>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- Higlighted Kategori End -->


    <!-- Tentang Kami Start -->
    <section class="container-fluid warna3 py-5">
        <div class="container text-center">
            <h3>Tentang Kami</h3>
            <p class="fs-5 mt-3">
                Lorem ipsum, dolor sit amet consectetur adipisicing elit. Odit nesciunt ducimus minus nobis doloribus odio nam debitis facilis totam perspiciatis vitae repellat id eius, corrupti nulla consectetur qui blanditiis cupiditate alias repudiandae praesentium quae sint veritatis! Totam optio quidem deleniti praesentium quis amet nam dignissimos autem dicta nulla laboriosam quam maiores odio atque, dolore magni similique voluptatum, fuga repellat. Modi reiciendis saepe error consectetur inventore accusantium provident veniam rerum, amet qui atque, iure minima animi sapiente deleniti dolorum mollitia illum!
            </p>
        </div>
    </section>
    <!-- Tentang Kami End -->


    <!-- Produk Start -->
    <section class="container-fluid py-5">
        <div class="container text-center">
            <h3>Produk</h3>

            <div class="row mt-5">

                <?php while ($data = mysqli_fetch_array($queryProduk)) { ?>
                <div class="col-sm-6 col-md-4 mb-3">
                    <div class="card h-100">
                        <div class="image-box">
                            <img src="image/<?php echo $data['foto']; ?>" class="card-img-top" alt="<?php echo$data['nama']; ?>">
                        </div>
                        <div class="card-body">
                            <h4 class="card-title"><?php echo$data['nama']; ?></h4>
                            <p class="card-text text-truncate">
                                <?php echo$data['detail']; ?>
                            </p>
                            <p class="card-text text-harga">Rp <?php echo$data['harga']; ?></p>
                            <a href="produk-detail.php?nama=<?php echo $data['nama'] ?>" class="btn warna2 text-white">Lihat Detail</a>
                        </div>
                    </div>
                </div>
                <?php } ?>

            </div>

            <a href="produk.php" class="btn btn-outline-warning mt-3">See More</a>
        </div>
    </section>
    <!-- Produk End -->

    <?php
        require 'footer.php';
    ?>

    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="fontawesome/js/all.min.js"></script>
</body>
</html>