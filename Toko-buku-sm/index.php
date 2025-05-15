<?php
session_start();
include "config.php";

// untuk nampilin produk
$query = "SELECT * FROM produk";

// untuk search produk
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
if (!empty($keyword)) {
    $query .= " WHERE nama_produk LIKE '%$keyword%' OR id_kategori LIKE '%$keyword%'";
}

$result = mysqli_query($conn, $query);

// Ambil riwayat pesanan jika user sudah login
$riwayat_pesanan = [];
if (isset($_SESSION['user_id'])) {
    $query_pesanan = mysqli_query($conn, "
        SELECT * FROM pesanan 
        WHERE id_user = {$_SESSION['user_id']}
        ORDER BY created_at DESC
    ");
    while ($row = mysqli_fetch_assoc($query_pesanan)) {
        $riwayat_pesanan[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Online</title>
    <style>
        nav {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 20px;
            background-color: rgb(228, 214, 199);
        }

        nav a{
            text-decoration: none;
            color: black;
            font-weight: bold;
        }
        nav ul {
            display: flex;
            gap: 15px;
            align-items: center;
            list-style-type: none;
            padding: 0;
        }

        .produk-wrapper {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin: 20px auto; /* ini untuk membuat wrapper berada di tengah */
            padding: 20px;
            max-width: 1000px; /* batasi lebar maksimal agar tidak melebar ke seluruh layar */
        }


        .produk-card {
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 5px;
            background-color:rgb(228, 214, 199);
            text-align: center;
        }

        .riwayat-pesanan {
            margin-top: 30px;
            border-top: 1px solid #eee;
            padding-top: 20px;
        }

        .status-pending {
            color: #f39c12;
        }

        .status-processing {
            color: #3498db;
        }

        .status-shipped {
            color: #2ecc71;
        }

        .status-completed {
            color: #27ae60;
        }

        .logo {
            border-radius: 100px;
            width: 50px;
            height: 50px;
            margin-right: 20px;
        }

        .header-pencarian {
            text-align: center;
            margin-top: 30px;
        }

        .header-pencarian form {
            margin-top: 10px;
        }

        .header-pencarian input[type="text"] {
            padding: 8px;
            width: 300px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .header-pencarian button {
            padding: 8px 12px;
            border: none;
            background-color: rgb(211, 188, 163);
            color: white;
            border-radius: 4px;
            cursor: pointer;
        }

        .header-pencarian button:hover {
            background-color: #a48463;
        }

        .riwayat-pesanan table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
            font-size: 14px;
            background-color: #fdfaf7;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 10px;
            overflow: hidden;
        }

        .riwayat-pesanan th,
        .riwayat-pesanan td {
            padding: 12px 15px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        .riwayat-pesanan th {
            background-color: rgb(211, 188, 163);
            color: black;
            font-weight: bold;
            text-transform: uppercase;
        }

        .riwayat-pesanan tr:nth-child(even) {
            background-color: #f5f5f5;
        }

        .riwayat-pesanan tr:hover {
            background-color: #f0e6dd;
        }

        .riwayat-pesanan a {
            text-decoration: none;
            color: #5a3e2b;
            font-weight: bold;
        }

        .riwayat-pesanan a:hover {
            text-decoration: underline;
        }

        .riwayat-pesanan h2 {
            text-align: center;
        }


    </style>
</head>

<body>
    <nav>
        <a href="assets/logo.png">
            <img src="assets/logo.png" alt="Logo" class="logo">
        </a>

        <ul>
            <li><a href="index.php">Produk Buku</a></li>
            <li><a href="about.php">Tentang Kami</a></li>
            <li><a href="contact.php">Kontak</a></li>
        </ul>
        <div>
            <?php if (isset($_SESSION['user'])): ?>
                <span>Welcome <?php echo htmlspecialchars($_SESSION['user']); ?></span>
                <a href="logout.php">Logout</a>
                <a href="keranjang.php">Keranjang</a>
            <?php else: ?>
                <a href="login_user.php">Login</a>
                <a href="login_user.php">Keranjang</a>
            <?php endif; ?>
        </div>
    </nav>

    <div class="header-pencarian">
        <h2>Daftar Buku</h2>
        <form method="GET" action="">
            <input type="text" name="keyword" placeholder="Cari produk atau kategori..." value="<?php echo htmlspecialchars($keyword); ?>">
            <button type="submit">Cari</button>
        </form>
    </div>

    <div class="produk-wrapper">
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="produk-card">
                    <img src="admin/uploads/<?php echo htmlspecialchars($row['gambar']); ?>" alt="<?php echo htmlspecialchars($row['nama_produk']); ?>" width="150">
                    <h3><?php echo htmlspecialchars($row['nama_produk']); ?></h3>
                    <p>Kategori: <?php echo htmlspecialchars($row['id_kategori']); ?></p>
                    <p>Harga: Rp<?php echo number_format($row['harga'], 0, ',', '.'); ?></p>
                    <p>Stok: <?php echo $row['stok']; ?></p>
                    <button onclick="addToCart(<?php echo $row['id_produk']; ?>)">Tambah Keranjang</button>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Buku tidak tersedia.</p>
        <?php endif; ?>
    </div>

    <!-- Riwayat Pemesanan -->
    <?php if (isset($_SESSION['user_id']) && !empty($riwayat_pesanan)): ?>
        <div class="riwayat-pesanan">
            <h2>Riwayat Pemesanan Anda</h2>
            <table border="1" cellpadding="10" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>ID Pesanan</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($riwayat_pesanan as $pesanan): ?>
                        <tr>
                            <td><?php echo $pesanan['id_pesanan']; ?></td>
                            <td><?php echo date('d/m/Y H:i', strtotime($pesanan['created_at'])); ?></td>
                            <td>Rp <?php echo number_format($pesanan['total'], 0, ',', '.'); ?></td>
                            <td class="status-<?php echo str_replace('_', '-', $pesanan['status']); ?>">
                                <?php
                                $status = [
                                    'pending' => 'pending',
                                    'diproses' => 'Diproses',
                                    'dikirim' => 'Dikirim',
                                    'selesai' => 'Selesai'
                                ];
                                echo $status[$pesanan['status']] ?? $pesanan['status'];
                                ?>
                            </td>
                            <td>
                                <a href="detail_pesanan_user.php?id=<?php echo $pesanan['id_pesanan']; ?>">Detail</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

    <script>
        function addToCart(productId) {
            <?php if (!isset($_SESSION['user_id'])): ?>
                alert("Silakan login terlebih dahulu!");
                window.location.href = "login_user.php";
            <?php else: ?>
                fetch("add_to_cart.php", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/x-www-form-urlencoded"
                        },
                        body: "id_produk=" + productId
                    })
                    .then(response => response.json())
                    .then(data => {
                        alert(data.message);
                        if (data.status === "success") {
                            window.location.reload();
                        }
                    });
            <?php endif; ?>
        }
    </script>
</body>

</html>
