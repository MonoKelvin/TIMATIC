<?php
if (!session_id()) {
    session_start();
}

global $user_name;
global $user_avatar;
if (isset($_SESSION['name'])) {
    $user_name = $_SESSION['name'];
}

?>

<nav class="side-navbar">
    <div class="sidebar-header d-flex align-items-center">
        <div class="title">
            <h1 class="h4">欢迎用户</h1>
            <p><?php echo $user_name; ?></p>
        </div>
    </div>
    <span class="heading">导航</span>
    <ul class="list-unstyled">
        <?php
        outputCurrentActivePage('index.php', '<i class="fa fa-database"></i>所有景点</a>');
        outputCurrentActivePage('population.php', '<i class="fa fa-database"></i>年度人数分布统计</a>');
        outputCurrentActivePage('history.php', '<i class="fa fa-book"></i>历史记录管理</a>');
        outputCurrentActivePage('collection.php', '<i class="fa fa-user"></i>收藏管理</a>');

        function outputCurrentActivePage($page_name, $contents)
        {
            if ($_SERVER['SCRIPT_NAME'] == "/$page_name") {
                echo '<li class="active">';
            } else {
                echo '<li>';
            }
            echo "<a class='p-4' href=$page_name>" . $contents . "</li>";
        }
        ?>
        <li><a class="p-4" href="login_page.php"> <i class="fa fa-sign-in"></i>登陆页面</a></li>
    </ul>
</nav>
