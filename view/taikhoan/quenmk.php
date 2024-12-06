
<?php
include "../../model/pdo.php";
include "../../model/taikhoan.php";
include "../../model/validate.php";
?>
<!DOCTYPE html>
<html lang="en">


<div class="box-qmk">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../css/css.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
</head>
<style>
    body {
        padding-top: 0;
    }
</style>

<body>
    <div class="box-container">
        <div class="container-dn">
            <div class="left">
                <div class="header">
                    <h2>Quên mật khẩu</h2>
                </div>
                <div class="box-qmk">
                    <form action="?act=quenmk" method="post">
                        <h3>Quên mật khẩu</h3>
                        <input type="text" name="email" placeholder="Mời nhập Email"> <br>
                        <?php if (isset($sendMailMess) && $sendMailMess != '') {
                            if ($sendMailMess == 'Gửi email thành công') {
                                echo '<span style="color:green">' . $sendMailMess . '</span> <br>';
                            } else {
                                echo '<span class="error">' . $sendMailMess . '</span> <br>';
                            }
                        } ?>
                        <button name="guiemail" value="guiemail" type="submit">Gửi</button>

                    </form>
                </div>
            </div>
            <div class="right">
                <img src="https://i.pinimg.com/originals/6a/ba/8d/6aba8d6fe7a455389b50d24cfbc84316.jpg">
            </div>
        </div>
    </div>
</body>

</html>