<?php
// Variabel yang diharapkan: $judul (string). Opsional: $css (path stylesheet).
$css = $css ?? '../assets/style.css';
?><!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($judul) ?></title>
    <link rel="stylesheet" href="<?= e($css) ?>">
</head>
<body>
<main class="container">
    <h1><?= e($judul) ?></h1>
