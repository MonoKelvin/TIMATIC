<?PHP
require_once('api/utility.php');
// isLogedIn();
refreshOnce();

global $page;
if ($page = @$_GET['page']) {
    if ($page < 1) {
        isEntry404(true);
    }
} else {
    $page = 1;
}

global $key;
$key = @$_GET['key'];

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>旅游信息查询系统</title>
    <?php include_once('html/included_head.php'); ?>
</head>

<body onload="createAttractionCards(<?php echo $page . ",'$key'"; ?>);">
    <div class="page">
        <?php include_once('html/header_navbar.php'); ?>
        <div class="page-content d-flex align-items-stretch">
            <?php include_once('html/side_navbar.php'); ?>
            <div class="content-inner">
                <!-- Page Header-->
                <header class="page-header">
                    <div class="container-fluid">
                        <h2 class="no-margin-bottom">主页</h2>
                    </div>
                </header>

                <!-- 搜索栏 -->
                <section class="d-flex flex-column align-items-center">
                    <h2 class="mb-3">搜索景点信息</h2>
                    <div class="col-8">
                        <form action="" method="get">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <button type="submit" class="btn btn-primary" style="padding-left:50px; padding-right:50px;">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                    <input name="key" type="text" placeholder="输入景点关键字" class="form-control search-control">
                                </div>
                            </div>
                        </form>
                    </div>
                </section>

                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <ul id="att-pagination1" class="pagination">
                        </ul>
                    </div>
                </div>

                <!-- 景点卡片信息展示 -->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 m-b-30">
                            <div id="att-card-container" class="row">

                            </div>
                        </div>
                    </div>
                </div>

                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <ul id="att-pagination2" class="pagination">
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- JavaScript files-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="vendor/jquery.cookie/jquery.cookie.js"> </script>
    <script src="vendor/bootstrap/js/bootstrap-paginator.js"></script>
    <script src="js/front.js"></script>

    <!-- Ajax请求景点数据，并生成html卡片展示 -->
    <script>
        function createAttractionCards(page, key) {
            // 获取数据
            $.ajax({
                url: './api/attraction_pagination.php',
                type: 'get',
                data: {
                    page: page,
                    key: key
                },
                dataType: 'json',
                error: function() {
                    alert('请求错误');
                },
                success: function(result) {
                    if (result.code == 200) {
                        $('#att-card-container').html(result.data.data);
                        item_per_page = result.data.item_pre_page;
                        var pages = Math.ceil(result.data.attraction_num / item_per_page);
                        var options = {
                            bootstrapMajorVersion: 3,
                            currentPage: page,
                            numberOfPages: pages > 10 ? 10 : pages,
                            totalPages: pages,
                            itemTexts: function(type, page, current) {
                                switch (type) {
                                    case 'first':
                                        return '首页';
                                    case 'prev':
                                        return '<';
                                    case 'next':
                                        return '>';
                                    case 'last':
                                        return '末页';
                                    case 'page':
                                        return page;
                                }
                            },
                            onPageClicked: function(event, originalEvent, type, page) {
                                currentPage = page;
                                createAttractionCards(page, key);
                            }
                        };
                        $('#att-pagination1').bootstrapPaginator(options);
                        $('#att-pagination2').bootstrapPaginator(options);
                    } else {
                        alert('请求失败，错误码：' + result.code);
                    }
                }
            });
        }
    </script>
</body>

</html>
