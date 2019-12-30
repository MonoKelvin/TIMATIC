$.ajax({
    url: "../../api/statistics.php",
    type: "get",
    dataType: "json",
    error: function() {
        alert("请求错误");
    },
    success: function(result) {
        if (result.code == 200) {
            // $.each(result.data, function(key, value) {
            // });
            online_num = parseInt(result.data["online_num"]);
            users_num = parseInt(result.data["users_num"]);
            rm_num = parseInt(result.data["remaining_num"]);
            lent_num = parseInt(result.data["lent_num"]);

            online_ratio = online_num / users_num * 100;
            rm_ratio = rm_num / (rm_num + lent_num) * 100;
            lent_ratio = lent_num / (rm_num + lent_num) * 100;

            document.getElementById('users_number').innerHTML = users_num;
            document.getElementById('online_progress').style.width = online_ratio + "%";
            document.getElementById('online_number').innerHTML = online_num;
            document.getElementById('remaining_progress').style.width = rm_ratio + "%";
            document.getElementById('remaining_number').innerHTML = rm_num;
            document.getElementById('lent_progress').style.width = lent_ratio + "%";
            document.getElementById('lent_number').innerHTML = lent_num;

        } else {
            alert("请求失败，错误码：" + result.code);
        }
    }
});
