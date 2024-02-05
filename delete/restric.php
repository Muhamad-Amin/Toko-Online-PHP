$queriCheck = mysqli_query($connect, "SELECT * FROM produk WHERE kategori_id='$id'");
                    $dataCount = mysqli_num_rows($queriCheck);
                    if($dataCount > 0) {
                        ?>
                            <div class="alert alert-danger" role="alert">
                                Kategori tidak bisa dihapus, karena sudah digunakan di produk
                            </div>
                        <?php
                    }