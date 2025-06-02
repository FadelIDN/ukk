<?php
$conn = new mysqli("localhost", "root", "", "cafetaria_fadel");
$kantin_id = isset($_GET['kantin_id']) ? (int)$_GET['kantin_id'] : 0;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kantin Online Sederhana</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand text-dark" href="landing.html">Cafetaria Telkom School</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="about.html">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="list.html">Cafetaria List</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="contact.php">How To Buy</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Contact Us</a>
        </li>
      </ul>
    </div>
  </nav>
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-body">
            <h3 class="text-center mb-4">Cafetaria Telkom</h3>
            <form method="GET" class="mb-3">
                <label for="kantin_id" class="form-label"><b>Pilih Kantin:</b></label>
                <select name="kantin_id" id="kantin_id" class="form-select" onchange="this.form.submit()">
                    <option value="">-- Pilih Kantin --</option>
                    <?php
                    $q = $conn->query("SELECT * FROM kantin");
                    while ($row = $q->fetch_assoc()) {
                        $selected = ($kantin_id == $row['id']) ? 'selected' : '';
                        echo "<option value='{$row['id']}' $selected>{$row['nama']}</option>";
                    }
                    ?>
                </select>
            </form>

            <?php if ($kantin_id): ?>
                <form method="POST" action="qr.php">
                    <input type="hidden" name="kantin_id" value="<?= $kantin_id ?>">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Menu</th><th>Harga</th><th>Stok</th><th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $menu = $conn->query("SELECT * FROM menu WHERE id_kantin = $kantin_id");
                            while ($row = $menu->fetch_assoc()):
                            ?>
                            <tr>
                                <td><?= $row['nama'] ?></td>
                                <td>Rp <?= number_format($row['harga']) ?></td>
                                <td><?= $row['stok'] ?></td>
                                <td>
                                    <input type="number" name="jumlah[<?= $row['id'] ?>]" 
                                           class="form-control jumlah" 
                                           data-harga="<?= $row['harga'] ?>" 
                                           max="<?= $row['stok'] ?>" min="0" value="0">
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                    <div class="mb-3">
                        <strong>Total Harga: <span id="totalHarga">Rp 0</span></strong>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Beli</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
document.querySelectorAll('.jumlah').forEach(input => {
    input.addEventListener('input', () => {
        let total = 0;
        document.querySelectorAll('.jumlah').forEach(i => {
            const qty = parseInt(i.value) || 0;
            const harga = parseInt(i.dataset.harga) || 0;
            total += qty * harga;
        });
        document.getElementById('totalHarga').textContent = 'Rp ' + total.toLocaleString('id-ID');
    });
});
</script>
<footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
    <div class="col-md-4 d-flex align-items-center p-3" >
      <span class="text-muted">© 2021 Company, Inc</span>
    </div>
  </footer>
</body>
</html>