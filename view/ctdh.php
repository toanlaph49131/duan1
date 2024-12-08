<div class="box-ctdh">
    <table>
        <thead>
            <tr>
                <th>Ảnh</th>
                <th>Tên sản phẩm</th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th>Thành tiền</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($ctdh as $value) {
                extract($value); ?>
                <tr>
                    <td><img width="70" src="uploads/img_sp/<?= $img ?>" alt="<?= $img ?>"></td>
                    <td><?= $name ?></td>
                    <td><?= number_format($gia_ban, 0, ",", ".") ?> ₫</td>
                    <td>x<?= $soluong ?></td>
                    <td><?= number_format($soluong * $gia_ban, 0, ",", ".") ?></td>
                </tr>
            <?php }
            ?>
            <?php
            if ($trangthai === 1) { ?>
                <form method="POST" action="?act=update_trangthai&id_dh=<?= $id ?>">
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                            <select name="ly_do_huy" id="ly_do_huy">
                                <option value="0">-- Chọn lý do hủy đơn --</option>
                                <option value="Đặt nhầm địa chỉ">Đặt nhầm địa chỉ</option>
                                <option value="Chờ xác nhận quá lâu">Chờ xác nhận quá lâu</option>
                                <option value="Không muốn mua sản phẩm này nữa">Không muốn mua sản phẩm này nữa</option>
                                <option value="Nhập sai thông tin đặt hàng">Nhập sai thông tin đặt hàng</option>
                            </select>
                        </td>
                        <td>
                            <button type="submit" onclick="return confirm('Bạn có chắc chắn muốn hủy đơn hàng?')" style=" background-color: red; color: #fff; border-radius: 5px; padding: 5px" >Hủy đơn hàng</button>
                        </td>
                    </tr>
                </form>

            <?php }
            ?>
        </tbody>
    </table>
    <?php
    if ($trangthai === 4 && count($load_not_vote) > 0) { ?>
        <div class="form-Evaluate mt">
            <form action="?act=ctdh&id_dh=<?= $id ?>" method="post">
                <table>
                    <thead>
                        <tr>
                            <th>Tên sản phẩm</th>
                            <th>Ảnh</th>
                            <th>Đánh giá</th>
                            <th>Bình luận</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($load_not_vote as $key => $item) {
                        ?>
                            <tr>
                                <td><?= $name ?> <input type="text" name="id_sp<?= $key + 1 ?>" value="<?= $item['id'] ?>" hidden></td>
                                <td><img width="50" src="uploads/img_sp/<?= $item['img'] ?>" alt=""></td>
                                <td>
                                    <div class="rating">
                                        <input class="star star-5" id="star-5-<?= $key + 1 ?>" value="5" type="radio" name="star-rating<?= $key + 1 ?>" />
                                        <label class="star star-5" for="star-5-<?= $key + 1 ?>"></label>
                                        <input class="star star-4" id="star-4-<?= $key + 1 ?>" value="4" type="radio" name="star-rating<?= $key + 1 ?>" />
                                        <label class="star star-4" for="star-4-<?= $key + 1 ?>"></label>
                                        <input class="star star-3" id="star-3-<?= $key + 1 ?>" value="3" type="radio" name="star-rating<?= $key + 1 ?>" />
                                        <label class="star star-3" for="star-3-<?= $key + 1 ?>"></label>
                                        <input class="star star-2" id="star-2-<?= $key + 1 ?>" value="2" type="radio" name="star-rating<?= $key + 1 ?>" />
                                        <label class="star star-2" for="star-2-<?= $key + 1 ?>"></label>
                                        <input class="star star-1" id="star-1-<?= $key + 1 ?>" value="1" type="radio" name="star-rating<?= $key + 1 ?>" />
                                        <label class="star star-1" for="star-1-<?= $key + 1 ?>"></label>
                                    </div>
                                </td>
                                <td>
                                    <textarea name="binhluan<?= $key + 1 ?>" id="" cols="30" rows="5" placeholder="Vui lòng nhập bình luận"></textarea>
                                </td>
                            </tr>
                        <?php }
                        ?>
                    </tbody>
                </table>
                <button class="mt" name="submit" value="submit" type="submit">Gửi</button>
            </form>


        </div>
    <?php }
    ?>

</div>