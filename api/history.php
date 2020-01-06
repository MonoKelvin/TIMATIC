<?php
require_once(dirname(__FILE__) . '\attraction_api.php');

refreshCheck();

if (isset($_GET['page'])) {
    if ($_GET['page'] > 0) {
        getAttractionCards($_GET['page'], @$_GET['key']);
    } else {
        isEntry404(true);
    }
} else {
    getAttractionCards(1);
}

function getAttractionCards($page = 1, $key = null)
{
    $fetch_num = 20;
    $attractions_arr = getHistoryInfoForCard($_SESSION['id'], $page * $fetch_num - $fetch_num, $fetch_num, $key);

    // 转换为int类型
    $attraction_num = 0 + $attractions_arr['count'];

    // 1.释放内存 2.防止foreach循环中操作该属性（因为该属性只是获取计数）
    unset($attractions_arr['count']);

    $resultStr = '';
    foreach ($attractions_arr as $attraction) {
        $htmlStr = '';
        $a_id = $attraction['a_id'];
        $name = $attraction['name'];
        $image = $attraction['image'];
        $time = $attraction['time'];
        $summary = mb_strcut($attraction['summary'], 0, 172);

        // 如果没有图片则使用默认图片
        if (!isValidString($image)) {
            $image = 'http://timatic.com/attraction/images/default_empty.jpg';
        }

        // 使用模板
        $temp_file = dirname(__FILE__) . '\..\html\template\user_history_card.html';
        $fp = fopen($temp_file, 'r');
        $htmlStr = fread($fp, filesize($temp_file));
        fclose($fp);

        // 替换内容，即动态生成 html的内容
        $htmlStr = str_replace('{id}', $a_id, $htmlStr);
        $htmlStr = str_replace('{name}', $name, $htmlStr);
        $htmlStr = str_replace('{image}', $image, $htmlStr);
        $htmlStr = str_replace('{summary}', $summary, $htmlStr);
        $htmlStr = str_replace('{time}', $time, $htmlStr);

        $resultStr .= $htmlStr;
    }

    $data = [
        'attraction_num' => $attraction_num,
        'item_pre_page' => $fetch_num,
        'data' => $resultStr,
    ];

    // 返回数据给ajax
    reply(200, 'success', $data);
}
