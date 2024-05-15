<?php
// Konfigurasi database
$servername = "localhost";
$username = "u1577682_sjs";
$password = "password";
$dbname = "u1577682_sjs";

// Membuat koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Jika file csv terupload
if (isset($_POST['submit'])) {
    // Mendapatkan nama file csv
    $filename = $_FILES['file']['name'];

    // Mendapatkan ekstensi file csv
    $ext = pathinfo($filename, PATHINFO_EXTENSION);

    // Cek jika ekstensi file csv benar
    if ($ext == 'csv') {
        // Mendapatkan sementara nama file
        $filetmp = $_FILES['file']['tmp_name'];

        // Membuka file csv
        $handle = fopen($filetmp, "r");

        // Membaca baris pertama (header)
        $header = fgetcsv($handle);

        // Loop untuk membaca data dari file csv
        while (($data = fgetcsv($handle)) !== false) {
            // Memasukkan data ke dalam variabel
            $id_pegawai = $data[0];
            $id_jabatan = $data[1];
            $id_departemen = $data[2];
            $username = $data[3];
            $name = $data[4];
            $email = $data[5];
            $password = password_hash($data[6], PASSWORD_DEFAULT); // Mengenkripsi password dengan bcrypt
            $jenis_kelamin = $data[7];
            $tempat_lahir = $data[8];
            $tanggal_lahir = $data[9];
            $no_hp = $data[10];
            $alamat = $data[11];
            $no_bpjs = $data[12];
            $tanggal_masuk = $data[13];
            $tanggal_berakhir = $data[14];
            $status = $data[15];

            // Query untuk memasukkan data ke dalam tabel users
            $sql = "INSERT INTO users (id_pegawai, id_jabatan, id_departemen, username, name, email, password, jenis_kelamin, tempat_lahir, tanggal_lahir, no_hp, alamat, no_bpjs, tanggal_masuk, tanggal_berakhir, status)
                    VALUES ('$id_pegawai', '$id_jabatan', '$id_departemen', '$username', '$name', '$email', '$password', '$jenis_kelamin', '$tempat_lahir', '$tanggal_lahir', '$no_hp', '$alamat', '$no_bpjs', '$tanggal_masuk', '$tanggal_berakhir', '$status')";

            // Eksekusi query
            if ($conn->query($sql) === true) {
                echo "Data berhasil diinputkan";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }

        // Menutup file csv
        fclose($handle);
    } else {
        echo "Ekstensi file yang diupload harus berupa csv";
    }
}

// Menutup koneksi
$conn->close();
?>
