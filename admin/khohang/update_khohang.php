<div class="container-fluid">

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 h5 text-dark font-weight-bold">Cập nhật kho hàng</h6>
        </div>
        <div class="card-body">
            <form class="row g-3 needs-validation" novalidate enctype="multipart/form-data" method="POST">
                <div class="col-md-6 mb-3">
                    <label for="validationCustomUsername" class="form-label font-weight-bold">Tên sản phẩm</label>
                    <div class="input-group has-validation">
                        <input name="name" type="text" class="form-control" id="validationCustomUsername" aria-describedby="inputGroupPrepend" required value="<?=$loadone_sp['name']?>">
                        <div class="invalid-feedback">
                            Không được để trống.
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="validationCustomUsername" class="form-label font-weight-bold">Số lượng sản phẩm còn</label>
                    <div class="input-group has-validation">
                        <input name="soluong" type="number" class="form-control" id="validationCustomUsername" aria-describedby="inputGroupPrepend" required value="<?=$loadone_sp['soluong']?>">
                        <div class="invalid-feedback">
                            Không được để trống.
                        </div>
                    </div>
                </div>
                
                <div class="col-md-12">
                    <input class="btn btn-success " type="submit" name="submit" value="Thực hiện"></input>
                    <button type="reset" class="btn btn-outline-secondary">Nhập lại</button>
                    <a class="btn btn-primary" href="?act=list_khohang" type="submit">Danh sách sản phẩm</a>
                </div>
                <div class="col-12">
                    <div class="mt-4">
                        <?php
                        if (isset($thongbao) && $thongbao != "") {
                            echo "<p style='color: green;'>$thongbao</p>";
                        }
                        if (isset($err) && $err != "") {
                            echo "<p style='color: red;'>$err</p>";
                        }
                        ?>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>