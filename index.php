<?php
    require_once('connection.php'); ##เชื่อมต่อกับไฟต์ connerct.php

    if (isset($_REQUEST['delete_id'])) { ## ให้ทำการร้องขอค่า id สำหรับลบข้อมูล
        $id = $_REQUEST['delete_id']; ## ร้องขอให้ id นั้นทำการลบ

        $select_stmt = $db->prepare("SELECT * FROM mytable WHERE id = :id");  
        $select_stmt->bindParam(':id', $id);
        $select_stmt->execute(); 
        $row = $select_stmt->fetch(PDO::FETCH_ASSOC);

        // Delete an original record from db
        $delete_stmt = $db->prepare('DELETE FROM mytable WHERE id = :id'); ## เตรียมพร้อมที่จะลบข้อมูล
        $delete_stmt->bindParam(':id', $id);
        $delete_stmt->execute(); ## จะทำการทำลายข้อมูลในตารางฐานข้อมูลที่กำหนด

        header('Location:index.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>test3</title>

    <link rel="stylesheet" href="bootstrap/bootstrap.css">
</head>
<body>
    <div class="container">
    <div class="display-3 text-center">From</div>
    <a href="add.php" class="btn btn-success mb-3">AddData</a>
    <table class="table table-striped table-bordered table-hover">
        <thead> 
            <tr>
                <th>Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Edit Data</th>
                <th>Delete Data</th>
            </tr>
        </thead>

        <tbody>
            <?php
                $select_stmt = $db->prepare("SELECT * FROM mytable");  ##ดึงข้อมูลจากฐานข้อมูล
                $select_stmt->execute(); ##เลือกข้อมูลที่ลบ

                while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
            ?>
            
                <tr>
                    <td><?php echo $row["name"]; ?></td> 
                    <td><?php echo $row["phone"]; ?></td>
                    <td><?php echo $row["email"]; ?></td>
                    <td><a href="edit.php?update_id=<?php echo $row["id"]; ?>" class="btn btn-primary">EditData</a></td> 
                    <td><a href="?delete_id=<?php echo $row["id"]; ?>" class="btn btn-danger">DeleteData</a></td>
                </tr>

                <?php } ?>
        </tbody>
    </table>
    </div>

    

    <script src="js/slim.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.js"></script>
</body>
</html>