<?php 
    include "connect.php";
    session_start();

    if($_SERVER['REQUEST_METHOD'] === "POST"){
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Cek Admin
        if ($username === "admin" && $password === "admin123") {
            $_SESSION['username'] = "admin";
            $_SESSION['role'] = "admin";
            $_SESSION['start_time'] = time();
            header("Location: ../pages/admin.php");
            exit();
        }

        try {
            $sql = "SELECT id, email, password FROM user WHERE username = ? LIMIT 1";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->store_result();

            if($stmt->num_rows > 0){
                $stmt->bind_result($id, $email, $db_password);
                $stmt->fetch();

                //Cocokkan Password
                if($password === $db_password){
                    $_SESSION['username'] = $username;
                    $_SESSION['id'] = $id;
                    $_SESSION['start_time'] = time();
                    header("Location: ../index.php");
                    exit();
                } else {
                    // Password Salah
                    echo "<script>alert('Sign In Gagal: Password Salah!'); window.location.href='../pages/signin.php'; </script>";
                    exit();
                }
            } else {
                // Username Tidak Ditemukan
                echo "<script>alert('Sign In Gagal: Username Tidak Ditemukan!'); window.location.href='../pages/signin.php'; </script>";
                exit();
            }

        } catch (mysqli_sql_exception $e) {
            echo "ERROR: " . $e->getMessage();
        }
    }
?>