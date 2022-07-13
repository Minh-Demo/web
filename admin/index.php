<?php
    session_start();
    include('../db/connect.php');
?> 
<?php
    // session_destroy();
    // unset('dangnhap');
    if(isset($_POST['dangnhap'])){
        $taikhoan = $_POST['taikhoan'];
        $matkhau = $_POST['matkhau'];
        if ($taikhoan=='' || $matkhau==''){
            echo '<h4>Vui lòng nhập đủ thông tin</h4>';
        }else{
            $sql_select_admin = mysqli_query($con,"SELECT *FROM tbl_admin WHERE email = '$taikhoan' AND 
                                    password = '$matkhau' LIMIT 1");
            $count = mysqli_num_rows($sql_select_admin);
            $row_dangnhap = mysqli_fetch_array($sql_select_admin);
            if($count>0){
                $_SESSION['dangnhap'] = $row_dangnhap['admin_name'];
                $_SESSION['admin_id'] = $row_dangnhap['admin_id'];
                header('Location:dashboard.php');
            }else{
                echo '<h4>Tài khoản hoặc mật khẩu không chính xác</h4>';
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập Admin</title>
</head>
<body>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500&display=swap');
        *{
            box-sizing: border-box;
        }
        body{
            background-color: #ccc;
            font-family: 'Montserrat', sans-serif;
            font-size: 17px;
        }
        #wrapper{
            
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 80vh;
        }
        form{
            background-color: #fff;
            border: 1px solid #dadce0;
            border-radius: 10px;
            padding: 30px;
        }
        h3{
            text-align: center;
            font-size: 24px;
            font-weight: 500;
        }
        .form-group{
            margin-bottom: 15px;
            position: relative;
        }
        input{
            height: 50px;
            width: 300px;
            outline: none;
            border: 1px solid #dadce0;
            padding: 10px;
            border-radius: 5px;
            font-size: inherit;
            color: #202124;
            transition: all 0.3s ease-in-out;
        }
        label{
            position: absolute;
            padding: 0px 5px;
            left: 5px;
            top: 50%;
            /* Quan trọng  */
            pointer-events: none;
            transform: translateY(-50%);
            background: #fff;
            transition: all 0.3s ease-in-out;
        }
        .form-group input:focus {
            border: 2px solid #1a73e8;
        }
        .form-group input:focus + label, .form-group input:valid + label{
            top: 0px;
            font-size: 13px;
            font-weight: 500;
            color: #1a73e8;
        }
        input#btn-login{
            background: #1a73e8;
            color: #fff;
            cursor: pointer;
        }
        input#btn-login:hover{
            opacity: 0.85;
        }
    </style>
    <div id="wrapper">
        <form action="" method="POST">
            <h3>Đăng nhập Admin</h3>
            <div class="form-group">
                <input type="text" name="taikhoan" >
                <label for="">Email</label>
            </div>
            <div class="form-group">
                <input type="password" name="matkhau" >
                <label for="">Mật khẩu</label>
            </div>
            <input type="submit" name="dangnhap" value="Đăng nhập" id="btn-login" >
        </form>
    </div>

    	<!-- ckeditor
	<script src="https://cdn.ckeditor.com/ckeditor5/34.1.0/classic/ckeditor.js"></script>
	<script>
        CKEDITOR.replace( 'mota' );
        CKEDITOR.replace( 'chitiet' );

    </script> -->
    
</body>
</html>