<?php
include "../config.php";

if (!isset($_GET['id'])) {
    echo "ID tidak ditemukan!";
    exit;
}

// ambil data Kategori
$queryGetKategori = "SELECT id_kategori, nama_kategori FROM kategori ORDER BY id_kategori DESC";
$resultKategori = $conn->query($queryGetKategori);

$id = $_GET['id'];
$query = "SELECT * FROM produk WHERE id_produk = $id";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

// Cek jika data tidak ditemukan
if (!$data) {
    echo "Produk tidak ditemukan!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Buku</title>

    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: rgb(95, 68, 38);
        color:rgb(228, 214, 199);
        padding: 40px;
    }

    h2 {
        text-align: center;
        color: white;
    }

    form {
        max-width: 600px;
        margin: 0 auto;
        background-color: #fff8e1;
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

    input[type="text"],
    input[type="number"],
    input[type="file"],
    select,
    textarea {
        width: 100%;
        padding: 10px;
        margin-top: 5px;
        border: 1px solid #d7ccc8;
        border-radius: 6px;
        background-color: #ffffff;
        font-size: 14px;
        box-sizing: border-box;
    }

    textarea {
        resize: vertical;
    }

    img {
        margin-top: 10px;
        border-radius: 5px;
        border: 1px solid #ccc;
    }

    button {
        background-color:rgb(121, 97, 88);
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
        background-color:rgb(109, 80, 69);
    }
</style>

</head>

<body>

    <h2>Edit Buku</h2>

    <form action="proses_edit.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id_produk" value="<?php echo $data['id_produk']; ?>">
        <input type="hidden" name="gambar_lama" value="<?php echo $data['gambar']; ?>">


        <label>Nama Buku:</label><br>
        <input type="text" name="nama_produk" value="<?php echo $data['nama_produk']; ?>"><br><br>
        <label>Kategori:</label><br>

        <select name="id_kategori" required>
            <?php
                                while ($row = $resultKategori->fetch_assoc()) {
                                    $selected = ($row['id_kategori'] == $data['id_kategori']) ? "selected" : "";
                                    echo "<option value='" . $row['id_kategori'] . "' $selected>" . $row['nama_kategori'] . "</option>";
                                }                                
                                ?>
        </select><br><br>

        <label>Harga:</label><br>
        <input type="number" name="harga" value="<?php echo $data['harga']; ?>"><br><br>

        <label>Deskripsi:</label><br>
        <textarea name="deskripsi"><?php echo $data['deskripsi']; ?></textarea><br><br>

        <label>Stok:</label><br>
        <input type="number" name="stok" value="<?php echo $data['stok']; ?>"><br><br>

        <!-- Menampilkan gambar lama -->
        <label>Gambar Saat Ini:</label><br>
        <img src="uploads/<?php echo $data['gambar']; ?>" alt="Gambar Produk" width="100"><br><br>

        <!-- Opsi untuk upload gambar baru -->
        <label>Gambar Baru:</label><br>
        <input type="file" name="gambar"><br><br>

        <button type="submit">Simpan Perubahan</button>
    </form>

</body>

</html>