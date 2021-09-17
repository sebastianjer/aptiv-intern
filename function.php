<?php
session_start();

//connect ke database
$conn = mysqli_connect("localhost", "root", "", "warehouseaptiv");

if (!$conn) {
    echo 'gagal';
}
    
//add material baru ke database - index.php
if(isset($_POST['add_material'])) {
    $material_id = $_POST['material_id'];
    $description = $_POST['description'];
    $vendor_id = $_POST['vendor_id'];
    $snp = $_POST['snp'];
    $total_box = $_POST['total_box'];
    
    $insert_to_material = mysqli_query($conn, "INSERT INTO material (material_id, description, vendor_id, snp, total_box) 
                            VALUES ('$material_id', '$description', '$vendor_id', '$snp', '$total_box')");
    
    if ($insert_to_material) {
        header('location: index.php');
    } else {
        echo 'gagal';
        header('location: index.php');
    }
}

//edit material - index.php
if(isset($_POST['edit_material'])) {
    $material_id = $_POST['material_id'];
    $vendor_id = $_POST['vendor_id']; //katanya sih vendor harusnya tetap ga ganti2
    $description = $_POST['description'];
    $snp = $_POST['snp'];
    $total_box = $_POST['total_box'];

    //update record di database dengan informasi baru
    $edit_material = mysqli_query($conn, "UPDATE material 
                        SET description = '$description', vendor_id = '$vendor_id', snp = '$snp', total_box = '$total_box' 
                        WHERE material_id = '$material_id'");
    
    if ($edit_material) {
        header('location: index.php');
    } else {
        echo 'gagal';
        header('location: index.php');
    }
}

//delete material - index.php
if(isset($_POST['delete_material'])) {
    $material_id = $_POST['material_id'];

    $delete_material= mysqli_query($conn, "DELETE FROM material WHERE material_id = '$material_id'");

    if ($delete_material) {
        header('location: index.php');
    } else {
        echo 'gagal';
        header('location: index.php');
    }
}

//------------------------------------------------

//barang masuk ke rak - masuk.php
if(isset($_POST['add_material_in'])) {
    $material_id = $_POST['material_id'];
    $total_box_in = $_POST['total_box_in'];
    $week = $_POST['week'];
    
    $insert_to_material_in = mysqli_query($conn, "INSERT INTO material_in (material_id, total_box_in, week) VALUES ('$material_id', '$total_box_in', '$week')");
    
    //update total box material di table material ketika ada material yang masuk
    // $cek_jumlah_barang = mysqli_query($conn, "SELECT jumlah FROM barang WHERE id_barang = '$pilihan_barang'");
    $cek_material = mysqli_query($conn, "SELECT * FROM material WHERE material_id = '$material_id'");
    $data_material = mysqli_fetch_array($cek_material);
    $total_box_current = $data_material['total_box'];
    $total_box_new = $total_box_current + $total_box_in;
    
    $update_material = mysqli_query($conn, "UPDATE material SET total_box = '$total_box_new' WHERE material_id = '$material_id'");
    
    if ($insert_to_material_in && $update_material) {
        header('location: masuk.php');
    } else {
        echo 'gagal';
        header('location: masuk.php');
    }
}

//edit material in - masuk.php
if(isset($_POST['edit_material_in'])) {
    $masuk_id = $_POST['masuk_id'];
    $material_id = $_POST['material_id'];
    $description = $_POST['description']; //harusnya tidak usah ganti nama karena repot nanti bagaimana dapat id_barang utk nama_barang yang baru
    $total_box_in = $_POST['total_box_in'];
    $week = $_POST['week'];

    //total box material saat ini di table material
    $cek_material = mysqli_query($conn, "SELECT * FROM material WHERE material_id = '$material_id'");
    $data_material = mysqli_fetch_array($cek_material);
    $total_box_current = $data_material['total_box'];

    //total box material in sebelum di edit
    $cek_material_in = mysqli_query($conn, "SELECT * FROM material_in WHERE masuk_id = '$masuk_id'");
    $data_material_in = mysqli_fetch_array($cek_material_in);
    $total_box_in_current = $data_material_in['total_box_in'];

    $total_box_new = 0;

    //apakah jumlah masuk yang baru lebih banyak atau lebih kecil dari sebelumnya
    if ($total_box_in > $total_box_in_current) {  //jumlah masuk baru lebih banyak, berarti jumlah di table material harus ditambah
        $diff = $total_box_in - $total_box_in_current;
        $total_box_new = $total_box_current + $diff;
    } else {                                //jumlah masuk baru lebih sedikit atau sama dengan, jumlah di table material harus dikurangi
        $diff = $total_box_in_current - $total_box_in;
        $total_box_new = $total_box_current - $diff;
    }

    //update total box material di table material
    $edit_material = mysqli_query($conn, "UPDATE material SET total_box = '$total_box_new' WHERE material_id = '$material_id'");

    //update total box in di table material_in
    $edit_material_in = mysqli_query($conn, "UPDATE material_in SET total_box_in = '$total_box_in', week = '$week' WHERE masuk_id = '$masuk_id'");

    if ($edit_material && $edit_material_in) {
        header('location: masuk.php');
    } else {
        echo 'gagal';
        header('location: masuk.php');
    }
}

//delete material in - masuk.php
if(isset($_POST['delete_material_in'])) {
    $masuk_id = $_POST['masuk_id'];
    $material_id = $_POST['material_id'];
    $total_box_in = $_POST['total_box_in']; //jumlah yang masuk, kita gunakan untuk mengembalikan jumlah di table barang ke sblm entri ini dimasukkan

    //total box material saat ini di table material
    $cek_material = mysqli_query($conn, "SELECT * FROM material WHERE material_id = '$material_id'");
    $data_material = mysqli_fetch_array($cek_material);
    $total_box_current = $data_material['total_box'];
    
    //update total box material di table material
    $total_box_new = $total_box_current - $total_box_in;
    $edit_material = mysqli_query($conn, "UPDATE material SET total_box = '$total_box_new' WHERE material_id = '$material_id'");

    //hapus entri material in di table material_in
    $delete_material_in = mysqli_query($conn, "DELETE FROM material_in WHERE masuk_id = '$masuk_id'");

    if ($edit_material && $delete_material_in) {
        header('location: masuk.php');
    } else {
        echo 'gagal';
        header('location: masuk.php');
    }
}

//------------------------------------------------

//barang keluar dari rak - keluar.php
if(isset($_POST['add_material_out'])) {
    $material_id = $_POST['material_id'];
    $total_box_out = $_POST['total_box_out'];
    $week = $_POST['week'];
    
    //cek jumlah barang saat ini di table barang
    // $cek_jumlah_barang = mysqli_query($conn, "SELECT jumlah FROM barang WHERE id_barang = '$pilihan_barang'");
    $cek_material = mysqli_query($conn, "SELECT * FROM material WHERE material_id = '$material_id'");
    $data_material = mysqli_fetch_array($cek_material);
    $total_box_current = $data_material['total_box'];
    
    //cek dulu apakah jumlah_current cukup untuk dikeluarkan, karena kalau yg mau keluar melebihi jumlah yg ada seharusnya tidak bisa
    if ($total_box_current >= $total_box_out) { //cukup
        $total_box_new = $total_box_current - $total_box_out;
        
        //masukkan entri di table material_out
        $insert_to_material_out = mysqli_query($conn, "INSERT INTO material_out (material_id, total_box_out, week) VALUES ('$material_id', '$total_box_out', '$week')");
        
        //update jumlah material di table material ketika ada barang yang keluar
        $update_material = mysqli_query($conn, "UPDATE material SET total_box = '$total_box_new' WHERE material_id = '$material_id'");
        
        if ($insert_to_material_out && $update_material) {
            header('location: keluar.php');
        } else {
            echo 'gagal';
            header('location: keluar.php');
        }
    } else {                         //tidak cukup
        echo '
        <script>
        alert("Stock saat ini tidak mencukupi");
        window.location.href = "keluar.php";
        </script>
        ';
    }
    
    
    
}

//edit material out - keluar.php
if(isset($_POST['edit_material_out'])) {
    $keluar_id = $_POST['keluar_id'];
    $material_id = $_POST['material_id'];
    $description = $_POST['description']; //harusnya tidak usah ganti nama karena repot nanti bagaimana dapat id_barang utk nama_barang yang baru
    $total_box_out = $_POST['total_box_out'];
    $week = $_POST['week'];

    //jumlah barang sekarang di table barang
    $cek_material = mysqli_query($conn, "SELECT * FROM material WHERE material_id = '$material_id'");
    $data_material = mysqli_fetch_array($cek_material);
    $total_box_current = $data_material['total_box'];

    //jumlah barang keluar sebelum di edit
    $cek_material_out = mysqli_query($conn, "SELECT * FROM material_out WHERE keluar_id = '$keluar_id'");
    $data_material_out = mysqli_fetch_array($cek_material_out);
    $total_box_out_current = $data_material_out['total_box_out'];

    $total_box_new = 0;

    //apakah jumlah barang keluar yang baru lebih banyak atau lebih kecil dari sebelumnya
    if ($total_box_out > $total_box_out_current) { 
        //jumlah keluar baru lebih besar, berarti jumlah di table barang harus dikurangi
        $diff = $total_box_out - $total_box_out_current;

        //cek tambahan, karena siapa tahu total box out yang baru melebihi stock yang tersedia
        if ($diff <= $total_box_current) {
            $total_box_new = $total_box_current - $diff;

            //update jumlah material di table material
            $edit_material = mysqli_query($conn, "UPDATE material SET total_box = '$total_box_new' WHERE material_id = '$material_id'");

            //update material out di table material_out
            $edit_material_out = mysqli_query($conn, "UPDATE material_out SET total_box_out = '$total_box_out', week = '$week' WHERE keluar_id = '$keluar_id'");

            if ($edit_material && $edit_material_out) {
                header('location: keluar.php');
            } else {
                echo 'gagal';
                header('location: keluar.php');
            }

        } else {
            $total_box_new = $total_box_current;
            echo '
            <script>
            alert("Stock saat ini tidak mencukupi");
            window.location.href = "keluar.php";
            </script>
            ';
        }

    } else {                                
        //jumlah keluar baru lebih kecil atau sama dengan, berarti jumlah di table barang ditambah
        $diff = $total_box_out_current - $total_box_out;
        $total_box_new = $total_box_current + $diff;
        
        //update jumlah material di table material
        $edit_material = mysqli_query($conn, "UPDATE material SET total_box = '$total_box_new' WHERE material_id = '$material_id'");
    
        //update material out di table material_out
        $edit_material_out = mysqli_query($conn, "UPDATE material_out SET total_box_out = '$total_box_out', week = '$week' WHERE keluar_id = '$keluar_id'");
        
        if ($edit_material && $edit_material_out) {
            header('location: keluar.php');
        } else {
            echo 'gagal';
            header('location: keluar.php');
        }
    }


}

//delete material out - keluar.php
if(isset($_POST['delete_material_out'])) {
    $keluar_id = $_POST['keluar_id'];
    $material_id = $_POST['material_id'];
    $total_box_out = $_POST['total_box_out']; //jumlah yang keluar, kita gunakan untuk mengembalikan jumlah di table barang ke sblm entri ini dimasukkan

    //jumlah barang sekarang di table barang
    $cek_material = mysqli_query($conn, "SELECT * FROM material WHERE material_id = '$material_id'");
    $data_material = mysqli_fetch_array($cek_material);
    $total_box_current = $data_material['total_box'];

    //update total box material di table material
    $total_box_new = $total_box_current + $total_box_out;
    $edit_material = mysqli_query($conn, "UPDATE material SET total_box = '$total_box_new' WHERE material_id = '$material_id'");

    //hapus entri material out di table material_out
    $delete_material_out = mysqli_query($conn, "DELETE FROM material_out WHERE keluar_id = '$keluar_id'");

    if ($edit_material && $delete_material_out) {
        header('location: keluar.php');
    } else {
        echo 'gagal';
        header('location: keluar.php');
    }
}

//------------------------------------------------

//download goods
//di download.php

//tambah barang pengiriman baru - upload-goods.php
if(isset($_POST['add_goods'])) {
    $goods_id = $_POST['goods_id'];
    $vendor_id = $_POST['vendor_id'];
    
    $asn_name = '';
    $pl_name = '';
    $awb_name = '';

    $target_dir = 'uploads/';
    
    //asn-----------------------------
    $target_file_asn = $target_dir.basename($_FILES['asn']['name']);
    $asnOk = 1;
    $asnFileType = strtolower(pathinfo($target_file_asn,PATHINFO_EXTENSION));

    //cek file exist
    if (file_exists($target_file_asn)) {
        echo "Sorry, file already exists.";
        $asnOk = 0;
    }

    //cek file size - dalam B (500000B = 500KB)
    // if ($_FILES['asn']['size'] > 500000) {
    //     echo 'Sorry, your file is too large.';
    //     $asnOk = 0;
    // }

    //format hanya pdf
    if($asnFileType != 'pdf') {
        echo 'Hanya boleh format PDF';
        $asnOk = 0;
    }

    //cek kalau 0 tidak di upload
    if ($asnOk == 0) {
        echo "Sorry, your file was not uploaded.";
      // if everything is ok, try to upload file
    } else {
        $asn_name = $_FILES['asn']['name'];
        if (move_uploaded_file($_FILES['asn']['tmp_name'], $target_file_asn)) {
            echo "The file ". htmlspecialchars( basename( $_FILES['asn']['name'])). " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
    //--------------------------------

    //pl------------------------------
    $target_file_pl = $target_dir.basename($_FILES['pl']['name']);
    $plOk = 1;
    $plFileType = strtolower(pathinfo($target_file_pl,PATHINFO_EXTENSION));

    //cek file exist
    if (file_exists($target_file_pl)) {
        echo "Sorry, file already exists.";
        $plOk = 0;
    }

    //cek file size - dalam B (500000B = 500KB)
    // if ($_FILES['pl']['size'] > 500000) {
    //     echo 'Sorry, your file is too large.';
    //     $plOk = 0;
    // }

    //format hanya pdf
    if($plFileType != 'pdf') {
        echo 'Hanya boleh format PDF';
        $plOk = 0;
    }

    //cek kalau 0 tidak di upload
    if ($plOk == 0) {
        echo "Sorry, your file was not uploaded.";
      // if everything is ok, try to upload file
    } else {
        $pl_name = $_FILES['pl']['name'];
        if (move_uploaded_file($_FILES['pl']['tmp_name'], $target_file_pl)) {
            echo "The file ". htmlspecialchars( basename( $_FILES['pl']['name'])). " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
    //--------------------------------

    //awb-----------------------------
    $target_file_awb = $target_dir.basename($_FILES['awb']['name']);
    $awbOk = 1;
    $awbFileType = strtolower(pathinfo($target_file_awb,PATHINFO_EXTENSION));

    //cek file exist
    if (file_exists($target_file_awb)) {
        echo "Sorry, file already exists.";
        $awbOk = 0;
    }

    //cek file size - dalam B (500000B = 500KB)
    // if ($_FILES['asn']['size'] > 500000) {
    //     echo 'Sorry, your file is too large.';
    //     $asnOk = 0;
    // }

    //format hanya pdf
    if($awbFileType != 'pdf') {
        echo 'Hanya boleh format PDF';
        $awbOk = 0;
    }

    //cek kalau 0 tidak di upload
    if ($awbOk == 0) {
        echo "Sorry, your file was not uploaded.";
      // if everything is ok, try to upload file
    } else {
        $awb_name = $_FILES['awb']['name'];
        if (move_uploaded_file($_FILES['awb']['tmp_name'], $target_file_awb)) {
            echo "The file ". htmlspecialchars( basename( $_FILES['awb']['name'])). " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
    //--------------------------------

    $insert_to_goods = mysqli_query($conn, "INSERT INTO goods (goods_id, vendor_id, asn_name, pl_name, awb_name) 
                            VALUES ('$goods_id', '$vendor_id', '$asn_name', '$pl_name', '$awb_name')");
    
    if ($insert_to_goods) {
        header('location: upload-goods.php');
    } else {
        echo 'gagal';
        header('location: upload-goods.php');
    }
}

//edit pengiriman - track-goods.php
if(isset($_POST['edit_goods'])) {
    $goods_id = $_POST['goods_id'];
    $vendor_id = $_POST['vendor_id'];
    $asn_name = $_POST['asn_name'];
    $pl_name = $_POST['pl_name'];
    $awb_name = $_POST['awb_name'];

    //yang mau diubah untuk keperluan tracking
    $log_partner = $_POST['log_partner'];
    $eta = $_POST['eta'];
    $status = $_POST['status'];

    //update record di table goods dengan informasi log_partner, eta, dan status pengiriman
    $edit_goods = mysqli_query($conn, "UPDATE goods 
                        SET log_partner = '$log_partner', ETA = '$eta', status = '$status' 
                        WHERE goods_id = '$goods_id'");
    
    if ($edit_goods) {
        header('location: track-goods.php');
    } else {
        echo 'gagal';
        header('location: track-goods.php');
    }
}

//delete pengiriman - track-goods.php
if(isset($_POST['delete_goods'])) {
    $goods_id = $_POST['goods_id'];

    $delete_goods= mysqli_query($conn, "DELETE FROM goods WHERE goods_id = '$goods_id'");

    if ($delete_goods) {
        header('location: track-goods.php');
    } else {
        echo 'gagal';
        header('location: track-goods.php');
    }
}

//------------------------------------------------

//input logistic partner, eta, status
if(isset($_POST[''])) {

}

//edit status
if(isset($_POST[''])) {

}

if(isset($_POST[''])) {

}

?>