<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>UTS</title>

	<style type="text/css">

::selection {
    background-color: #E13300;
    color: white;
}

::-moz-selection {
    background-color: #E13300;
    color: white;
}

body {
    background-color: #f5f5f5;
	margin: 20px;
    font: 16px/24px 'Times New Roman', serif;
    color: #555;
}

a {
    color: #003399;
    font-weight: bold;
    text-decoration: none;
}

a:hover {
    color: #97310e;
}

h1 {
    color: #333;
    background-color: #ddd;
    border-bottom: 1px solid #D0D0D0;
    font-size: 24px;
    font-weight: bold;
    margin: 0 0 20px 0;
    padding: 20px;
}

#body {
	margin: 20px;
    padding: 15px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

p {
    margin: 0 0 15px;
}

p.footer {
    text-align: right;
    font-size: 14px;
    border-top: 1px solid #D0D0D0;
    line-height: 32px;
    padding: 10px;
    margin: 20px 0 0 0;
}

#container {
    margin: 20px;
    border: 1px solid #D0D0D0;
    box-shadow: 0 0 8px #D0D0D0;
}

	</style>
</head>
<body>

<div id="container">
    <h2>KEDAI MAKANAN</h2>

    <form action="<?= site_url('admin/tambah_pesanan'); ?>" method="post">
        <label>Jenis Makanan:</label>
        <select name="jenis_makanan" required>
            <option value="nasi_goreng">Nasi Goreng</option>
            <option value="pecel_lele">Pecel Lele</option>
            <option value="nasi">Nasi</option>
            <!-- Tambahkan jenis makanan lain sesuai kebutuhan -->
        </select>
        <label>Jumlah:</label>
        <input type="number" name="jumlah" required>
        <button type="submit">Tambah ke Pesanan</button>
    </form>

    <h2>Pesanan Anda</h2>

    <ul>
        <?php foreach ($kasir as $index => $item): ?>
            <li>
                <?= $item['jenis_makanan']; ?> - <?= $item['jumlah']; ?> -
                <?php
                // Pengecekan sebelum menggunakan number_format
                if (isset($item['harga'])) {
                    echo 'Harga: Rp ' . number_format($item['harga'], 0, ',', '.');
                } else {
                    echo 'Harga tidak tersedia';
                }
                ?>
                <a href="<?= site_url('admin/hapus_pesanan/'.$index); ?>">Hapus</a>
            </li>
        <?php endforeach; ?>
    </ul>

    <p>Total Harga: Rp <?php echo isset($kasir) ? number_format(array_sum(array_column($kasir, 'harga')), 0, ',', '.') : '0'; ?></p>

    <a href="<?= site_url('admin/hapus_semua_pesanan'); ?>">Hapus Pesanan</a>
</div>

</body>
</html>