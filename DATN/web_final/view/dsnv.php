<?php
    include "init.php";
    $user_id = $_SESSION['user_id'];
    
    $sql= "select * from Danh_sach where ID = '$user_id'";
    $result = $connect->query($sql);
    $row = $result->fetch_assoc();
    $id_bo_phan = $row["ID_BP"];
    
    $sql2= "select * from Danh_sach where ID_BP = '$id_bo_phan' ORDER BY ID";
    $result2 = $connect->query($sql2);
    $numRows = $result2->num_rows;
    $sql3= "select * from Danh_sach where 1";
    $result3 = $connect->query($sql3);
    
    if (isset($_GET['page'])){
        $page = $_GET['page'];
         $_SESSION['ds_page'] = $page;
    }
    else{
        if (isset($_SESSION['ds_page']))
            $page = $_SESSION['ds_page'];
        else $page = 1;
    }
    if (isset($_GET['size'])){
        $size = $_GET['size'];
        $_SESSION['ds_size'] = $size;
        $page = 1;
    }
    else{
        if (isset($_SESSION['ds_size']))
            $size = $_SESSION['ds_size'];
        else $size = 10;
    }
    $numPage = ceil($numRows/$size);
?>
<div class="modal fade modal-fullscreen" id="profileModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center" id="exampleModalLabel">Thông tin</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="container-fluid" id="profileMDbody">
            
        </div>
      </div>
      <div class="modal-footer">
        <div class="text-center">
          <!--button type="button" class="btn btn-primary fade" id="hiddenButton" data-bs-toggle="modal" data-bs-target="#messModal"></button-->
          <button type="button" class="btn btn-primary text-center" data-bs-dismiss="modal">Đóng</button>
        </div>
      </div>
    </div>
  </div>
