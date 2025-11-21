<?php 
    include "connect.php";
    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Cek Apakah Email Sudah Terdaftar
        try {
            $sql = "SELECT * FROM user WHERE email = ?";
            $cek = $conn->prepare($sql);
            $cek->bind_param("s", $email);
            $cek->execute();
            $result = $cek->get_result();

            if ($result->num_rows > 0) {
                echo "<script>alert('Sign Up Gagal: Email Sudah Terdaftar!'); window.location.href='../pages/signup.php'; </script>";
                exit();
            }
            $cek->close();
        } catch (mysqli_sql_exception $e) {
            echo "ERROR: " .$e->getMessage();
            exit();
        }

        // Simpan Data ke Database
        try {
            $sql = "INSERT into user(email, username, password) VALUES (?,?,?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $email, $username, $password);
            if ($stmt->execute()) {
                header("Location: ../pages/signin.php");
                exit();
            } else {
                echo "<script>alert('Sign Up Gagal: Terjadi Kesalahan pada Server!'); window.location.href='../pages/signup.php'; </script>";
                exit();
            }
            $stmt->close();
        } catch (mysqli_sql_exception $e) {
            echo "ERROR: " . $e->getMessage();
        }
    }
?>