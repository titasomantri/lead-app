<?php include 'leads_app/includes/header.php'; ?>

<div class="container mt-5">
    <h2>Tambah Lead</h2>
    <a href="index.php" class="btn btn-secondary mb-3">Kembali</a> <!-- Tombol Kembali -->
    
    <form action="simpan_lead.php" method="POST">
        <div class="form-group">
            <label for="tanggal">Tanggal:</label>
            <input type="date" class="form-control" id="tanggal" name="tanggal" required>
        </div>
        
        <div class="form-group">
            <label for="id_sales">Nama Sales:</label>
            <select class="form-control" id="id_sales" name="id_sales" required>
                <option value="">Pilih Sales</option>
                <?php
                // Koneksi ke database
                $conn = new mysqli('localhost', 'root', '', 'db_ut');

                // Cek koneksi
                if ($conn->connect_error) {
                    die("Koneksi gagal: " . $conn->connect_error);
                }

                // Query untuk mengambil data sales
                $sql = "SELECT id_sales, nama_sales FROM sales"; // Pastikan tabel sales ada
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Tampilkan data sales dalam dropdown
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='{$row['id_sales']}'>{$row['nama_sales']}</option>";
                    }
                }

                // Tutup koneksi
                $conn->close();
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="id_produk">Nama Produk:</label>
            <select class="form-control" id="id_produk" name="id_produk" required>
                <option value="">Pilih Produk</option>
                <?php
                // Koneksi ke database
                $conn = new mysqli('localhost', 'root', '', 'db_ut');

                // Cek koneksi
                if ($conn->connect_error) {
                    die("Koneksi gagal: " . $conn->connect_error);
                }

                // Query untuk mengambil data produk
                $sql = "SELECT id_produk, nama_produk FROM produk"; // Pastikan tabel produk ada
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Tampilkan data produk dalam dropdown
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='{$row['id_produk']}'>{$row['nama_produk']}</option>";
                    }
                }

                // Tutup koneksi
                $conn->close();
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="no_wa">No. WhatsApp:</label>
            <input type="text" class="form-control" id="no_wa" name="no_wa" required>
        </div>
        <div class="form-group">
            <label for="nama_lead">Nama Lead:</label>
            <input type="text" class="form-control" id="nama_lead" name="nama_lead" required>
        </div>
        <div class="form-group">
            <label for="kota">Kota:</label>
            <input type="text" class="form-control" id="kota" name="kota" required>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Simpan Lead</button>
            <button type="button" class="btn btn-secondary" onclick="window.history.back();">Cancel</button> <!-- Tombol Cancel -->
        </div>
    </form>
</div>

<?php include 'leads_app/includes/footer.php'; ?>
