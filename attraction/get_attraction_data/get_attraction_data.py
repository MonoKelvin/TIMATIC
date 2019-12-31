# -*- coding: utf-8 -*-
import re
import urllib.request
from urllib.parse import quote
import string

# import pymysql

config = {
    'host': '127.0.0.1',
    'port': 3306,  # MySQL默认端口
    'user': 'root',  # mysql默认用户名
    'password': 'root',
    'db': 'test',  # 数据库
    'charset': 'utf8',
}

course = {}

headers = ("User-Agent", "Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.26 Safari/537.36 Core/1.63.6726.400 QQBrowser/10.2.2265.400")

opener = urllib.request.build_opener()
opener.addheaders = [headers]
urllib.request.install_opener(opener)

province = "上海"


def getAttractionIds(provinceName):
    # 获取景点的id
    baseUrl = "https://piao.ctrip.com/dest/u-" + \
        quote(provinceName) + "/s-tickets/"

    pageData = urllib.request.urlopen(baseUrl).read().decode("utf-8", "ignore")

    # 提取包含景点id的字符串
    stringUrl = re.compile('{"id":[0-9]\d*,"name"', re.S).findall(pageData)

    # 获取景点ID数组
    attIdArray = []
    for attId in stringUrl:
        attId = attId[6:]
        attId = attId[0:-7]
        attIdArray.append(attId)

    return attIdArray

def getAttractionInfo(attId):
    baseUrl = "https://piao.ctrip.com/dest/t" + str(attId) + ".html"
    pageData = urllib.request.urlopen(baseUrl).read().decode("utf-8", "ignore")

    # 获取景点名字
    attName = re.compile('window.__INITIAL_STATE__ = (.*?)', re.S).findall(pageData)

    print(attName)

    return
    # 插库
    # for i in range(0, len(stringUrl)):
    #     db = pymysql.connect(**config)
    #     # 使用cursor()方法获取操作游标
    #     cursor = db.cursor()
    #     # print(stringUrl[i][1])
    #     sql = "insert into tb_scenic_spot(name) values('%s')" % stringUrl[i][1]
    #     #sql = "selsect id from tb_scenic_spot"
    #     # SQL 插入语句

    #     try:
    #         # 执行sql语句
    #         cursor.execute(sql)
    #         # 提交到数据库执行
    #         db.commit()
    #     except:
    #         # 如果发生错误则回滚
    #         db.rollback()

    #     # 关闭数据库连接


ids = getAttractionIds(province)
getAttractionInfo(ids[0])

