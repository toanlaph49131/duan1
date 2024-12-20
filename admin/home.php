<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Thống kê chi tiết</h1>
    </div>
    <!-- Content Row -->
    <div class="row">
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Doanh thu</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= $thong_ke_doanh_thu['tong_thanhtien'] ? number_format($thong_ke_doanh_thu['tong_thanhtien'], 0, ',', '.') : '0' ?>
                                ₫</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Requests Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Số lượng sản phẩm</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $count_sp ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->

    <div class="row">
        <div class="col-xl-12 col-lg-7">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Thống kê</a>
                    <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Biểu đồ</a>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                    <div class="card shadow mb-4">
                        <!-- Card Body -->
                        <div class="card-body">
                            <div class="chart-area">
                                <div class="container text-center">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <div id="chartContainer" style="height: 300px; width: 100%;"></div>
                                        </div>
                                        <div class="col">
                                            <div id="myPlot" style="width: 100%; height: 320px;"></div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                $dataPoints = [];
                                foreach ($thong_ke_doanh_thu_thang as $row) {
                                    $dataPoints[] = [
                                        "label" => "Tháng " . $row['thang'], // Gắn nhãn theo tháng
                                        "y" => $row['doanhthu'] // Doanh thu theo tháng
                                    ];
                                }                                   ?>
                                <script>
                                    window.onload = function() {

                                        var chart = new CanvasJS.Chart("chartContainer", {
                                            animationEnabled: true,
                                            exportEnabled: true,
                                            theme: "light1", // "light1", "light2", "dark1", "dark2"
                                            title: {
                                                text: "Thống kê doanh thu tháng"
                                            },
                                            axisY: {
                                                includeZero: true
                                            },
                                            data: [{
                                                type: "column",
                                                dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
                                            }]
                                        });
                                        chart.render();
                                    }
                                </script>
                                <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
                                <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>

                                <script>
                                    // Nhận dữ liệu từ PHP
                                    const xArray = <?php echo $xArrayJson; ?>; // Tên trạng thái
                                    const yArray = <?php echo $yArrayJson; ?>; // Phần trăm trạng thái

                                    // Cấu hình biểu đồ Pie
                                    const layout = {
                                        title: "Tỷ lệ trạng thái đơn hàng"
                                    };

                                    const data = [{
                                        labels: xArray, // Nhãn (Tên trạng thái)
                                        values: yArray, // Giá trị (Phần trăm)
                                        type: "pie"
                                    }];

                                    // Hiển thị biểu đồ
                                    Plotly.newPlot("myPlot", data, layout);
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                    <div class="card shadow mb-4">
                        <!-- Card Body -->
                        <div class="card card-body">
                            <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                            <script type="text/javascript">
                                google.charts.load("current", {
                                    packages: ["corechart"]
                                });
                                google.charts.setOnLoadCallback(drawChart);

                                function drawChart() {
                                    var data = google.visualization.arrayToDataTable([
                                        ['Danh mục', 'Số lượng'],
                                        <?php foreach ($thong_ke as $value) {
                                            extract($value);
                                            echo "['$name', $soluong_sanpham],";
                                        } ?>
                                    ]);

                                    var options = {
                                        title: 'Biểu đồ thống kê sản phẩm theo doanh mục',
                                        is3D: true,
                                    };

                                    var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
                                    chart.draw(data, options);
                                }
                            </script>
                            <div id="piechart_3d" style="width: 100%; height: 350px;"></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>