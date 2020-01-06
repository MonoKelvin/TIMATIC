function createAttractionCards(page, key) {
    // 获取数据
    $.ajax({
        url: '/../../api/attraction_pagination.php',
        type: 'get',
        data: {
            page: page,
            key: key
        },
        dataType: 'json',
        error: function() {
            alert('请求错误');
        },
        success: function(result) {
            if (result.code == 200) {
                $('#att-card-container').html(result.data.data);
                item_per_page = result.data.item_pre_page;
                var pages = Math.ceil(result.data.attraction_num / item_per_page);
                var options = {
                    bootstrapMajorVersion: 3,
                    currentPage: page,
                    numberOfPages: pages > 10 ? 10 : pages,
                    totalPages: pages,
                    itemTexts: function(type, page, current) {
                        switch (type) {
                            case 'first':
                                return '首页';
                            case 'prev':
                                return '<';
                            case 'next':
                                return '>';
                            case 'last':
                                return '末页';
                            case 'page':
                                return page;
                        }
                    },
                    onPageClicked: function(event, originalEvent, type, page) {
                        currentPage = page;
                        createAttractionCards(page, key);
                    }
                };
                $('#att-pagination1').bootstrapPaginator(options);
                $('#att-pagination2').bootstrapPaginator(options);
            } else {
                alert('请求失败，错误码：' + result.code);
            }
        }
    });
}

function createHistoryCards(page, key) {
    // 获取数据
    $.ajax({
        url: '/../../api/history.php',
        type: 'get',
        data: {
            page: page,
            key: key
        },
        dataType: 'json',
        error: function() {
            alert('请求错误');
        },
        success: function(result) {
            if (result.code == 200) {
                $('#att-card-container').html(result.data.data);
                item_per_page = result.data.item_pre_page;
                var pages = Math.ceil(result.data.attraction_num / item_per_page);
                var options = {
                    bootstrapMajorVersion: 3,
                    currentPage: page,
                    numberOfPages: pages > 10 ? 10 : pages,
                    totalPages: pages,
                    itemTexts: function(type, page, current) {
                        switch (type) {
                            case 'first':
                                return '首页';
                            case 'prev':
                                return '<';
                            case 'next':
                                return '>';
                            case 'last':
                                return '末页';
                            case 'page':
                                return page;
                        }
                    },
                    onPageClicked: function(event, originalEvent, type, page) {
                        currentPage = page;
                        createAttractionCards(page, key);
                    }
                };
                $('#att-pagination1').bootstrapPaginator(options);
                $('#att-pagination2').bootstrapPaginator(options);
            } else {
                alert('请求失败，错误码：' + result.code);
            }
        }
    });
}

function createPopulationCards(page, key) {
    // 获取数据
    $.ajax({
        url: '/../../api/population.php',
        type: 'get',
        data: {
            page: page,
            key: key
        },
        dataType: 'json',
        error: function() {
            alert('请求错误');
        },
        success: function(result) {
            if (result.code == 200) {
                $('#population-card-container').html(result.data.data);
                item_per_page = result.data.item_pre_page;
                var pages = Math.ceil(result.data.attraction_num / item_per_page);
                var options = {
                    bootstrapMajorVersion: 3,
                    currentPage: page,
                    numberOfPages: pages > 10 ? 10 : pages,
                    totalPages: pages,
                    itemTexts: function(type, page, current) {
                        switch (type) {
                            case 'first':
                                return '首页';
                            case 'prev':
                                return '<';
                            case 'next':
                                return '>';
                            case 'last':
                                return '末页';
                            case 'page':
                                return page;
                        }
                    },
                    onPageClicked: function(event, originalEvent, type, page) {
                        currentPage = page;
                        createAttractionCards(page, key);
                    }
                };
                $('#pop-pagination1').bootstrapPaginator(options);
                $('#pop-pagination2').bootstrapPaginator(options);
            } else {
                alert('请求失败，错误码：' + result.code);
            }
        }
    });
}