<?php
require_once(dirname(__FILE__) . '\api\utility.php');
refreshOnce();

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>管理员注册</title>
    <?php include_once('html/included_head.php'); ?>
</head>

<body>
    <div class="page login-page">
        <div class="container d-flex align-items-center p-5">
            <div class="form-holder has-shadow">
                <div class="row">
                    <!-- Logo & Information Panel-->
                    <div class="col-lg-6">
                        <div class="info d-flex align-items-center">
                            <div class="content text-right">
                                <h1 style="font-size: 80px">TIMATIC</h1>
                                <h2>—— 旅游信息查询系统</h2>
                            </div>
                        </div>
                    </div>
                    <!-- Form Panel    -->
                    <div class="col-lg-6 bg-white">
                        <div class="form d-flex align-items-center">
                            <div class="content">
                                <form method="post" class="form-validate" action="api/register_validate.php?obj=admin">
                                    <input id="register-id" name="register_id" class="hidden-form-control">
                                    <div class="form-group">
                                        <input id="register-name" type="text" name="name" required data-msg="请输入至少一个非空格字符" maxlength="16" class="input-material">
                                        <label for="register-name" class="label-material">用户昵称</label>
                                    </div>
                                    <div class="row justify-content-between no-margin">
                                        <div class="col-9">
                                            <div class="form-group">
                                                <input id="register-email" type="email" name="account" required data-msg="请输入一个有效的邮件地址" class="input-material">
                                                <label for="register-email" class="label-material">QQ邮箱地址</label>
                                            </div>
                                        </div>
                                        <div class="col-3 text-right">
                                            <button onclick="sendVerifyCodeMail($('#register-email'), true);" type="button" class="btn btn-primary">
                                                获取验证码
                                            </button>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input id="register-password" type="password" name="password" required data-msg="请输入6-16个字符作为密码" minlength="6" maxlength="16" class="input-material">
                                        <label for="register-password" class="label-material">密码</label>
                                    </div>
                                    <div class="form-group">
                                        <input id="register-repassword" type="password" name="repassword" required data-msg="两次密码不一样" minlength="6" maxlength="16" class="input-material">
                                        <label for="register-repassword" class="label-material">确认密码</label>
                                    </div>
                                    <div class="form-group">
                                        <input id="register-code" type="text" name="verify_code" required data-msg="请输入验证码" class="input-material">
                                        <label for="register-code" class="label-material">验证码</label>
                                    </div>
                                    <div class="form-group terms-conditions">
                                        <input id="register-agree" name="registerAgree" type="checkbox" required checked="checked" data-msg="必须同意才能进行注册" class="checkbox-template">
                                        <label for="register-agree">同意遵守《旅游信息查询使用规章制度》</label>
                                    </div>
                                    <div class="form-group text-right">
                                        <button type="submit" name="submit" value="submit" class="btn btn-lg btn-primary">完成注册</button>
                                        <button type="button" onclick="location.href='login_page.php';" class="btn btn-lg btn-primary ml-3">返回登录</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="copyrights text-center">
            <p>Developed by <a href="https://github.com/MonoKelvin">MonoKelvin</a>
                <!-- Please do not remove the back-link to us unless you support further theme's development at https://bootstrapious.com/donate. It is part of the license conditions. Thank you for understanding :) -->
                <br /> Thanks for the page designed by <a href="https://bootstrapious.com/donate" class="external">Bootstrapious</a>
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
    <script src="js/utility.js"></script>
</body>

</html>
