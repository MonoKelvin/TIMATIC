<?php
require_once(dirname(__FILE__) . '../api/attraction_api.php');
// isLogedIn();
refreshOnce();

global $attraction;
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $attraction = getBookInfoById($_GET['id']);
} else {
    isEntry404(true);
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>图书<?php echo $attraction['id']; ?></title>
    <?php include_once('html/included_head.php'); ?>
    <link rel="stylesheet" href="/vendor/bootstrap/css/bootstrap-datetimepicker.min.css">
</head>

<body onload="createUserLentItemsForBook(<?php echo $attraction['id']; ?>);">
    <div class="page">
        <?php include_once('html/header_navbar.php'); ?>
        <div class="page-content d-flex align-items-stretch">
            <?php include_once('html/side_navbar.php'); ?>
            <div class="content-inner">
                <header class="page-header">
                    <div class="container-fluid">
                        <h2 class="no-margin-bottom">用户管理</h2>
                    </div>
                </header>
                <div class="breadcrumb-holder container-fluid">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">主页</a></li>
                        <li class="breadcrumb-item"><a href=<?php $page = @$_GET['page'] ? $_GET['page'] : 1;
                                                            echo "'attraction_manager.php?page={$page}'"; ?>>图书管理</a></li>
                        <li class="breadcrumb-item active">图书<?php echo $attraction['id']; ?></li>
                    </ul>
                </div>

                <section class="forms">
                    <form id="attraction-form" action="api/attraction_update.php" class="form-horizontal" method="post" enctype="multipart/form-data">
                        <div class="container-fluid d-flex flex-row">
                            <div class="card  card-primary col-lg-12 no-padding">
                                <div class="card-header">
                                    <h3>基本信息</h3>
                                </div>
                                <div class="card-body d-flex align-items-center row">
                                    <div class="col-lg-4 d-flex justify-content-center pb-3 flex-column">
                                        <img id="attraction-image" src=<?php echo "{$attraction['image']}"; ?> alt="void" class="img-fluid">
                                        <input id="tmp-file-input" name="image" onchange="changeBookImage(this)" type="file" class="hidden-form-control">
                                        <button type="button" class="btn btn-primary mt-3" onclick="$('#tmp-file-input').click();">更换封面</button>
                                        <small class="help-block-none mt-2">请选择不大于1M的png、jpg或jpeg格式的图片文件</small>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="container-fluid">
                                            <div class="form-group row">
                                                <label class="col-lg-3 form-control-label">ID</label>
                                                <div class="col-lg-9">
                                                    <input name="id" type="text" readonly value=<?php echo "'{$attraction['id']}'"; ?> class="form-control">
                                                    <small class="help-block-none">书籍的ID编号不可更改.</small>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 form-control-label">ISBN13<strong class="required-label-star">*</strong></label>
                                                <div class="col-lg-9">
                                                    <input name="isbn13" type="text" value=<?php echo "'{$attraction['isbn13']}'"; ?> class="form-control" onkeyup="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}" onafterpaste="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}">
                                                    <small class="help-block-none">书籍的ISBN13分类号尽量不要更改！</small>
                                                </div>
                                            </div>
                                            <div class="line"></div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 form-control-label">书名<strong class="required-label-star">*</strong></label>
                                                <div class="col-lg-9">
                                                    <input name="title" maxlength="100" type="text" class="form-control" value=<?php echo "'{$attraction['title']}'"; ?>>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 form-control-label">副标题</label>
                                                <div class="col-lg-9">
                                                    <input name="subtitle" maxlength="100" type="text" class="form-control" value=<?php echo "'{$attraction['subtitle']}'"; ?>>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 form-control-label">原标题</label>
                                                <div class="col-lg-9">
                                                    <input name="origin_title" maxlength="100" type="text" class="form-control" value=<?php echo "'{$attraction['origin_title']}'"; ?>>
                                                </div>
                                            </div>
                                            <div class="line"></div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 form-control-label">作者<strong class="required-label-star">*</strong></label>
                                                <div class="col-sm-9">
                                                    <input name="author" maxlength="100" type="text" class="form-control" value=<?php echo "'{$attraction['author']}'"; ?>>
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
                                        <div class="card-header">
                                            <h3>详细信息</h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group row">
                                                <label class="col-sm-3 form-control-label">摘要</label>
                                                <div class="col-sm-9">
                                                    <textarea name="summary" class="form-control" rows="6"><?php echo $attraction['summary']; ?></textarea>
                                                </div>
                                            </div>
                                            <div class="line"></div>

                                            <div class="form-group row">
                                                <label class="col-sm-3 form-control-label">作者简介</label>
                                                <div class="col-sm-9">
                                                    <textarea name="author_intro" class="form-control" rows="6"><?php echo $attraction['author_intro']; ?></textarea>
                                                </div>
                                            </div>
                                            <div class="line"></div>

                                            <div class="form-group row">
                                                <label class="col-sm-3 form-control-label">翻译</label>
                                                <div class="col-sm-9">
                                                    <input name="translator" maxlength="32" type="text" class="form-control" value=<?php echo "'{$attraction['translator']}'"; ?>>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-3 form-control-label">出版社</label>
                                                <div class="col-sm-9">
                                                    <input name="publisher" maxlength="32" type="text" class="form-control" value=<?php echo "'{$attraction['publisher']}'"; ?>>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-3 form-control-label">出版时间</label>
                                                <div class="col-sm-9">
                                                    <input name="pubdate" class="form-control" id="datetimepicker" type="text" value=<?php echo "'{$attraction['pubdate']}'"; ?>>
                                                </div>
                                            </div>
                                            <div class="line"></div>

                                            <div class="form-group row">
                                                <label class="col-sm-3 form-control-label">页数</label>
                                                <div class="col-sm-9">
                                                    <input name="pages" type="text" class="form-control" maxlength="10" value=<?php echo "'{$attraction['pages']}'"; ?> onkeyup="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}" onafterpaste="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-3 form-control-label">定价</label>
                                                <div class="col-sm-9">
                                                    <input name="price" type="text" class="form-control" maxlength="16" value=<?php echo "'{$attraction['price']}'"; ?> onkeyup="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}" onafterpaste="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}">
                                                    <small class="help-block-none">默认计价单位为‘元’</small>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-3 form-control-label">评分</label>
                                                <div class="col-sm-9">
                                                    <input type="text" disabled="" placeholder=<?php echo "'{$attraction['rating']}'"; ?> class="form-control">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-3 form-control-label">装帧形式</label>
                                                <div class="col-sm-9">
                                                    <select name="binding" class="form-control mb-3">
                                                        <option><?php echo $attraction['binding']; ?></option>
                                                        <option>平装</option>
                                                        <option>精装</option>
                                                        <option>线装</option>
                                                        <option>单行本</option>
                                                        <option>合订本</option>
                                                        <option>普及本</option>
                                                        <option>缩印本</option>
                                                        <option>袖珍本</option>
                                                        <option>特藏本</option>
                                                        <option>豪华本</option>
                                                        <option>简册装</option>
                                                        <option>卷轴装</option>
                                                        <option>经折装</option>
                                                        <option>旋风装</option>
                                                        <option>蝴蝶装</option>
                                                        <option>包背装</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-3 form-control-label">标签</label>
                                                <div class="col-sm-9">
                                                    <div id="add-tag-container" class="bootstrap-label">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend pb-2">
                                                                <button onclick="addTag();" type="button" class="btn btn-primary"> <i class="fa fa-plus"></i> </button>
                                                            </div>
                                                            <input id="input-add-tag" class="form-control">
                                                        </div>
                                                        <?php
                                                        $tags = explode(',', $attraction['tags']);
                                                        if ($attraction['tags']) {
                                                            foreach ($tags as $tag) {
                                                                echo "<span class='label label-info m-1'>$tag";
                                                                echo '<a onclick="deleteTag(this);" class="text-white pl-2" style="cursor:pointer">';
                                                                echo '<i class="fa fa-trash"></i></a></span>';
                                                            }
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="line"></div>

                                            <div class="form-group row">
                                                <label class="col-sm-3 form-control-label">目录章节</label>
                                                <div class="col-sm-9">
                                                    <?php
                                                    $nl_count = substr_count($attraction['catalog'], "\n") * 26;
                                                    $nl_count = $nl_count < 200 ? 200 : ($nl_count > 1000 ? 1000 : $nl_count);
                                                    echo '<textarea name="catalog" style="height:' . $nl_count . 'px;" class="form-control" rows="6">';
                                                    echo $attraction['catalog'];
                                                    echo '</textarea>';
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="line pt-5"></div>

                                            <div class="form-group row justify-content-end">
                                                <div class="col-sm-2 pb-2">
                                                    <button type="button" data-toggle="modal" data-target="#alterAlert" class="form-control btn btn-primary">保存修改</button>
                                                    <div id="alterAlert" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade text-left">
                                                        <div role="document" class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h3 class="modal-title">数据改动提示</h3>
                                                                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p>你确定要保存当前数据的修改吗？</p>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" data-dismiss="modal" class="btn btn-secondary">取消</button>
                                                                    <!-- <form action="api/attraction_update.php" method="post"> -->
                                                                    <button id="change-attraction-submit" type="submit" name="submit" value="submit" class="btn btn-primary">确定</button>
                                                                    <!-- </form> -->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2 pb-2">
                                                    <button type="button" onclick="window.location.reload();" class="form-control btn btn-secondary">还原</button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </section>

                <div class="container-fluid">
                    <div class="card card-primary">
                        <div class="card-header d-flex align-items-center">
                            <h3 class="h4">正借此书的用户</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="text-center">用户id</th>
                                            <th class="text-center">用户名</th>
                                            <th class="text-center">借书时间</th>
                                            <th class="text-center">转到</th>
                                        </tr>
                                    </thead>
                                    <tbody id="users-lent-the-attraction-table">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- JavaScript files-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/popper.js/umd/popper.min.js"> </script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="vendor/jquery.cookie/jquery.cookie.js"> </script>
    <script src="vendor/chart.js/Chart.min.js"></script>
    <script src="vendor/jquery-validation/jquery.validate.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap-datetimepicker.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap-datetimepicker.zh-CN.js"></script>
    <script src="js/charts-custom.js"></script>
    <!-- Main File-->
    <script src="js/front.js"></script>
    <!-- Ajax Request File -->
    <script src="js/ajax/user_lent_attractions.js"></script>
    <!-- DataTimePicker Plugin -->
    <script>
        <?php
        if ($attraction['tags'] != '') {
            $tmp = explode(',', $attraction['tags']);
            foreach ($tmp as $key => $val) {
                $tmp[$key] = '"' . $val . '"';
            }
            $tmp = implode(',', $tmp);
            echo "var tags = [$tmp];";
        } else {
            echo "var tags = [];";
        }
        ?>

        document.getElementById('change-attraction-submit').addEventListener('click', function() {
            var attractionForm = $('#attraction-form');
            var tmpTagsInput = $("<input type='text' name='tags' class='hidden-form-control'/>");
            tmpTagsInput.val(tags.join(','));
            attractionForm.append(tmpTagsInput);
            attractionForm.submit();
        });
    </script>
    <script src="js/attraction_form_relative.js"></script>
</body>

</html>
