<?php
    require 'session.php';
    require '../koneksi.php';

    $id = $_GET['p'];

    $query = mysqli_query($connect, "SELECT a.*, b.nama AS nama_kategori FROM produk a JOIN kategori b ON a.kategori_id=b.id WHERE a.id = '$id'");
    $data = mysqli_fetch_array($query);
    $queriKategori = mysqli_query($connect, "SELECT * FROM kategori WHERE id != '$data[kategori_id]'");

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
    <title>Detail Produk <?php echo $data['nama']; ?></title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="../css/trix.css">
</head>
<body>
    <?php
        require 'navbar.php';
    ?>

    <main class="container my-5">
        <h2>Detail Produk</h2>

        <section class="col-12 col-lg-6">
            <form action="" method="post" enctype="multipart/form-data">

                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" id="nama" name="nama" value="<?php echo $data['nama']; ?>" class="form-control" autocomplete="off" required>
                </div>

                <div class="mb-3">
                    <label for="kategori" class="form-label">Kategori</label>
                    <select name="kategori" id="kategori" class="form-control" required>
                        <option value="<?php echo $data['id']; ?>">
                            <?php echo $data['nama_kategori'] ?>
                        </option>
                        <?php
                            while ($dataKategori = mysqli_fetch_array($queriKategori)) {
                                ?>
                                    <option value="<?php echo $dataKategori['id']; ?>">
                                        <?php echo $dataKategori['nama']; ?>
                                    </option>
                                <?php
                            }
                            ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="harga" class="form-label">Harga</label>
                    <input type="number" id="harga" name="harga" value="<?php echo $data['harga']; ?>" class="form-control" autocomplete="off" required>
                </div>

                <div class="mb-3">
                    <label for="currentFoto" class="form-label">Foto Produk Sekarang</label>
                    <div class="col-lg-6 col-md-8 d-block">
                        <img src="../image/<?php echo $data['foto']; ?>" alt="<?php echo $data['nama']; ?>" class="img-fluid img-thumbnail">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="foto" class="form-label">Foto</label>
                    <input type="file" name="foto" id="foto" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="detail" class="form-label">Detail</label>
                    <input type="hidden" id="detail" value="<?php echo $data['detail']; ?>" name="detail">
                    <trix-editor input="detail"></trix-editor>
                </div>

                <div class="mb-3">
                    <label for="ketersedia_stok" class="form-label">Ketersedia Stok</label>
                    <select name="ketersediaan_stok" class="form-control" id="ketersedian_stok">
                        <option value="<?php echo $data['ketersediaan_stok'] ?>">
                            <?php echo $data['ketersediaan_stok'] ?>
                        </option>
                        <?php
                            if ($data['ketersediaan_stok'] == 'tersedia') {
                                ?>
                                    <option value="habis">Habis</option>
                                <?php
                            } else {
                                ?>
                                    <option value="tersedia">Tersedia</option>
                                <?php
                            }
                        ?>
                    </select>
                </div>

                <div class="mb-3 d-flex justify-content-between">
                    <a href="produk.php" class="btn btn-primary">Back</a>
                    <button type="submit" class="btn btn-success" name="update">Update</button>
                    <button type="submit" class="btn btn-danger" name="hapus">Hapus</button>
                </div>

            </form>


            <?php
                if (isset($_POST['update'])) {
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
                        $queriUpdate = mysqli_query($connect, "UPDATE produk SET kategori_id='$kategori', nama='$nama', harga='$harga', detail='$detail', ketersediaan_stok='$ketersediaan_stok' WHERE id='$id'");

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

                                    $queriUpdate = mysqli_query($connect, "UPDATE produk SET foto='$new_name' WHERE id='$id'");

                                    if ($queriUpdate) {
                                        ?>
                                            <div class="alert alert-success" role="alert">
                                                Produk berhasil dihapus
                                            </div>
                                            <meta http-equiv="refresh" content="2; url=produk.php">
                                        <?php
                                    } else {
                                        echo mysqli_error($connect);
                                    }
                                }
                            }
                        }
                    }
                }


                if (isset($_POST['hapus'])) {
                    $queryHapus = mysqli_query($connect,"DELETE FROM produk WHERE id='$id'");
                    if ($queryHapus){
                        ?>
                            <div class="alert alert-success" role="alert">
                                Produk berhasil didelete
                            </div>
                            <meta http-equiv="refresh" content="2; url=produk.php">
                        <?php
                    } else {
                        echo mysqli_error($connect);
                    }
                }
            ?>

        </section>
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