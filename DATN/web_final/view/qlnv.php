<?php
    include "init.php";
    if(isset($_POST["Delete"])){
        $_SESSION['m_profileUpMsg'] = "";
        $ID = $_POST["ID"];
        $sql= "delete from Danh_sach where ID = '$ID'";
        if ($connect->query($sql) == TRUE)
            $_SESSION['m_profileUpMsg'] .=  "Xoá nhân viên có ID là $ID thành công!";
        else
            $_SESSION['m_profileUpMsg'] .= "Lỗi: " . $connect->error;
        $sql= "delete from Tai_khoan where ID = '$ID'";
        $connect->query($sql);
        die();
    }
    if(isset($_POST["update"])){
        $pattern_text = "/^[a-zA-Z-' ÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ]*$/";
        $pattern_number = "/^[0-9 -\+\-]+$/";
        $ID = $_POST["ID"];
        $sql0= "select * from Danh_sach where ID = '$ID'";
        $result0 = $connect->query($sql0);
        $row0 = $result0->fetch_assoc();
        
        $_sql0= "select * from Tai_khoan where ID = '$ID'";
        $_result0 = $connect->query($_sql0);
        $_row0 = $_result0->fetch_assoc();
        $_SESSION['m_profileUpMsg'] = "";
        if (!empty($_POST["Ten"])) {
            if (!preg_match($pattern_text,$_POST["Ten"])) {
                $_SESSION['m_profileUpMsg']  .= "Tên không được chứa ký tự đặc biệt hoặc chữ số<br>";
            }
            else if($_POST['Ten'] != $row0['Ten']){
                updateCol($ID,"Ten",$_POST['Ten']);
                $_SESSION['m_profileUpMsg']  .= "Cập nhật tên thành công<br>";
            }
        }
        if (!empty($_POST["Ho"])) {
            if (!preg_match($pattern_text,$_POST["Ho"])) {
                $_SESSION['m_profileUpMsg']  .= "Họ không được chứa ký tự đặc biệt<br>";
            }
            else if($_POST['Ho'] != $row0['Ho']){
                updateCol($ID,"Ho",$_POST['Ho']);
                $_SESSION['m_profileUpMsg']  .= "Cập nhật họ thành công<br>";
            }
        }
        if (!empty($_POST["Dia_chi"]) && $_POST['Dia_chi'] != $row0['Dia_chi']) {
            updateCol($ID,"Dia_chi",$_POST['Dia_chi']);
            $_SESSION['m_profileUpMsg']  .= "Cập nhật địa chỉ thành công<br>";
        }
        if (!empty($_POST["Ngay_sinh"]) && $_POST["Ngay_sinh"] != $row0['Ngay_sinh']) {
            updateCol($ID,"Ngay_sinh",$_POST['Ngay_sinh']);
            $_SESSION['m_profileUpMsg']  .= "Cập nhật ngày sinh thành công<br>";
        }
        if (!empty($_POST["Dien_thoai"])) {
            if (!preg_match($pattern_number,$_POST["Dien_thoai"]) )
                $_SESSION['m_profileUpMsg']  .= "Số điện thoại nhập không đúng hoặc chứa ký tự đặc biệt, chữ cái<br>";
            else if($_POST["Dien_thoai"] != $row0['Dien_thoai']){
                updateCol($ID,"Dien_thoai",$_POST['Dien_thoai']);
                $_SESSION['m_profileUpMsg']  .= "Cập nhật số điện thoại thành công<br>";
            }
        }
        if (!empty($_POST["luong"])) {
            if($_POST["luong"] != $row0['Luong']){
                updateCol($ID,"Luong",$_POST['luong']);
                $_SESSION['m_profileUpMsg']  .= "Cập nhật lương thành công<br>";
            }
        }
        if (!empty($_POST["Gioi_tinh"]) && $_POST["Gioi_tinh"] != $row0['Gioi_tinh']) {
            updateCol($ID,"Gioi_tinh",$_POST['Gioi_tinh']);
            $_SESSION['m_profileUpMsg']  .= "Cập nhật giới tính thành công<br>";
        }
		if(!empty($_POST["Email"]) && $_POST["Email"] != $row0["Email"]){
		    $Email = $_POST["Email"];
    		if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['m_profileUpMsg'] .= "Email sai định dạng<br>";
            }
            else{
        		updateCol($ID,"Email",$Email);
        		$_SESSION['m_profileUpMsg'] .= "Cập nhật email thành công<br>";
            }
		}
		if ((!empty($_POST["account"]))) {
		    updateCol($ID,"account",$_POST['account']);
            $_SESSION['m_profileUpMsg']  .= "Cập nhật tên đăng nhập thành công<br>";
        }
        if (!empty($_POST["password"])) {
            updateCol($ID,"password",$_POST['password']);
            $_SESSION['m_profileUpMsg']  .= "Cập nhật mật khẩu thành công<br>";
        }
        if ($_POST["id_cv"] != $row0["ID_CV"] ) {
            updateCol($ID,"ID_CV",$_POST['id_cv']);
            $_SESSION['m_profileUpMsg']  .= "Cập nhật chức vụ thành công<br>";
        }
        if ($_POST["id_bp"] != $row0["ID_BP"]) {
            updateCol($ID,"ID_BP",$_POST['id_bp']);
            $_SESSION['m_profileUpMsg']  .= "Cập nhật bộ phận thành công<br>";
        }
        if($_SESSION['m_profileUpMsg'] == "" )
            $_SESSION['m_profileUpMsg'] = "Chưa có thông tin nào được cập nhật";
        die();
    }
    function updateCol($id,$col,$value){
	    $connect = $GLOBALS["connect"];
	    $_sql = "";
	    if ($col == 'password' || $col == 'account')
	       $_sql= "update Tai_khoan SET $col='$value' WHERE ID='$id'";
	    else
	        $_sql= "update Danh_sach SET $col='$value' WHERE ID='$id'";
	    //Connect
        if ($connect->query($_sql) == TRUE)
            return  "Update $col with value $value successful!";
        else
            return "Update error:" . $connect->error;
	}
    /**************************************************************************/
    $user_id = $_SESSION['user_id'];
    $sql= "select * from Danh_sach where ID = '$user_id'";
    $result = $connect->query($sql);
    $row = $result->fetch_assoc();
    $id_bo_phan = $row["ID_BP"];
    $id_cv = $row["ID_CV"];
    $bp="";
    if (isset($_GET['bp']))
        $bp = $_GET['bp'];
    else
        $bp = $id_bo_phan;
    $sql1= "select * from Phan_quyen where ID_CV = '$id_cv'";
    $result1 = $connect->query($sql1);
    $i = 0;
    while ($row1 = $result1 -> fetch_assoc()){
        $sql4= "select Ten_BP from Bo_phan where ID_BP = '".$row1['ID_BP']."'";
        $result4 = $connect->query($sql4);
        $row4 = $result4-> fetch_assoc();
        $ds_idbp[$i] = $row1['ID_BP'];
        $ds_tbp[$i] = $row4['Ten_BP'];
        $i++;
    }
    $sql2= "select * from Danh_sach where ID_BP = '$id_bo_phan'";
    $result2 = $connect->query($sql2);
    
    $page = 1;
    $page_size = 10;
    
    ?>
