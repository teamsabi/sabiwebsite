<?php
require_once '../../helper/conek.php';

if(isset($_POST['aksi'])){
    $id_kelas = $_POST['id_kelas'];
    $kode_kelas = $_POST['kode_kelas'];
    $nama_kelas = $_POST['nama_kelas'];
    $jumlah_siswa = $_POST['jumlah_siswa'];

    if($_POST['aksi'] == "add"){
        $query = "INSERT INTO kelas (kode_kelas, nama_kelas, jumlah_siswa) VALUES ('$kode_kelas', '$nama_kelas', '0');";
        $status = 'tambah';
    } elseif($_POST['aksi'] == "edit"){
        $query = "UPDATE kelas SET kode_kelas='$kode_kelas', nama_kelas='$nama_kelas', jumlah_siswa='$jumlah_siswa' WHERE id_kelas='$id_kelas';";
        $status = 'edit';
    }

    if(mysqli_query($conn, $query)){
        header("Location: Kelas.php?status=sukses&aksi=$status");
    } else {
        header("Location: Kelas.php?status=gagal&aksi=$status");
    }
}

if (isset($_GET['hapus'])) {
    $id_kelas = $_GET['hapus'];

    // Query untuk menghapus data
    $query = "DELETE FROM kelas WHERE id_kelas = '$id_kelas'";
    $sql = mysqli_query($conn, $query);
    $status = 'hapus';

    if ($sql) {
        header("Location: Kelas.php?status=sukses&aksi=$status");
    } else {
        header("Location: Kelas.php?status=gagal&aksi=hapus");
    }
} else {
    header("Location: Kelas.php");
}

?>