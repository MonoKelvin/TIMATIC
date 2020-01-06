<?php
require_once(dirname(__FILE__) . '\utility.php');

refreshCheck();

session_start();

// 退出后online置为0，表示不在线，并可以在其他设备登录
$db = MySqlAPI::getInstance();
$db->query('update userinfo set online=0 where id=' . $_SESSION['id']);
$db->close();

// 清空session信息
$_SESSION = array();

// 清空客户端sessionid
if (isset($_COOKIE[session_name()])) {
    setCookie(session_name(), '', time() - 3600, '/');
}

// 彻底销毁session
session_destroy();

header('location: http://timatic.com/login_page.php');
