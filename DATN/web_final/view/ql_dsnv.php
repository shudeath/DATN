
<?php
    include "init.php";
    if (isset($_GET['bp'])){
        $id_bo_phan = $_GET['bp'];
        $m = $_GET['m'];
        $y = $_GET['y'];
    }
    else die();
    if ($id_bo_phan == '0'){
        $user_id = $_GET['id'];
        $sql2= "select * from Danh_sach where ID = '$user_id'";
        $result2 = $connect->query($sql2);
        $row2 = $result2->fetch_assoc();
        $id_cv = $row2["ID_CV"];
 
        $sql1= "select * from Phan_quyen where ID_CV = '$id_cv'";
        $result1 = $connect->query($sql1);
        $i = 0;
        $ds_id_bp = array();
        while ($row1 = $result1 -> fetch_assoc()){
            $ds_id_bp[$i] = $row1['ID_BP'];
            $i++;
        }
        $sql= "select * from Danh_sach where ID_BP = '";
        $sql .= $ds_id_bp[0] . "'";
        for ($i=1; $i < count($ds_id_bp); $i++){
            $sql .= " or ID_BP = '".$ds_id_bp[$i]. "'";
        }
        $sql.= " order by ID";
    }
    else{
        $sql= "select * from Danh_sach where ID_BP = '$id_bo_phan' ORDER BY ID";
    }
    $result = $connect->query($sql);
    //Lấy tên chức vụ
    $sql1= "select * from Chuc_vu where 1";
    $result1 = $connect->query($sql1);
    $i=0;
    $tongLuong = 0;
    while($row1 = $result1->fetch_assoc()){
        $ID_CV[$i] = $row1['ID_CV'];
        $Ten_CV[$ID_CV[$i]] = $row1['Ten_CV'];
        $i++;
    }
    
    $sql1= "select * from Bo_phan where 1";
    $result1 = $connect->query($sql1);
    $i=0;
    $tongLuong = 0;
    while($row1 = $result1->fetch_assoc()){
        $ID_BP[$i] = $row1['ID_BP'];
        $Ten_BP[$ID_BP[$i]] = $row1['Ten_BP'];
        $i++;
    }
    
    echo "<table class='table table-hover table-sm table-striped' >
        <tr></tr> 
      <tbody id='qlnvtable' class=''>";
    while ($row = $result->fetch_assoc()){
        getProfile($row['ID'],$m,$y);
    }
    
    function getProfile($id,$m,$y){
        $connect = $GLOBALS['connect'];
        $sql= "select * from Danh_sach where ID = '$id'";
        $result = $connect->query($sql);
        $row = $result->fetch_assoc();
        $id_bo_phan = $row["ID_BP"];
        $cong = 0.0;
        $so_lan_muon = 0;
        $sql1= "select * from Diem_danh where ID = '$id'";
        $result1 = $connect->query($sql1);
         $_sql= "select * from Cai_dat where 1";
        $_result = $connect->query($_sql);
        $_row = $_result->fetch_assoc();

        while ($row1 = $result1->fetch_assoc()){
            if (intval(date('m',strtotime($row1['Ngay_diem_danh']))) == $m && 
            intval(date('Y',strtotime($row1['Ngay_diem_danh']))) == $y){
                $cong+=1.0;
                /*if (timeSubtr($row1['Gio_diem_danh'],$_row['Gio_bat_dau']) != -1){
                    $so_lan_muon++;
                }*/
                
            }
        }
         $GLOBALS['tongLuong'] += $cong * $row["Luong"];
        echo "<tr style='cursor: pointer;' id='".$row['ID']."' onclick='loadUserProfile(this.id)'>";
        echo "<td id='col1'>" . $row['ID'] . "</td>";
        echo "<td id='col2'>" . $row['Ho'] . " " .  $row['Ten']. "</td>";
        echo "<td id='col3'>" . TenBP($row['ID_BP']). "</td>";
        echo "<td id='col3'>" . TenCV($row['ID_CV']) . "</td>";
        echo "<td id='col4' class='text-center'>" . $cong . "</td>";
        echo "<td id='col5' class='text-center'>" . number_format($cong * $row["Luong"] , 0, ',', '.') . " đ</td>";
        echo "</tr>";
    }
    function TenBP($idbp){
        $tenbp = $GLOBALS['Ten_BP'][$idbp];
        $tenbp = explode(' ',$tenbp);
        return ucfirst($tenbp[2]) .' '.  $tenbp[3];
    }
    function TenCV($idcv){
        return $GLOBALS['Ten_CV'][$idcv];
    }
    function timeSubtr($time1,$time2){
        /* time1 - time2 */
        $result = strtotime($time1) - strtotime($time2);
        if ($result < 0)
            return -1;
        else
            return round($result/60);
    }
    echo "</tbody></table>";
    //$_SESSION['tongLuong'] = $tongLuong;
    echo "<table class='table table-hover table-sm Tong w-100'>";
    echo "<tfoot class=' mb-3'><tr>";
    echo "<th style='width:75%;'></th>";
    echo "<th class='text-center col4' scope='col'>Tổng:</th>";
    echo "<th class='text-center col5' scope='col'>"  . number_format($tongLuong,0,',','.') . " đ</th>";
    echo "</tr></tfoot>";
    echo "</table>";
?>
