<?php
function thong_ke()
{
    $sql = "SELECT dm.id, dm.name, COUNT(sp.id) AS soluong_sanpham
    FROM danhmuc dm
    LEFT JOIN sanpham sp ON dm.id = sp.iddm
    GROUP BY dm.id, dm.name
    ORDER BY dm.id";
    return pdo_query($sql);
}


function thong_ke_doanh_thu()
{
    $sql = "SELECT SUM(thanhtien) AS tong_thanhtien
    FROM (
        SELECT MAX(thanhtien) AS thanhtien
        FROM ct_don_hang JOIN donhang ON ct_don_hang.id_dh = donhang.id
        WHERE donhang.trangthai = '4'
        GROUP BY id_dh
    ) AS max_thanhtien;";
    return pdo_query_one($sql);
}
function thong_ke_star($idsp)
{
    $sql = "
    SELECT
    COUNT(CASE WHEN star = 1 THEN 1 END) AS star_1,
    COUNT(CASE WHEN star = 2 THEN 1 END) AS star_2,
   COUNT(CASE WHEN star = 3 THEN 1 END) AS star_3,
    COUNT(CASE WHEN star = 4 THEN 1 END) AS star_4,
     COUNT(CASE WHEN star = 5 THEN 1 END) AS star_5
    
  FROM binhluan
  WHERE id_pro = '$idsp'
  GROUP BY id_pro;
    ";
    return pdo_query($sql);
}

function thong_ke_doanh_thu_thanh(){
    $sql = "
    SELECT
    MONTH(dh.date) AS thang,
    SUM(dh.thanhtien) AS doanhthu
FROM
    donhang dh
WHERE
    dh.trangthai = 4
GROUP BY
    thang
ORDER BY
 thang;
    ";
    return pdo_query($sql);
}

function thong_ke_trang_thai() {
    $sql = "
    SELECT 
        s.name_status AS ten_trang_thai, 
        COUNT(d.id) AS so_luong,
        ROUND(COUNT(d.id) * 100 / (SELECT COUNT(*) FROM donhang), 2) AS phan_tram
    FROM 
        donhang d
    JOIN 
        status s ON d.trangthai = s.id
    GROUP BY 
        d.trangthai, s.name_status
    ORDER BY 
        so_luong DESC
    ";
    return pdo_query($sql);
}