<script>
    function m_updateProfile(){
        $('#Modal1').modal('hide');
        _ID = document.getElementById('ID').value;
        _Tai_khoan = document.getElementById('Tai_khoan').value;
        _Mat_khau = document.getElementById('Mat_khau').value;
        _Ten = document.getElementById('Ten').value;
        _Ho = document.getElementById('Ho').value;
        _Dia_chi = document.getElementById('Dia_chi').value;
        _Ngay_sinh = document.getElementById('Ngay_sinh').value;
        _Dien_thoai  = document.getElementById("Dien_thoai").value;
        _Email       = document.getElementById("Email").value;
        _ID_BP       = document.getElementById("Bo_phan").value;
        _ID_CV       = document.getElementById("Chuc_vu").value;
        _Gioi_tinh   = document.querySelector('input[name="Gioi_tinh"]:checked').value;
        _Luong       = document.getElementById("Luong").value;
        var bp = document.getElementById("idbp").value;
        //console.log(_ID_BP);
        spinner();
        $.post("view/qlnv.php",
        {
            update      : true,
            ID          : _ID,
            account     : _Tai_khoan,
            password    : _Mat_khau,
            Ten         : _Ten,
            Ho          : _Ho,
            Dia_chi     : _Dia_chi,
            Ngay_sinh   : _Ngay_sinh,
            Gioi_tinh   : _Gioi_tinh,
            Dien_thoai  : _Dien_thoai,
            Email       : _Email,
            id_bp       : _ID_BP,
            id_cv       : _ID_CV,
            luong       :_Luong
        },
        function(data,status){
            $("#maincontent").load("view/qlnv.php?bp=" + bp);
        });
    }
    var m_ID;
    function loadUserProfile(__ID){
        document.getElementById('modalBody1').innerHTML = view_spin;
        m_ID = __ID;
        var y = document.getElementById("curyear").value;
        var x = document.getElementById("curmonth");
        var m = x.selectedIndex + 1;
        var url = "view/ql_view.php?m_user_id=" + __ID  + "&m=" + m + "&y=" + y;
        $("#modalBody1").load(url);
        $('#Modal1').modal('show')
    }
    function deleteProfile(){
        var bp = document.getElementById("idbp").value;
        console.log(m_ID);
        spinner();
        $.post("view/qlnv.php",
        {
            Delete      : true,
            ID          : m_ID
        },
        function(data,status){
            $("#maincontent").load("view/qlnv.php?bp=" + bp);
        });
    }
    window.onclick = function(event) {
    if (event.target == document.getElementById('Modal1')) {
            $('#Modal1').modal('hide');
            $('#Modal2').modal('hide');
        }
    };
    /*$('#Modal1').on('hidden.bs.modal', function (e) {
        document.getElementById('profileMDbody').innerHTML = view_spin;
    });*/
    document.getElementById('modalBody1').innerHTML = view_spin;
    /****************************/
    function ql_dateSelect(){
        cardLoad();
        var y = document.getElementById("curyear").value;
        var x = document.getElementById("curmonth");
        var bp = document.getElementById("idbp").value;
        id = "<?php echo $user_id;?>";
        var m = x.selectedIndex + 1;
        const url = "view/ql_dsnv.php?m=" + m + "&y=" + y + "&bp=" + bp + "&id=" + id;
        //console.log(url);
        $("#qlnv_table").load(url);
    }
    /***************Load default table***************/
    defaultTime();
    ql_dateSelect();
    <?php if(isset($_SESSION['m_profileUpMsg'])){ echo "$('#Modal2').modal('show');"; }?>
    /******************************/
    function sizeSelect(size){
        console.log(size);
    }
    function cardLoad(){
        var main=document.getElementById("qlnv_table");
        main.innerHTML = card_spin;
    }
