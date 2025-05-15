<?php
session_start();
include "config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login_user.php");
    exit;
}

// Ambil data keranjang
$query = mysqli_query($conn, "
    SELECT produk.nama_produk, produk.harga, keranjang.jumlah 
    FROM keranjang 
    JOIN produk ON keranjang.id_produk = produk.id_produk 
    WHERE keranjang.id_user = {$_SESSION['user_id']}
");

$total = 0;
$item_count = mysqli_num_rows($query);
?>
<!DOCTYPE html>
<html>

<head>
    <title>Keranjang</title>
    <script>
        function validateCheckout() {
            <?php if ($item_count == 0): ?>
                alert("Keranjang kosong! Tambahkan produk terlebih dahulu.");
                window.location.href = "index.php";
                return false;
            <?php else: ?>
                return true;
            <?php endif; ?>
        }
    </script>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f0eb;
            color: #4e342e;
            margin: 0;
            padding: 20px;
        }

        h2 {
            color: #6d4c41;
            text-align: center;
        }

        div {
            background-color: #d7ccc8;
            border: 1px solid #a1887f;
            border-radius: 8px;
            padding: 15px;
            margin: 15px auto;
            max-width: 600px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        h3 {
            margin: 0 0 10px 0;
        }

        p {
            margin: 5px 0;
        }

        h4 {
            text-align: center;
            color: #5d4037;
        }

        a {
            display: block;
            width: fit-content;
            margin: 20px auto;
            background-color: #8d6e63;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
        }

        a:hover {
            background-color: #6d4c41;
        }
    </style>
</head>

<body>
    <h2>Keranjang Belanja</h2>
    <?php while ($row = mysqli_fetch_assoc($query)): ?>
        <div>
            <h3><?php echo $row['nama_produk']; ?></h3>
            <p>Harga: Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></p>
            <p>Jumlah: <?php echo $row['jumlah']; ?></p>
        </div>
        <?php $total += $row['harga'] * $row['jumlah']; ?>
    <?php endwhile; ?>
    <h4>Total: Rp <?php echo number_format($total, 0, ',', '.'); ?></h4>


    <div style="margin-top: 20px;">
        <a href="checkout.php" onclick="return validateCheckout()" style="background: #6d4c41; color: white; padding: 10px 20px; text-decoration: none;">Checkout</a>
    </div>

</body>

</html>