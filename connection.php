<?php
    ##-> เช็ตเชื่อมต่อกับฐานข้อมูล
    $db_host = "localhost";
    $db_user = "root";
    $db_password = "";
    $db_name = "test";

    try {
        $db = new PDO("mysql:host={$db_host}; dbname={$db_name}",$db_user,$db_password); ##-> สร้างการเชื่อมต่อกับฐานข้อมูลด้วยรูปแบบ PDO ซึงเป็นออปเจ็ทของ SQL
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    } catch(PDOEXCEPTION $e) {
        $e->getMessage(); ##-> แจ้งข้อความError
    }


?>