<?php
require_once(dirname(__FILE__) . '\mysql_api.php');

/**
 * Ajax应答请求
 * @param int $code 状态码
 * @param string $message 相关信息
 * @param array $res 应答返回json的数据
 */
function reply($code = 404, $message = 'error', $res = [])
{
    $res = array('code' => $code, 'message' => $message, 'data' => $res);
    echo json_encode($res);
}

/**
 * 提供一次刷新机会的函数
 * @see function refreshCheck()
 */
function refreshOnce()
{
    if (!session_id()) {
        session_start();
    }
    $_SESSION['refresh_code'] = random_int(0, 10000);
}

/**
 * 刷新检测函数，用于检测是否多次刷新页面
 * @see function refreshOnce()
 */
function refreshCheck()
{
    if (!session_id()) {
        session_start();
    }
    if (isset($_SESSION["refresh_code"])) {
        unset($_SESSION["refresh_code"]);
    } else {
        isEntry404(true);
    }
}

/**
 * 下载网络文件
 * @param string $file_url 网络文件的地址
 * @param string $save_to 要保存下载下来的文件的路径
 */
function downloadNetworkFile($file_url, $save_to)
{
    $content = file_get_contents($file_url);
    if (empty($content) || $content == false) {
        die('file_download_filed');
    }
    file_put_contents($save_to, $content);
}

/**
 * 是否要进入404页面
 * @param bool $condition 进入404页面的条件，为`true`则进入
 */
function isEntry404($condition = true)
{
    if ($condition) {
        require_once(dirname(__FILE__) . '\..\pages_error_404.html');
        header('HTTP/1.1 404 Not Found');
        header('Status: 404 Not Found');
        exit;
    }
}

/**
 * 判断用户（管理员）是否已经登录
 * @param bool $isLogin 是否是登陆页面的请求
 */
function isLogedIn($isLoginPage = false)
{
    session_start();
    // 如果没有登录信息
    if (isset($_SESSION['account']) && isset($_SESSION['id'])) {
        if ($isLoginPage == true) {
            echo '<script>alert("您已经登录过了！"); window.location="/../index.php";</script>';
        }
    } else {
        if ($isLoginPage == false) {
            header('location: http://timatic.com/login_page.php');
        } else if ($_SERVER['REQUEST_URI'] != '/login_page.php') {
            header('location: http://timatic.com/login_page.php');
        }
    }
}

/**
 * 判断是否为正整数
 * @param mix $value 输入的内容
 * @param bool $isVoid 是否可以为空，即空字符串或null
 * @param bool 如果是正整数返回true
 */
function isPositiveInteger($value, $isVoid = false)
{
    if ($isVoid == true && ($value == '' || $value == null)) {
        return true;
    }
    if (preg_match("/^[0-9][0-9]*$/", $value)) {
        return true;
    }
    return false;
}

/**
 * 判断是否为有效字符串
 * @summary 如果内容部不为空和null，且不全是空格则为有效字符串
 * @param string $str 输入的内容
 * @param bool 如果有效返回true
 */
function isValidString($str)
{
    if ($str == '' || $str == null) {
        return false;
    }
    if (str_replace(' ', '', $str) == '') {
        return false;
    }
    return true;
}

/**
 * 判断输入的字符串是否是合法日期
 * @param string $data 输入的字符串格式的日期
 * @param bool $isVoid 是否可以为空，即空字符串或null
 * @param bool 如果合法，返回true
 * ```php
 * checkdate("2008-");      // false
 * checkdate("a-b-c");      // false
 * checkdate("2009-2-29");  // false
 * checkdate("2009-03-31"); // false
 * checkdate("2008-01-10"); // true
 * checkdate("2008-2-29");  // true
 * ```
 */
function isValidDate($data, $isVoid = false)
{
    if ($isVoid == true && ($data == '' || $data == null)) {
        return true;
    }
    $date = strtotime($data);
    if ($data == (date("Y-m-d", $date)) || $data == (date("Y-m-j", $date)) || $data == (date("Y-n-d", $date)) || $data == (date("Y-n-j", $date))) {
        return true;
    } else {
        return false;
    }
}

/**********************************************************
 * 以下检验ISBN码的算法函数来源于 `露兜`
 * 其博客地址为：http://www.ludou.org/
 *
 * 使用方法举例：
 *      isISBN('9787507421781')    // 输出 true
 **********************************************************/

/**
 * 用于计算ISBN加权和
 * @param string $isbn : isbn码
 * @param int $len : isbn码长度
 */
function isbnSum($isbn, $len)
{
    $sum = 0;

    if ($len == 10) {
        for ($i = 0; $i < $len - 1; $i++) {
            $sum = $sum + (int) $isbn[$i] * ($len - $i);
        }
    } elseif ($len == 13) {
        for ($i = 0; $i < $len - 1; $i++) {
            if ($i % 2 == 0)
                $sum = $sum + (int) $isbn[$i];
            else
                $sum = $sum + (int) $isbn[$i] * 3;
        }
    }
    return $sum;
}

/**
 * 用于计算ISBN末位校验码
 * @param string $isbn : isbn码
 * @param int $len : isbn码长度，只能为10或13
 */
function isbnCompute($isbn, $len)
{

    if ($len == 10) {
        $digit = 11 - isbnSum($isbn, $len) % 11;

        if ($digit == 10) {
            $rc = 'X';
        } else if ($digit == 11) {
            $rc = '0';
        } else {
            $rc = (string) $digit;
        }
    } else if ($len == 13) {
        $digit = 10 - isbnSum($isbn, $len) % 10;

        if ($digit == 10) {
            $rc = '0';
        } else {
            $rc = (string) $digit;
        }
    }

    return $rc;
}

/**
 * 用于判断是否为ISBN号
 * @param string $isbn : isbn码，可以是10位或13位的
 * @return bool 返回是否为合法的ISBN码
 */
function isISBN($isbn)
{
    $len = strlen($isbn);

    if ($len != 10 && $len != 13) {
        return 0;
    }

    $rc = isbnCompute($isbn, $len);

    if ($isbn[$len - 1] != $rc) {
        return 0;
    } else {
        return 1;
    }
}
