<?php
session_start();
session_unset();      // Menghapus semua variabel sesi
session_destroy();    // Mengakhiri sesi

// Redirect ke halaman login (ubah jika perlu)
header("Location: login.php");
exit();
?>
