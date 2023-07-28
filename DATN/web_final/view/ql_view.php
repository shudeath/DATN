<?php
    include "init.php";
    if(isset($_GET["m_user_id"])){
        if ($_SESSION["Quan_ly"] == true){
            $m_user_id = $_GET["m_user_id"];
            $m_cmonth = $_GET["m"];
            $m_cyear = $_GET["y"];
        }
        else die();
    }
    else 
        die();
    
    $sql= "select * from Danh_sach where ID = '$m_user_id'";
    $result = $connect->query($sql);
    $row = $result->fetch_assoc();
    
    $sql1= "select * from Tai_khoan where ID = '$m_user_id'";
    $result1 = $connect->query($sql1);
    $row1 = $result1->fetch_assoc();
    if ($result1->num_rows == 0){
            $__sql = "INSERT INTO Tai_khoan (ID,account,password) VALUES ('$m_user_id','$m_user_id','$m_user_id')";
            $connect->query($__sql);
        }
    $id_cv = $row['ID_CV'];
    $sql2= "select * from Chuc_vu where ID_CV = '$id_cv'";
    $result2 = $connect->query($sql2);
    $row2 = $result2->fetch_assoc();
    $chuc_vu = $row2['Ten_CV'];
    
    $id_bp = $row['ID_BP'];
    $sql3= "select * from Bo_phan where ID_BP = '$id_bp'";
    $result3 = $connect->query($sql3);
    $row3 = $result3->fetch_assoc();
    $bo_phan = $row3['Ten_BP'];
    //Lay thong tin cac bo phan*************************************************
    $sql_b= "select * from Bo_phan where 1";
    $result_b = $connect->query($sql_b);
    $i=0;
    while($row_b =  mysqli_fetch_array($result_b)){
        $ID_BP[$i] = $row_b['ID_BP'];
        $Ten_BP[$ID_BP[$i]] = $row_b['Ten_BP'];
        $i++;
    }
    $sql_c= "select * from Chuc_vu where 1";
    $result_c = $connect->query($sql_c);
    $i=0;
    while($row_c =  mysqli_fetch_array($result_c)){
        $ID_CV[$i] = $row_c['ID_CV'];
        $Ten_CV[$ID_CV[$i]] = $row_c['Ten_CV'];
        $i++;
    }
    //**************************************************************************
    function dateConv($date){
        $str = "";
        $str = date("d",strtotime($date));
        $str = $str ."/";
        $str = $str .date("m",strtotime($date));
        $str = $str ."/";
        $str = $str .date("Y",strtotime($date));
        return $str;
    }
?>
<style>
    .col-4{
        max-width: 10rem;
    }
    .col-8{
        max-width: 24rem;
    }
