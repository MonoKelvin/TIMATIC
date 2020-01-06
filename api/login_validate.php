<?php
require_once(dirname(__FILE__) . '\utility.php');

refreshCheck();

if (@$_POST['submit'] === 'login') {
    $db = MySqlAPI::getInstance();
    $account = @$_POST['account'];
    $password = @$_POST['password'];

    if ($db == null) {
        echo '<script> alert("数据库连接失败"); history.go(-1);</script>';
    } else {
        if (!$account || !$password) {
            echo '<script> alert("信息获取失败，请重新登录！"); history.go(-1);</script>';
            die;
        }
        $res = $db->getRow(
            "select id,account,name,password,online from userinfo
            where account = '$account' and password = '$password'"
        );

        if ($res) {
            if ($res['online'] == 1) {
                $db->close();
                echo '<script>alert("该账号已在另一台设备登录，不可重复登录！"); history.go(-1); </script>';
                die;
            }

            // 获取登录信息
            $_SESSION['id'] = $res['id'];
            $_SESSION['account'] = $res['account'];
            $_SESSION['name'] = $res['name'];
            $_SESSION['password'] = $res['password'];

            // 登陆后online置为1，表示在该设备登录了
            $db->query('update userinfo set online=1 where id=' . $res['id']);

            echo '<script>window.location="/../index.php";</script>';
        } else {
            echo '<script>alert("邮箱或密码错误！"); history.go(-1); </script>';
        }
    }

    $db->close();
} else {
    isEntry404();
}
