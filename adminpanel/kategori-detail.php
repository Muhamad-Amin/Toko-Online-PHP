<?php
    require 'session.php';
    require '../koneksi.php';

    $id = $_GET['p'];

    $query = mysqli_query($connect, "SELECT * FROM kategori WHERE id = '$id'");
    $data = mysqli_fetch_array($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Kategori <?php echo $data['nama'] ?></title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
</head>
<body>
    
    <?php
        require 'navbar.php';
    ?>

    <main class="container mt-5">
        <h2>Detail Kategori</h2>

        <section class="col-12 col-lg-6">
            <form action="" method="post">
                <div class="mb-3">
                    <label for="kategori" class="form-label">Kategori</label>
                    <input type="text" name="kategori" class="form-control" id="kategori" value="<?php echo $data['nama'] ?>">
                </div>
                <div class="mb-3 d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary" name="editBtn">Edit</button>
                    <button type="submit" class="btn btn-danger" name="deleteBtn">Delete</button>
                </div>
            </form>

            <?php
                if (isset($_POST['editBtn'])) {
                    $kategori = htmlspecialchars($_POST['kategori']);

                    if ($data['nama'] == $kategori) {
                        ?>
                            <meta http-equiv="refresh" content="0; url=kategori.php">
                        <?php
                    } else {
                        $query = mysqli_query($connect, "SELECT * FROM kategori WHERE nama='$kategori'");
                        $jumlahData = mysqli_num_rows($query);

                        if ($jumlahData > 0) {
                            ?>
                                <div class="alert alert-danger" role="alert">
                                    Kategori sudah ada
                                </div>
                            <?php   
                        } else {
                            $querySimpan = mysqli_query($connect, "UPDATE kategori SET nama = '$kategori' WHERE id='$id'");
                            if($querySimpan){
                                ?>
                                    <div class="alert alert-success" role="alert">
                                        Kategori berhasil diupdate
                                    </div>
                                    <meta http-equiv="refresh" content="2; url=kategori.php">
                                <?php
                            } else {
                                echo mysqli_errno($connect);
                            }
                        }
                    }
                }
            
                if (isset($_POST['deleteBtn'])) {
                    // Aktifkan kode yang ada di ../delete/restric.php jika menggunakan on delete restric dan tempel kode itu di bawah

                    $queryDelete = mysqli_query($connect, "DELETE FROM kategori WHERE id='$id'");
                        if ($queryDelete){
                            ?>
                                <div class="alert alert-success" role="alert">
                                    Kategori berhasil didelete
                                </div>
                                <meta http-equiv="refresh" content="2; url=kategori.php">
                            <?php
                        } else {
                            echo mysqli_error($connect);
                        }
                }
            ?>
        </section>
    </main>

    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>