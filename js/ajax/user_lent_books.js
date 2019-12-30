document.write('<script src="js/utility.js"></script>');

function createUserLentBookItems(id) {
    $.ajax({
        url: '../../api/user_lent_books.php?id=' + id,
        type: 'get',
        dataType: 'json',
        error: function() {
            alert('请求错误');
        },
        success: function(result) {
            if (result.code == 200) {
                var html = '';
                $.each(result.data, function(key, value) {
                    html += '<tr>';
                    html += '<td class="text-center">' + value.b_id + '</td>';
                    html += '<td class="text-center">' + value.title + '</td>';
                    html += '<td class="text-center">' + value.author + '</td>';

                    var lent_time = new Date(value.lent_time);
                    html += '<td class="text-center">' + dateFormat('yyyy-MM-dd hh:mm:ss', lent_time) + '</td>';
                    lent_time.setTime(lent_time.getTime() + 1000 * 60 * 60 * 24 * 30); // 默认还书期限为30天
                    html += '<td class="text-center">' + dateFormat('yyyy-MM-dd hh:mm:ss', lent_time) + '</td>';

                    html +=
                        '<td class="container-fluid d-flex pt-2"><div class="flex-fill text-center"><form action="book_info_page.php" method="get"><button type="submit" name="id" value="';
                    html +=
                        value.b_id +
                        '" class="btn btn-primary"><i class="fa fa-share"></i></button></form></div><div class="flex-fill text-center"><button type="button" data-toggle="modal" data-target="#returnBookAlert';
                    html +=
                        id +
                        '" class="btn btn-danger"><i class="fa fa-reply-all"></i></button><div id="returnBookAlert';
                    html +=
                        id +
                        '" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade text-left"><div role="document" class="modal-dialog"><div class="modal-content"><div class="modal-header">';
                    html +=
                        '<h4 class="modal-title">提示</h4><button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button></div>';
                    html +=
                        '<form action="../../api/user_return_book.php" method="post"><div class="modal-body"><p>归还';
                    html +=
                        '书：<strong>《' +
                        value.title +
                        '》</strong></p><p class="text-red">一旦确定就无法撤销，你要继续吗？</p>';
                    html +=
                        '<input name="password" type="password" class="form-control" placeholder="输入管理员密码"><input name="u_id" value="';
                    html +=
                        id +
                        '" type="text" class="hidden-form-control"><input name="b_id" value="' +
                        value.b_id +
                        '" type="text" class="hidden-form-control"></div>';
                    html +=
                        '<div class="modal-footer"><button type="button" data-dismiss="modal" class="btn btn-secondary">取消</button><button type="submit" name="submit" value="submit" class="btn btn-primary">确定</button>';
                    html += '</div></form></div></div></div></div></td>';
                });
                $('#user-lent-books-table').html(html);
            } else {
                alert('请求失败，错误码：' + result.code);
            }
        }
    });
}

function createUserLentItemsForBook(book_id) {
    $.ajax({
        url: '../../api/user_lent_books.php?book_id=' + book_id,
        type: 'get',
        dataType: 'json',
        error: function() {
            alert('请求错误');
        },
        success: function(result) {
            if (result.code == 200) {
                var html = '';
                $.each(result.data, function(key, value) {
                    html += '<tr>';
                    html += '<td class="text-center">' + value.u_id + '</td>';
                    html += '<td class="text-center">' + value.name + '</td>';

                    var lent_time = new Date(value.lent_time);
                    html += '<td class="text-center">' + dateFormat('yyyy-MM-dd hh:mm:ss', lent_time) + '</td>';

                    html += '<td class="container-fluid d-flex pt-2"><div class="flex-fill text-center">';
                    html += '<form action="user_info_page.php" method="GET">';
                    html += '<button type="submit" name="id" value="' + value.u_id;
                    html += '" class="btn btn-primary"><i class="fa fa-share"></i></button>';
                    html += '</form></div></td></tr>';
                });
                $('#users-lent-the-book-table').html(html);
            } else {
                alert('请求失败，错误码：' + result.code);
            }
        }
    });
}
