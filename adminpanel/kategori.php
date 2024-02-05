<?php
    require 'session.php';
    require '../koneksi.php';

    $queryKategori = mysqli_query($connect, "SELECT * FROM kategori");
    $jumlahKategori = mysqli_num_rows($queryKategori);
?>    
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategori</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/fontawesome.min.css">
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
                    <a href="kategori.php" class="text-decoration-none text-secondary">Kategori</a>
                </li>
            </ol>
        </nav>

        <section class="my-5 col-12 col-lg-6">
            <h3>Tambah Kategori</h3>

            <form action="" method="post">
                <div class="mb-3">
                    <label for="kategori" class="form-label">Kategori</label>
                    <input type="text" id="kategory" name="kategori" placeholder="input name kategori" class="form-control" autocomplete="off">
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary" name="simpan_kategori">Simpan</button>
                </div>
            </form>

            <?php
                if (isset($_POST['simpan_kategori'])) {
                    $kategori = htmlspecialchars($_POST['kategori']);

                    $queryExist = mysqli_query($connect, "SELECT nama FROM kategori WHERE nama='$kategori'");
                    $jumlahDataKategoriBaru = mysqli_num_rows($queryExist);

                    if ($jumlahDataKategoriBaru > 0) {
                        ?>
                            <div class="alert alert-danger" role="alert">
                                Kategori sudah ada
                            </div>
                        <?php    
                    } else {
                        $querySimpan = mysqli_query($connect, "INSERT INTO kategori (nama) VALUES ( '$kategori')");
                        if($querySimpan){
                            ?>
                                <div class="alert alert-success" role="alert">
                                    Kategori berhasil tersimpan
                                </div>
                                <meta http-equiv="refresh" content="2; url=kategori.php">
                            <?php
                        } else {
                            echo mysqli_errno($connect);
                        }
                    }
                }
            ?>
        </section>

        <section class="mt-3">
            <h2>List Kategori</h2>

            <div class="table-responsive mt-5">
                <table class="table">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>Nama</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if ($jumlahKategori == 0) {
                                ?>
                                    <tr>
                                        <td colspan="3" class="text-center">Data Kategori Tidak Tersedia</td>
                                    </tr>
                                <?php
                            } else {
                                $jumlah = 1;
                                while ($data=mysqli_fetch_array($queryKategori)){
                                    ?>
                                        <tr>
                                            <td>
                                                <?php echo $jumlah; ?>
                                            </td>
                                            <td>
                                                <?php echo $data['nama'] ?>
                                            </td>
                                            <td>
                                                <a href="kategori-detail.php?p=<?php echo $data['id'] ?>" class="btn btn-info">
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
    </main>
    
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome/js/all.min.js"></script>
</body>
</html>