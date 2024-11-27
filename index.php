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

if (isset($_GET['act']) && $_GET['act'] != '') {
    $act = $_GET['act'];
    switch ($act) {

case 'ctsp':
    $loadbl_sp = load_bl_sp($_GET['idsp']);
    $loadone_sp = loadAll_sanpham("", $_GET['idsp']);
    $load_sp_cl = load_sp_cung_loai($_GET['idsp'], $_GET['iddm']);
    // $starss =  thong_ke_star($_GET['idsp']);
    // var_dump($starss);
    include_once 'view/ctsp.php';
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
        include 'view/cart/thanhtoan.php';
        break;
    }
    
} else {
    include 'view/home.php';
}
include 'view/footer.php';
ob_end_flush();
















?>