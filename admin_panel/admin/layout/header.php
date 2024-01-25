<?php
ob_start();
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">

    <link rel="icon" type="image/png" href="<?php echo BASE_URL; ?>uploads/favicon.png">

    <title>Admin Panel</title>

    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="<?php echo BASE_URL; ?>dist-admin/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>dist-admin/css/font_awesome_5_free.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>dist-admin/css/select2.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>dist-admin/css/duotone-dark.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>dist-admin/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>dist-admin/css/iziToast.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>dist-admin/css/fontawesome-iconpicker.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>dist-admin/css/bootstrap4-toggle.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>dist-admin/css/style.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>dist-admin/css/components.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>dist-admin/css/air-datepicker.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>dist-admin/css/spacing.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>dist-admin/css/custom.css">

    <script src="<?php echo BASE_URL; ?>dist-admin/js/jquery-3.7.0.min.js"></script>
    <script src="<?php echo BASE_URL; ?>dist-admin/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo BASE_URL; ?>dist-admin/js/popper.min.js"></script>
    <script src="<?php echo BASE_URL; ?>dist-admin/js/tooltip.js"></script>
    <script src="<?php echo BASE_URL; ?>dist-admin/js/jquery.nicescroll.min.js"></script>
    <script src="<?php echo BASE_URL; ?>dist-admin/js/moment.min.js"></script>
    <script src="<?php echo BASE_URL; ?>dist-admin/js/stisla.js"></script>
    <script src="<?php echo BASE_URL; ?>dist-admin/js/jscolor.js"></script>
    <script src="<?php echo BASE_URL; ?>dist-admin/js/bootstrap-tagsinput.min.js"></script>
    <script src="<?php echo BASE_URL; ?>dist-admin/js/select2.full.min.js"></script>
    <script src="<?php echo BASE_URL; ?>dist-admin/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo BASE_URL; ?>dist-admin/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo BASE_URL; ?>dist-admin/js/iziToast.min.js"></script>
    <script src="<?php echo BASE_URL; ?>dist-admin/js/fontawesome-iconpicker.js"></script>
    <script src="<?php echo BASE_URL; ?>dist-admin/js/air-datepicker.min.js"></script>
    <script src="<?php echo BASE_URL; ?>dist-admin/tinymce/tinymce.min.js"></script>
    <script src="<?php echo BASE_URL; ?>dist-admin/js/bootstrap4-toggle.min.js"></script>
</head>

<body>
<div id="app">
    <div class="main-wrapper">