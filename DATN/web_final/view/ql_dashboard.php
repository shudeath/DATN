<?php
    include "init.php";
    //So luong nhan vien
    $sql = "select * from Danh_sach where 1";
    $result = $connect->query($sql);
    $slnv = $result->num_rows;
    //So luong bo phan
    $sql = "select * from Bo_phan where 1";
    $result = $connect->query($sql);
    $slbp = $result->num_rows;
    //So luong tai khoan
    $sql = "select * from Tai_khoan where 1";
    $result = $connect->query($sql);
    $sltk = $result->num_rows;
    //So luot truy cap
    $sql = "select * from So_luong_truy_cap where 1";
    $result = $connect->query($sql);
    $row = $result->fetch_assoc();
    $sltc = $row['S'];
    //So luong chuc vu
    $sql = "select * from Chuc_vu where 1";
    $result = $connect->query($sql);
    $slcv = $result->num_rows;
    //Tinh tong luong
    $tongLuong = array(0,0,0,0, 0,0,0,0, 0,0,0,0);
    $sql1= "select * from Diem_danh where 1";
    $result1 = $connect->query($sql1);
    /*$_sql= "select * from Cai_dat where 1";
    $_result = $connect->query($_sql);
    $_row = $_result->fetch_assoc();*/
    $thisYear = date("Y");
    $thisMonth = date("m");
    while ($row1 = $result1->fetch_assoc()){
        if (intval(date('Y',strtotime($row1['Ngay_diem_danh']))) == $thisYear){
            $m = intval(date('m',strtotime($row1['Ngay_diem_danh'])));
            $sql2= "select * from Danh_sach where ID=".$row1['ID'];
            $result2 = $connect->query($sql2);
            $row2 = $result2->fetch_assoc();
            if (isset($row2['Luong']))
                $tongLuong[$m-1] += $row2['Luong'];
        }
    }
    $tongLuongNam = 0;
    for ($m=0;$m<12;$m++)
        $tongLuongNam += $tongLuong[$m];
