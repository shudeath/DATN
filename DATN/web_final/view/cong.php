<?php
    include "init.php";
    if(isset($_GET["m_user_id"])){
        if ($_SESSION["Quan_ly"] == true)
            $user_id = $_GET["m_user_id"];
        else die();
    }
    else 
        $user_id = $_SESSION['user_id'];
    $month = $_GET['m'];
    $year = $_GET['y'];
    
    tableLoad($month, $year);
    function tableLoad($month, $year){
        $list=array();
        $thu = array();
        for($d=1; $d<=31; $d++)
        {
            $time=mktime(12, 0, 0, $month, $d, $year);          
            if (date('m', $time)==$month){       
                $list[]=date('Y-m-d', $time);
                $thu[]=dayConv(date('D', $time));
            }
        }
        $length =  count($thu);
        include "init.php";
        $user_id = $GLOBALS['user_id'];
        $sql0= "select * from Danh_sach where ID='$user_id'";
        $result0 = $connect->query($sql0);
        $row0 = $result0->fetch_assoc();
        
        $cong = 0;
        $slmuon = 0;
        $nghi = 0;
        $t=time();
        $curdate = date("Y-m-d",$t);
        for ($i = 0; $i < $length && $list[$i] <= $curdate; $i++){
            $date = $list[$i];
            $sql= "select * from Diem_danh where ID = '$user_id' and Ngay_diem_danh = '$date'";
            $result = $connect->query($sql);
            $sql2= "select * from Ra_ve where ID = '$user_id' and Ngay_ve = '$date'";
            $result2 = $connect->query($sql2);
            
            $_sql= "select * from Cai_dat where 1";
            $_result = $connect->query($_sql);
            $_row = $_result->fetch_assoc();
            
            if ($result->num_rows > 0 || $result2->num_rows > 0) {
                $row = $result->fetch_assoc();
                $row2 = $result2->fetch_assoc();
                if (timeSubtr($row['Gio_diem_danh'],$_row['Gio_bat_dau']) > 0){
                    $slmuon++;
                }
                $cong++;
            }
            else{
                if($thu[$i] != "Thứ Bảy" && $thu[$i] != "Chủ Nhật")
                    $nghi++;
            }
        }
        echo"
        <div class='mt-3'>
        <div class='m-0 p-0'>
        <table class='table table-hover table-sm overflow-auto'>
            <tr>
                <th scope='col' class='myTble'> Công tháng:</th>
                <th>". $cong ."</th>
            </tr><tr>
                <th scope='col' class='myTble'> Lương:</th>
                <th>". number_format($row0['Luong'] , 0, ',', '.') ." đ</th>
            </tr>
            <tr>
                <th scope='col' class='myTble'> Lương tháng:</th>
                <th>".  number_format($cong * $row0['Luong'] , 0, ',', '.') ." đ</th>
            </tr>
            <tr>
                <th scope='col' class='myTble'> Số lần đi muộn:</th>
                <th>". $slmuon ."</th>
            </tr>
            <tr>
                <th scope='col' class='myTble'> Số ngày nghỉ:</th>
                <th>". $nghi ."</th>
            </tr>
        </table>
        </div></div>";
        echo
            "
            <div class='table-responsive m-0 p-0'>
            <table class='table table-hover table-sm overflow-auto table-striped'>
              <thead>
                <tr>
                  <th scope='col'>Ngày</th>
                  <th scope='col'>Thứ</th>
                  <th scope='col'>Công</th>
                  <th scope='col'>Thời gian có mặt</th>
                  <th scope='col'>Số phút đi muộn</th>
                  <th scope='col'>Thời gian ra về</th>
                </tr>
              <thead>
            <tbody id='tableBody'>";
        for ($i = 0; $i < $length; $i++){
            echo "<tr>";
            echo "<td >". dateConv($list[$i]) ."</th>";
            echo "<td>". $thu[$i] ."</th>";
            $date = $list[$i];
            $sql= "select * from Diem_danh where ID = '$user_id' and Ngay_diem_danh = '$date'";
            $result = $connect->query($sql);
            $sql2= "select * from Ra_ve where ID = '$user_id' and Ngay_ve = '$date'";
            $result2 = $connect->query($sql2);
            
            $_sql= "select * from Cai_dat where 1";
            $_result = $connect->query($_sql);
            $_row = $_result->fetch_assoc();
            
            if ($result->num_rows > 0 || $result2->num_rows > 0) {
                $row = $result->fetch_assoc();
                $row2 = $result2->fetch_assoc();
                echo "<td><i class=\"fa fa-check\" style=\"color:#299438\"></th>";
                echo "<td>". $row['Gio_diem_danh']. "</th>";
                $spmuon =timeSubtr($row['Gio_diem_danh'],$_row['Gio_bat_dau']);
                if ( $spmuon < 0)
                    $spmuon = 0;
                echo "<td>". $spmuon . "</th>";
                echo "<td>". $row2['Gio_ve']. "</th>";
            }
            else{
                if ($list[$i] <= $curdate && ($thu[$i] != "Thứ Bảy" && $thu[$i] != "Chủ Nhật") )
                    echo "<td><i class=\"fa fa-remove\" style=\"color:#DB4035\"></th>";
                else
                    echo "<td></th>";
                echo "<td></th>";
                echo "<td></th>";
                echo "<td></th>";
            }
            echo "</tr>";
        }
        echo "</tbody></table></div>";
    }
    function dayConv($date){
        switch ($date){
            case "Mon": return "Thứ Hai";
            case "Tue": return "Thứ Ba";
            case "Wed": return "Thứ Tư";
            case "Thu": return "Thứ Năm";
            case "Fri": return "Thứ Sáu";
            case "Sat": return "Thứ Bảy";
            case "Sun": return "Chủ Nhật";
        }
    }
    function dateConv($date){
        $str = "";
        $str = date("d",strtotime($date));
        $str = $str ."/";
        $str = $str .date("m",strtotime($date));
        $str = $str ."/";
        $str = $str .date("Y",strtotime($date));
        return $str;
    }
    function timeSubtr($time1,$time2){
        /* time1 - time2 */
        $result = strtotime($time1) - strtotime($time2);
        /*if ($result < 0)
            return 0;
        else*/
            return round($result/60);
    }
?>
<style>
    .myTble{
        max-width: 4rem;
    }
</style>     