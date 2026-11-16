<?php
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=umkm_sales;charset=utf8mb4', 'root', '', [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
]);
function e($s){ return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
function rp($n){ return 'Rp ' . number_format((float)$n, 0, ',', '.'); }
