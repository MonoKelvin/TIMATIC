$('#datetimepicker').datetimepicker({
    language: 'zh-CN',
    format: 'yyyy-mm-dd',
    autoclose: true,
    endDate: new Date(),
    startView: 3,
    minView: 2,
    todayBtn: true,
    todayHighlight: true
});

$('#datetimepicker2').datetimepicker({
    language: 'zh-CN',
    format: 'yyyy-mm-dd',
    autoclose: true,
    endDate: new Date(),
    startView: 3,
    minView: 2,
    todayBtn: true,
    todayHighlight: true
});

// 防止input回车键自动提交表单
document.onkeydown = function(event) {
    var target, code, tag;
    if (!event) {
        event = window.event; //针对ie浏览器
        target = event.srcElement;
        code = event.keyCode;
        if (code == 13) {
            tag = target.tagName;
            if (tag == 'TEXTAREA') {
                return true;
            } else {
                return false;
            }
        }
    } else {
        target = event.target; //针对遵循w3c标准的浏览器，如Firefox
        code = event.keyCode;
        if (code == 13) {
            tag = target.tagName;
            if (tag == 'INPUT') {
                return false;
            } else {
                return true;
            }
        }
    }
};

Array.prototype.remove = function(val) {
    var index = this.indexOf(val);
    if (index > -1) {
        this.splice(index, 1);
    }
};

function addTag() {
    let tag = $('#input-add-tag')
        .val()
        .toString();
    tag = tag.replace(',', ' ');
    if (tag && tag.split(' ').join('').length > 0) {
        // 如果标签不存在，就添加新的
        if (tags.indexOf(tag) == -1) {
            tags.push(tag);

            let domStr = '<span class="label label-info m-1">' + tag;
            domStr += '<a onclick="deleteTag(this);" class="text-white pl-2" style="cursor:pointer">';
            domStr += '<i class="fa fa-trash"></i></a></span>';

            var tmpDiv = document.createElement('div');
            tmpDiv.innerHTML = domStr;
            document.getElementById('add-tag-container').appendChild(tmpDiv.childNodes[0]);

            $('#input-add-tag').val('');
        } else {
            alert('标签已经存在！');
            $('#input-add-tag').val('');
            return;
        }
    }
}

function deleteTag(obj) {
    var parent = obj.parentNode.parentNode;
    parent.removeChild(obj.parentNode);
    tags.remove(obj.parentNode.innerText);
}

function changeBookImage(obj) {
    var file = obj.files && obj.files.length > 0 ? obj.files[0] : null;

    if (!file) {
        return;
    }
    if (file.size >= 1 * 1024 * 1024) {
        alert('文件不允许大于1M');
        return;
    }
    if (file.type !== 'image/png' && file.type !== 'image/jpg' && file.type !== 'image/jpeg') {
        alert('文件格式必须为：png/jpg/jpeg');
        return;
    }

    var reader = new FileReader();
    reader.onload = function(e) {
        var data = e.target.result;
        $('#book-image').attr('src', data);
    };
    reader.readAsDataURL(file);
    return;
}
