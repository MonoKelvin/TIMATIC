<?php
require_once(dirname(__FILE__) . '\utility.php');
getAttractionInfoForCard();

/**
 * 为首页展示景点卡片而获取的基本信息
 * @param int $number 要一次拿出几个数据
 * @param int $first 从结果中的第几个位置拿，对分页展示有效
 * @param string $key 根据关键字查找
 * @return int 从数据库中取出的数据，取出来的数据 <= $number
 */
function getAttractionInfoForCard($first = 0, $number = 50, $key = null)
{
    $db = MySqlAPI::getInstance();
    $res = [];

    if (!isValidString($key)) {
        $key = null;
    }

    if ($key != null) {
        $res = $db->getAll(
            "select SQL_CALC_FOUND_ROWS id,name,image,mark,ticket,summary
            from attraction where name like '%$key%'
            limit $first, $number"
        );
    } else {
        $res = $db->getAll(
            "select SQL_CALC_FOUND_ROWS id,name,image,mark,ticket,summary
            from attraction limit $first, $number"
        );
    }

    $res['count'] = $db->getRow("select found_rows() num")['num'];

    $db->close();

    return $res;
}

/**
 * 为历史景点卡片而获取的基本信息
 * @param int $id 用户id
 * @param int $number 要一次拿出几个数据
 * @param int $first 从结果中的第几个位置拿，对分页展示有效
 * @param string $key 根据关键字查找
 * @return int 从数据库中取出的数据，取出来的数据 <= $number
 */
function getHistoryInfoForCard($id, $first = 0, $number = 50, $key = null)
{
    $db = MySqlAPI::getInstance();
    $res = [];

    if (!isValidString($key)) {
        $key = null;
    }

    if ($key != null) {
        $res = $db->getAll(
            "select SQL_CALC_FOUND_ROWS * from user_history_card where u_id='$id' and name like '%$key%' limit $first, $number"
        );
    } else {
        $res = $db->getAll(
            "select SQL_CALC_FOUND_ROWS * from user_history_card where u_id='$id' limit $first, $number"
        );
    }

    $res['count'] = $db->getRow("select found_rows() num")['num'];

    $db->close();
    
    return $res;
}

/**
 * 为年度人数分布卡片而获取的基本信息
 * @param int $number 要一次拿出几个数据
 * @param int $first 从结果中的第几个位置拿，对分页展示有效
 * @param string $key 根据关键字查找
 * @return int 从数据库中取出的数据，取出来的数据 <= $number
 */
function getPopulationForCard($first = 0, $number = 50, $key = null)
{
    $db = MySqlAPI::getInstance();
    $res = [];

    if (!isValidString($key)) {
        $key = null;
    }

    if ($key != null) {
        $res = $db->getAll(
            "select SQL_CALC_FOUND_ROWS * from population_cards where name like '%$key%' limit $first, $number"
        );
    } else {
        $res = $db->getAll(
            "select SQL_CALC_FOUND_ROWS * from population_cards limit $first, $number"
        );
    }

    $res['count'] = $db->getRow("select found_rows() num")['num'];

    $db->close();

    return $res;
}

/** 获得景点的所有信息
 * @param int $id 要获得景点的id
 * @return array 返回数据数组，其中只有play_cost为数组，其他都为字符串（如果不为null）
 * @note 返回中images用逗号分隔，所以解析时使用：
 * ```
 *  explode(',', $data['images']);
 * ```
 * 得到数组使用
 */
function getAttractionAllInfoById($id)
{
    $db = MySqlAPI::getInstance();

    $res = $db->getRow('select * from att_all_info where id=' . $id);
    $res['play_cost'] = $db->getAll('select ticket_name,price from playcost where id=' . $id);

    $db->close();

    isEntry404(($res === null));

    return $res;
}

/** 创建景点游玩表项内容
 * @param array $play_cost 传入的书表项array数据
 */
function createPlayCostTableBody($play_cost)
{
    $html = '';
    foreach ($play_cost as $item) {
        $html .= '<tr><td class="text-left">' . $item['ticket_name'] . '</td><td class="text-left"><h2 class="text-red">￥' . $item['price'] . '<small class="text-muted small">&nbsp;起</small></h2></td></tr>';
    }

    echo $html;
}

/** 创建图片画廊
 * @param array $imgs 传入的图片地址字符串，每个地址用`','`隔开
 */
function createPictureGallery($imgs)
{
    if (!isValidString($imgs)) {
        echo '<div class="gallery-item gallery-more" data-image="http://timatic.com/attraction/images/default_empty.jpg" href="http://timatic.com/attraction/images/default_empty.jpg" style="background-image: url(&quot;http://timatic.com/attraction/images/default_empty.jpg&quot;);"><div>+0</div></div>';
        return;
    }

    // 分割字符串
    $imgs = explode(',', $imgs);

    $html = '';
    foreach ($imgs as $img) {
        $html .= '<div class="gallery-item" data-image="' . $img . '" href="' . $img . '" style="background-image: url(&quot;' . $img . '&quot;);"></div>';
    }

    echo $html;
}

/**
 * 获得所有景点的数量
 * @return int 返回书库里书的数量
 */
function getAttractionsNumber()
{
    $db = MySqlAPI::getInstance();

    $res = $db->getRow("select COUNT(id) from attraction")['COUNT(id)'];

    $db->close();

    return $res;
}
