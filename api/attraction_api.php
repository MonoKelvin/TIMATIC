<?php
require_once(dirname(__FILE__) . '\utility.php');

/**
 * 为首页展示景点卡片而获取书的基本信息
 * @param int $number 要一次拿出几个数据
 * @param int $first 从结果中的第几个位置拿，对分页展示有效
 * @param string $key 根据关键字查找
 * @return int 从数据库中取出的书，取出来的数据 <= $number
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

/*
function storeBookFromDouBan($attraction_json)
{
    $json_obj = json_decode($attraction_json, true);
    isEntry404($json_obj == null || $json_obj == false);

    // 存储图书的图片
    $img_url = $json_obj['image'];
    $img_file_name = $json_obj['id'] . substr($img_url, strripos($img_url, '.'));
    $local_img_path = "http://timatic.com/attraction/images/$img_file_name";
    downloadNetworkFile($img_url, dirname(__FILE__) . "/../attractionstudy_api/attraction/image/$img_file_name");

    // 打开数据库
    $db = MySqlAPI::getInstance();

    // 基本信息的获取
    $author = implode(",", $json_obj['author']);
    $translator = implode(",", $json_obj['translator']);
    $data = [
        'id' => $json_obj['id'],
        'title' => addslashes($json_obj['title']),
        'author' => addslashes($author),
        'publisher' => addslashes($json_obj['publisher']),
        'pages' => $json_obj['pages'] ? $json_obj['pages'] : 0,
        'pubdate' => $json_obj['pubdate'],
        'rating' => $json_obj['rating']['average'],
        'image' => $local_img_path,
        'summary' => $json_obj['summary'],
        'translator' => addslashes($translator)
    ];
    $res = $db->insert('attractioninfo', $data);

    // 详细信息的获取
    $tags = '';
    foreach ($json_obj['tags'] as $val) {
        $tags .= $val['name'] . ',';
    }
    $tags = trim($tags, ',');
    $data = [
        'id' => $json_obj['id'],
        'isbn13' => $json_obj['isbn13'],
        'subtitle' => addslashes($json_obj['subtitle']),
        'origin_title' => addslashes($json_obj['origin_title']),
        'binding' => $json_obj['binding'],
        'tags' => addslashes($tags),
        'author_intro' => addslashes($json_obj['author_intro']),
        'catalog' => addslashes($json_obj['catalog'])
    ];
    $res = $db->insert('attractiondetail', $data);

    // 关闭数据库并返回插入后影响的ID号
    $db->close();
    return $res;
}
*/

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
