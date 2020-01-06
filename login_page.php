<?php
require_once(dirname(__FILE__) . '\api\utility.php');
isLogedIn(true);
refreshOnce();

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>用户登录</title>
    <?php include_once('html/included_head.php'); ?>
</head>

<body>
    <div class="page login-page">
        <div class="container d-flex align-items-center p-5">
            <div class="form-holder has-shadow">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="info d-flex align-items-center">
                            <div class="content text-right">
                                <h1 style="font-size: 80px">TIMATIC</h1>
                                <h2>—— 旅游信息查询系统</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 bg-white">
                        <div class="form d-flex align-items-center">
                            <div class="content">
                                <div class="text-center">
                                    <h3 class="pb-5">用户登录</h3>
                                </div>
                                <form action="/api/login_validate.php" method="post" class="form-validate">
                                    <div class="form-group">
                                        <input id="login-username" type="text" name="account" required data-msg="账号" class="input-material">
                                        <label for="login-username" class="label-material">邮箱</label>
                                    </div>
                                    <div class="form-group">
                                        <input maxlength="20" id="login-password" type="password" name="password" required data-msg="密码" class="input-material">
                                        <label for="login-password" class="label-material">密码</label>
                                    </div>
                                    <div class="form-group text-right">
                                        <small> <a href="forget_password.php">忘记密码?</a></small>
                                    </div>
                                    <div class="form-group text-right">
                                        <button id="login-btn" name="submit" value="login" class="btn btn-lg btn-primary">登录</button>
                                        <button id="register-btn" onclick="location.href='register.php';" type="button" class="btn btn-lg btn-primary ml-3">注册</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="copyrights text-center">
            <p>Developed by <a href="https://github.com/MonoKelvin" target="_blank">MonoKelvin</a>
                <!-- Please do not remove the back-link to us unless you support further theme's development at https://bootstrapious.com/donate. It is part of the license conditions. Thank you for understanding :) -->
                <br /> Thanks for the page designed by <a href="https://bootstrapious.com/donate" class="external" target="_blank">Bootstrapious</a>
            </p>
        </div>
    </div>
    <!-- JavaScript files-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/popper.js/umd/popper.min.js"> </script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="vendor/jquery.cookie/jquery.cookie.js"> </script>
    <script src="vendor/chart.js/Chart.min.js"></script>
    <script src="vendor/jquery-validation/jquery.validate.min.js"></script>
    <!-- Main File-->
    <script src="js/front.js"></script>
</body>

</html>