</script>
<style>
    .modal-content{
        -webkit-transition: max-height 1s; 
        -moz-transition: max-height 1s; 
        -ms-transition: max-height 1s; 
        -o-transition: max-height 1s; 
        transition: max-height 1s;  
    }
    @media (min-width: 991.98px) {
      .hh-100{
        min-height:calc(100vh - 92px);
      }
    }
    .myPag{
        position : absolute;
        bottom   : 0;
        left: 0; 
          right: 0; 
          margin-left: auto; 
          margin-right: auto; 
    }
    .sizeSelect{
        position : absolute;
        bottom   : 0;
        left: 0; 
        right: 1; 
        margin-left: auto; 
        margin-right: auto;
    }
    .Tong{
        position : absolute;
        bottom   : 0;
        left: 100;
        right : 0;
        margin-left: auto; 
        margin-right: auto;
        width: 10rem;
    }
    #col1{
        width:10%;
    }
    #col2{
        width:20%;
    }
    #col3{
        width:20%;
    }
    #col4{
        width:10%;
    }
    #col5{
        width:10%;
    }
</style>
<div class="modal fade" id="Modal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h5 class="modal-title w-100" id="exampleModalLabel">Thông tin thành viên</h5>
        <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body m-0 p-0" id="modalBody1">
        <div class="container-fluid p-0" id="">
            <!--Content here-->
        </div>
      </div>
      <div class="modal-footer text-center">
        <div class="w-100">
          <button type="button" class="btn btn-primary" name="update" onclick="m_updateProfile()">Cập nhật</button>
          <button type="button" class="btn btn-danger" data-mdb-dismiss="modal" data-mdb-target="#">Đóng</button>
          <button type="button" class="btn btn btn-secondary" data-mdb-dismiss="modal" 
          data-mdb-target="#confirmModal" data-mdb-toggle="modal">Xoá nhân viên</button>
        </div>
      </div>
    </div>
  </div>