</div>
<!----------------------------------------------------------------------------->
<div class="p-3">
  <div class="card hh-100" id="pagebody_dsnv">
  <h4 class="text-center p-3">DANH SÁCH NHÂN VIÊN</h4>
    <div id="myTable" class="w-100" style='margin-bottom:-16px'>
      <table class="table table-hover table-sm w-100">
        <thead>
          <tr class="">
            <th scope="col" id='col1'>ID</th>
            <th scope="col" id='col2'>Họ và tên</th>
            <th scope="col" id='col3'>Điện thoại</th>
            <th scope="col" id='col4'>Email</th>
            <th scope="col" id='col5'>Địa chỉ</th>
          </tr>
        </thead>
      </table>
    </div>
    <div id="myTable2" class="table-responsive" style='margin-bottom:60px'>
    <table class="table table-hover table-sm">
      <thead></thead>
      <tbody>
            <?php
                for ($i=0; $i< ($page - 1) * $size ;$i++){
                    $row2 = $result2->fetch_assoc();
                }
                for ($i=0; $i < $size && ($i + ($page-1)*$size) < $numRows;$i++){
                    $row2 = $result2->fetch_assoc();
                    echo "<tr id='".$row2['ID']."'>";
                    echo "<td id='col1'>" . $row2['ID'] . "</td>";
                    echo "<td id='col2'>" . $row2['Ho'] . " " . $row2['Ten'] . "</td>";
                    echo "<td id='col3'>" . $row2['Dien_thoai'] . "</td>";
                    echo "<td id='col4'>" . $row2['Email'] . "</td>";
                    echo "<td id='col5'>" . $row2['Dia_chi']. "</td>";
                    echo "</tr>";
                }
            ?>
      </tbody>
    </table>
    </div>
    <div class='myPag'>
      <ul class="pagination justify-content-center">
        <li class="page-item">
          <a class="page-link" href="javascript:void(0)" aria-label="Previous" onclick='First()'>
            <i class="fa-solid fa-backward"></i>
          </a>
        </li>
        <li class="page-item">
          <a class="page-link" href="javascript:void(0)" aria-label="Previous" onclick='Prev()'>
            <i class="fa-solid fa-caret-left"></i>
          </a>
        </li>
        <?php
            if ($numPage > 5){
                if ($page < 4){
                    for ($i=1; $i<=5; $i++){
                        echo "<li class='page-item ";
                        if ($i==$page){ 
                            echo "active'>";
                            echo "<a class='page-link'
                            href='javascript:void(0)'>$i</a></li>";
                        }
                        else {
                            echo"'>";
                            echo "<a class='page-link' onclick='pageSelect(this.innerHTML)'
                            href='javascript:void(0)'>$i</a></li>";
                        }
                    }  
                }
                else if ($page > $numPage - 3){
                    for ($i=$numPage-4; $i<=$numPage; $i++){
                        echo "<li class='page-item ";
                        if ($i==$page){ 
                            echo "active'>";
                            echo "<a class='page-link'
                            href='javascript:void(0)'>$i</a></li>";
                        }
                        else {
                            echo"'>";
                            echo "<a class='page-link' onclick='pageSelect(this.innerHTML)'
                            href='javascript:void(0)'>$i</a></li>";
                        }
                    }  
                }
                else{
                    for ($i=$page-2; $i<=$page+2; $i++){
                        echo "<li class='page-item ";
                        if ($i==$page){ 
                            echo "active'>";
                            echo "<a class='page-link'
                            href='javascript:void(0)'>$i</a></li>";
                        }
                        else {
                            echo"'>";
                            echo "<a class='page-link' onclick='pageSelect(this.innerHTML)'
                            href='javascript:void(0)'>$i</a></li>";
                        }
                    }  
                }
            }
            else{
                for ($i=1; $i<=$numPage; $i++){
                    echo "<li class='page-item ";
                    if ($i==$page){ 
                        echo "active'>";
                        echo "<a class='page-link'
                        href='javascript:void(0)'>$i</a></li>";
                    }
                    else {
                        echo"'>";
                        echo "<a class='page-link' onclick='pageSelect(this.innerHTML)'
                        href='javascript:void(0)'>$i</a></li>";
                    }
                }
            }
        ?>
        <!--li class="page-item active"><a class="page-link" href="#">1</a></li>
        <li class="page-item"><a class="page-link" href="#">2</a></li>
        <li class="page-item"><a class="page-link" href="#">3</a></li-->
        <li class="page-item">
          <a class="page-link" href="javascript:void(0)" aria-label="Next" disabled onclick='Next()'>
            <i class="fa-solid fa-caret-right"></i>
          </a>
         </li>
         <li class="page-item">
          <a class="page-link" href="javascript:void(0)" aria-label="Previous" onclick='Last()'>
            <i class="fa-solid fa-forward"></i>
          </a>
        </li>
      </ul>
      
    </div>
    <div class="col col-auto sizeSelect p-3">
      <select id="pageSize" class="form-select" onchange="sizeSelect(this.value)" style="height:35.27px">
        <option value="2" <?php if ($size==2) echo "selected"?> >2</option>
        <option value="5" <?php if ($size==5) echo "selected"?> >5</option>
        <option value="10" <?php if ($size==10) echo "selected"?> >10</option>
        <option value="20" <?php if ($size==20) echo "selected"?> >20</option>
        <option value="50" <?php if ($size==50) echo "selected"?> >50</option>
      </select>
    </div>
    </div>
  </div>
</div>
<style>
    .hh-100{
        min-height:calc(100vh - 92px);
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
    #col1{
        width:10%;
    }
    #col2{
        width:20%;
    }
    #col3{
        width:15%;
    }
    #col4{
        width:20%;
    }
    #col5{
        width:30%;
    }
</style>
<script src="js/script.js"></script>
<script>
    var curPage = <?php echo $page;?>;
    var maxPage = <?php echo $numPage;?>;
    function cardLoad(){
        var main=document.getElementById("myTable2");
        main.innerHTML = card_spin;
    }
    function sizeSelect(size){
        cardLoad();
        var url = "view/dsnv.php?size=" + size;
        $("#maincontent").load(url);
        //console.log(url);
    }
    function pageSelect(page){
        //console.log(page);
        cardLoad();
        var url = "view/dsnv.php?page=" + page;
        $("#maincontent").load(url);
    }
    function Next(){
        if (curPage == maxPage)
            return;
        curPage++;
        var url = "view/dsnv.php?page=" + curPage;
        cardLoad();
        $("#maincontent").load(url);
    }
    function Prev(){
        if (curPage == 1)
            return;
        curPage--;
        var url = "view/dsnv.php?page=" + curPage;
        cardLoad();
        $("#maincontent").load(url);
    }
    function First(){
        if (curPage == 1)
            return;
        cardLoad();
        var url = "view/dsnv.php?page=1";
        $("#maincontent").load(url);
    }
    function Last(){
        if (curPage == maxPage)
            return;
        cardLoad();
        var url = "view/dsnv.php?page=" + maxPage;
        $("#maincontent").load(url);
    }
</script>