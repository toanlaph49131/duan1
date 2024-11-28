<div class="container-fluid">

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 h5 text-dark font-weight-bold">Danh sách tài khoản</h6>
        </div>
        <div class="card-body">
            
            <div class="table-responsive">
                <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="fw-bold text-secondary">STT</th>
                            <th class="fw-bold text-secondary">Tên sản phẩm</th>
                            <th class="fw-bold text-secondary">Số lượng Kho</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($list_khohang as $value) {?>
                        <tr>
                            <td><?= $value['id']?></td>
                            <td><?= $value['name']?></td>
                            <td><?= $value['soluong']?></td>
                            
                               
                        </tr>
                        <?php }?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>