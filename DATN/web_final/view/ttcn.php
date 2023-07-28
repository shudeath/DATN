<?php
    include "init.php";
    $user_id = $_SESSION["user_id"];

    $sql= "select * from Danh_sach where ID = '$user_id'";
    $result = $connect->query($sql);
    $row = $result->fetch_assoc();
    if(isset($_POST["update"])){
        $_SESSION['profileUpMsg'] = "";
        if (!empty($_POST["Ten"])) {
            if (!preg_match("/^[a-zA-Z-' ÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂ
            ưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ]*$/",$_POST["Ten"])) {
                $_SESSION['profileUpMsg']  .= "Tên không được chứa ký tự đặc biệt<br>";
            }
            else{
                updateCol("Ten",$_POST['Ten']);
                $_SESSION['profileUpMsg']  .= "Cập nhật tên thành công<br>";
            }
        }
        if (!empty($_POST["Ho"])) {
            if (!preg_match("/^[a-zA-Z-' ÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂ
            ưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ]*$/",$_POST["Ho"])) {
                $_SESSION['profileUpMsg']  .= "Họ không được chứa ký tự đặc biệt<br>";
            }
            else{
                updateCol("Ho",$_POST['Ho']);
                $_SESSION['profileUpMsg']  .= "Cập nhật họ thành công<br>";
            }
        }
        if (!empty($_POST["Dia_chi"])) {
            updateCol("Dia_chi",$_POST['Dia_chi']);
            $_SESSION['profileUpMsg']  .= "Cập nhật địa chỉ thành công<br>";
        }
        if (!empty($_POST["Ngay_sinh"]) && $_POST["Ngay_sinh"] != $row['Ngay_sinh']) {
            updateCol("Ngay_sinh",$_POST['Ngay_sinh']);
            $_SESSION['profileUpMsg']  .= "Cập nhật ngày sinh thành công<br>";
        }
        if (!empty($_POST["Gioi_tinh"]) && $_POST["Gioi_tinh"] != $row['Gioi_tinh']) {
            updateCol("Gioi_tinh",$_POST['Gioi_tinh']);
            $_SESSION['profileUpMsg']  .= "Cập nhật giới tính thành công<br>";
        }
        if (!empty($_POST["Dien_thoai"])) {
            if (!preg_match("/^[0-9 -\+\-]+$/",$_POST["Dien_thoai"]))
                $_SESSION['profileUpMsg']  .= "Số điện thoại nhập không đúng hoặc chứa ký tự đặc biệt, chữ cái<br>";
            else{
                updateCol("Dien_thoai",$_POST['Dien_thoai']);
                $_SESSION['profileUpMsg']  .= "Cập nhật số điện thoại thành công<br>";
            }
        }
		if(!empty($_POST["Email"])){
		    $Email = $_POST["Email"];
    		if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['profileUpMsg'] .= "Email sai định dạng<br>";
            }
            else{
        		updateCol("Email",$Email);
        		$_SESSION['profileUpMsg'] .= "Cập nhật email thành công<br>";
            }
		}
        if($_SESSION['profileUpMsg'] == "" )
            $_SESSION['profileUpMsg'] = "Chưa có thông tin nào được cập nhật";
        die();
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
    
    function dateConv($date){
        $str = "";
        $str = date("d",strtotime($date));
        $str = $str ."/";
        $str = $str .date("m",strtotime($date));
        $str = $str ."/";
        $str = $str .date("Y",strtotime($date));
        return $str;
    }
	function updateCol($col,$value){
	    include "init.php";
        $user_id = $GLOBALS["user_id"];
        echo $user_id;
	    $_sql= "update Danh_sach SET $col='$value' WHERE ID='$user_id'";
        $_result = $connect->query($_sql);
        //echo "<script>alert('Cap nhat thanh cong!')</script>";
	}
	function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
?>
<script>
    var _myModal = document.getElementById('messModal');
    <?php if(isset($_SESSION['profileUpMsg']))
    echo "var myModal = new bootstrap.Modal(document.getElementById('messModal'), {});
    myModal.show();\n";?>
    function updateProfile(){
        var _Ten = document.getElementById("Ten").value;
        var _Ho = document.getElementById("Ho").value;
        var _Dia_chi = document.getElementById("Dia_chi").value;
        var _Dien_thoai = document.getElementById("Dien_thoai").value;
        var _Email = document.getElementById("Email").value;
        var _Ngay_sinh = document.getElementById("Ngay_sinh").value;
        var _Gioi_tinh   = document.querySelector('input[name="Gioi_tinh"]:checked').value;
        spinner();
        $.post("view/ttcn.php",
        {
            update: "true",
            Ten: _Ten,
            Ho: _Ho,
            Gioi_tinh: _Gioi_tinh,
            Dia_chi: _Dia_chi,
            Dien_thoai: _Dien_thoai,
            Email: _Email,
            Ngay_sinh: _Ngay_sinh
        },
        function(data,status){
            $("#maincontent").load("view/ttcn.php");
        });
    }
    window.onclick = function(event) {
    if (event.target == _myModal) {
            var myModal = new bootstrap.Modal(document.getElementById('messModal'), {});
            myModal.hide();
        }
    }
    var navBar = document.getElementById("main-navbar");
    var side = String(window.innerHeight-navBar.offsetHeight - 32) + "px";
    document.getElementsByClassName("card")[0].style.minHeight = side;
