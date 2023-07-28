<?php
    $servername = "localhost";
    $username = "id18760121_admin";
    $password = "Nguyencuong09.10";
    $dbname = "id18760121_cong_ty";
    
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    else{
        $id = $_GET["id"];
        
        $sql_c = "SELECT * FROM Danh_sach WHERE ID = '$id'";
        $check = $conn->query($sql_c);
        if ($check->num_rows  == 0) {
            echo "ID không tồn tại!";
        }
        else{
            $settime = "SET time_zone = '+07:00';";
            $sql0 = "SELECT * FROM Ra_ve WHERE ID = '$id' AND Ngay_ve = CURRENT_DATE();";
            $conn->query($settime);
            $result = $conn->query($sql0);
        
            if ($result->num_rows > 0) {
                $conn->query($settime);
                $sql = "INSERT INTO Ra_ve (ID, Ngay_ve, Gio_ve) VALUES ('$id', CURRENT_DATE(), CURRENT_TIME())";
            }
            else{
                $conn->query($settime);
                $sql = "INSERT INTO Ra_ve (ID, Ngay_ve, Gio_ve) VALUES ('$id', CURRENT_DATE(), CURRENT_TIME())";
            
                if ($conn->query($sql) === TRUE) {
                    echo "Ra ve!";
                } 
                else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }
        }
        $conn->close();
    }
?>