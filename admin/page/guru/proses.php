<?php
require_once 'fungsi.php'; 

    if(isset($_POST['aksi'])){
        if($_POST['aksi'] == "add"){

            $berhasil = tambah_data($_POST, $_FILES);

            if ($berhasil) {
                header("location: ManajemenAkun-Guru.php?status=success&message=Data berhasil ditambahkan");
            } else {
                header("location: ManajemenAkun-Guru.php?status=error&message=$berhasil");
            }
        }else if($_POST['aksi'] == "edit"){
            
            $berhasil = ubah_data($_POST, $_FILES);

             
            if ($berhasil) {
                header("location: ManajemenAkun-Guru.php?status=success&message=Data berhasil diubah");
            } else {
                header("location: ManajemenAkun-Guru.php?status=error&message=$berhasil");
            }


        }
    }

    if(isset($_GET['hapus'])){   
        
        $berhasil = hapus_data($_GET);

        if($berhasil){
            header("location: ManajemenAkun-Guru.php?status=success&message=Data berhasil dihapus");
        }else{
            header("Location: ManajemenAkun-Guru.php?status=error&message=Data gagal dihapus");
        }
    }
 ?>