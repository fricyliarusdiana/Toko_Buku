<?php
session_start();
include "../config.php";



if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

// ambil data Kategori
$queryGetKategori = "SELECT id_kategori, nama_kategori FROM kategori ORDER BY id_kategori DESC";
$resultKategori = $conn->query($queryGetKategori);

// Proses saat form disubmit
if (isset($_POST['submit'])) {
    $nama_produk = $_POST['nama_produk'];
    $id_kategori = $_POST['id_kategori'];
    $harga = $_POST['harga'];
    $deskripsi = $_POST['deskripsi'];
    $stok = $_POST['stok'];

    // Upload gambar
    $gambar = $_FILES['gambar']['name'];
    $tmp_name = $_FILES['gambar']['tmp_name'];
    $upload_dir = "uploads/";

    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $gambar_path = $upload_dir . basename($gambar);

    if (move_uploaded_file($tmp_name, $gambar_path)) {
        $query = "INSERT INTO produk (nama_produk, id_kategori, gambar, harga, deskripsi, stok) 
                  VALUES ('$nama_produk', '$id_kategori', '$gambar', '$harga', '$deskripsi', '$stok')";

        if (mysqli_query($conn, $query)) {
            echo "Produk berhasil ditambahkan!";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "Gagal upload gambar.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Buku</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f9f9f9;
            margin: 0;
            padding: 20px;
            padding-top: 50px;
        }

        .navbar {
            background-color: rgb(95, 68, 38);
            padding: 10px;
        }

        .navbar a {
            color: white;
            margin-right: 20px;
            text-decoration: none;
            font-weight: bold;
        }

        .navbar a:hover {
            text-decoration: underline;
        }

        
        h2, h3 {
            color: #333;
        }

        form {
            background: #fff;
            padding: 20px;
            margin-bottom: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="number"],
        input[type="file"],
        select,
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        textarea {
            resize: vertical;
        }

        button {
            background-color: rgb(95, 68, 38);
            color: white;
            padding: 10px 25px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        button:hover {
            background-color:rgb(95, 68, 38);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            margin-bottom: 40px;
            box-shadow: 0 0 5px rgba(0,0,0,0.05);
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px 10px;
            text-align: left;
        }

        th {
            background-color: rgb(95, 68, 38);
            color: white; /* Warna teks putih */
            padding: 8px;
            text-align: center;
        }

        img {
            max-width: 50px;
            border-radius: 4px;
        }

        a {
            color: #007BFF;
            text-decoration: none;
            margin-right: 5px;
        }

        a:hover {
            text-decoration: underline;
        }

        td select[name="status"] {
            width: 100%;
            max-width: 150px; /* batasi lebar maksimal */
            box-sizing: border-box;
        }

    </style>
</head>

<body>
    <div class="navbar">
        <a href="index.php" class="active">Dashboard</a>
        <a href="index.php">Data Buku</a>
        <a href="kategori.php">Kategori</a>
        <a href="logout.php">Logout</a>
    </div>

    <h2>Dashboard</h2>
        <div style="position: absolute; top: 10px; right: 20px;">
            <h4 style="margin: 0;">Halo <?php echo $_SESSION['username'] ?></h4>
        </div>

    <form action="" method="POST" enctype="multipart/form-data">
        <label>Nama Buku:</label><br>
        <input type="text" name="nama_produk" required><br><br>

        <label>Pilih Kategori:</label>
        <select name="id_kategori">
            <?php
            while ($row = $resultKategori->fetch_assoc()) {
                echo "<option value='" . $row['id_kategori'] . "'>" . $row['nama_kategori'] . "</option>";
            }
            ?>
        </select>


        <label>Gambar:</label><br>
        <input type="file" name="gambar" required><br><br>

        <label>Harga:</label><br>
        <input type="number" name="harga" required><br><br>

        <label>Deskripsi:</label><br>
        <textarea name="deskripsi" required></textarea><br><br>

        <label>Stok:</label><br>
        <input type="number" name="stok" required><br><br>

        <button type="submit" name="submit">Tambah Produk</button>
    </form>


    <h2>Data Buku</h2>

    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>ID Buku</th>
            <th>Nama Buku</th>
            <th>Kategori Buku</th>
            <th>Gambar</th>
            <th>Harga</th>
            <th>Deskripsi</th>
            <th>Stok</th>
            <th>Aksi</th>
        </tr>

        <?php
        $query_produk = "SELECT b.id_produk,
                                k.nama_kategori,
                                b.nama_produk,
                                b.gambar,
                                b.harga,
                                b.deskripsi,
                                b.stok
                                From produk b
                                JOIN kategori k ON b.id_kategori = k.id_kategori";
        $stmt = $conn->prepare($query_produk);
        $stmt->execute();
        $result_produk = $stmt->get_result();

        $no = 1;
        while ($row_produk = $result_produk->fetch_assoc()) :
        ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $row_produk['nama_produk']; ?></td>
                    <td><?php echo $row_produk['nama_kategori']; ?></td>
                    <td><img src="uploads/<?php echo $row_produk['gambar']; ?>" width="50"></td>
                    <td><?php echo $row_produk['harga']; ?></td>
                    <td><?php echo $row_produk['deskripsi']; ?></td>
                    <td><?php echo $row_produk['stok']; ?></td>
                    <td>
                        <a href="edit_produk.php?id=<?php echo $row_produk['id_produk']; ?>">Edit</a> |
                        <a href="hapus_produk.php?id=<?php echo $row_produk['id_produk']; ?>" onclick="return confirm('Yakin ingin hapus produk ini?');">Hapus</a>
                    </td>
                </tr>
        <?php endwhile; ?>
    </table>


    <h2>Data User</h2>

    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>No</th>
            <th>Username</th>
            <th>Nama Lengkap</th>
            <th>No Telp</th>
            <th>Alamat</th>
            <th>Dibuat pada</th>
        </tr>

        <?php
        $no = 1;
        $query_user = "SELECT * FROM user";
        $result_user = mysqli_query($conn, $query_user);

        if (mysqli_num_rows($result_user) > 0) :
            while ($row_user = mysqli_fetch_assoc($result_user)) :
        ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $row_user['username']; ?></td>
                    <td><?php echo $row_user['nama_lengkap']; ?></td>
                    <td><?php echo $row_user['no_telepon']; ?></td>
                    <td><?php echo $row_user['alamat']; ?></td>
                    <td><?php echo $row_user['created_at']; ?></td>

                </tr>
        <?php
            endwhile;
        else :
            echo "<tr><td colspan='8'>Tidak ada data produk.</td></tr>";
        endif;
        ?>
    </table>

    <h2>Data Pesanan</h2>
    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>ID Pesanan</th>
            <th>Pelanggan</th>
            <th>Total</th>
            <th>Status</th>
            <th>Tanggal</th>
            <th>Aksi</th>
        </tr>
        <?php
        $query_pesanan = "SELECT pesanan.*, user.username 
                      FROM pesanan 
                      JOIN user ON pesanan.id_user = user.id_user
                      ORDER BY pesanan.created_at DESC";
        $result_pesanan = mysqli_query($conn, $query_pesanan);

        if (mysqli_num_rows($result_pesanan) > 0) :
            while ($row = mysqli_fetch_assoc($result_pesanan)) :
        ?>
                <tr>
                    <td><?= $row['id_pesanan'] ?></td>
                    <td><?= $row['username'] ?></td>
                    <td>Rp <?= number_format($row['total'], 0, ',', '.') ?></td>
                    <td>
                        <form action="update_status.php" method="POST" style="display:inline;">
                            <input type="hidden" name="id_pesanan" value="<?= $row['id_pesanan'] ?>">
                            <select name="status" onchange="this.form.submit()">
                                <option value="pending" <?= ($row['status'] == 'pending') ? 'selected' : '' ?>>pending</option>
                                <option value="diproses" <?= ($row['status'] == 'diproses') ? 'selected' : '' ?>>Diproses</option>
                                <option value="dikirim" <?= ($row['status'] == 'dikirim') ? 'selected' : '' ?>>Dikirim</option>
                                <option value="selesai" <?= ($row['status'] == 'selesai') ? 'selected' : '' ?>>Selesai</option>
                            </select>
                        </form>
                    </td>
                    <td><?= date('d/m/Y', strtotime($row['created_at'])) ?></td>
                    <td>
                        <a href="detail_pesanan.php?id=<?= $row['id_pesanan'] ?>">Detail</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else : ?>
            <tr>
                <td colspan="6">Tidak ada pesanan.</td>
            </tr>
        <?php endif; ?>
    </table>


</body>
</html>