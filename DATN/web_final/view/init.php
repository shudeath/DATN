<?php
    $servername = "localhost";
    $username = "id18760121_admin";
    $password = "Nguyencuong09.10";
    $dbname = "id18760121_cong_ty";
    $expireTime = 30*60;
    $connect = new mysqli($servername, $username, $password, $dbname);
    mysqli_set_charset($connect,"utf8");
    
    if (session_status() === PHP_SESSION_NONE && !headers_sent())
        session_start();
    
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