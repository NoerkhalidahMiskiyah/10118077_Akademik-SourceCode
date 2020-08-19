<?php
$conn = mysqli_connect("localhost", "root", "", "db_akademik");

function query($query) {
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ( $row = mysqli_fetch_assoc($result)) {
        $rows [] = $row;
    }
    return $rows;
}

function tambah ($data) {
    global $conn;
    
    $nim = htmlspecialchars ($data["nim"]);
    $nama = htmlspecialchars ($data["nama"]);
    $kode_mk = htmlspecialchars ($data["kode_mk"]);
    $nama_mk = htmlspecialchars ($data["nama_mk"]);


    $query = "INSERT INTO mahasiswa VALUES('','$nim', '$nama', '$kode_mk', '$nama_mk','')";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}


function hapus($id) {
    global $conn;
    mysqli_query($conn, "DELETE FROM mahasiswa WHERE id = $id");
    return mysqli_affected_rows($conn);
}

function ubah($data) {
    global $conn;

    $id = $data["id"];
    $nim = htmlspecialchars ($data["nim"]);
    $nama = htmlspecialchars ($data["nama"]);
    $kode_mk = htmlspecialchars ($data["kode_mk"]);
    $nama_mk = htmlspecialchars ($data["nama_mk"]);
    $na = htmlspecialchars ($data["na"]);
    $indeks = htmlspecialchars ($data["indeks"]);

    $query = "UPDATE mahasiswa SET
            nim = '$nim',
            nama = '$nama',
            kode_mk = '$kode_mk',
            nama_mk = '$nama_mk',
            na = '$na',
            indeks = '$indeks'
            WHERE id = $id
            ";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function cari($keyword) {
    $query = "SELECT * FROM mahasiswa WHERE 
        nim LIKE '%$keyword%'
    ";
    return query($query);
}

function registrasi($data) {
    global $conn;

    $username = strtolower(stripslashes($data["username"]));
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $password2 = mysqli_real_escape_string($conn, $data["password2"]);

    // cek username ada
    $result = mysqli_query($conn, "SELECT username FROM user WHERE username = '$username'");
    if ( mysqli_fetch_assoc($result) ) {
        echo "<script>
            alert('username sudah ada')</script>";
            return false;
    }
    // cek konfirmasi passord
    if ( $password !== $password2 ) {
        echo "<script>
            alert ('password tidak sama');
        </script>";
        return false;
    } 

    //enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);

    //tambahkan user baru
    mysqli_query($conn, "INSERT INTO user VALUES('', '$username', '$password')");
    return mysqli_affected_rows($conn);
}
?>