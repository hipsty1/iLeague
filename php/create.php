<?php 
    include "connect.php";
    if(!$conn){
        die("Koneksi gagal: " . mysqli_connect_error());
    }


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Ambil data dari form
        $tanggal = $_POST['tanggal'];
        $tim_home = $_POST['timHome'];
        $tim_away = $_POST['timAway'];
        $skor_home = $_POST['skor_home'];
        $skor_away = $_POST['skor_away'];

        // Validasi dasar
        if ($tim_home === $tim_away) {
            die("Tim home dan tim away tidak boleh sama!");
        }

        // Cek apakah pertandingan antar tim yang sama sudah ada (baik home–away maupun away–home)
        $cekSql = "SELECT COUNT(*) AS jumlah FROM pertandingan 
                WHERE (tim_home = ? AND tim_away = ?) 
                OR (tim_home = ? AND tim_away = ?)";
        $cek = $conn->prepare($cekSql);
        $cek->bind_param("iiii", $tim_home, $tim_away, $tim_away, $tim_home);
        $cek->execute();
        $hasil = $cek->get_result()->fetch_assoc();

        if ($hasil['jumlah'] > 1) {
            die("Pertandingan antara dua tim ini sudah tercatat (home/away). Tidak dapat ditambahkan lagi.");
        }
        $cek->close();


        // Simpan ke database
        $sql = "INSERT INTO pertandingan (tanggal_pertandingan, tim_home, tim_away, skor_tim_home, skor_tim_away) 
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("siiii", $tanggal,  $tim_home, $tim_away, $skor_home, $skor_away);
        if ($stmt->execute()) {
            // Redirect ke halaman admin setelah berhasil menambahkan pertandingan
            header("Location: ../pages/admin.php");
            exit();
        } else {
            echo "ERROR: " . $stmt->error;
        }
        $stmt->close();
        $conn->close();       
    } else {
        echo "AKSES TIDAK VALID!";
    }
?>