?>
<div class='p-3'>  
    <!-- Section: Main chart -->
    <section class="mb-3">
      <div class="card">
        <div class="card-header py-3">
          <h5 class="mb-0 text-center"><strong>Chi ngân năm <?php echo $thisYear;?></strong></h5>
        </div>
        <div class="card-body">
          <div class="chartjs-size-monitor">
            <div class="chartjs-size-monitor-expand">
              <div class="">
              </div>
            </div>
            <div class="chartjs-size-monitor-shrink">
              <div class="">
              </div>
            </div>
          </div>
          <canvas class="my-4 w-100 chartjs-render-monitor" id="myChart" height="250" style="display: block; height: 390px; width: 753px;" width="813">
          </canvas>
        </div>
      </div>
    </section>
    <!-- Section: Main chart -->
    <section>
      <div class="row">
        <div class="col-xl-3 col-sm-6 col-12 mb-3">
          <div class="card">
            <div class="card-body">
              <div class="d-flex justify-content-between px-md-1">
                <div class="align-self-center">
                  <i class="fas text-info fa-3x fa-solid fa-users"></i>
                </div>
                <div class="text-end">
                  <h3><?php echo $slnv ?></h3>
                  <p class="mb-0">Nhân viên</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12 mb-3">
          <div class="card">
            <div class="card-body">
              <div class="d-flex justify-content-between px-md-1">
                <div class="align-self-center">
                  <i class="fas text-warning fa-3x fa-solid fa-chart-pie"></i>
                </div>
                <div class="text-end">
                  <h3><?php echo $slbp ?></h3>
                  <p class="mb-0">Bộ phận</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12 mb-3">
          <div class="card">
            <div class="card-body">
              <div class="d-flex justify-content-between px-md-1">
                <div class="align-self-center">
                  <i class="fas text-primary fa-3x fa-solid fa-briefcase"></i>
                </div>
                <div class="text-end">
                  <h3><?php echo $slcv ?></h3>
                  <p class="mb-0">Chức vụ</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12 mb-3">
          <div class="card">
            <div class="card-body">
              <div class="d-flex justify-content-between px-md-1">
                <div class="align-self-center">
                  <i class="fa-solid fa-eye fas text-danger fa-3x"></i>
                </div>
                <div class="text-end">
                  <h3><?php echo $sltc ?></h3>
                  <p class="mb-0">Lượt truy cập</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!------------------------------------------------------------------------->
    <section>
      <div class="row">
        <div class="col-xl-3 col-sm-6 col-12 mb-3">
          <div class="card">
            <div class="card-body">
              <div class="d-flex justify-content-between px-md-1">
                <div class="align-self-center">
                  <i class="fa-solid fa-id-card-clip fas text-success fa-3x"></i>
                </div>
                <div class="text-end">
                  <h3><?php echo $sltk ?></h3>
                  <p class="mb-0">Tài khoản</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12 mb-3">
          <div class="card">
            <div class="card-body">
              <div class="d-flex justify-content-between px-md-1">
                <div class="align-self-center">
                  <i class="fas fa-3x fa-solid fa-list-check" style="color:#d63384;"></i>
                </div>
                <div class="text-end">
                  <h3>0</h3>
                  <p class="mb-0">Dự án</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12 mb-3">
          <div class="card">
            <div class="card-body">
              <div class="d-flex justify-content-between px-md-1">
                <div class="align-self-center">
                  <i class="fa-solid fa-chart-line fas fa-3x" style="color:#20c997;"></i>
                </div>
                <div class="text-end">
                  <h3>0</h3>
                  <p class="mb-0">KPI</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12 mb-3">
          <div class="card">
            <div class="card-body">
              <div class="d-flex justify-content-between px-md-1">
                <div class="align-self-center">
                  <i class="fas fa-3x fa-solid fa-bell" style="color:#6f42c1;"></i>
                </div>
                <div class="text-end">
                  <h3>0</h3>
                  <p class="mb-0">Thông báo mới</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!------------------------------------------------------------------------->
    <section>
      <!--div class="row">
        <div class="col-xl-6 col-md-12 mb-4">
          <div class="card">
            <div class="card-body">
              <div class="d-flex justify-content-between p-md-1">
                <div class="d-flex flex-row">
                  <div class="align-self-center">
                    <i class="fas fa-pencil-alt text-info fa-3x me-4"></i>
                  </div>
                  <div>
                    <h4>Total Posts</h4>
                    <p class="mb-0">Monthly blog posts</p>
                  </div>
                </div>
                <div class="align-self-center">
                  <h2 class="h1 mb-0">18,000</h2>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-6 col-md-12 mb-4">
          <div class="card">
            <div class="card-body">
              <div class="d-flex justify-content-between p-md-1">
                <div class="d-flex flex-row">
                  <div class="align-self-center">
                    <i
                       class="far fa-comment-alt text-warning fa-3x me-4"
                       ></i>
                  </div>
                  <div>
                    <h4>Total Comments</h4>
                    <p class="mb-0">Monthly blog posts</p>
                  </div>
                </div>
                <div class="align-self-center">
                  <h2 class="h1 mb-0">84,695</h2>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div-->
      <div class="row">
        <div class="col-xl-6 col-md-12 mb-4">
          <div class="card">
            <div class="card-body">
              <div class="d-flex justify-content-between p-md-1">
                <div class="d-flex flex-row">
                  <div class="align-self-center">
                    <h2 class="h1 mb-0 me-4"><?php echo number_format($tongLuongNam, 0, ',', '.'). 'đ'; ?></h2>
                  </div>
                  <div>
                    <h4>Chi ngân</h4>
                    <p class="mb-0"><?php echo 'Năm '. $thisYear; ?></p>
                  </div>
                </div>
                <div class="align-self-center">
                  <i class="far fa-heart text-danger fa-3x"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-6 col-md-12 mb-4">
          <div class="card">
            <div class="card-body">
              <div class="d-flex justify-content-between p-md-1">
                <div class="d-flex flex-row">
                  <div class="align-self-center">
                    <h2 class="h1 mb-0 me-4"><?php echo number_format($tongLuong[$thisMonth-1], 0, ',', '.'). 'đ'; ?></h2>
                  </div>
                  <div>
                    <h4>Chi ngân</h4>
                    <p class="mb-0">Tháng <?php echo ($thisMonth + 0); ?></p>
                  </div>
                </div>
                <div class="align-self-center">
                  <i class="fas fa-wallet text-success fa-3x"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
</div>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
<script type="text/javascript">{// Graph
var ctx = document.getElementById("myChart");

var myChart = new Chart(ctx, {
  type: "line",
  data: {
    labels: [
      "Tháng 1",
      "Tháng 2",
      "Tháng 3",
      "Tháng 4",
      "Tháng 5",
      "Tháng 6",
      "Tháng 7",
      "Tháng 8",
      "Tháng 9",
      "Tháng 10",
      "Tháng 11",
      "Tháng 12",
    ],
    datasets: [
      {
        data: [
        <?php 
            for ($m=0;$m<12;$m++)
            echo $tongLuong[$m] . ',';
        ?>],
        lineTension: 0,
        backgroundColor: "transparent",
        borderColor: "#007bff",
        borderWidth: 4,
        pointBackgroundColor: "#007bff",
      },
    ],
  },
  options: {
    scales: {
      yAxes: [
        {
          ticks: {
            beginAtZero: false,
          },
        },
      ],
    },
    legend: {
      display: false,
    },
  },
});}
</script>
<script id="allow-copy_script">(function agent() {
    let unlock = false
    document.addEventListener('allow_copy', (event) => {
      unlock = event.detail.unlock
    })

    const copyEvents = [
      'copy',
      'cut',
      'contextmenu',
      'selectstart',
      'mousedown',
      'mouseup',
      'mousemove',
      'keydown',
      'keypress',
      'keyup',
    ]
    const rejectOtherHandlers = (e) => {
      if (unlock) {
        e.stopPropagation()
        if (e.stopImmediatePropagation) e.stopImmediatePropagation()
      }
    }
    copyEvents.forEach((evt) => {
      document.documentElement.addEventListener(evt, rejectOtherHandlers, {
        capture: true,
      })
    })
  })()
</script>
