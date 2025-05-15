<?php
session_start();
include "../config.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}
// penenganan hapus data 
if(isset($_GET['delete_id'])) {
    $id_kategori = $_GET['delete_id'];
        $query_delete = "DELETE FROM kategori WHERE id_kategori = '$id_kategori'";
        if(mysqli_query($conn, $query_delete)) {
            
            echo "<script>alert('Kategori berhasil dihapus!');</script>";
        } else {
            echo "<script>alert('Gagal menghapus Kategori!');</script>";
        }
    }

// Menangani data POST
if (isset($_POST['SIMPAN'])) {
    $nama_kategori =$_POST['nama_kategori'];
   
            $query = "INSERT INTO kategori (nama_kategori) values ('$nama_kategori')";
            if(mysqli_query($conn, $query)) {
                echo "Kategori Baru Berhasil Disimpan";
                header("location:" .$_SERVER['PHP_SELF']);
                exit();
            }else{
                echo "Error:" .mysqli_error($conn);
            }
    }

$datakategori="SELECT * FROM kategori ORDER BY id_Kategori ASC";
$resultkategori = $conn->query($datakategori);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta charset="UTF-8">
    <title>Kategori Buku</title>

    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: rgb(245, 243, 242);
        color: rgb(228, 214, 199);
        padding: 40px;
    }

    /* Navbar Styling */
    .navbar-container {
        max-width: 1000px;
        margin: 0 auto 30px auto;
        background-color: #5d4037; /* Coklat tua */
        border-radius: 10px;
        padding: 8px 20px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.15);
        position: relative;
        top: -20px;
    }

    .navbar-container ul {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 0;
        margin: 0;
        list-style: none;
    }

    .navbar-container li {
        margin: 0 20px;
    }

    .navbar-container a {
        display: block;
        padding: 10px 18px;
        color: #fff8f0; /* Putih krem */
        font-weight: 600;
        font-size: 16px;
        text-decoration: none;
        border-radius: 6px;
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    .navbar-container a:hover {
        background-color: #8d6e63; /* Coklat muda saat hover */
        color: #ffffff;
    }

    h2 {
        text-align: center;
        color: white;
    }

    form {
        max-width: 600px;
        margin: 0 auto 30px auto;
        background-color: #efebe9;
        padding: 25px 30px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(100, 70, 50, 0.1);
    }

    label {
        display: block;
        margin-top: 15px;
        font-weight: 600;
        color: #5d4037;
    }

    input[type="text"] {
        width: 100%;
        padding: 10px;
        margin-top: 5px;
        border: 1px solid #bcaaa4;
        border-radius: 6px;
        background-color: #ffffff;
        font-size: 14px;
        box-sizing: border-box;
    }

    button {
        background-color: #6d4c41;
        color: white;
        padding: 12px 20px;
        margin-top: 20px;
        border: none;
        border-radius: 6px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    button:hover {
        background-color: #5d4037;
    }

    table {
        width: 80%;
        margin: 0 auto;
        border-collapse: collapse;
        background-color: #fff8e1;
        color: #5d4037;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 8px rgba(100, 70, 50, 0.1);
    }

    th, td {
        border: 1px solid #d7ccc8;
        padding: 12px 15px;
        text-align: center;
    }

    th {
        background-color: #d7ccc8;
        font-weight: bold;
    }

    /* Tombol Edit dan Hapus */
    .btn-primary, .btn-danger {
        padding: 5px 10px; /* Menyusutkan padding tombol */
        font-size: 10px; /* Mengurangi ukuran font */
        border-radius: 4px; /* Menjaga tombol tetap rapi dengan sudut membulat */
        text-decoration: none;
        margin: 0 5px; /* Memberikan jarak antar tombol */
        display: inline-block; /* Agar tombol tidak mengganggu layout */
        text-align: center;
        width: auto;
        min-width: 80px;
    }

    /* Tombol Edit */
    .btn-primary {
        background-color: #6d4c41;
        color: white;
    }

    .btn-primary:hover {
        background-color: #5d4037;
    }

    /* Tombol Hapus */
    .btn-danger {
        background-color: #c62828;
        color: white;
    }

    .btn-danger:hover {
        background-color: #b71c1c;
    }

</style>

</head>

<body>
    <nav class="navbar-container">
    <ul>
        <li><a href="index.php">Dashboard</a></li>
        <li><a href="kategori.php">Kategori</a></li>
    </ul>   

    <h2>Kategori Buku</h2>

    <form action="" method="POST">
        <label>Nama Kategori :</label><br>
        <input type="text" name="nama_kategori" placeholder="Nama Kategori"><br><br>
        <button type="submit" name="SIMPAN">Simpan Perubahan</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Kategori</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            while ($kategori = $resultkategori->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $no++ . '</td>';
                echo '<td>' . $kategori['nama_kategori'] . '</td>';
                echo '<td>';
                            echo '<a href="edit-kategori.php?id_kategori=' . $kategori['id_kategori'] . '" class="btn btn-primary">Edit</a> &nbsp';
                            echo '<a href="?delete_id=' . $kategori['id_kategori'] . '" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin ingin menghapus Kategori ini?\')">Hapus</a> &nbsp;';
                echo '</td>';
                echo '</tr>';
            }
            ?>
        </tbody>
    </table>           

</body>

</html>

    