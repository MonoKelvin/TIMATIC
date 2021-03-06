<?php
require_once(dirname(__FILE__) . '\attraction_api.php');

refreshCheck();

if (isset($_GET['page'])) {
    if ($_GET['page'] > 0) {
        getPopulationCards($_GET['page'], @$_GET['key']);
    } else {
        isEntry404(true);
    }
} else {
    getPopulationCards(1);
}

function getPopulationCards($page = 1, $key = null)
{
    $fetch_num = 20;
    $attractions_arr = getPopulationForCard($page * $fetch_num - $fetch_num, $fetch_num, $key);

    // 转换为int类型
    $attraction_num = 0 + $attractions_arr['count'];

    // 1.释放内存 2.防止foreach循环中操作该属性（因为该属性只是获取计数）
    unset($attractions_arr['count']);

    $resultStr = '';
    foreach ($attractions_arr as $attraction) {
        $htmlStr = '';
        $id = $attraction['id'];
        $name = $attraction['name'];
        $image = $attraction['image'];
        $population = formatBigNumber($attraction['population']);
        $max_per_day = formatBigNumber($attraction['max_per_day']);
        $year = $attraction['year'];
        $summary = mb_strcut($attraction['summary'], 0, 250);

        // 如果没有图片则使用默认图片
        if (!isValidString($image)) {
            $image = 'http://timatic.com/attraction/images/default_empty.jpg';
        }

        // 使用模板
        $temp_file = dirname(__FILE__) . '\..\html\template\population_card.html';
        $fp = fopen($temp_file, 'r');
        $htmlStr = fread($fp, filesize($temp_file));
        fclose($fp);

        // 替换内容，即动态生成 html的内容
        $htmlStr = str_replace('{id}', $id, $htmlStr);
        $htmlStr = str_replace('{name}', $name, $htmlStr);
        $htmlStr = str_replace('{image}', $image, $htmlStr);
        $htmlStr = str_replace('{summary}', $summary, $htmlStr);
        $htmlStr = str_replace('{population}', $population, $htmlStr);
        $htmlStr = str_replace('{max_per_day}', $max_per_day, $htmlStr);
        $htmlStr = str_replace('{year}', $year, $htmlStr);

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
