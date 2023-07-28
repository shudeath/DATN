<?php
    $servername = "localhost";
    $username = "id18760121_admin";
    $password = "Nguyencuong09.10";
    $dbname = "id18760121_cong_ty";
    
    $connect = new mysqli($servername, $username, $password, $dbname);
    mysqli_set_charset($connect,"utf8");
    
    $expireTime = 60*30;
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (isset ($_SESSION['expire'])){
	    $currentTime = time();
	    if ($_SESSION['expire'] < $currentTime){
	        session_destroy();
	        echo "<script>window.location.href = \"php/logout.php\";</script>";
	    }
	    else
	        $_SESSION['expire'] = $currentTime + $expireTime;
	}
?>