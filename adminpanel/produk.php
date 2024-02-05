<?php
    require 'session.php';
    require '../koneksi.php';

    $queri = mysqli_query($connect, "SELECT a.*, b.nama AS nama_kategori FROM produk a JOIN kategori b ON a.kategori_id=b.id");
    $jumlahProduk = mysqli_num_rows($queri);

    $queriKategori = mysqli_query($connect, "SELECT * FROM kategori");

    function generateRandomString($length = 10){
        $characters  = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i=0; $i < $length; $i++) { 
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
?>  
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="../css/trix.css">
</head>
<body>
    
    <?php
        require 'navbar.php';
    ?>

    <main class="container mt-5">

        <nav aria-label="breadcrumb" style="--bs-breadcrumb-divider: '>' ;">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                    <a href="index.php" class="text-decoration-none text-mute">
                        <i class="fas fa-home"></i> Home
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <a href="produk.php" class="text-decoration-none text-secondary">Produk</a>
                </li>
            </ol>
        </nav>

        <!-- tambah produk Start -->
        <section class="my-5 col-12 col-lg-6">
            <h3>Tambah Produk</h3>

            <form action="" method="post" enctype="multipart/form-data">

                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" id="nama" name="nama" class="form-control" autocomplete="off" required>
                </div>

                <div class="mb-3">
                    <label for="kategori" class="form-label">Kategori</label>
                    <select name="kategori" id="kategori" class="form-control" required>
                        <option value="">Pilih Satu</option>
                        <?php
                            while ($data = mysqli_fetch_array($queriKategori)) {
                                ?>
                                    <option value="<?php echo $data['id']; ?>">
                                        <?php echo $data['nama']; ?>
                                    </option>
                                    <?php
                            }
                            ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="harga" class="form-label">Harga</label>
                    <input type="number" id="harga" name="harga" class="form-control" autocomplete="off" required>
                </div>

                <div class="mb-3">
                    <label for="foto" class="form-label">Foto</label>
                    <input type="file" name="foto" id="foto" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="detail" class="form-label">Detail</label>
                    <input type="hidden" id="detail" name="detail">
                    <trix-editor input="detail"></trix-editor>
                </div>

                <div class="mb-3">
                    <label for="ketersedia_stok" class="form-label">Ketersedia Stok</label>
                    <select name="ketersediaan_stok" class="form-control" id="ketersedian_stok">
                        <option value="tersedia">Tersedia</option>
                        <option value="habis">Habis</option>
                    </select>
                </div>

                <div class="mb-3">
                    <button type="submit" class="btn btn-primary" name="simpan">Simpan</button>
                </div>

            </form>


            <?php
                if (isset($_POST['simpan'])) {
                    $nama = htmlspecialchars($_POST['nama']);
                    $kategori = htmlspecialchars($_POST['kategori']);
                    $harga = htmlspecialchars($_POST['harga']);
                    $detail = htmlspecialchars($_POST['detail']);
                    $ketersediaan_stok = htmlspecialchars($_POST['ketersediaan_stok']);

                    $target_dir = "../image/";
                    $nama_file = basename($_FILES["foto"]["name"]);
                    $target_file = $target_dir . $nama_file;
                    $imageFileType =  strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                    $image_size = $_FILES["foto"] ["size"];
                    $random_name = generateRandomString(20);
                    $new_name = $random_name .'.'.$imageFileType;


                    if ($nama == '' || $kategori == '' || $harga == '') {
                        ?>
                            <div class="alert alert-danger mt-3" role="alert">
                                Nama, Kategori dan Harga wajib di isi
                            </div>
                        <?php
                    } else {
                        if ($nama_file != '') {
                            if ($image_size > 11000000) {
                                ?>
                                    <div class="alert alert-danger mt-3" role="alert">
                                        File tidak boleh lebih dari 10 MB
                                    </div>
                                <?php
                            } else {
                                if ($imageFileType != 'jpg' && $imageFileType != 'png' && $imageFileType != 'gif') {
                                    ?>
                                        <div class="alert alert-danger mt-3" role="alert">
                                            File Wajib bertipe jpg atau png atau gif
                                        </div>
                                    <?php
                                } else {
                                    move_uploaded_file($_FILES["foto"]["tmp_name"], $target_dir . $new_name);
                                }
                            }
                        }

                        // queri insert to produk table
                        $queriTambah = mysqli_query($connect, "INSERT INTO produk (kategori_id, nama, harga, foto, detail, ketersediaan_stok) VALUES ('$kategori', '$nama', '$harga', '$new_name', '$detail', '$ketersediaan_stok')");

                        if ($queriTambah) {
                            ?>
                                <div class="alert alert-success" role="alert">
                                    Produk berhasil tersimpan
                                </div>
                                <meta http-equiv="refresh" content="2; url=produk.php">
                            <?php
                        } else {
                            echo mysqli_error($connect);
                        }
                    }
                }
            

            ?>

        </section>
        <!-- tambah produk End -->

        <!-- List Produk Start -->
        <section class="mt-3 mb-5">
            <h2>List Produk</h2>
            
            <div class="table-responsive mt-5">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Ketersedian Stok</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if ($jumlahProduk == 0) {
                                ?>
                                    <tr>
                                        <td colspan="6" class="text-center">Data Produk Tidak Tersedia</td>
                                    </tr>
                                        
                                <?php
                            } else {
                                $jumlah = 1;
                                while ($data=mysqli_fetch_array($queri)) {
                                    ?>
                                        <tr>
                                            <td><?php echo $jumlah; ?></td>
                                            <td><?php echo $data['nama']; ?></td>
                                            <td><?php echo $data['nama_kategori']; ?></td>
                                            <td>Rp <?php echo $data['harga']; ?></td>
                                            <td><?php echo $data['ketersediaan_stok']; ?></td>
                                            <td>
                                                <a href="produk-detail.php?p=<?php echo $data['id'] ?>" class="btn btn-info">
                                                    <i class="fas fa-search"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php
                                    $jumlah++;
                                }
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </section>
        <!-- List Produk End -->

    </main>


    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome/js/all.min.js"></script>
    <script src="../js/trix.js"></script>
    <script>
        document.addEventListener('trix-file-accept', function(e) {
            e.preventDefault();
        });
    </script>
</body>
</html>