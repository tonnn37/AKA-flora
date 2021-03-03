<?php 

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "db_ntk";
    
    // Create Connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);
        
    
    //กำหนด charset ให้ฐานข้อมุลอ่านภาษาไทยได้
    mysqli_query($conn,'set names utf8');

    // Check connection
    if (!$conn) {
        die("Connection failed" . mysqli_connect_error());
    }
