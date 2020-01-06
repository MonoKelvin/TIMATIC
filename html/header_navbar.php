<header class="header">
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-holder d-flex align-items-center justify-content-between">
                <div class="navbar-header">
                    <a id="toggle-btn" href="#" class="menu-btn active"><span></span><span></span><span></span></a>
                    <a href="index.php" class="navbar-brand d-none d-sm-inline-block">
                        <div class="brand-text d-none d-lg-inline-block">TIMATIC <strong>旅游信息查询系统</strong></div>
                    </a>
                </div>
                <ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center">
                    <li class="nav-item">
                        <a data-toggle="modal" data-target="#logoutAlert" href="api/logout.php" class="nav-link logout">
                            <span class="d-none d-sm-inline">Logout</span><i class="fa fa-sign-out"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div id="logoutAlert" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">退出提示</h3>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <p>你确定要退出当前管理员的登录状态吗？</p>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-secondary">取消</button>
                    <form action="api/logout.php">
                        <button type="submit" class="btn btn-primary">确定</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
