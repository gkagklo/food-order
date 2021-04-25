<?php
 include('../config/constants.php');
 include('login-check.php');
 ?>

<html>
    <head>
        <title>Food Order Website - Home Page</title>
        <link rel="stylesheet" href="../css/admin.css">
        <script src="../js/jquery-3.5.1.min.js"></script>
        <script src="../js/sweetalert2.all.min.js"></script>
        <script src="https://kit.fontawesome.com/5c82625db1.js" crossorigin="anonymous"></script>
    </head>

    <body>
        <!-- Menu section starts-->
        <div class="menu">
            <div class="wrapper">
            <ul class="text-center">
                <li><a href="index.php">Home</a></li>
                <li><a href="manage-admin.php">Admin</a></li>
                <li><a href="manage-category.php">Category</a></li>
                <li><a href="manage-food.php">Food</a></li>
                <li><a href="manage-order.php">Order</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
            </div>            
        </div>
        <!-- Menu section ends-->
   