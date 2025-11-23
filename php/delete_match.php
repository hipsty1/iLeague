<?php 
    include "connect.php";
    if(!$conn){
        die("Koneksi Gagal: " . mysqli_connect_error());
    }

    if(isset($_GET['id_pertandingan'])){
        $id_pertandingan = $_GET['id_pertandingan'];

        $sql = "DELETE FROM pertandingan WHERE id_pertandingan = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_pertandingan);

        if($stmt->execute()){
            header("Location: ../pages/admin.php");
            exit();
        } else {
            echo "Gagal Menghapus Data Pertandingan: " . $stmt->error;
        } 
        $stmt->close();
        $conn->close();
    } else {
        echo "ID Pertandingan Tidak Ditemukan.";
    }
?>