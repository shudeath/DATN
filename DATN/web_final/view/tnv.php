<?php
    include "init.php";
    $pattern_text = "/^[a-zA-Z-' ÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ]*$/";
    $pattern_number = "/^[0-9 -\+\-]+$/";
    if(isset($_POST['addemp'])){
        $ID         = test_input($_POST['id']);
        $account    = test_input($_POST['account']);
        $password   = test_input($_POST['password']);
        $Ten        = test_input($_POST['ten']);
        $Ho         = test_input($_POST['ho']);
        $Dia_chi    = test_input($_POST['dia_chi']);
        $Ngay_sinh  = $_POST['ngay_sinh'];
        $Gioi_tinh  = $_POST['gioi_tinh'];
        $Dien_thoai = test_input($_POST['dien_thoai']);
        $Email      = test_input($_POST['email']);
        $ID_BP      = $_POST['id_bp'];
        $ID_CV      = $_POST['id_cv'];
        $Luong      = $_POST['luong'];
        global $pattern_text;
        global $pattern_number;
        $_SESSION['tnvMsg'] = "";
        $sql0= "select * from Danh_sach where ID = '$ID'";
        $result0 = $connect->query($sql0);
        if($result0 -> num_rows !=0){
            $_SESSION['tnvMsg']  = "ID đã tồn tại";
            die();
        }
        if (empty($account)) {
            $_SESSION['tnvMsg']  .= "Tên đăng nhập bị bỏ trống<br>";
        }
        if (empty($password)) {
            $_SESSION['tnvMsg']  .= "Mật khẩu bị bỏ trống<br>";
        }
        if (!empty($Ten)) {
            if (!preg_match($pattern_text,$Ten)) {
                $_SESSION['tnvMsg']  .= "Tên không được chứa ký tự đặc biệt hoặc chữ số<br>";
            }
        }
        else{
            $_SESSION['tnvMsg']  .= "Tên bị bỏ trống<br>";
        }
        if (!empty($Ho)) {
            if (!preg_match($pattern_text,$Ho)) {
                $_SESSION['tnvMsg']  .= "Họ không được chứa ký tự đặc biệt<br>";
            }
        }
        else{
            $_SESSION['tnvMsg']  .= "Họ bị bỏ trống<br>";
        }
        if (!empty($Dien_thoai)) {
            if (!preg_match($pattern_number,$Dien_thoai)) {
                $_SESSION['tnvMsg']  .= "Số điện thoại chỉ được bao gồm dấu \"-\", \"+\" và chữ số<br>";
            }
        }
        else{
            $_SESSION['tnvMsg']  .= "Số điện thoại bị bỏ trống<br>";
        }
        if(!empty($Email)){
            if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['tnvMsg'] .= "Email sai định dạng<br>";
            }
        }
        else{
             $_SESSION['tnvMsg'] .= "Email bị bỏ trống<br>";
        }
        if ($_SESSION['tnvMsg'] == ""){
            $sql2 = "INSERT INTO Danh_sach (
            ID,
            Ho,
            Ten,
            Dia_chi,
            Ngay_sinh,
            Dien_thoai,
            Gioi_tinh,
            Email,
            ID_BP,
            ID_CV,
            Luong) values (
            '$ID',
            '$Ho',
            '$Ten',
            '$Dia_chi',
            '$Ngay_sinh',
            '$Dien_thoai',
            '$Gioi_tinh',
            '$Email',
            '$ID_BP',
            '$ID_CV',
            $Luong)";
            if ($connect->query($sql2) != TRUE){
                $_SESSION['tnvMsg']  .= "Lỗi SQL:". $connect->error ."<br>";
                $_SESSION['tnvMsg']  .= "Thêm nhân viên thất bại";
                die();
            }
            $sql = "INSERT INTO Tai_khoan (ID, account, password) values ('$ID', '$account', '$password')";
            if ($connect->query($sql) != TRUE){
                $_SESSION['tnvMsg']  .= "Lỗi SQL:". $connect->error ."<br>";
                $_SESSION['tnvMsg']  .= "Thêm nhân viên thất bại";
                die();
            }
            $_SESSION['tnvMsg']  = "Thêm nhân viên thành công";
        }
        else{
            $_SESSION['tnvMsg']  .= "Thêm nhân viên thất bại";
        }
        die();
    }
    /**********************/
    $sql= "select * from Bo_phan where 1";
    $result = $connect->query($sql);
    $i=0;
    while($row =  mysqli_fetch_array($result)){
        $ID_BP[$i] = $row['ID_BP'];
        $Ten_BP[$ID_BP[$i]] = $row['Ten_BP'];
        $i++;
    }
    $sql2= "select * from Chuc_vu where 1";
    $result2 = $connect->query($sql2);
    $i=0;
    while($row2 =  mysqli_fetch_array($result2)){
        $ID_CV[$i] = $row2['ID_CV'];
        $Ten_CV[$ID_CV[$i]] = $row2['Ten_CV'];
        $i++;
    }
    /**********************/
    $curdate = date("Y-m-d");
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
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
<script>
    var _tnvModal = document.getElementById('tnvModal');
    var tnvModal = new bootstrap.Modal(document.getElementById('tnvModal'), {});
    var addForm = document.getElementById('addForm');
    <?php if(isset($_SESSION['tnvMsg']))
    echo "tnvModal.show();"?>
    window.onclick = function(event) {
        if (event.target == _tnvModal) {
            tnvModal.hide();
        }
    }
    /************************/
    function getValue(){
        ID          = document.getElementById("ID").value;
        Tai_khoan   = document.getElementById("Tai_khoan").value;
        Mat_khau    = document.getElementById("Mat_khau").value;
        Ten         = document.getElementById("Ten").value;
        Ho          = document.getElementById("Ho").value;
        Dia_chi     = document.getElementById("Dia_chi").value;
        Ngay_sinh   = document.getElementById("Ngay_sinh").value;
        Dien_thoai  = document.getElementById("Dien_thoai").value;
        Email       = document.getElementById("Email").value;
        ID_BP       = document.getElementById("Bo_phan").value;
        ID_CV       = document.getElementById("Chuc_vu").value;
        Gioi_tinh   = document.querySelector('input[name="Gioi_tinh"]:checked').value;
        Luong       = document.getElementById("luong").value;
    }
    addForm.onkeyup = function(){
        getValue();
        if(ID.length < 6 ||Ten==""||Ho=="" || Dien_thoai=="" || Email ==""
        || Tai_khoan=="" || Mat_khau==""){
            document.getElementById('addBtn').disabled = true;
        }
        else{
            document.getElementById('addBtn').disabled = false;
        }
    };
    /************************/
    function bpSelect(){
        //ID_BP = document.getElementById("Bo_phan").value;
        //console.log( document.getElementById("bp" + ID_BP).value);
    }
    function addEmployee()
    {
        getValue();
        spinner();
        $.post("view/tnv.php",
        {
            addemp      : true,
            id          : ID,
            account     : Tai_khoan,
            password    : Mat_khau,
            ten         : Ten,
            ho          : Ho,
            dia_chi     : Dia_chi,
            ngay_sinh   : Ngay_sinh,
            gioi_tinh   : Gioi_tinh,
            dien_thoai  : Dien_thoai,
            email       : Email,
            id_bp       : ID_BP,
            id_cv       : ID_CV,
            luong       : Luong
        },
        function(data,status){
            if (String(status) == "success"){
                $("#maincontent").load("view/tnv.php");
            }
        });
    }
    var navBar = document.getElementById("main-navbar");
    var side = String(window.innerHeight-navBar.offsetHeight - 32) + "px";
    document.getElementsByClassName("card")[0].style.minHeight = side;
