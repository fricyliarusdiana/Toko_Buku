<?php
session_start();
include "../config.php";


$id_pesanan = (int)$_GET['id'];

// Ambil data pesanan + bukti transfer
$query_pesanan = mysqli_query($conn, "
    SELECT pesanan.*, user.username 
    FROM pesanan 
    JOIN user ON pesanan.id_user = user.id_user
    WHERE pesanan.id_pesanan = $id_pesanan
");
$pesanan = mysqli_fetch_assoc($query_pesanan);

// Ambil item pesanan
$query_items = mysqli_query($conn, "
    SELECT detail_pesanan.*, produk.nama_produk, produk.gambar
    FROM detail_pesanan
    JOIN produk ON detail_pesanan.id_produk = produk.id_produk
    WHERE detail_pesanan.id_pesanan = $id_pesanan
");
?>
<!DOCTYPE html>
<html>

<head>
    <title>Detail Pesanan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f8f9fa;
            padding: 0;
        }

        .container {
            max-width: 900px;
            margin: 40px auto;
            background-color: rgb(228, 214, 199);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: rgb(95, 68, 38);
            margin-bottom: 30px;
        }

        h3 {
            border-bottom: 2px solid rgb(168, 137, 102);
            padding-bottom: 5px;
            color:rgb(95, 68, 38);
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 15px;
        }

        th,
        td {
            border: 1px solid #e0e0e0;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: rgb(95, 68, 38);
            color: white;
        }

        .info-section {
            margin-bottom: 30px;
        }

        .bukti-transfer {
            max-width: 300px;
            margin-top: 10px;
        }

        .status-pending {
            color: #e67e22;
            font-weight: bold;
        }

        .status-verified {
            color: #2ecc71;
            font-weight: bold;
        }

        a {
            color: #2980b9;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .back-link {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: rgb(168, 137, 102);
            color: white;
            border-radius: 5px;
            text-decoration: none;
        }

        .back-link:hover {
            background-color:rgb(168, 137, 102);
        }
    </style>
</head>

<body>
    <div classs="container">
        
        <h1>Detail Pesanan <?= $id_pesanan ?></h1>

        <!-- Informasi Utama Pesanan -->
        <div class="info-section">
            <h3>Informasi Pesanan</h3>
            <p><strong>Pelanggan:</strong> <?= $pesanan['username'] ?></p>
            <p><strong>Tanggal Pesan:</strong> <?= date('d/m/Y H:i', strtotime($pesanan['created_at'])) ?></p>
            <p><strong>Status:</strong>
                <span class="<?=
                                ($pesanan['status'] == 'menunggu_verifikasi') ? 'status-pending' : 'status-verified'
                                ?>">
                    <?= ucfirst(str_replace('_', ' ', $pesanan['status'])) ?>
                </span>
            </p>
            <p><strong>Total:</strong> Rp <?= number_format($pesanan['total'], 0, ',', '.') ?></p>
            <p><strong>Alamat Pengiriman:</strong><br><?= nl2br($pesanan['alamat']) ?></p>
        </div>

        <!-- Bukti Transfer -->
        <div class="info-section">
            <h3>Bukti Transfer</h3>
            <?php if ($pesanan['bukti_transfer']): ?>
                <img src="../bukti_transfer/<?= $pesanan['bukti_transfer'] ?>" alt="Bukti Transfer" class="bukti-transfer">
                <p>
                    <a href="../bukti_transfer/<?= $pesanan['bukti_transfer'] ?>" download>Download Bukti</a> 

                </p>
            <?php else: ?>
                <p>Belum mengupload bukti transfer.</p>
            <?php endif; ?>
        </div>

        <!-- Daftar Item Pesanan -->
        <div class="info-section">
            <h3>Item Pesanan</h3>
            <table>
                <tr>
                    <th>Produk</th>
                    <th>Gambar</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                </tr>
                <?php while ($item = mysqli_fetch_assoc($query_items)): ?>
                    <tr>
                        <td><?= $item['nama_produk'] ?></td>
                        <td><img src="uploads/<?= $item['gambar'] ?>" width="50"></td>
                        <td>Rp <?= number_format($item['harga'], 0, ',', '.') ?></td>
                        <td><?= $item['jumlah'] ?></td>
                        <td>Rp <?= number_format($item['harga'] * $item['jumlah'], 0, ',', '.') ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </div>
         <a href="index.php" class="back-link">&laquo; Kembali ke Dashboard</a>
    </div>
</body>

</html>