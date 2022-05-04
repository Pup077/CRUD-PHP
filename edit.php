<?php
    require_once('connection.php'); ##เชื่อมต่อกับไฟต์ connerct.php

    if(isset($_REQUEST['update_id'])) { ##กำหนดค่าใหม่ 
        try {
            $id = $_REQUEST['update_id']; ## ทำการรีเควต ให้ทำการ Update ตามค่า id
            $select_stmt = $db->prepare("SELECT * FROM mytable WHERE id = :id");
            $select_stmt->bindParam(':id', $id);
            $select_stmt->execute();
            $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
            extract($row);
        } catch(PDOException $e) { ## เตือน Error
            $e->getMessage();
        }
    }

    if (isset($_REQUEST['btn_update'])) { ##กำหนดค่าใหม่ 
        $name_up = $_REQUEST['txt_Name'];
        $phone_up = $_REQUEST['txt_Phone'];
        $email_up = $_REQUEST['txt_Email'];

        if (empty($name_up)) { ## ตั้งคำเตือนเมื่อไม่มีข้อความ
            $errorMsg = "Please Enter Name";
        } else if (empty($phone_up)) {
            $errorMsg = "Plase Enter Phone";
        } else if (empty($email_up)) {
            $errorMsg = "Plase Enter Email";
        } else {
            try {
                if (!isset($errorMsg)) { ## ถ้ามีการแก้ไขข้อความเข้ามาจะอัพเดทค่า ไปในฐานข้อมูลที่กำหนด
                    $update_stmt = $db->prepare("UPDATE mytable SET name = :Name_up, phone= :Phone_up, email= :Email_up WHERE id = :id");
                    $update_stmt->bindParam(':Name_up', $name_up);
                    $update_stmt->bindParam(':Phone_up', $phone_up);
                    $update_stmt->bindParam(':Email_up', $email_up);
                    $update_stmt->bindParam(':id', $id);

                    if ($update_stmt->execute()) { ## เมื่อกดปุ่ม Update จะทำการลบข้อมูลและอัพเดทช้อความและไปขึ้นในหน้า index
                        $updateMsg = "Record Update Successfully...";
                        header("refresh:2;index.php");
                    }
                }

            } catch(PDOException $e) { ## แจ้งเตือน Error
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
    <title>Edit</title>

    <link rel="stylesheet" href="bootstrap/bootstrap.css">
</head>
<body>
    <div class="container">
    <div class="display-3 text-center">Edit Data</div>
    <br>

    <?php
        if (isset($errorMsg)) {
    ?>
        <div class="alert alert-danger">
            <strong>Wrong! <?php echo $errorMsg; ?></strong> 
        </div>
    <?php } ?>

    <?php
        if (isset($updateMsg)) {
    ?>
        <div class="alert alert-success">
            <strong>Success! <?php echo $updateMsg; ?></strong> 
        </div> 
    <?php } ?>

    <form method="post" class="form-horizontal">

            <div class="form-group">   
               <div class="row">
               <label for="name" class="col-sm-3 control-lable">Name</label>
                <div class="col-sm-9">
                    <input type="text" name="txt_Name" class="form-control" value="<?php echo $name; ?>"> 
                </div>
               </div>
            </div>
            <div class="form-group">
                <div class="row">
                <label for="phone" class="col-sm-3 control-lable">Phone</label>
                <div class="col-sm-9">
                    <input type="text" name="txt_Phone" class="form-control" value="<?php echo $phone; ?>">
                </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                <label for="email" class="col-sm-3 control-lable">Email</label>
                <div class="col-sm-9">
                    <input type="text" name="txt_Email" class="form-control" value="<?php echo $email; ?>">
                </div>
                </div>
            </div>
            <div class="form-group text-center">
                <div class="col-md-12 mt-3">
                    <input type="submit" name="btn_update" class="btn btn-success" value="Update">
                    <a href="index.php" class="btn btn-danger">Cancel</a>
                </div>
            </div>

    </form>

    <script src="js/slim.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.js"></script>
</body>
</html>