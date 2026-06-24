<?php
if (!isset($page_title)) {
    $page_title = "Admin Panel | ShopEase";
}

if (!isset($page_badge)) {
    $page_badge = "Admin Panel";
}

if (!isset($page_heading)) {
    $page_heading = "Dashboard";
}

if (!isset($page_description)) {
    $page_description = "Manage your ShopEase admin panel.";
}

$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body class="admin-body">

<div class="admin-layout">