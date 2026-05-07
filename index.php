<?php

include 'koneksi.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);

$method = $_SERVER['REQUEST_METHOD'];

/*
=================================
GET = AMBIL DATA
POST = TAMBAH DATA
DELETE = HAPUS DATA
=================================
*/

if ($method == 'GET') {

    $data = mysqli_query($koneksi, "SELECT * FROM users");

    $hasil = [];

    while ($d = mysqli_fetch_assoc($data)) {
        $hasil[] = $d;
    }

    echo json_encode([
        "status" => true,
        "message" => "Data berhasil diambil",
        "data" => $hasil
    ]);
}


/*
=================================
POST TAMBAH DATA
=================================
*/

elseif ($method == 'POST') {

    $nama  = $_POST['nama'] ?? '';
    $sandi = $_POST['sandi'] ?? '';

    if ($nama == '' || $sandi == '') {

        echo json_encode([
            "status" => false,
            "message" => "Nama dan sandi wajib diisi"
        ]);

        exit;
    }

    $query = mysqli_query(
        $koneksi,
        "INSERT INTO users (nama, sandi)
         VALUES ('$nama', '$sandi')"
    );

    if ($query) {

        echo json_encode([
            "status" => true,
            "message" => "Data berhasil ditambahkan"
        ]);

    } else {

        echo json_encode([
            "status" => false,
            "message" => "Gagal tambah data",
            "error" => mysqli_error($koneksi)
        ]);
    }
}

    
elseif ($method == 'PUT') {

    $data = json_decode(file_get_contents("php://input"), true);

    $id    = $data['id'] ?? '';
    $nama  = $data['nama'] ?? '';
    $sandi = $data['sandi'] ?? '';

    if ($id == '' || $nama == '' || $sandi == '') {

        echo json_encode([
            "status" => false,
            "message" => "ID, nama, dan sandi wajib diisi"
        ]);

        exit;
    }

    $query = mysqli_query(
        $koneksi,
        "UPDATE users 
         SET nama='$nama', sandi='$sandi'
         WHERE id='$id'"
    );

    if ($query) {

        echo json_encode([
            "status" => true,
            "message" => "Data berhasil diupdate"
        ]);

    } else {

        echo json_encode([
            "status" => false,
            "message" => "Gagal update data",
            "error" => mysqli_error($koneksi)
        ]);
    }
}

/*
=================================
DELETE DATA
=================================
*/

elseif ($method == 'DELETE') {

    parse_str(file_get_contents("php://input"), $_DELETE);

    $id = $_DELETE['id'] ?? '';

    if ($id == '') {

        echo json_encode([
            "status" => false,
            "message" => "ID wajib diisi"
        ]);

        exit;
    }

    $query = mysqli_query(
        $koneksi,
        "DELETE FROM users WHERE id='$id'"
    );

    if ($query) {

        echo json_encode([
            "status" => true,
            "message" => "Data berhasil dihapus"
        ]);

    } else {

        echo json_encode([
            "status" => false,
            "message" => "Gagal hapus data",
            "error" => mysqli_error($koneksi)
        ]);
    }
}

else {

    echo json_encode([
        "status" => false,
        "message" => "Method tidak didukung"
    ]);
}
?>
