<?php
// Koneksi ke database
$conn = new mysqli('localhost', 'root', '', 'db_ut');

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Cek jika data dikirim melalui POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil data dari form dan sanitasi
    $tanggal = isset($_POST['tanggal']) ? htmlspecialchars($_POST['tanggal']) : '';
    $id_sales = isset($_POST['id_sales']) ? (int)$_POST['id_sales'] : 0;  // Menggunakan ID sales
    $id_produk = isset($_POST['id_produk']) ? (int)$_POST['id_produk'] : 0; // Menggunakan ID produk
    $no_wa = isset($_POST['no_wa']) ? htmlspecialchars($_POST['no_wa']) : '';
    $nama_lead = isset($_POST['nama_lead']) ? htmlspecialchars($_POST['nama_lead']) : '';
    $kota = isset($_POST['kota']) ? htmlspecialchars($_POST['kota']) : '';

    // Cek apakah ada perubahan data berdasarkan ID
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0; // Ambil ID dari input (jika ada)

    // Query untuk mengecek data lama
    $sql = "SELECT * FROM leads WHERE id = ?";
    $stmt = $conn->prepare($sql);

    // Cek apakah statement berhasil disiapkan
    if ($stmt) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();

        // Cek apakah data ada dan bandingkan
        $dataChanged = false;
        if ($data) {
            if ($data['tanggal'] != $tanggal || $data['id_sales'] != $id_sales || 
                $data['id_produk'] != $id_produk || $data['no_wa'] != $no_wa || 
                $data['nama_lead'] != $nama_lead || $data['kota'] != $kota) {
                $dataChanged = true;
            }
        }
        
        // Tutup statement
        $stmt->close();
    } else {
        echo "Error: " . $conn->error;
    }

    // Query untuk menyimpan data leads
    $sql = "INSERT INTO leads (tanggal, id_sales, id_produk, no_wa, nama_lead, kota) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    // Cek apakah statement berhasil disiapkan
    if ($stmt) {
        // Persiapkan dan ikat parameter
        $stmt->bind_param("siisss", $tanggal, $id_sales, $id_produk, $no_wa, $nama_lead, $kota);
        
        // Eksekusi statement
        if ($stmt->execute()) {
            if ($dataChanged) {
                echo "Data telah berubah dan berhasil disimpan!";
            } else {
                echo "Leads berhasil disimpan!";
            }
            // Redirect atau kembali ke halaman daftar leads
            header("Location: index.php");
            exit();
        } else {
            echo "Error saat menyimpan data: " . $stmt->error;
        }
        
        // Tutup statement
        $stmt->close();
    } else {
        echo "Error: " . $conn->error;
    }
}

// Tutup koneksi
$conn->close();
?>
