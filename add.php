<?php
    require_once('connection.php'); ##เชื่อมต่อกับไฟต์ connerct.php

    if(isset($_REQUEST['btn_insert'])) { ##กำหนดค่าใหม่ 
        $name = $_REQUEST['txt_Name'];
        $phone = $_REQUEST['txt_Phone'];
        $email = $_REQUEST['txt_Email'];    

        if (empty($name)) {  ## ตั้งคำเตือนเมื่อไม่มีข้อความ
            $errorMsg = "Please Enter Name";
        } else if (empty($phone)) {
            $errorMsg = "Please Enter Phone";
        } else if (empty($email)) {
            $errorMsg = "Please Enter Email";            
        } else {
            try {
                if (!isset($errorMsg)) { ## ถ้ามีข้อความเข้ามาจะส่งค่า ไปในฐานข้อมูลที่กำหนด
                    $insert_stmt = $db->prepare("INSERT INTO mytable(name, phone, email) VALUES (:Name, :Phone, :Email)");
                    $insert_stmt->bindParam(':Name', $name);
                    $insert_stmt->bindParam(':Phone', $phone);
                    $insert_stmt->bindParam(':Email', $email);

                    if ($insert_stmt->execute()) { ## เมื่อกดปุ่ม insert จะแสดงช้อความและไปขึ้นในหน้า index
                        $insertMsg = "Insert Successfully...";
                        header("refresh:2;index.php");
                    }
                }
            } catch (PDOException $e) { ## แจ้งเตือน Error
                echo $e->getMessage();
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add</title>

    <link rel="stylesheet" href="bootstrap/bootstrap.css">
</head>
<body>
    <div class="container">
    <div class="display-3 text-center">AddData</div>

    <?php ## เช็คว่ามี Error ไหม
        if (isset($errorMsg)) {
    ?>
        <div class="alert alert-danger">
            <strong>Wrong! <?php echo $errorMsg; ?></strong> 
        </div>
    <?php } ?>

    <?php ## แจ้งว่า เพึ่มข้อมูลได้
        if (isset($insertMsg)) {
    ?>
        <div class="alert alert-success">
            <strong>Success! <?php echo $insertMsg; ?></strong> 
        </div> 
    <?php } ?>

    <form method="post" class="form-horizontal mt-5">

            <div class="form-group  text-center">   
               <div class="row">
               <label for="name" class="col-sm-3 control-lable">Name</label>
                <div class="col-sm-9">
                    <input type="text" name="txt_Name" class="form-control" placeholder="Enter Name...">
                </div>
               </div>
            </div>
            <div class="form-group  text-center">
                <div class="row">
                <label for="phone" class="col-sm-3 control-lable">Phone</label>
                <div class="col-sm-9">
                    <input type="text" name="txt_Phone" class="form-control" placeholder="Enter Phone...">
                </div>
                </div>
            </div>
            <div class="form-group  text-center">
                <div class="row">
                <label for="email" class="col-sm-3 control-lable">Email</label>
                <div class="col-sm-9">
                    <input type="text" name="txt_Email" class="form-control" placeholder="Enter Email...">
                </div>
                </div>
            </div>
            <div class="form-group text-center">
                <div class="col-md-12 mt-3">
                    <input type="submit" name="btn_insert" class="btn btn-success" value="Insert">
                    <a href="index.php" class="btn btn-danger">Cancel</a>
                </div>
            </div>

    </form>

    <script src="js/slim.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.js"></script>
</body>
</html>