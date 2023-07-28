<?php
    include "init.php";
    
    if(isset($_POST['new_pass'])){
        $new_pass = $_POST['new_pass'];
        $old_pass = $_POST['old_pass'];
        $re_pass = $_POST['re_pass'];
        if($old_pass == ""){
            $_SESSION['passUpdate'] = "Bạn chưa nhập mật khẩu cũ!";
            die();
        }
        if($new_pass == ""){
            $_SESSION['passUpdate'] = "Bạn chưa nhập mật khẩu mới!";
            die();
        }
        if($new_pass != $re_pass){
            $_SESSION['passUpdate'] = "Hai mật khẩu không khớp!";
            die();
        }
        if($new_pass == $old_pass){
            $_SESSION['passUpdate'] = "Mật khẩu giữ nguyên!";
            die();
        }
        $user_id = $_SESSION["user_id"];
        $sql = "select * from Tai_khoan where ID = '$user_id'";
        $result = $connect->query($sql);
        $row = $result->fetch_assoc();
        if ($old_pass != $row['password']){
            $_SESSION['passUpdate'] = "Mật khẩu cũ không đúng!";
            die();
        }
        
        $_sql= "update Tai_khoan SET password ='$new_pass' WHERE ID='$user_id'";
        if ($connect->query($_sql) === TRUE) {
            $_SESSION['passUpdate'] = "Cập nhật mật khẩu thành công!";
        }else{
            $_SESSION['passUpdate'] = "Cập nhật mật khẩu không thành công!<br>Lỗi: ". $connect->error;
        }
        die();
    }
    
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
    var _myModal = document.getElementById('messModal');
    window.onclick = function(event) {
        if (event.target == _myModal) {
            var myModal = new bootstrap.Modal(document.getElementById('messModal'), {});
            myModal.hide();
        }
    }
    function passCheck(){
        newPass = document.getElementById('Mat_khau_moi').value;
        rePass  = document.getElementById('Mat_khau_re').value;
        if (rePass != newPass){
            document.getElementById('passAlert').innerHTML = "Hai mật khẩu không khớp";
            document.getElementById('pwrdChBtn').disabled = true;
        }else{
            document.getElementById('passAlert').innerHTML = "";
            document.getElementById('pwrdChBtn').disabled = false;
        }
    }
    function passChange(){
        oldPass = document.getElementById('Mat_khau_cu').value;
        newPass = document.getElementById('Mat_khau_moi').value;
        rePass  = document.getElementById('Mat_khau_re').value;
        spinner();
        $.post("view/dmk.php",
        {
            new_pass: newPass,
            old_pass: oldPass,
            re_pass: rePass,
        },
        function(data,status){
            if (String(status) == "success"){
                $("#maincontent").load("view/dmk.php");
            }
        });
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
      <div class="modal-body">
        <?php 
            if(isset($_SESSION['passUpdate'])){
                echo $_SESSION['passUpdate'];
                echo "<script>var myModal = new bootstrap.Modal(document.getElementById('messModal'), {});myModal.show();</script>";
                unset($_SESSION['passUpdate']);
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

<div class="p-3 h-100">
<div class="card">
<div class="form-signin justify-content-center"> 
  <form action="" method="POST" class="">
    <h4 class="text-center p-3">ĐỔI MẬT KHẨU</h4>
    <div class="row justify-content-center">
      <div class="col-8 p-1">
        <div class="form-outline">
        <input type="password" id="Mat_khau_cu" class="form-control" autocomplete="off">
        <label class="form-label" for="Mat_khau_cu">Mật khẩu cũ</label>
        <div class="form-notch">
        <div class="form-notch-leading" style="width: 9px;"></div>
        <div class="form-notch-middle" style="width: 70px;"></div>
        <div class="form-notch-trailing"></div></div></div>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-8 p-1">
        <div class="form-outline">
        <input type="password" id="Mat_khau_moi" class="form-control" autocomplete="off" onkeyup="passCheck()">
        <label class="form-label" for="Mat_khau_moi">Mật khẩu mới</label>
        <div class="form-notch">
        <div class="form-notch-leading" style="width: 9px;"></div>
        <div class="form-notch-middle" style="width: 78x;"></div>
        <div class="form-notch-trailing"></div></div></div>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-8 p-1">
        <div class="form-outline">
        <input type="password" id="Mat_khau_re" class="form-control" autocomplete="off" onkeyup="passCheck()">
        <label class="form-label" for="Mat_khau_re">Nhập lại mật khẩu</label>
        <div class="form-notch">
        <div class="form-notch-leading" style="width: 9px;"></div>
        <div class="form-notch-middle" style="width: 78x;"></div>
        <div class="form-notch-trailing"></div></div></div>
        
        <!--input type="password" id="Mat_khau_re" class="form-control active" name="Mat_khau_re" value="" placeholder="Nhập lại mật khẩu" onkeyup="passCheck()" autocomplete="off"/-->
        <span id="passAlert" class="fs-6 text-danger"></span>
      </div>
    </div>
    <div class="text-center p-3">
      <button type="button" class="btn btn-primary" name="update" onclick="passChange()" 
      id="pwrdChBtn">Đổi mật khẩu</button>
    </div>
    
  </form>
</div>
</div>
<style>
@media (min-width: 991.98px) {
  .hh-100{
    height:calc(100vh - 92px);
  }
}
</style>