</script>
<div class="modal fade" id="messModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h5 class="modal-title w-100" id="exampleModalLabel">Thông báo</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="modalBody">
        <?php 
            if(isset($_SESSION['profileUpMsg'])){
                echo $_SESSION['profileUpMsg'];
                unset($_SESSION['profileUpMsg']);
            }
        ?>
      </div>
      <div class="modal-footer text-center">
        <div class="w-100">
          <!--button type="button" class="btn btn-primary fade" id="hiddenButton" data-bs-toggle="modal" data-bs-target="#messModal"></button-->
          <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Đóng</button>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="p-3">
<div class="card">
<h4 class="text-center mt-3">THÔNG TIN CÁ NHÂN</h4>
<div class="container-fluid">
  <div class="row">
    <div class="col-lg mt-3 right-line">
      <div class="">
      <h5 class="text-center">Thông tin</h5>
        <div class="row justify-content-center">
          <div class="col-3">
            <p>ID:</p>
          </div>
        <div class="col-8">
          <p class="fw-bold"><?php echo $user_id ?></p>
        </div>
        </div>
        <div class="row justify-content-center">
          <div class="col-3">
            <p>Tên:</p>
          </div>
          <div class="col-8">
            <p class="fw-bold"><?php echo $row['Ten'] ?></p>
          </div>
        </div>
        <div class="row justify-content-center">
          <div class="col-3">
            <p>Họ:</p>
          </div>
          <div class="col-8">
            <p class="fw-bold"><?php echo $row['Ho'] ?></p>
          </div>
        </div>
        <div class="row justify-content-center">
          <div class="col-3">
            <p>Địa chỉ:</p>
          </div>
          <div class="col-8">
            <p class="fw-bold"><?php echo $row['Dia_chi'] ?></p>
          </div>
        </div>
        <div class="row justify-content-center">
          <div class="col-3">
            <p>Ngày sinh:</p>
          </div>
        <div class="col-8">
          <p class="fw-bold"><?php echo dateConv($row['Ngay_sinh']) ?></p>
          </div>
        </div>
        <div class="row justify-content-center">
          <div class="col-3">
            <p>Giới tính:</p>
          </div>
        <div class="col-8">
          <p class="fw-bold"><?php echo $row['Gioi_tinh'] ?></p>
          </div>
        </div>
        <div class="row justify-content-center">
          <div class="col-3">
            <p>Điện thoại:</p>
          </div>
        <div class="col-8">
          <p class="fw-bold"><?php echo $row['Dien_thoai'] ?></p>
          </div>
        </div>
        <div class="row justify-content-center">
          <div class="col-3">
            <p>Email:</p>
          </div>
        <div class="col-8">
          <p class="fw-bold"><?php echo $row['Email'] ?></p>
          </div>
        </div>
        <div class="row justify-content-center">
          <div class="col-3">
            <p>Bộ phận:</p>
          </div>
        <div class="col-8">
          <p class="fw-bold"><?php echo $bo_phan ?></p>
          </div>
        </div>
        <div class="row justify-content-center">
          <div class="col-3">
            <p>Chức vụ:</p>
          </div>
        <div class="col-8">
          <p class="fw-bold"><?php echo $chuc_vu ?></p>
          </div>
        </div>
      </div>
    </div>
    <!--Second col-------------------------------------------------------------->
    <div class="col-lg mt-3">
      <form action="" method="POST" class="">
        <div class="">
        <h5 class="text-center">Bảng cập nhật</h5>
        <div class="row justify-content-center">
          <div class="col-3">
            <p>ID:</p>
          </div>
          <div class="col-8">
            <input type="text" id="ID" class="form-control" disabled name="ID"
              value="" placeholder="<?php echo $user_id ?>"/>
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
        <div class="row justify-content-center align-item-center">
          <div class="col-3">
            <p>Giới tính:</p>
          </div>
          <div class="col-8">
            <div class="row mt-1">
              <div class="col-auto">
                <div class="form-check">
                  <input class="form-check-input" type="radio" id="gt_nam" name="Gioi_tinh" value="Nam"
                  <?php  if($row['Gioi_tinh']=="Nam") echo "checked" ?>/>
                  <label class="form-check-label" for="gt_nam"> Nam </label>
                </div>
              </div>
              <div class="col-auto">
                <div class="form-check">
                  <input class="form-check-input" type="radio" id="gt_nu" name="Gioi_tinh" value="Nữ"
                  <?php  if($row['Gioi_tinh']=="Nữ") echo "checked" ?>/>
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
        <div class="col-8">
          <input type="text" id="Bo_phan" class="form-control" name="Bo_phan" disabled
            value=""placeholder="<?php echo $bo_phan ?>"/>
          </div>
        </div>
        <div class="row justify-content-center">
          <div class="col-3">
            <p>Chức vụ:</p>
          </div>
        <div class="col-8">
          <input type="text" id="Chuc_vu" class="form-control" name="Chuc_vu" disabled
            value="" placeholder="<?php echo $chuc_vu ?>"/>
          </div>
        </div>
    </div>
    <div class="text-center p-3">
      <button type="button" class="btn btn-primary" name="update" 
      onclick="updateProfile()">Cập nhật</button>
    </div>
    </form>
    </div>
</div>
</div>
</div>
</div>
<style>
@media (min-width: 991.98px) {
  .right-line{
    border-right: 2px solid #ccc;
  }
  .hh-100{
    min-height:calc(100vh - 92px);
  }
}
</style>