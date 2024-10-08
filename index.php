<?php include 'leads_app/includes/header.php'; ?>

<div class="container mt-5">
    <h2>Daftar Leads</h2>
    <a href="add_lead.php" class="btn btn-primary mb-3">Tambah Lead</a>

    <!-- Form Pencarian -->
    <form action="index.php" method="GET" class="mb-3">
        <div class="form-row align-items-end">
            <div class="col">
                <label for="nama_produk">Pilih Nama Produk:</label>
                <select class="form-control" id="nama_produk" name="nama_produk">
                    <option value="">Semua Produk</option>
                    <?php
                    // Koneksi ke database
                    $conn = new mysqli('localhost', 'root', '', 'db_ut');

                    // Query untuk mengambil data produk
                    $sql = "SELECT id_produk, nama_produk FROM produk";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        // Tampilkan data produk dalam dropdown
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='{$row['id_produk']}'>{$row['nama_produk']}</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="col">
                <label for="nama_sales">Pilih Nama Sales:</label>
                <select class="form-control" id="nama_sales" name="nama_sales">
                    <option value="">Semua Sales</option>
                    <?php
                    // Query untuk mengambil data sales
                    $sql = "SELECT id_sales, nama_sales FROM sales";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        // Tampilkan data sales dalam dropdown
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='{$row['id_sales']}'>{$row['nama_sales']}</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="col">
                <label for="bulan">Pilih Bulan:</label>
                <select class="form-control" id="bulan" name="bulan">
                    <option value="">Semua Bulan</option>
                    <?php
                    for ($i = 1; $i <= 12; $i++) {
                        echo "<option value='$i'>" . date("F", mktime(0, 0, 0, $i, 1)) . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col">
                <label>&nbsp;</label>
                <button type="submit" class="btn btn-primary form-control">Cari</button>
            </div>
        </div>
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tanggal</th>
                <th>Nama Sales</th>
                <th>Nama Produk</th>
                <th>No. WhatsApp</th>
                <th>Nama Lead</th>
                <th>Kota</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Query untuk mengambil data leads
            $whereClauses = [];
            if (!empty($_GET['nama_produk'])) {
                $whereClauses[] = "leads.id_produk = " . intval($_GET['nama_produk']);
            }
            if (!empty($_GET['nama_sales'])) {
                $whereClauses[] = "leads.id_sales = " . intval($_GET['nama_sales']);
            }
            if (!empty($_GET['bulan'])) {
                $whereClauses[] = "MONTH(leads.tanggal) = " . intval($_GET['bulan']);
            }
            $whereSQL = implode(" AND ", $whereClauses);
            if ($whereSQL) {
                $whereSQL = "WHERE " . $whereSQL;
            }

            $sql = "SELECT leads.id, leads.tanggal, sales.nama_sales, produk.nama_produk, leads.no_wa, leads.nama_lead, leads.kota 
                    FROM leads 
                    JOIN sales ON leads.id_sales = sales.id_sales 
                    JOIN produk ON leads.id_produk = produk.id_produk 
                    $whereSQL";

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Menampilkan data
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$row['id']}</td>";
                    echo "<td>{$row['tanggal']}</td>";
                    echo "<td>{$row['nama_sales']}</td>";
                    echo "<td>{$row['nama_produk']}</td>";
                    echo "<td>{$row['no_wa']}</td>";
                    echo "<td>{$row['nama_lead']}</td>";
                    echo "<td>{$row['kota']}</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>Tidak ada data ditemukan</td></tr>";
            }

            // Tutup koneksi
            $conn->close();
            ?>
        </tbody>
    </table>
</div>

<?php include 'leads_app/includes/footer.php'; ?>
