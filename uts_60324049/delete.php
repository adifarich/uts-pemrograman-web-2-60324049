<?php
require_once 'config/database.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: index.php?pesan=id_tidak_valid');
    exit;
}

$id = (int) $_GET['id'];

if ($id <= 0) {
    header('Location: index.php?pesan=id_tidak_valid');
    exit;
}

$cek = $conn->prepare("SELECT id_kategori FROM kategori WHERE id_kategori = ?");
$cek->bind_param('i', $id);
$cek->execute();
$cek->store_result();

if ($cek->num_rows === 0) {
    $cek->close();
    header('Location: index.php?pesan=id_tidak_valid');
    exit;
}
$cek->close();

$stmt = $conn->prepare("DELETE FROM kategori WHERE id_kategori = ?");
$stmt->bind_param('i', $id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    $stmt->close();
    header('Location: index.php?pesan=hapus_berhasil');
    exit;
} else {
    $stmt->close();
    header('Location: index.php?pesan=hapus_gagal');
    exit;
}