</script>

<div class="modal fade" id="tnvModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h5 class="modal-title w-100" id="exampleModalLabel">Thông báo</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="container-fluid" id="tnvbody">
            <?php
                if(isset($_SESSION['tnvMsg'])){
                    echo $_SESSION['tnvMsg'];
                    unset($_SESSION['tnvMsg']);
                }
            ?>
        </div>
      </div>
      <div class="modal-footer text-center">
        <div class="w-100">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Đóng</button>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="p-3">
<div class="card">
<div class="justify-content-center">
  <form action="" method="POST" class="" id="addForm">
    <h4 class="text-center p-3">THÊM NHÂN VIÊN MỚI</h4>
    <div class="row justify-content-center">
      <div class="col-4">
        <p>ID: <strong class="text-danger">*</strong></p>
      </div>
      <div class="col-8">
        <input type="text" id="ID" class="form-control" name="ID"
        onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))"
          value="" placeholder="Điền đủ 6 kí tự ID" maxlength="6" autocomplete="off"/>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-4">
        <p>Tên đăng nhập: <strong class="text-danger">*</strong></p>
      </div>
      <div class="col-8">
        <input type="text" id="Tai_khoan" class="form-control" name="Tai_khoan"
          value="" placeholder="Tên đăng nhập"/>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-4">
        <p>Mật khẩu: <strong class="text-danger">*</strong></p>
      </div>
      <div class="col-8">
        <input type="text" id="Mat_khau" class="form-control" name="Mat_khau"
          value="" placeholder="Mật khẩu" autocomplete="off"/>
          <span class="text-right" id="Mat_khau_span"></span>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-4">
        <p>Tên: <strong class="text-danger">*</strong></p>
      </div>
      <div class="col-8">
        <input type="text" id="Ten" class="form-control" name="Ten"
          value="" placeholder="Tên"/>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-4">
        <p>Họ: <strong class="text-danger">*</strong></p>
      </div>
      <div class="col-8">
        <input type="text" id="Ho" class="form-control" name="Ho"
            value="" placeholder="Họ"/>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-4">
        <p>Địa chỉ:</p>
      </div>
      <div class="col-8">
        <input type="text" id="Dia_chi" class="form-control" name="Dia_chi"
          value="" placeholder="Địa chỉ"/>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-4">
        <p>Ngày sinh:</p>
      </div>
    <div class="col-8">
      <input type="date" id="Ngay_sinh" class="form-control" name="Ngay_sinh"
        value="<?php echo $curdate ?>" placeholder="Ngày sinh"/>
      </div>
    </div>
    <div class="row justify-content-center align-item-center">
      <div class="col-4">
        <p>Giới tính:</p>
      </div>
      <div class="col-8">
        <div class="row mt-1">
          <div class="col-auto">
            <div class="form-check">
              <input class="form-check-input" type="radio" id="gt_nam" name="Gioi_tinh" value="Nam"/>
              <label class="form-check-label" for="gt_nam"> Nam </label>
            </div>
          </div>
          <div class="col-auto">
            <div class="form-check">
              <input class="form-check-input" type="radio" id="gt_nu" name="Gioi_tinh" value="Nữ" checked/>
              <label class="form-check-label" for="gt_nu"> Nữ </label>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-4">
        <p>Điện thoại: <strong class="text-danger">*</strong></p>
      </div>
    <div class="col-8">
      <input type="text" id="Dien_thoai" class="form-control" name="Dien_thoai"
        value="" placeholder="Điện thoại"/>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-4">
        <p>Email: <strong class="text-danger">*</strong></p>
      </div>
      <div class="col-8">
        <input type="email" id="Email" class="form-control" name="Email"
        value="" placeholder="Email"/>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-4">
        <p>ID bộ phận:</p>
      </div>
      <div class="col-8">
        <select class="form-select" aria-label="Default select example" id="Bo_phan" onchange="bpSelect()">
          <?php 
            for ($i=0; $i < count($ID_BP); $i++){
                echo "<option value="  . $ID_BP[$i] . ">" . $Ten_BP[$ID_BP[$i]] . "</option>";
            }
          ?>
        </select>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-4">
        <p>ID chức vụ:</p>
      </div>
      <div class="col-8">
        <select class="form-select" aria-label="Default select example" id="Chuc_vu" onchange="cvSelect()">
          <?php 
            for ($i=0; $i < count($ID_CV); $i++){
                echo "<option id='bp" .$ID_CV[$i]. "' value='"  . $ID_CV[$i] . "'>" . $Ten_CV[$ID_CV[$i]] . "</option>";
            }
          ?>
        </select>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-4">
        <p>Lương: <strong class="text-danger">*</strong></p>
      </div>
    <div class="col-8">
      <input type="number" id="luong" class="form-control" name="luong"
        value="0" placeholder="Tiền lương"/>
      </div>
    </div>
    <div class="text-center p-3">
      <button type="button" class="btn btn-primary" name="addBtn" id="addBtn" onclick="addEmployee()" disabled>Thêm</button>
    </div>
  </form>
</div>
</div>