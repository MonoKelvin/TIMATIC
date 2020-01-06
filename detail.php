<?php
require_once(__DIR__ . '\api\attraction_api.php');
// refreshOnce();

global $attraction;
if (isset($_GET['id']) && $_GET['id'] > 0) {
    $attraction = getAttractionAllInfoById($_GET['id']);
}

isEntry404(!$attraction || count($attraction) < 2);

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>图书<?php echo $attraction['id']; ?></title>
    <?php include_once(__DIR__ . '/html/included_head.php'); ?>
    <link rel="stylesheet" href="vendor/jquery/jquery.chocolat.css">
</head>

<body>
    <div class="page">
        <?php include_once(__DIR__ . '/html/header_navbar.php'); ?>
        <div class="page-content d-flex align-items-stretch">
            <?php include_once('html/side_navbar.php'); ?>
            <div class="content-inner">
                <div class="breadcrumb-holder container-fluid">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href=<?php $page = @$_GET['page'] ? $_GET['page'] : 1;
                                                            echo "'/index.php?page={$page}'"; ?>>主页</a></li>
                        <li class="breadcrumb-item active"><?php echo $attraction['name']; ?></li>
                    </ul>
                </div>

                <section>
                    <!-- 主要信息 -->
                    <div class="container-fluid d-flex flex-row">
                        <div class="card card-primary col-lg-12 no-padding">
                            <div class="card-body d-flex align-items-start pt-4">
                                <!-- 景点照片 -->
                                <div class="col-5 d-flex align-items-start flex-column">
                                    <img src=<?php echo "{$attraction['image']}"; ?> alt="void" class="img-fluid">
                                    <a href="#picture-gallery" class="text-right mt-2">查看更多图片>></a>
                                </div>
                                <!-- 基本信息 -->
                                <div class="col-7">
                                    <div class="container-fluid d-flex flex-column">
                                        <h1 class="large-title"><?php echo $attraction['name']; ?></h1>
                                        <div class="line"></div>
                                        <div>
                                            <div class="row">
                                                <div class="col-2"><strong>景点地址</strong></div>
                                                <div class="col-10"><?php echo $attraction['address'] ?></div>
                                            </div>
                                            <div class="line"></div>
                                            <div class="row">
                                                <div class="col-2"><strong>开放时间</strong></div>
                                                <div class="col-10"><?php echo $attraction['open_time'] ?></div>
                                            </div>
                                            <div class="line"></div>
                                            <div class="row">
                                                <div class="col-2"><strong>游客评分</strong></div>
                                                <div class="col-10 d-flex align-items-end">
                                                    <h1 class="text-red no-margin"><?php echo $attraction['mark']; ?></h1>
                                                    <span>&nbsp;/5.0分</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-12 col-12">
                                <div class="card card-primary">
                                    <!-- <div class="card-header">
                                            <h3>景点详细信息</h3>
                                        </div> -->
                                    <div class="card-body m-1">

                                        <!-- 游玩门票 -->
                                        <div class="column">
                                            <h3 class="text-left text-primary mb-3">游玩门票</h3>
                                            <div class="table-responsive ml-3 mr-3">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-left">名称</th>
                                                            <th class="text-left">价格</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php createPlayCostTableBody($attraction['play_cost']); ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="line"></div>

                                        <!-- 景点介绍 -->
                                        <div class="column">
                                            <h3 class="text-left text-primary mb-3">景点介绍</h3>
                                            <div class="d-flex flex-column ml-3 mr-3">
                                                <div>
                                                    <div class="badge badge-rounded badge-warning mr-3">特色</div>
                                                    <p class=" d-inline-block"><?php echo $attraction['feature']; ?></p>
                                                </div>
                                                <p rows="6"><?php echo $attraction['summary']; ?></p>
                                            </div>
                                        </div>
                                        <div class="line"></div>

                                        <!-- 更多图片-图片画廊 -->
                                        <div class="column">
                                            <h3 id="picture-gallery" class="text-left text-primary mb-3">更多图片</h3>
                                            <div class="gallery ml-3 mr-3">
                                                <?php createPictureGallery($attraction['images']); ?>
                                            </div>
                                        </div>
                                        <div class="line"></div>

                                        <!-- 交通信息 -->
                                        <div class="column">
                                            <h3 class="text-left text-primary mb-3">交通指南</h3>
                                            <div class="d-flex flex-column ml-3 mr-3">
                                                <?php echo $attraction['traffic']; ?>
                                            </div>
                                        </div>
                                        <div class="line"></div>

                                        <!-- 其他补充信息 -->
                                        <div class="column">
                                            <h3 class="text-left text-primary mb-3">其他信息</h3>
                                            <div class="d-flex flex-column ml-3 mr-3">
                                                <?php echo $attraction['more_info']; ?>
                                            </div>
                                        </div>
                                        <div class="line"></div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <!-- JavaScript files-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="vendor/jquery.cookie/jquery.cookie.js"> </script>
    <script src="vendor/jquery/jquery.chocolat.min.js"></script>
    <script src="js/front.js"></script>
    <script>
        $(function() {
            // Gallery
            $(".gallery .gallery-item").each(function() {
                var me = $(this);

                me.attr('href', me.data('image'));
                me.attr('title', me.data('title'));
                if (me.parent().hasClass('gallery-fw')) {
                    me.css({
                        height: me.parent().data('item-height'),
                    });
                    me.find('div').css({
                        lineHeight: me.parent().data('item-height') + 'px'
                    });
                }
                me.css({
                    backgroundImage: 'url("' + me.data('image') + '")'
                });
            });
            if (jQuery().Chocolat) {
                $(".gallery").Chocolat({
                    className: 'gallery',
                    imageSelector: '.gallery-item',
                });
            }

            // Chocolat
            if ($('.chocolat-parent').length && jQuery().Chocolat) {
                $('.chocolat-parent').Chocolat();
            }

        });
    </script>
</body>

</html>
