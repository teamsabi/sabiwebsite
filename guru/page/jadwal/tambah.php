<?php
require_once '../../layout/top.php';
require_once '../../helper/conek.php';

$id_jadwal = '';
$hari = '';
$tanggal = '';
$tempat= '';
$nama_kelas = '';
$mapel = '';    
$jam_mulai = '';
$jam_selesai = '';
$nama_guru = '';
$kelasjadwal = mysqli_query($conn, "SELECT nama_kelas FROM kelas");
$gurukelas = mysqli_query($conn, "SELECT nama_guru FROM guru");
$nama_mapel = mysqli_query($conn, "SELECT nama_mapel FROM mapel");

// Mengecek apakah ada parameter 'ubah' di URL
if (isset($_GET['ubah'])) {
    $id_jadwal = $_GET['ubah'];

    // Query untuk mengambil data berdasarkan ID jadwal
    $query = "SELECT * FROM jadwal WHERE id_jadwal = '$id_jadwal'";
    $sql = mysqli_query($conn, $query);
    
    // Cek apakah data ditemukan
    if (mysqli_num_rows($sql) > 0) {
        $result = mysqli_fetch_assoc($sql);
        
        // Ambil data dari database
        $hari = $result['hari'];
        $tanggal = $result['tanggal'];
        $tempat = $result['tempat'];
        $nama_kelas = $result['nama_kelas'];
        $mapel = $result['mapel'];
        $jam_mulai = $result['jam_mulai'];
        $jam_selesai = $result['jam_selesai'];
        $nama_guru = $result['nama_guru'];
    } else {
        echo "Data tidak ditemukan!";
        exit;
    }
}
?>


<!--Content body start-->
<div class="content-body">
    <div class="container">
        <form method="POST" action="proses.php">
            <div class="row justify-content-center">
                <div class="col-md-11">
                    <div class="card">
                        <div class="card-header mb-4">
                            <h4 class="card-title">Tambah Jadwal Mengajar</h4>
                        </div>
                        <div class="card-body">
                            <input type="hidden" value="<?php echo $id_jadwal; ?>" name="id_jadwal">
                            <div class="form-group row">
                                <label for="hari" class="col-sm-3 col-form-label">Hari</label>
                                <div class="col-sm-9">
                                    <select id="hari" name="hari" class="form-control">
                                        <option selected disabled>Pilih Hari</option>
                                        <option value="Senin">Senin</option>
                                        <option value="Selasa">Selasa</option>
                                        <option value="Rabu">Rabu</option>
                                        <option value="Kamis">Kamis</option>
                                        <option value="Jumat">Jumat</option>
                                        <option value="Sabtu">Sabtu</option>
                                        <option value="Minggu">Minggu</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="tanggal" class="col-sm-3 col-form-label">Tanggal</label>
                                <div class="col-sm-9">
                                    <input required type="date" name="tanggal" class="form-control" id="tanggal" value="<?php echo $tanggal; ?>" min="<?php echo date('Y-m-d'); ?>">
                                </div>
                            </div> 
                            <div class="form-group row">
                                <label for="tempat" class="col-sm-3 col-form-label">Tempat</label>
                                <div class="col-sm-9">
                                    <input required type ="text" name="tempat" class="form-control" id="tempat" placeholder="Masukkan Tempat" value="<?php echo $tempat;?>">
                                </div>
                            </div> 
                            <div class="form-group row">
                                <label for="kelassiswa" class="col-sm-3 col-form-label">Kelas</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="nama_kelas" id="kelassiswa" required>
                                        <option value="">--Pilih Kelas--</option>
                                        <?php
                                        while ($r = mysqli_fetch_array($kelasjadwal)) :
                                        ?>
                                        <option value="<?= $r['nama_kelas'] ?>"><?= $r['nama_kelas'] ?></option>
                                        <?php
                                        endwhile;
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nama_mapel" class="col-sm-3 col-form-label">Mata Pelajaran</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="mapel" id="nama_mapel" required>
                                        <option value="">--Pilih Mata Pelajaran--</option>
                                        <?php
                                        while ($r = mysqli_fetch_array($nama_mapel)) :
                                        ?>
                                        <option value="<?= $r['nama_mapel'] ?>"><?= $r['nama_mapel'] ?></option>
                                        <?php
                                        endwhile;
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="jamMulai" class="col-sm-3 col-form-label">Jam Mulai</label>
                                <div class="col-sm-9">
                                    <input type="time" name="jam_mulai" class="form-control" id="jamMulai" value="<?php echo $jam_mulai;?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="jamSelesai" class="col-sm-3 col-form-label">Jam Selesai</label>
                                <div class="col-sm-9">
                                    <input type="time" name="jam_selesai" class="form-control" id="jamSelesai" value="<?php echo $jam_selesai;?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="gurukelas" class="col-sm-3 col-form-label">Nama Guru</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="nama_guru" id="gurukelas" required>
                                        <option value="">--Pilih Guru Pengajar--</option>
                                        <?php
                                        while ($r = mysqli_fetch_array($gurukelas)) :
                                        ?>
                                        <option value="<?= $r['nama_guru'] ?>"><?= $r['nama_guru'] ?></option>
                                        <?php
                                        endwhile;
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <?php if (isset($_GET['ubah'])) { ?>
                                <button type="submit" name="aksi" value="edit" class="btn btn-sm" style="background-color: #229799; color: white;">
                                    <i class="fa fa-floppy-o"></i> Simpan Perubahan
                                </button>
                            <?php } else { ?>
                                <button type="submit" name="aksi" value="add" class="btn btn-sm" style="background-color: #229799; color: white;">
                                    <i class="fa fa-floppy-o"></i> Simpan
                                </button>
                            <?php } ?>
                            <a href="Jadwal.php" type="button" class="btn btn-danger btn-sm">
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