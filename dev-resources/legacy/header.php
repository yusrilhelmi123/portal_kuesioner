<?php
session_start();
if (!isset($_SESSION['student_id'])) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kuisioner PM</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="navbar">
        <div class="logo">POINTMARKET</div>
        <div class="user-info" style="font-size: 0.9rem; font-weight: 500;">
            <?= htmlspecialchars($_SESSION['nama']) ?> (
            <?= htmlspecialchars($_SESSION['npm']) ?>)
        </div>
    </div>
    <div class="container">