<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>INVENTARISASI BARANG</title>
  <style>

  </style>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body class="bg-success">
  <div class="container">
    <div class="position-absolute top-50 start-50 translate-middle w-100 h-75">
      <div class="card w-75 mw-100 h-100 m-auto">
        <div class="card-header"></div>
        <div class="card-body">
          <div class="card-title mb-3">
            <h4>Inventarisasi Barang</h4>
          </div>
          <div class="d-flex justify-content-between">
            <a href="tambah-barang.php" class="btn btn-sm btn-success">+ Add</a>
            <div class="d-flex">
              <a href="pdf-template.php" class="btn btn-sm btn-danger me-2" target="_blank">PDF</a>
              <a href="excel-template.php" class="btn btn-sm btn-success">EXCEL</a>
            </div>
          </div>

          <?php
          include "function/function.php";
          $no = 1;
          $kategori = mysqli_query($conn, "SELECT * FROM kategori");

          if (isset($_GET['keyword']) and isset($_GET['filter'])) {
            $key = $_GET['keyword'];
            $filter = $_GET['filter'];
            if ($_GET['filter'] == 'all') {
              $dataBarang = mysqli_query($conn, "SELECT * FROM barang JOIN kategori using(id_kategori) WHERE nama_barang LIKE '%$key%'"); // SEARCH
            } else {
              $dataBarang = mysqli_query($conn, "SELECT * FROM barang JOIN kategori using(id_kategori) WHERE nama_barang LIKE '%$key%' AND id_kategori = '$filter'"); //SEARCH & FILTER
            }
          } else {
            $dataBarang = mysqli_query($conn, "SELECT * FROM barang JOIN kategori using(id_kategori)"); // ALL
          }
          ?>

          <!-- Search -->
          <form action="" method="GET" class="my-3">
            <div class="input-group">
              <input type="text" name="keyword" id="" class="form-control" placeholder="Cari..." value="<?= isset($_GET['keyword']) ? $_GET['keyword'] : '' ?>">

              <select name="filter">
                <option value="all">All</option>
                <?php foreach ($kategori as $data) : ?>
                  <option value="<?= $data['id_kategori'] ?>" 
                  <?= isset($_GET['filter']) ? ($_GET['filter'] == $data['id_kategori'] ? 'selected' : '') : '' ?>>
                    <?= $data['nama_kategori'] ?>
                  </option>
                <?php endforeach; ?>
              </select>

              <button type="submit" class="btn btn-success">Search</button>
            </div>
          </form>

          <!-- TABLE -->
          <div class="mt-3 overflow-auto" style="height: 70%;">
            <table class="table table-sm table-hover">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Barang</th>
                  <th>Kategori</th>
                  <th>Stok</th>
                  <th>Gambar</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                foreach ($dataBarang as $barang) :
                ?>
                  <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $barang['nama_barang'] ?></td>
                    <td><?= $barang['nama_kategori'] ?></td>
                    <td><?= $barang['stok'] ?></td>
                    <td>Gambar</td>
                    <td>
                      <a href="edit-barang.php?id=<?= $barang['id_barang'] ?>" class="btn btn-sm btn-warning">Edit</a>
                      <a href="edit-barang.php?id=<?= $barang['id_barang'] ?>" class="btn btn-sm btn-danger">Delete </a>
                    </td>
                  </tr>
                <?php
                endforeach;
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>
