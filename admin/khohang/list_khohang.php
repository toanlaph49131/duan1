<div class="container-fluid">

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 h5 text-dark font-weight-bold">Danh sách kho hang</h6>
        </div>
        <div class="card-body">
            
            <div class="table-responsive">
                <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="fw-bold text-secondary">STT</th>
                            <th class="fw-bold text-secondary">Tên sản phẩm</th>
                            <th class="fw-bold text-secondary">Số lượng Kho</th>
                            <th class="fw-bold text-secondary">Tình trạng trong kho</th></th>
                            <th class="fw-bold text-secondary">Action</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($list_khohang as $key => $value) {?>
                        <tr>
                            <td><?= ++$key?></td>
                            <td><?= $value['name']?></td>
                            <td><?= $value['soluong']?></td>
                            <td>
                            <?php 
                                if ($value['soluong'] < 10) {
                                    echo '<span style="color: red;">Sắp hết hàng</span>';
                                } else {
                                    echo '<span style="color: green;">Đang còn</span>';
                                }
                            ?>
                        </td>
                            <td><a href="index.php?act=update_khohang&id=<?= $value['id'] ?>">Update</a></td>
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