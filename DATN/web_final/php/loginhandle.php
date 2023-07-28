<?php    
    if(isset($_POST["login"])){
		$tk = $_POST["username"];
		$mk = $_POST["password"];
		$re = "no";
		if (isset($_POST["remember"]))
		    $re = $_POST["remember"];
		$sql= "select * from Tai_khoan where account = '$tk' and password = '$mk'";
        $result = $connect->query($sql);
        $row = $result->fetch_assoc();
        $user_id = $row["ID"];
        if ($result->num_rows  == 1){
		    if ( $re != "yes"){
                $_SESSION['expire'] = time() + $expireTime;
		    }
			$_SESSION["username"] = $tk;
			$_SESSION["password"] = $mk;
			$_SESSION["user_id"] = $user_id;
			$_SESSION["logged"] = "true";
			
			$sql2= "select * from Danh_sach where ID = '$user_id'";
            $result2 = $connect->query($sql2);
            $row2 = $result2->fetch_assoc();
            $_SESSION["Ten"] = $row2["Ten"];
            $_SESSION["ID_CV"] = $row2["ID_CV"];
            $id_cv = $_SESSION["ID_CV"];
            
            $sql3= "select * from Phan_quyen where ID_CV = '$id_cv'";
            $result3 = $connect->query($sql3);
            
            $sql4= "select * from So_luong_truy_cap where 1";
            $result4 = $connect->query($sql4);
            $row4 = $result4->fetch_assoc();
            $count = $row4['S'];
            $count++;
            $sql4= "update So_luong_truy_cap set S=$count where 1";
            $connect->query($sql4);
            
            if ($result3->num_rows > 0){
                $_SESSION["Quan_ly"] = true;
            }
            else $_SESSION["Quan_ly"] = false;
		}
		else{
		    //$_SESSION["logerr"] = "true";
		    echo "<script type='text/javascript'>alert('Sai thông tin đăng nhập');location.href = '/'</script>";
		}
	}
?>