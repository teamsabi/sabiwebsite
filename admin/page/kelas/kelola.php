<?php
require_once '../../layout/top.php';
require_once '../../helper/config.php';

$kode_kelas = '';
$nama_kelas = '';
$jumlah_siswa = '';

if(isset($_GET['ubah'])){
    $kode_kelas = $_GET['ubah'];

    $query = "SELECT * FROM kelas WHERE kode_kelas = '$kode_kelas';";
    $sql = mysqli_query($conn, $query);

    $result = mysqli_fetch_assoc($sql);

    $kode_kelas = $result['kode_kelas'];
    $nama_kelas = $result['nama_kelas'];

} else {
    $query = "SELECT kode_kelas FROM kelas ORDER BY kode_kelas DESC LIMIT 1;";
    $sql = mysqli_query($conn, $query);
    $result = mysqli_fetch_assoc($sql);

    if ($result) {
        $last_number = intval(substr($result['kode_kelas'], 3));
        $next_number = $last_number + 1;
    } else {
        $next_number = 1;
    }

    $kode_kelas = 'KLS' . str_pad($next_number, 3, '0', STR_PAD_LEFT);
}
?>

<!--Content body start-->
<div class="content-body">
    <div class="container">
        <form method="POST" action="proses.php" enctype="multipart/form-data">
            <div class="row justify-content-center">
                <div class="col-md-11">
                    <div class="card">
                        <div class="card-header mb-4">
                            <h4 class="card-title">Tambah Data Kelas</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="kodekelas" class="col-sm-3 col-form-label">Kode Kelas</label>
                                <div class="col-sm-9">
                                    <input required type="text" name="kode_kelas" class="form-control" id="kodekelas" value="<?php echo $kode_kelas; ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="namakelas" class="col-sm-3 col-form-label">Nama Kelas</label>
                                <div class="col-sm-9">
                                    <input required type="text" name="nama_kelas" class="form-control" id="namakelas" placeholder="Masukkan Nama Kelas" value="<?php echo $nama_kelas; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <?php
                                if(isset($_GET['ubah'])){ 
                            ?>
                                <button type="submit" name="aksi" value="edit" class="btn btn-success btn-sm">
                                    <i class="fa fa-floppy-o"></i> Simpan Perubahan
                                </button>
                            <?php
                                } else {
                            ?>
                                <button type="submit" name="aksi" value="add" class="btn btn-success btn-sm">
                                    <i class="fa fa-floppy-o"></i> Simpan
                                </button>
                            <?php
                                }
                            ?>
                            <a href="Kelas.php" type="button" class="btn btn-danger btn-sm">
                                <i class="fa fa-reply"></i> Batal
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!--Content body end-->

<?php
require_once '../../layout/footer.php';
?>
