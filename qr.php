<?php

$conn = new mysqli("localhost", "root", "", "cafetaria_fadel");
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['jumlah'])) {
    $total = 0;
    $errors = [];

    foreach ($_POST['jumlah'] as $id => $qty) {
        $id = (int)$id;
        $qty = (int)$qty;
        if ($qty > 0) {
            $res = $conn->query("SELECT * FROM menu WHERE id = $id");
            if ($res->num_rows > 0) {
                $data = $res->fetch_assoc();
                if ($data['stok'] >= $qty) {
                    $conn->query("UPDATE menu SET stok = stok - $qty WHERE id = $id");
                    $total += $data['harga'] * $qty;
                } else {
                    $errors[] = "Stok tidak cukup untuk " . $data['nama'];
                }
            }
        }
    }

    // Bootstrap 5 CDN
    echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">';
    echo "<div class='container py-5'>";
    if ($errors) {
        echo "<div class='alert alert-danger'><h4 class='alert-heading'>Terjadi Kesalahan:</h4><ul class='mb-0'>";
        foreach ($errors as $e) echo "<li>$e</li>";
        echo "</ul></div>";
    } else {
        echo "<div class='alert alert-success'><h3>Berhasil beli! Total: Rp " . number_format($total) . "</h3>";
        echo "<p><img src='qrdummy.png' width='150' class='img-thumbnail mb-3'><br>Scan QR ini untuk bayar.</p></div>";
    }
   echo "<a href='buy.php?kantin_id=" . $_POST['kantin_id'] . "' class='btn btn-primary mt-3'>Kembali</a></div>";


}
?>
