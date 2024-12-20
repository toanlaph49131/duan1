<?php
function loadall_taikhoan($key = "", $idtk = 0)
{
    $sql = "SELECT * FROM taikhoan";
    if ($key != "") {
        $sql .= " WHERE user = '$key'";
    }
    if ($idtk > 0) {
        $sql .= " WHERE id = $idtk";
    }
    $sql .= " ORDER BY id desc";
    return pdo_query($sql);
}
function insert_taikhoan($user, $email, $pass,$status)
{
    $sql = "INSERT INTO taikhoan(user,email,pass,status) values('$user','$email','$pass', '$status')";
    pdo_execute($sql);
}

function update_mk($id,$pass)
{
    $sql = "UPDATE taikhoan SET pass = '$pass' WHERE id = " . $id;
    pdo_execute($sql);
}
function delete_taikhoan($id)
{
    $sql = "delete FROM taikhoan WHERE id=" . $id;
    pdo_execute($sql);
}

function checkuser($user, $pass)
{
    $sql = "SELECT * FROM taikhoan WHERE  user='" . $user . "' AND  pass='" . $pass . "'";
    $sp = pdo_query_one($sql);
    return $sp;
}

function checkemail($email)
{
    $sql = "SELECT * FROM taikhoan WHERE  email='" . $email . "'";
    $sp = pdo_query_one($sql);
    return $sp;
}
function  update_taikhoan($id, $user, $email, $sdt, $address)
{
    $sql = "UPDATE `taikhoan` SET `user`='$user',`email`='$email',`tel`='$sdt',`address`='$address', `checkname` = '0'  WHERE id=" . $id;
    pdo_execute($sql);
}

function update_role($id, $role, $status)
{
    // Thêm dấu nháy đơn cho chuỗi và đảm bảo ID là số
    $sql = "UPDATE taikhoan SET role=$role, status='$status' WHERE id=" . $id;
    
    // Thực thi câu lệnh SQL
    pdo_execute($sql);
}

function checkuserlogin($user)
{
    $sql = "SELECT * FROM taikhoan WHERE  user='" . $user . "'";
    $sp = pdo_query_one($sql);
    return $sp;
}
function selectone_tk($id)
{
    $sql = "SELECT * FROM taikhoan WHERE id=" . $id;
    return pdo_query_one($sql);
}
function check_email($email)
{
    $sql = "SELECT * FROM taikhoan WHERE  email='" . $email. "'";
    $sp = pdo_query_one($sql);
    return $sp;
}
function update_mk_email($email, $pass)
{
    // Đảm bảo email và pass được đặt trong dấu nháy đơn
    $sql = "UPDATE taikhoan SET pass = '" . $pass . "' WHERE email = '" . $email . "'";
    pdo_execute($sql);
}