</div>
<!----------------------------------------------------------------------------->
<div class="modal fade" id="Modal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h5 class="modal-title w-100" id="ModalLabel1">Thông báo</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="modalBody2">
        <?php 
            if(isset($_SESSION['m_profileUpMsg'])){
                echo $_SESSION['m_profileUpMsg'];
                unset($_SESSION['m_profileUpMsg']);
            }
        ?>
      </div>
      <div class="modal-footer text-center">
        <div class="w-100">
          <button type="button" class="btn btn-primary" data-mdb-target="#Modal2" data-mdb-dismiss="modal">Đóng</button>
        </div>
      </div>
    </div>
  </div>
</div>
<!----------------------------------------------------------------------------->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h5 class="modal-title w-100" id="ModalLabel1">Thông báo</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="modalBody2">
        Xác nhận xoá nhân viên này!
      </div>
      <div class="modal-footer text-center">
        <div class="w-100">
          <button type="button" class="btn btn-danger" data-mdb-target="#confirmModal" data-mdb-dismiss="modal"
          onclick='deleteProfile()'>Xoá</button>
          <button type="button" class="btn btn-primary" data-mdb-target="#confirmModal" data-mdb-dismiss="modal">Huỷ</button>
        </div>
      </div>
    </div>
  </div>
</div>
<!----------------------------------------------------------------------------->
<div class="p-3 hh-100">
  <div class="card hh-100">
  <h4 class="text-center p-3">QUẢN LÝ NHÂN VIÊN</h4>
  <div class="row justify-content-center align-items-center p-3">
    <div class="col col-auto mb-2" style="max-width: 3.5rem;">
      <label for="curmonth" class="control-label">Tháng:</label>
    </div>
    <div class="col col-auto mb-2" style="-min-width: 6rem;">
      <select id="curmonth" class="form-select" onchange="ql_dateSelect()"  style="height: 35.27px;">
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
    <div class="col col-auto mb-2" style="max-width: 3rem">
      <label for="curyear" class="control-label">Năm:</label>
    </div>
    <div class="col col-auto mb-2" style="max-width: 6.5rem">
      <div class="input-group">
        <input type="number" class="form-control" value="0" name="curyear" id="curyear" 
        onkeyup="ql_dateSelect()" onchange="ql_dateSelect()"/>
      </div>
    </div>
    <div class="col col-auto mb-2">
      <select id="idbp" class="form-select" onchange="ql_dateSelect()" style="height:35.27px">
        <option value='0'>Tất cả</option>
        <?php for ($i=0; $i < count($ds_idbp); $i++){
            echo "<option value='" .$ds_idbp[$i] . "' ";
            if ($ds_idbp[$i] == $bp) echo "selected='true'";
            echo "'>". $ds_tbp[$i] . "</option>";   
        }?>
      </select>
    </div>
  </div>
    <div id="hTable" class="table"  style="margin-bottom:-16px;">
    <table class="table table-hover table-sm">
      <thead id='Thead'>
        <tr>
          <th scope="row" id='col1'>ID</th>
          <th scope="col" id='col2'>Họ và tên</th>
          <th scope="col" id='col3'>Bộ phận</th>
          <th scope="col" id='col3'>Chức vụ</th>
          <th scope="col" id='col4' class='text-center'>Công tháng</th>
          <th scope="col" id='col5' class='text-center'>Lương tháng</th>
        </tr>
      </thead>
      <tbody></tbody>
    </table>
    </div>
    <div id="qlnv_table" class="table-responsive" style="margin-bottom:60px;">
    <!--table class="table table-hover table-sm" >
        <tr></tr> 
      <tbody id="qlnv_table" class=''>
            
      </tbody>
    </table-->
    </div>
    <!--div class='myPag'>
      <ul class="pagination justify-content-center">
        <li class="page-item">
          <a class="page-link" href="#" aria-label="Previous">
            <span aria-hidden="true">&laquo;</span>
          </a>
        </li>
        <li class="page-item active"><a class="page-link" href="#">1</a></li>
        <li class="page-item"><a class="page-link" href="#">2</a></li>
        <li class="page-item"><a class="page-link" href="#">3</a></li>
        <li class="page-item">
          <a class="page-link" href="#" aria-label="Next">
            <span aria-hidden="true">&raquo;</span>
          </a>
        </li>
      </ul>
    </div>
    <div class="col col-auto sizeSelect p-3">
      <select id="pageSize" class="form-select" onchange="sizeSelect(this.value)" style="height:35.27px">
        <option value="10">10</option>
        <option value="20">20</option>
        <option value="50">50</option>
      </select>
    </div-->
  </div>
</div>