</style>
<section class="p-0 m-0">
  <!-- Tabs navs -->
  <ul class="nav nav-tabs nav-justified mb-3" id="ex1" role="tablist">
    <li class="nav-item" role="presentation">
      <a class="nav-link active fs-6" id="ex1-tab-1" data-mdb-toggle="tab" href="#ex1-tabs-1" role="tab" aria-controls="ex1-tabs-1" aria-selected="true">Thông tin thành viên</a>
    </li>
    <li class="nav-item" role="presentation">
      <a class="nav-link fs-6" id="ex1-tab-2" data-mdb-toggle="tab" href="#ex1-tabs-2" role="tab" aria-controls="ex1-tabs-2" aria-selected="false">Bảng công tháng</a>
    </li>
  </ul>
  <!-- Tabs navs -->

  <!-- Tabs content -->
  <div class="tab-content" id="ex1-content">
    <div class="tab-pane fade active show" id="ex1-tabs-1" role="tabpanel" aria-labelledby="ex1-tab-1">
      <form action="" method="POST" class="form">
        <div class="row justify-content-center">
          <div class="col-3">
            <p>ID:</p>
          </div>
          <div class="col-8">
            <input type="text" id="ID" class="form-control" disabled name="ID"
              value="<?php echo $m_user_id ?>" placeholder="<?php echo $m_user_id ?>"/>
          </div>
        </div>
        <div class="row justify-content-center">
          <div class="col-3">
            <p>Tên đăng nhập:</p>
          </div>
          <div class="col-8">
            <input type="text" id="Tai_khoan" class="form-control" name="Tai_khoan"
              value="" placeholder="<?php echo $row1['account'] ?>"/>
          </div>
        </div>
        <div class="row justify-content-center">
          <div class="col-3">
            <p>Mật khẩu:</p>
          </div>
          <div class="col-8">
            <input type="text" id="Mat_khau" class="form-control" name="Mat_khau"
              value="" placeholder="<?php echo $row1['password'] ?>" autocomplete="off"/>
          </div>
        </div>
        <div class="row justify-content-center">
          <div class="col-3">
            <p>Tên:</p>
          </div>
          <div class="col-8">
            <input type="text" id="Ten" class="form-control" name="Ten"
              value="" placeholder="<?php echo $row['Ten'] ?>"/>
          </div>
        </div>
        <div class="row justify-content-center">
          <div class="col-3">
            <p>Họ:</p>
          </div>
          <div class="col-8">
            <input type="text" id="Ho" class="form-control" name="Ho"
                value="" placeholder="<?php echo $row['Ho'] ?>"/>
          </div>
        </div>
        <div class="row justify-content-center">
          <div class="col-3">
            <p>Địa chỉ:</p>
          </div>
          <div class="col-8">
            <input type="text" id="Dia_chi" class="form-control" name="Dia_chi"
              value="" placeholder="<?php echo $row['Dia_chi'] ?>"/>
          </div>
        </div>
        <div class="row justify-content-center">
          <div class="col-3">
            <p>Ngày sinh:</p>
          </div>
        <div class="col-8">
          <input type="date" id="Ngay_sinh" class="form-control" name="Ngay_sinh"
            value="<?php echo $row['Ngay_sinh'] ?>"/>
          </div>
        </div>
        <div class="row justify-content-center">
          <div class="col-3">
            <p>Giới tính:</p>
          </div>
          <div class="col-8">
            <div class="row mt-1">
              <div class="col-auto">
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="Gioi_tinh" value="Nam" <?php  if($row['Gioi_tinh']=="Nam") echo "checked" ?>/>
                  <label class="form-check-label" for="gt_nam"> Nam </label>
                </div>
              </div>
              <div class="col-auto">
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="Gioi_tinh" value="Nữ" <?php  if($row['Gioi_tinh']=="Nữ") echo "checked" ?>/>
                  <label class="form-check-label" for="gt_nu"> Nữ </label>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row justify-content-center">
          <div class="col-3">
            <p>Điện thoại:</p>
          </div>
        <div class="col-8">
          <input type="text" id="Dien_thoai" class="form-control" name="Dien_thoai"
            value="" placeholder="<?php echo $row['Dien_thoai'] ?>"/>
          </div>
        </div>
        <div class="row justify-content-center">
          <div class="col-3">
            <p>Email:</p>
          </div>
          <div class="col-8">
          <input type="email" id="Email" class="form-control" name="Email"
            value="" placeholder="<?php echo $row['Email'] ?>"/>
          </div>
        </div>
        <div class="row justify-content-center">
          <div class="col-3">
            <p>Bộ phận:</p>
          </div>
        <!--div class="col-8">
          <input type="text" id="Bo_phan" class="form-control" name="Bo_phan"
            value=""placeholder="<?php //echo $bo_phan ?>"/>
          </div-->
        <div class="col-8">
          <select class="form-select" aria-label="Default select example" id="Bo_phan">
            <?php 
                for ($i=0; $i < count($ID_BP); $i++){
                    echo "<option value='"  . $ID_BP[$i] . "'";
                    if($id_bp == $ID_BP[$i]) echo "selected";
                    echo ">". $Ten_BP[$ID_BP[$i]] . "</option>";
                }
            ?>
          </select>
        </div>
        </div>
        <div class="row justify-content-center">
          <div class="col-3">
            <p>Chức vụ:</p>
          </div>
          <!--div class="col-8">
            <input type="text" id="Chuc_vu" class="form-control" name="Chuc_vu"
            value="" placeholder="<?php echo $chuc_vu ?>"/>
          </div-->
          <div class="col-8">
            <select class="form-select" aria-label="Default select example" id="Chuc_vu" >
              <?php 
                for ($i=0; $i < count($ID_CV); $i++){
                    echo "<option id='bp" .$ID_CV[$i]. "' value='"  . $ID_CV[$i] . "'";
                    if ($ID_CV[$i] == $id_cv) echo "selected";
                    echo ">". $Ten_CV[$ID_CV[$i]] . "</option>";
                }
              ?>
            </select>
          </div>
        </div>
        <div class="row justify-content-center">
          <div class="col-3">
            <p>Lương:</p>
          </div>
          <div class="col-8">
          <input type="number" id="Luong" class="form-control" name="Email"
            value="" placeholder="<?php echo $row['Luong'] ?> đ"/>
          </div>
        </div>
      </div>
      </form>
<!------------------------------------------------------------------------------------->  
    <div class="tab-pane fade" id="ex1-tabs-2" role="tabpanel" aria-labelledby="ex1-tab-2">
      <div class="">
        <div class="row justify-content-center">
          <div class="col-1 flex-column" style="min-width: 4rem">
            <label for="m_curmonth" class="control-label">Tháng:</label>
          </div>
          <div class="col-1 flex-column" style="min-width: 6rem">
              <select id="m_curmonth" class="form-select" onchange="m_dateSelect()">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
              </select>
          </div>
        <div class="col-1" style="min-width: 3rem">
          <label for="m_curyear" class="control-label">Năm:</label>
        </div>
        <div class="col-1" style="min-width: 7rem">
          <div class="input-group mb-3">
            <input type="number" class="form-control" value="0" name="m_curyear" id="m_curyear" 
            onkeyup="m_dateSelect()" onchange="m_dateSelect()"/>
          </div>
        </div>
        </div>
        <div id="myTable" class="table-responsive m-0 p-0">

        </div>
        </div>
      </div>
    </div>
  <!-- Tabs content -->
</section>
<script>
    function m_defaultTable(){
        y = <?php echo $m_cyear?>;
        m = <?php echo $m_cmonth?>;
        const url = "view/cong.php?m=" + m + "&y=" + y + "&m_user_id=<?php echo $m_user_id?>";
        loadPage(url,"myTable","GET");
    }
    function m_dateSelect(){
        var y = document.getElementById("m_curyear");
        var x = document.getElementById("m_curmonth");
        var i = x.selectedIndex + 1;
        const url = "view/cong.php?m=" + i + "&y=" + y.value + "&m_user_id=<?php echo "$m_user_id"?>";
        loadPage(url,"myTable","GET");
    }
    function m_defaultTime(){
        var y = document.getElementById("m_curyear");
        y.value = "<?php echo $m_cyear?>";
        var x = document.getElementById("m_curmonth");
        
        for (var i=0; i<x.options.length; i++) {
            option = x.options[i];
            if (option.value == parseInt(<?php echo $m_cmonth?>)) {
                    option.setAttribute('selected', true);
                return; 
            }
        } 
    }
    m_defaultTime();
    m_defaultTable();
</script>
    
    