<?php
ob_start();
session_start();
include 'model/pdo.php';
include 'model/sanpham.php';
include 'model/danhmuc.php';
include 'model/taikhoan.php';
if (isset($_SESSION['iduser'])) {
    $tk =  selectone_tk($_SESSION['iduser']);
}
include 'view/header.php';
include 'model/cart.php';
include 'model/validate_form.php';
include 'model/validate_pass.php';
include 'model/binhluan.php';
include 'model/donhang.php';
include 'model/thongke.php';

// if (isset($_SESSION['user'])) {
//     header('Location:view/taikhoan/dangnhap.php');
// }
if (isset($_SESSION['role']) && $_SESSION['role'] === 1) {
    header('location:admin/index.php');
}
$loadstar = loadstar();
$load_sp_luot_xem = load_sp_luotxem();
// $list_sp_home = loadAll_sanpham();
$list_dm = loadAll_danhmuc();
$load_sp_star = load_sp_star();

if (isset($_GET['act']) && $_GET['act'] != '') {
    $act = $_GET['act'];
    switch ($act) {
        case 'dangxuat':
            session_unset();
            header('location:index.php');
            break;
        case 'ctsp':
            $loadbl_sp = load_bl_sp($_GET['idsp']);
            $loadone_sp = loadAll_sanpham("", $_GET['idsp']);
            $load_sp_cl = load_sp_cung_loai($_GET['idsp'], $_GET['iddm']);
            // $starss =  thong_ke_star($_GET['idsp']);
            // var_dump($starss);
            include_once 'view/ctsp.php';
            break;
        case 'ctdh':
            $load_not_vote = load_sp_chua_danh_gia($_SESSION['iduser'], $_GET['id_dh']);
            $_SESSION['mang'] = [];
            if (isset($_POST['submit']) && $_POST['submit']) {
                $mang = $_SESSION['mang'];

                // Loop through posted data and store in session array
                for ($i = 1; $i <= count($load_not_vote); $i++) {
                    $id = isset($_POST['id_sp' . $i]) ? $_POST['id_sp' . $i] : null;
                    $binhluan = $_POST['binhluan' . $i];
                    $rating = isset($_POST['star-rating' . $i]) ? $_POST['star-rating' . $i] : 5;

                    // Check if the comment is not empty before adding to the array
                    if (!empty($binhluan)) {
                        $mang[] = ['id' => $id, 'binhluan' => $binhluan, 'rating' => $rating];
                    }
                }

                $_SESSION['mang'] = $mang;
                for ($j = 0; $j < count($mang); $j++) {
                    insert_bl($_SESSION['iduser'], $mang[$j]['id'], $mang[$j]['binhluan'], $mang[$j]['rating']);
                    unset($_SESSION['mang']);
                }
                header('location: ' . $_SERVER['PHP_SELF'] . '?act=ctdh&id_dh=' . $_GET['id_dh']);
            }

            $ctdh =  loadone_chitietdonhang($_GET['id_dh']);
            include_once 'view/ctdh.php';
            break;
        case 'listsp':
            if (isset($_POST['submit']) && $_POST['submit']) {
                // từ khóa
                if (isset($_POST['kyw'])) {
                    $key = $_POST['kyw'];
                    $_SESSION['key'] = $key;
                } else {
                    $key = "";
                }
                //gia
                if (isset($_POST['gia'])) {
                    $gia = $_POST['gia'];
                } else {
                    $gia = "";
                }
                //Kieu may
                if (isset($_POST['kieumay'])) {
                    $kieumay = $_POST['kieumay'];
                } else {
                    $kieumay = "";
                }
                // xuat xu
                if (isset($_POST['xuatxu'])) {
                    $xuatxu = $_POST['xuatxu'];
                } else {
                    $xuatxu = "";
                }
            } else {
                $key = $gia = $kieumay = $xuatxu = "";
                unset($_SESSION['key']);
            }
            // id danh mục
            if (isset($_GET['iddm']) && $_GET['iddm'] > 0) {
                $iddm = $_GET['iddm'];
            } else {
                $iddm = 0;
            }
            $listsp_dm = listsp_dm($key, $iddm, $gia, $kieumay, $xuatxu);
            include_once 'view/listsp.php';
            break;
        case 'addtocart':
            if (isset($_SESSION['user'])) {
                $found = false;
                $loadAll_cart = loadAll_cart($_SESSION['iduser']);
                if (isset($_POST['btn']) && $_POST['btn']) {
                    $idsp = $_GET['idsp'];
                    $iduser = $_SESSION['iduser'];
                    $them = 0;
                    foreach ($loadAll_cart as &$value) {
                        if ($value['idsp'] == $idsp) {
                            $found = true;
                            if (isset($_POST['soluong']) && $_POST['soluong'] > 0) {
                                $them = $value['soluong'] + $_POST['soluong'];
                            }
                            update_sl($_SESSION['iduser'], $idsp, $them);
                            break; // Exit the loop after updating the quantity
                        }
                    }
                    if (!$found) {
                        if (isset($_POST['soluong'])) {
                            $soluong = $_POST['soluong'];
                        } else {
                            $soluong = 1;
                        }
                        insert_cart($iduser, $idsp, $soluong);
                    }
                    $_SESSION['count_cart'] = count(count_cart($_SESSION['iduser']));
                    header('Location: ' . $_SERVER['REQUEST_URI']);
                }
                if (isset($_POST['btn_delete']) && $_POST['btn_delete']) {
                    delete_cart($_GET['idcart']);
                    $_SESSION['count_cart'] = count(count_cart($_SESSION['iduser']));

                    header('Location: ' . $_SERVER['REQUEST_URI']);
                }
                if (isset($_POST['btn_giam']) && $_POST['btn_giam']) {
                    update_soluong($_SESSION['iduser'], $_GET['idcart'], $giam = "a", $tang = "");
                    header("Location: ?act=addtocart");
                    exit();
                }
                if (isset($_POST['btn_tang']) && $_POST['btn_tang']) {
                    update_soluong($_SESSION['iduser'], $_GET['idcart'], $giam = "", $tang = "a");
                    header("Location: ?act=addtocart");
                    exit();
                }
                $loadAll_cart = loadAll_cart($_SESSION['iduser']);
            } else {
                header('Location: view/taikhoan/dangnhap.php?act=dangnhap');
                exit();
            }
            include_once 'view/cart/viewcart.php';
            break;
        case 'thanhtoantc':
            include 'view/cart/thanhtoantc.php';
            break;
        case 'update_trangthai':
            update_trangthai($_GET['id_dh']);
            header('Location: ?act=mytaikhoan');
            break;
        case 'thanhtoan':
            if (isset($_SESSION['iduser'])) {
                if (isset($_GET['idcart']) && $_GET['idcart'] > 0) {
                    $idcart = $_GET['idcart'];
                } else {
                    $idcart = 0;
                }
                $loadAll_cart = loadAll_cart($_SESSION['iduser']);
                if (isset($_GET['idsp'])) {
                    $loadone_sp = loadAll_sanpham("",  $_GET['idsp']);
                }


                if (isset($_POST['redirect']) && $_POST['redirect']) {
                    if (isset($_POST['thanhtoan']) && $_POST['thanhtoan'] == "Thanh toán khi nhận hàng") {
                        $thanhtoan = $_POST['thanhtoan'];
                        $user = $_POST['user'];
                        $email = $_POST['email'];
                        $sdt = $_POST['sdt'];
                        $address = $_POST['address'];
                        $thanhtien = $_POST['thanhtien'];
                        $err = validate_form($user, $email, $sdt, $address);
                        if (empty($err)) {
                            $iddh =  insert_donhang($_SESSION['iduser'], $user, $sdt, $email, $address, $thanhtien);
                            if (!isset($_GET['idsp'])) {
                                for ($i = 0; $i < count($loadAll_cart); $i++) {
                                    $idsp = $loadAll_cart[$i]['idsp'];
                                    $idcart = $loadAll_cart[$i]['idcart'];
                                    $name = $loadAll_cart[$i]['name'];
                                    $gia = $loadAll_cart[$i]['gia_new'];
                                    $soluong = $loadAll_cart[$i]['soluong'];
                                    $img = $loadAll_cart[$i]['img'];
                                    insert_chitietdonhang($iddh, $idsp, $name, $gia, $soluong, $img);
                                    delete_cart($idcart);
                                }
                            } else {
                                $idsp = $_GET['idsp'];
                                $name = $loadone_sp[0]['name'];
                                $gia = $loadone_sp[0]['gia_new'];
                                $soluong = 1;
                                $img = $loadone_sp[0]['img'];
                                insert_chitietdonhang($iddh, $idsp, $name, $gia, $soluong, $img);
                            }
                            $_SESSION['count_cart'] = count(count_cart($_SESSION['iduser']));
                            header("Location: view/cart/thanhtoantc.php");
                        }
                    } else {
                        $error = 'Vui lòng chọn phương thức thanh toán!';
                    }
                }
                $loadAll_cart = loadAll_cart($_SESSION['iduser']);
            } else {
                header("Location: view/taikhoan/dangnhap.php?act=dangnhap");
            }
            include 'view/cart/thanhtoan.php';
            break;
        case 'mytaikhoan':
            if (isset($_POST['btn_tt']) && $_POST['btn_tt']) {
                $user = $_POST['user'];
                $email = $_POST['email'];
                $sdt = $_POST['sdt'];
                $address = $_POST['diachi'];
                $err = validate_form($user, $email, $sdt, $address);
                if (empty($err)) {
                    update_taikhoan($_SESSION['iduser'], $user, $email, $sdt, $address);
                    header("Location: index.php?act=mytaikhoan");
                }
            }
            if (isset($_POST['btn_update_pass']) && $_POST['btn_update_pass']) {
                $pass = $_POST['pass'];
                $captcha = $_POST['captcha'];
                $ma = $_POST['ma'];
                $confim = $_POST['confim'];
                $pass2 = $_POST['pass2'];
                $err  = check_update_pass($pass, $ma, $captcha, $confim, $pass2);
                if (empty($err)) {
                    update_mk($_SESSION['iduser'], $pass2);
                    echo "<script>alert('Đổi mật khẩu thành công!')</script>";
                }
            }
            $dh = load_donhang_user($_SESSION['iduser']);
            include 'view/taikhoan/mytaikhoan.php';
            break;
            case 'quenmk':
                include 'view/taikhoan/quenmk.php';
                if (isset($_POST['guiemail']) && $_POST['guiemail']) {
                    // Nếu thấy tồn tại email cho phép cập nhật mật khẩu mới và xóa mật khẩu cũ
                    $email = $_POST['email'];
                    
                    // Lưu email vào cookie, thời gian hết hạn là 1 ngày (86400 giây)
                    setcookie('email', $email, time() + 86400, "/"); 
            
                    if(checkemail($email)){
                        header('location:index.php?act=reset_pass');
                    }
                }
                break;
            case 'reset_pass':
                if(isset($_COOKIE['email']) && isset($_POST['submit']) && $_POST['submit']) {
                    $pass = $_POST['pass'];
                    $confirm = $_POST['confim'];
                    $email = $_COOKIE['email'];  // Lấy email từ cookie
            
                    if($pass == $confirm) {
                        update_mk_email($email, md5($pass));
                        echo "<script>alert('Đổi mật khẩu thành công!')</script>";
                        header('location:view/taikhoan/dangnhap.php?act=dangnhap');
                    }
                }
                include 'view/taikhoan/reset_pass.php';
                break;
            

                
    }
} else {
    include 'view/home.php';
}
include 'view/footer.php';
ob_end_flush();
