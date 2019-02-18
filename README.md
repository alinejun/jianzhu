## 人员筛选条件

**url**: /people_condition/getcondition

**请求方式**：get



**请求参数：**


| 字段名 | 类型 | 说明 |
| ------ | ---- | ---- |
| 无     | 无   | 无   |

**返回参数：**

|      字段名      | 类型   | 说明                       |
| :--------------: | ------ | -------------------------- |
|       code       | int    | 错误码                     |
|       msg        | string | 消息                       |
|       data       | array  | 返回数据                   |
|        id        | int    | 类型                       |
| register_certnum | string | 证书编号                   |
|  register_type   | string | 证书类型                   |
|      _child      | array  | 该类型下包含的二级类型数据 |
| register_certnum | string | 证书编号                   |
|  register_type   | string | 证书类型                   |
|       pid        | string | 上级类型id                 |



**返回示例：**

```
{
    "code": 1,
    "msg": "成功",
    "data": [
        {
            "id": "1",
            "register_type": "注册建筑师",
            "_child": [
                {
                    "register_certnum": "121500249",
                    "register_type": "一级注册建筑师",
                    "pid": 1
                },
                {
                    "register_certnum": "2006100762",
                    "register_type": "二级注册建筑师",
                    "pid": 1
                }
            ]
        },
        {
            "id": "2",
            "register_type": "勘察设计注册工程师",
            "_child": [
                {
                    "register_certnum": "S174101880",
                    "register_type": "一级注册结构工程师",
                    "pid": 2
                },
                {
                    "register_certnum": "S2182100484",
                    "register_type": "二级注册结构工程师",
                    "pid": 2
                },
                {
                    "register_certnum": "AY183600374",
                    "register_type": "注册土木工程师（岩土）",
                    "pid": 2
                },
                {
                    "register_certnum": "CS103700019",
                    "register_type": "注册公用设备工程师（给水排水）",
                    "pid": 2
                },
                {
                    "register_certnum": "CD103700002",
                    "register_type": "注册公用设备工程师（动力）",
                    "pid": 2
                },
                {
                    "register_certnum": "DF173600132",
                    "register_type": "注册电气工程师（发输变电）",
                    "pid": 2
                },
                {
                    "register_certnum": "DG102100226",
                    "register_type": "注册电气工程师（供配电）",
                    "pid": 2
                },
                {
                    "register_certnum": "F103700037",
                    "register_type": "注册化工工程师",
                    "pid": 2
                }
            ]
        },
        {
            "id": "3",
            "register_type": "注册监理工程师"
        },
        {
            "id": "4",
            "register_type": "注册建造师",
            "_child": [
                {
                    "register_certnum": "00234634",
                    "register_type": "一级注册建造师",
                    "pid": 4
                },
                {
                    "register_certnum": "2155683",
                    "register_type": "二级注册建造师",
                    "pid": 4
                },
                {
                    "register_certnum": "00018382",
                    "register_type": "一级临时注册建造师",
                    "pid": 4
                },
                {
                    "register_certnum": "00110147",
                    "register_type": "二级临时注册建造师",
                    "pid": 4
                }
            ]
        },
        {
            "id": "5",
            "register_type": "注册造价工程师"
        }
    ],
    "exe_time": "0.000988"
}
```

## 根据注册类型获取专业

**url**: /people_condition/getMajor

**请求方式**：post



**请求参数：**

| 字段名        | 类型   | 说明         |
| ------------- | ------ | ------------ |
| register_type | string | 人员筛选条件 |

**返回参数：**

|     字段名     | 类型   | 说明     |
| :------------: | ------ | -------- |
|      code      | int    | 错误码   |
|      msg       | string | 消息     |
|      data      | array  | 返回数据 |
| register_major | string | 专业名称 |

**示例：**

```
{
    "code": 1,
    "msg": "成功",
    "data": [
        "公路工程",
        "化工石油工程",
        "土建",
        "安装",
        "市政公用工程",
        "建筑工程",
        "房屋建筑工程",
        "机电工程",
        "民航机场工程",
        "水利水电工程",
        "港口与航道工程",
        "电力工程",
        "矿业工程",
        "矿山工程",
        "航天航空工程",
        "铁路工程"
    ],
    "exe_time": "0.548566"
}
```

## 人员筛选

**url**: /people_condition/getCompanyByPeople

**请求方式**：post



**请求参数：**


| 字段名 | 类型 | 说明 |
| ------ | ---- | ---- |
| register_type   | string|多条件以逗号隔开，如：一级注册建造师，二级注册建造师|
| register_major   | string|多条件以逗号隔开，如：建筑工程，机电工程|
| pageSize   | int|每页返回条数|
| pageNum   | int|页码（从零开始）|

**返回参数：**

|      字段名      | 类型   | 说明                       |
| :--------------: | ------ | -------------------------- |
|       code       | int    | 错误码                     |
|       msg        | string | 消息                       |
|       company_list       | array  | 返回公司数据                   |
|        id        | int    | id                       |
| company_url | string | 公司链接                   |
|  company_name   | string | 公司名称                   |
|    company_creditnum    | string  | 统一社会信用代码 |
| company_legalreprst | string | 企业法人代表                   |
|  company_regtype   | string | 企业登记注册类型                   |
|       company_regadd        | string | 企业注册属地                 |
|       company_manageadd        | string | 企业经营地址                 |
|       create_time        | string | 记录时间                 |
|       is_end_quali        | string | 未知                |
|       company_count        | string | 符合条件的记录总数                 |

**返回示例：**

```
{
    "code": 1,
    "msg": "成功",
    "company_list": [
        [
            {
                "id": 232679,
                "company_url": "001607220057194462",
                "company_name": "苏州市新源建设工程有限公司",
                "company_creditnum": "91320594780268314T",
                "company_legalreprst": "蔡苏建",
                "company_regtype": "有限责任公司（自然人投资或控股）",
                "company_regadd": "江苏省",
                "company_manageadd": "江苏省苏州市苏州工业园区星海国际商务广场1幢808室",
                "create_time": "2019-01-22 09:31:21",
                "is_end_quali": 1
            }
        ],
        [
            {
                "id": 5899,
                "company_url": "001607220057194463",
                "company_name": "江苏强安工程建设有限公司",
                "company_creditnum": "91320583674907784J",
                "company_legalreprst": "李丽",
                "company_regtype": "有限责任公司（自然人独资）",
                "company_regadd": "江苏省",
                "company_manageadd": "江苏省苏州市昆山市开发区华敏世家花园6号楼27室",
                "create_time": "2019-01-21 16:46:58",
                "is_end_quali": 1
            }
        ],
        [
            {
                "id": 9553,
                "company_url": "001607220057194464",
                "company_name": "上海首正幕墙装饰工程有限公司",
                "company_creditnum": "91310117769414851X",
                "company_legalreprst": "李红云",
                "company_regtype": "有限责任公司（国内合资）",
                "company_regadd": "上海市",
                "company_manageadd": "新浜镇赵王一字路71号",
                "create_time": "2019-01-21 16:56:26",
                "is_end_quali": 1
            }
        ],
        [
            {
                "id": 232735,
                "company_url": "001607220057194465",
                "company_name": "江苏棵棵树装饰工程有限公司",
                "company_creditnum": "91321181595623636J",
                "company_legalreprst": "张冬青",
                "company_regtype": "有限责任公司",
                "company_regadd": "江苏省",
                "company_manageadd": "江苏省镇江市丹阳市司徒镇张寺村122省道北侧",
                "create_time": "2019-01-22 09:31:28",
                "is_end_quali": 1
            }
        ],
        [
            {
                "id": 9547,
                "company_url": "001607220057194468",
                "company_name": "浙江千秋装饰工程有限公司",
                "company_creditnum": "91330782677204726D",
                "company_legalreprst": "朱晓林",
                "company_regtype": "私营有限责任公司(自然人控股或私营性质企业控股)",
                "company_regadd": "浙江省",
                "company_manageadd": "浙江省义乌市北苑街道望道路337号3号楼6楼",
                "create_time": "2019-01-21 16:56:23",
                "is_end_quali": 1
            }
        ],
        [
            {
                "id": 232717,
                "company_url": "001607220057194470",
                "company_name": "江苏恒维建设工程有限公司",
                "company_creditnum": "913208000535020631",
                "company_legalreprst": "陈建",
                "company_regtype": "有限责任公司（自然人独资）",
                "company_regadd": "江苏省",
                "company_manageadd": "江苏省淮安市经济技术开发区南京北路6号6幢6室",
                "create_time": "2019-01-22 09:31:27",
                "is_end_quali": 1
            }
        ],
        [
            {
                "id": 232656,
                "company_url": "001607220057194471",
                "company_name": "福建腾晖环境建设集团有限公司",
                "company_creditnum": "913506007173745365",
                "company_legalreprst": "黄恩怀",
                "company_regtype": "有限责任公司",
                "company_regadd": "福建省",
                "company_manageadd": "福建省漳州高新区九湖镇长福村花卉交易中心大楼",
                "create_time": "2019-01-22 09:31:18",
                "is_end_quali": 1
            }
        ],
        [
            {
                "id": 235284,
                "company_url": "001607220057194472",
                "company_name": "江苏广宁建设有限公司",
                "company_creditnum": "913208917539242830",
                "company_legalreprst": "赵广成",
                "company_regtype": "有限责任公司",
                "company_regadd": "江苏省",
                "company_manageadd": "淮安经济开发区开发大道158号",
                "create_time": "2019-01-22 09:35:51",
                "is_end_quali": 1
            }
        ],
        [
            {
                "id": 2944,
                "company_url": "001607220057194474",
                "company_name": "北京雷森建筑工程有限公司",
                "company_creditnum": "911101021015966406",
                "company_legalreprst": "雷雨强",
                "company_regtype": "有限责任公司（自然人投资或控股）",
                "company_regadd": "北京市",
                "company_manageadd": "北京市西城区报国寺夹道1号西院报国寺招待所017室",
                "create_time": "2019-01-21 16:31:32",
                "is_end_quali": 1
            }
        ],
        [
            {
                "id": 3038,
                "company_url": "001607220057194481",
                "company_name": "四川米兰建筑装饰设计工程有限公司",
                "company_creditnum": "30934873-4 / 510000000391563",
                "company_legalreprst": "黄莉",
                "company_regtype": "有限责任公司（自然人投资或控股）",
                "company_regadd": "四川省",
                "company_manageadd": "成都市锦江区三色路163号1栋14层1402号",
                "create_time": "2019-01-21 16:31:35",
                "is_end_quali": 1
            }
        ],
        [
            {
                "id": 3236,
                "company_url": "001607220057194483",
                "company_name": "北京华清博雅环保工程有限公司",
                "company_creditnum": "911101085923492217",
                "company_legalreprst": "陈金光",
                "company_regtype": "其他有限责任公司",
                "company_regadd": "北京市",
                "company_manageadd": "北京市海淀区上地西路8号院1-4号楼1层4102",
                "create_time": "2019-01-21 16:31:43",
                "is_end_quali": 1
            }
        ],
        [
            {
                "id": 30146,
                "company_url": "001607220057194485",
                "company_name": "北京利通顺达建筑工程有限公司",
                "company_creditnum": "91110115358992497A",
                "company_legalreprst": "崔书芳",
                "company_regtype": "有限责任公司（自然人投资或控股）",
                "company_regadd": "北京市",
                "company_manageadd": "北京市大兴区三合北巷7号院5号1层",
                "create_time": "2019-01-21 17:29:51",
                "is_end_quali": 1
            }
        ],
        [
            {
                "id": 232638,
                "company_url": "001607220057194494",
                "company_name": "灵寿县第三建筑公司",
                "company_creditnum": "91130126721662290C",
                "company_legalreprst": "候小三",
                "company_regtype": "集体所有制",
                "company_regadd": "河北省",
                "company_manageadd": "灵寿县城北街",
                "create_time": "2019-01-22 09:31:15",
                "is_end_quali": 1
            }
        ],
        [
            {
                "id": 232637,
                "company_url": "001607220057194498",
                "company_name": "河北建研科技有限公司",
                "company_creditnum": "911301007373910341",
                "company_legalreprst": "叶金成",
                "company_regtype": "有限责任公司",
                "company_regadd": "河北省",
                "company_manageadd": "石家庄市裕华区槐中路244号",
                "create_time": "2019-01-22 09:31:15",
                "is_end_quali": 1
            }
        ],
        [
            {
                "id": 3161,
                "company_url": "001607220057194499",
                "company_name": "北京富丰市政工程建设有限公司",
                "company_creditnum": "911101068022233616",
                "company_legalreprst": "徐军",
                "company_regtype": "有限责任公司（法人独资）",
                "company_regadd": "北京市",
                "company_manageadd": "北京市丰台区科学城海鹰路9号2号楼(园区)",
                "create_time": "2019-01-21 16:31:40",
                "is_end_quali": 1
            }
        ],
        [
            {
                "id": 3204,
                "company_url": "001607220057194500",
                "company_name": "石家庄市延东电力工程有限公司",
                "company_creditnum": "911301007454005196",
                "company_legalreprst": "施龙宝",
                "company_regtype": "有限责任公司",
                "company_regadd": "河北省",
                "company_manageadd": "石家庄市桥西区中华南大街585号华府园银座4-1603室",
                "create_time": "2019-01-21 16:31:42",
                "is_end_quali": 1
            }
        ],
        [
            {
                "id": 5924,
                "company_url": "001607220057194502",
                "company_name": "河北省魏县第五建筑安装有限公司",
                "company_creditnum": "91130434106870661A",
                "company_legalreprst": "王振华",
                "company_regtype": "有限责任公司",
                "company_regadd": "河北省",
                "company_manageadd": "魏县陵园街8号",
                "create_time": "2019-01-21 16:47:04",
                "is_end_quali": 1
            }
        ],
        [
            {
                "id": 232660,
                "company_url": "001607220057194507",
                "company_name": "任丘市华兴建筑安装有限公司",
                "company_creditnum": "91130982700770049M",
                "company_legalreprst": "刘德朋",
                "company_regtype": "有限责任公司",
                "company_regadd": "河北省",
                "company_manageadd": "任丘市北关村",
                "create_time": "2019-01-22 09:31:19",
                "is_end_quali": 1
            }
        ],
        [
            {
                "id": 232672,
                "company_url": "001607220057194508",
                "company_name": "河北中冶润丰建设股份有限公司",
                "company_creditnum": "911302001049134454",
                "company_legalreprst": "王小平",
                "company_regtype": "股份有限公司（非上市）",
                "company_regadd": "河北省",
                "company_manageadd": "唐山市丰润区银城铺二十二冶工业园区",
                "create_time": "2019-01-22 09:31:21",
                "is_end_quali": 1
            }
        ],
        [
            {
                "id": 232642,
                "company_url": "001607220057194509",
                "company_name": "秦皇岛中科富斯信息科技有限公司",
                "company_creditnum": "91130301063146322R",
                "company_legalreprst": "高建中",
                "company_regtype": "有限责任公司",
                "company_regadd": "河北省",
                "company_manageadd": "秦皇岛市经济技术开发区天马湖路4号恒热控股大厦四层",
                "create_time": "2019-01-22 09:31:15",
                "is_end_quali": 1
            }
        ]
    ],
    "company_count": 146893,
    "exe_time": "70.835348"
}
```


## 企业筛选条件

**url**: /companycondition/qualificationType

**请求方式**：get



**请求参数：**


| 字段名 | 类型 | 说明 |
| ------ | ---- | ---- |
| code   | string|1.如果不传值，返回的是第一级数据（即资质类别）2.传code值过来再次请求接口，会返回此code的子级，依次类推|

**返回参数：**

|      字段名      | 类型   | 说明                       |
| :--------------: | ------ | --------------------------|
|       code       | int    | 错误码                     |
|       msg        | string | 消息                       |
|       data       | array  | 返回数据                   |
|        id        | int    | 资质ID                     |
|       code       | string | 对应资质级别的父级          |
|       name       | string | 当前等级的资质名称          |
|      is_end      | int    | 是否是最后一级              |
|       level      | string | 等级                       |



**返回示例：**

```
示例1：
/companycondition/qualificationType?code=A201
{
  "code": 1,
  "msg": "success",
  "data": [
    {
      "id": 419,
      "code": "A201A",
      "name": "工程设计煤炭行业甲级",
      "is_end": 1,
      "level": "甲级"
    },
    {
      "id": 420,
      "code": "A201B",
      "name": "工程设计煤炭行业乙级",
      "is_end": 1,
      "level": "乙级"
    }
  ]
}
示例2：
/companycondition/qualificationType?code=B
{
  "code": 1,
  "msg": "success",
  "data": [
    {
      "id": 11,
      "code": "B1",
      "name": "工程勘察综合资质",
      "is_end": 0,
      "level": ""
    },
    {
      "id": 12,
      "code": "B2",
      "name": "工程勘察专业资质",
      "is_end": 0,
      "level": ""
    },
    {
      "id": 13,
      "code": "B3",
      "name": "工程勘察劳务资质",
      "is_end": 0,
      "level": ""
    }
  ]
}
```


## 企业数据数量

**url**: /company/getCompanyDataNumber

**请求方式**：get



**请求参数：**


| 字段名 | 类型 | 说明 |
| ------ | ---- | ---- |
| code   | string|这个code是包括 多选等级 和 单选等级 两种类型,比如 ?code=414,352,(322|189)|

**返回参数：**

|      字段名      | 类型   | 说明                       |
| :--------------: | ------ | --------------------------|
|       code       | int    | 错误码                     |
|       msg        | string | 消息                       |
|       data       | int    | 返回符合资质筛选条件的公司数量 |


**返回示例：**

```
示例1：
/company/getCompanyDataNumber?code=414
{
  "code": 1,
  "msg": "success",
  "data": 184
}
示例2：
/company/getCompanyDataNumber?code=414,352,(322|189)
{
  "code": 1,
  "msg": "success",
  "data": 34
}
```


## 企业数据

**url**: /company/getCompanyData

**请求方式**：get


**请求参数：**

| 字段名 | 类型 | 说明 |
| ------ | ---- | ---- |
| code   | string|这个code是包括 多选等级 和 单选等级 两种类型,比如 ?code=414,352,(322|189),同获取公司数量的格式 |
| page   | int| 页数：例如1,2,3,4,5 我设置了默认值 1|
| page_size   | int| 每页数量：例如10,20 我设置了默认值 10  |

**返回参数：**

|      字段名      | 类型   | 说明                       |
| :--------------: | ------ | --------------------------|
|       code       | int    | 错误码                     |
|       msg        | string | 消息                       |
|       page        | int | 当前页数                     |
|       page_size        | int | 每页个数                  |
|       total_page        | int | 总页数                    |
|       total_num        | int | 总个数                       |
|       data       | array    | 返回符合资质筛选条件的公司数据 |
|       company_name       | sting    | 企业名称 |
|       company_legalreprst       | string    | 企业法定代表人 |
|       company_regadd       | string    | 企业注册属地 |
|       qualification       | array    | 返回该公司资质相关数据 |
|       ion_type_name       | string    | 资质类别 |
|       ion_name       | string    | 资质名称 |
|       ion_validity       | date    | 证书有效期 |
|       cpny_change       | array    | 返回该公司变更相关数据 |
|       change_date       | string    | 变更日期 |
|       change_content       | string    | 变更内容 |
|       cpny_miscdct       | array    |  返回该公司诚信相关数据|
|       miscdct_name       | string   |  诚信记录主体|
|       miscdct_content       | string    |  决定内容|
|       miscdct_dept       | string    |  实施部门|
|       miscdct_date       | date    | 发布有效期|



**返回示例：**

```
示例1：
/company/getCompanyData?code=414,352,(322|189)&page=2&page_size=10
{
  "code": 1,
  "msg": "success",
  "data": [
    {
      "company_name": "云南秀川水利水电勘察设计有限公司",
      "company_legalreprst": "张功育",
      "company_regadd": "云南省",
      "qualification": [
        {
          "ion_type_name": "设计资质",
          "ion_name": "工程设计水利行业灌溉排涝专业乙级",
          "ion_validity": "2023-04-20"
        },
        {
          "ion_type_name": "设计资质",
          "ion_name": "工程设计水利行业引调水专业乙级",
          "ion_validity": "2023-04-20"
        },
        {
          "ion_type_name": "设计资质",
          "ion_name": "工程设计水利行业水库枢纽专业乙级",
          "ion_validity": "2023-04-20"
        },
        {
          "ion_type_name": "设计资质",
          "ion_name": "工程设计水利行业城市防洪专业乙级",
          "ion_validity": "2023-04-20"
        },
        {
          "ion_type_name": "设计资质",
          "ion_name": "工程设计水利行业河道整治专业乙级",
          "ion_validity": "2023-04-20"
        },
        {
          "ion_type_name": "设计资质",
          "ion_name": "工程设计水利行业围垦专业丙级",
          "ion_validity": "2023-11-08"
        },
        {
          "ion_type_name": "设计资质",
          "ion_name": "工程设计水利行业水土保持专业丙级",
          "ion_validity": "2023-11-08"
        },
        {
          "ion_type_name": "勘察资质",
          "ion_name": "工程勘察岩土工程专业乙级",
          "ion_validity": "2020-07-22"
        },
        {
          "ion_type_name": "勘察资质",
          "ion_name": "工程勘察水文地质勘察专业乙级",
          "ion_validity": "2020-07-22"
        },
        {
          "ion_type_name": "勘察资质",
          "ion_name": "工程勘察工程测量专业乙级",
          "ion_validity": "2020-07-22"
        }
      ],
      "cpny_change": [
        
      ],
      "cpny_miscdct": [
        
      ]
    },
    {
      "company_name": "塔城地区水利水电勘察设计院",
      "company_legalreprst": "马品非",
      "company_regadd": "新疆维吾尔自治区",
      "qualification": [
        {
          "ion_type_name": "设计资质",
          "ion_name": "工程设计水利行业城市防洪专业乙级",
          "ion_validity": "2020-07-23"
        },
        {
          "ion_type_name": "设计资质",
          "ion_name": "工程设计水利行业河道整治专业乙级",
          "ion_validity": "2020-07-23"
        },
        {
          "ion_type_name": "设计资质",
          "ion_name": "工程设计水利行业灌溉排涝专业乙级",
          "ion_validity": "2020-07-23"
        },
        {
          "ion_type_name": "设计资质",
          "ion_name": "工程设计水利行业水库枢纽专业乙级",
          "ion_validity": "2020-07-23"
        },
        {
          "ion_type_name": "设计资质",
          "ion_name": "工程设计水利行业引调水专业乙级",
          "ion_validity": "2020-07-23"
        },
        {
          "ion_type_name": "设计资质",
          "ion_name": "工程设计电力行业水力发电（含抽水蓄能、潮汐）专业乙级",
          "ion_validity": "2022-06-21"
        },
        {
          "ion_type_name": "勘察资质",
          "ion_name": "工程勘察岩土工程专业乙级",
          "ion_validity": "2020-04-02"
        },
        {
          "ion_type_name": "勘察资质",
          "ion_name": "工程勘察工程测量专业乙级",
          "ion_validity": "2020-04-02"
        }
      ],
      "cpny_change": [
        
      ],
      "cpny_miscdct": [
        
      ]
    },
    {
      "company_name": "大理白族自治州水利水电勘测设计研究院",
      "company_legalreprst": "刘宇宽",
      "company_regadd": "云南省",
      "qualification": [
        {
          "ion_type_name": "设计资质",
          "ion_name": "工程设计水利行业灌溉排涝专业乙级",
          "ion_validity": "2021-02-02"
        },
        {
          "ion_type_name": "设计资质",
          "ion_name": "工程设计水利行业河道整治专业乙级",
          "ion_validity": "2021-02-02"
        },
        {
          "ion_type_name": "设计资质",
          "ion_name": "工程设计水利行业城市防洪专业乙级",
          "ion_validity": "2021-02-02"
        },
        {
          "ion_type_name": "设计资质",
          "ion_name": "工程设计水利行业水库枢纽专业乙级",
          "ion_validity": "2021-02-02"
        },
        {
          "ion_type_name": "设计资质",
          "ion_name": "工程设计水利行业引调水专业乙级",
          "ion_validity": "2021-02-02"
        },
        {
          "ion_type_name": "设计资质",
          "ion_name": "工程设计电力行业水力发电（含抽水蓄能、潮汐）专业乙级",
          "ion_validity": "2021-02-16"
        },
        {
          "ion_type_name": "勘察资质",
          "ion_name": "工程勘察工程测量专业乙级",
          "ion_validity": "2020-08-05"
        },
        {
          "ion_type_name": "勘察资质",
          "ion_name": "工程勘察岩土工程专业乙级",
          "ion_validity": "2020-08-05"
        },
        {
          "ion_type_name": "勘察资质",
          "ion_name": "工程勘察水文地质勘察专业乙级",
          "ion_validity": "2020-08-05"
        }
      ],
      "cpny_change": [
        
      ],
      "cpny_miscdct": [
        
      ]
    },
    {
      "company_name": "重庆同望水利水电工程设计有限公司",
      "company_legalreprst": "聂庚生",
      "company_regadd": "重庆市",
      "qualification": [
        {
          "ion_type_name": "设计资质",
          "ion_name": "工程设计水利行业水土保持专业乙级",
          "ion_validity": "2023-04-20"
        },
        {
          "ion_type_name": "设计资质",
          "ion_name": "工程设计水利行业引调水专业乙级",
          "ion_validity": "2023-04-20"
        },
        {
          "ion_type_name": "设计资质",
          "ion_name": "工程设计水利行业城市防洪专业乙级",
          "ion_validity": "2023-04-20"
        },
        {
          "ion_type_name": "设计资质",
          "ion_name": "工程设计水利行业灌溉排涝专业乙级",
          "ion_validity": "2023-04-20"
        },
        {
          "ion_type_name": "设计资质",
          "ion_name": "工程设计公路行业公路专业丙级",
          "ion_validity": "2021-02-22"
        },
        {
          "ion_type_name": "设计资质",
          "ion_name": "工程设计水利行业丙级",
          "ion_validity": "2021-02-22"
        },
        {
          "ion_type_name": "设计资质",
          "ion_name": "工程设计市政行业给水工程专业乙级",
          "ion_validity": "2021-02-22"
        },
        {
          "ion_type_name": "设计资质",
          "ion_name": "工程设计市政行业排水工程专业乙级",
          "ion_validity": "2021-02-22"
        },
        {
          "ion_type_name": "设计资质",
          "ion_name": "工程设计建筑行业（建筑工程）丙级",
          "ion_validity": "2021-02-22"
        },
        {
          "ion_type_name": "设计资质",
          "ion_name": "工程设计农林行业农业综合开发生态工程专业乙级",
          "ion_validity": "2021-02-22"
        },
        {
          "ion_type_name": "勘察资质",
          "ion_name": "工程勘察岩土工程专业（岩土工程勘察）乙级",
          "ion_validity": "2020-04-29"
        },
        {
          "ion_type_name": "勘察资质",
          "ion_name": "工程勘察工程钻探劳务",
          "ion_validity": "2020-04-29"
        },
        {
          "ion_type_name": "勘察资质",
          "ion_name": "工程勘察工程测量专业乙级",
          "ion_validity": "2020-04-29"
        },
        {
          "ion_type_name": "勘察资质",
          "ion_name": "工程勘察水文地质勘察专业乙级",
          "ion_validity": "2020-04-29"
        },
        {
          "ion_type_name": "建筑业企业资质",
          "ion_name": "水利水电工程施工总承包三级",
          "ion_validity": "2021-05-18"
        }
      ],
      "cpny_change": [
        
      ],
      "cpny_miscdct": [
        
      ]
    },
    {
      "company_name": "贵港市水利电力勘测设计研究院",
      "company_legalreprst": "韦民华",
      "company_regadd": "广西壮族自治区",
      "qualification": [
        {
          "ion_type_name": "设计资质",
          "ion_name": "工程设计水利行业水库枢纽专业乙级",
          "ion_validity": "2020-07-23"
        },
        {
          "ion_type_name": "设计资质",
          "ion_name": "工程设计水利行业灌溉排涝专业乙级",
          "ion_validity": "2020-07-23"
        },
        {
          "ion_type_name": "设计资质",
          "ion_name": "工程设计水利行业城市防洪专业乙级",
          "ion_validity": "2020-07-23"
        },
        {
          "ion_type_name": "勘察资质",
          "ion_name": "工程勘察水文地质勘察专业乙级",
          "ion_validity": "2020-12-04"
        },
        {
          "ion_type_name": "勘察资质",
          "ion_name": "工程勘察岩土工程专业（岩土工程勘察）乙级",
          "ion_validity": "2020-12-04"
        }
      ],
      "cpny_change": [
        
      ],
      "cpny_miscdct": [
        
      ]
    },
    {
      "company_name": "呼和浩特市科兆丰水业勘测设计有限公司",
      "company_legalreprst": "刘国华",
      "company_regadd": "内蒙古自治区",
      "qualification": [
        {
          "ion_type_name": "设计资质",
          "ion_name": "工程设计水利行业灌溉排涝专业乙级",
          "ion_validity": "2020-04-16"
        },
        {
          "ion_type_name": "设计资质",
          "ion_name": "工程设计水利行业河道整治专业乙级",
          "ion_validity": "2020-04-16"
        },
        {
          "ion_type_name": "设计资质",
          "ion_name": "工程设计水利行业城市防洪专业乙级",
          "ion_validity": "2020-04-16"
        },
        {
          "ion_type_name": "设计资质",
          "ion_name": "工程设计市政行业给水工程专业丙级",
          "ion_validity": "2020-05-15"
        },
        {
          "ion_type_name": "设计资质",
          "ion_name": "工程设计水利行业围垦专业丙级",
          "ion_validity": "2020-05-15"
        },
        {
          "ion_type_name": "设计资质",
          "ion_name": "工程设计市政行业排水工程专业丙级",
          "ion_validity": "2020-05-15"
        },
        {
          "ion_type_name": "设计资质",
          "ion_name": "工程设计水利行业水库枢纽专业丙级",
          "ion_validity": "2020-05-15"
        },
        {
          "ion_type_name": "设计资质",
          "ion_name": "工程设计水利行业引调水专业丙级",
          "ion_validity": "2020-05-15"
        },
        {
          "ion_type_name": "勘察资质",
          "ion_name": "工程勘察工程测量专业乙级",
          "ion_validity": "2020-06-29"
        },
        {
          "ion_type_name": "勘察资质",
          "ion_name": "工程勘察岩土工程专业（岩土工程勘察）乙级",
          "ion_validity": "2020-06-29"
        }
      ],
      "cpny_change": [
        
      ],
      "cpny_miscdct": [
        
      ]
    },
    {
      "company_name": "黄石市振兴勘察设计有限公司",
      "company_legalreprst": "戴雄彬",
      "company_regadd": "湖北省",
      "qualification": [
        {
          "ion_type_name": "设计资质",
          "ion_name": "工程设计水利行业河道整治专业乙级",
          "ion_validity": "2021-03-18"
        },
        {
          "ion_type_name": "设计资质",
          "ion_name": "工程设计水利行业灌溉排涝专业乙级",
          "ion_validity": "2021-03-18"
        },
        {
          "ion_type_name": "设计资质",
          "ion_name": "工程设计水利行业城市防洪专业乙级",
          "ion_validity": "2021-03-18"
        },
        {
          "ion_type_name": "勘察资质",
          "ion_name": "工程勘察工程测量专业乙级",
          "ion_validity": "2020-04-21"
        }
      ],
      "cpny_change": [
        
      ],
      "cpny_miscdct": [
        
      ]
    },
    {
      "company_name": "抚州市水电勘测设计院",
      "company_legalreprst": "钟国锋",
      "company_regadd": "江西省",
      "qualification": [
        {
          "ion_type_name": "设计资质",
          "ion_name": "工程设计水利行业河道整治专业乙级",
          "ion_validity": "2020-04-16"
        },
        {
          "ion_type_name": "设计资质",
          "ion_name": "工程设计水利行业城市防洪专业乙级",
          "ion_validity": "2020-04-16"
        },
        {
          "ion_type_name": "设计资质",
          "ion_name": "工程设计水利行业引调水专业乙级",
          "ion_validity": "2020-04-16"
        },
        {
          "ion_type_name": "设计资质",
          "ion_name": "工程设计水利行业水库枢纽专业乙级",
          "ion_validity": "2020-04-16"
        },
        {
          "ion_type_name": "设计资质",
          "ion_name": "工程设计水利行业灌溉排涝专业乙级",
          "ion_validity": "2020-04-16"
        },
        {
          "ion_type_name": "勘察资质",
          "ion_name": "工程勘察工程测量专业乙级",
          "ion_validity": "2020-06-16"
        },
        {
          "ion_type_name": "勘察资质",
          "ion_name": "工程勘察水文地质勘察专业乙级",
          "ion_validity": "2020-06-16"
        }
      ],
      "cpny_change": [
        
      ],
      "cpny_miscdct": [
        
      ]
    },
    {
      "company_name": "临沧市水利水电勘测设计研究院",
      "company_legalreprst": "黄凤岗",
      "company_regadd": "云南省",
      "qualification": [
        {
          "ion_type_name": "设计资质",
          "ion_name": "工程设计水利行业城市防洪专业乙级",
          "ion_validity": "2020-05-21"
        },
        {
          "ion_type_name": "设计资质",
          "ion_name": "工程设计水利行业灌溉排涝专业乙级",
          "ion_validity": "2020-05-21"
        },
        {
          "ion_type_name": "设计资质",
          "ion_name": "工程设计水利行业河道整治专业乙级",
          "ion_validity": "2020-05-21"
        },
        {
          "ion_type_name": "设计资质",
          "ion_name": "工程设计水利行业水库枢纽专业乙级",
          "ion_validity": "2020-05-21"
        },
        {
          "ion_type_name": "设计资质",
          "ion_name": "工程设计水利行业引调水专业乙级",
          "ion_validity": "2020-05-21"
        },
        {
          "ion_type_name": "设计资质",
          "ion_name": "工程设计电力行业送电工程专业丙级",
          "ion_validity": "2020-05-25"
        },
        {
          "ion_type_name": "设计资质",
          "ion_name": "工程设计电力行业变电工程专业丙级",
          "ion_validity": "2020-05-25"
        },
        {
          "ion_type_name": "设计资质",
          "ion_name": "工程设计电力行业水力发电（含抽水蓄能、潮汐）专业乙级",
          "ion_validity": "2020-05-25"
        },
        {
          "ion_type_name": "勘察资质",
          "ion_name": "工程勘察水文地质勘察专业乙级",
          "ion_validity": "2020-05-25"
        },
        {
          "ion_type_name": "勘察资质",
          "ion_name": "工程勘察岩土工程专业乙级",
          "ion_validity": "2020-05-25"
        },
        {
          "ion_type_name": "勘察资质",
          "ion_name": "工程勘察工程测量专业乙级",
          "ion_validity": "2020-05-25"
        },
        {
          "ion_type_name": "勘察资质",
          "ion_name": "工程勘察工程钻探劳务",
          "ion_validity": "2020-05-25"
        }
      ],
      "cpny_change": [
        
      ],
      "cpny_miscdct": [
        
      ]
    },
    {
      "company_name": "凉山州水电设计院设计咨询有限公司",
      "company_legalreprst": "李政",
      "company_regadd": "四川省",
      "qualification": [
        {
          "ion_type_name": "设计资质",
          "ion_name": "工程设计水利行业河道整治专业乙级",
          "ion_validity": "2021-07-11"
        },
        {
          "ion_type_name": "设计资质",
          "ion_name": "工程设计水利行业城市防洪专业乙级",
          "ion_validity": "2021-07-11"
        },
        {
          "ion_type_name": "设计资质",
          "ion_name": "工程设计水利行业围垦专业乙级",
          "ion_validity": "2021-07-11"
        },
        {
          "ion_type_name": "设计资质",
          "ion_name": "工程设计水利行业灌溉排涝专业乙级",
          "ion_validity": "2021-07-11"
        },
        {
          "ion_type_name": "设计资质",
          "ion_name": "工程设计水利行业水库枢纽专业乙级",
          "ion_validity": "2021-07-11"
        },
        {
          "ion_type_name": "设计资质",
          "ion_name": "工程设计水利行业引调水专业乙级",
          "ion_validity": "2021-07-11"
        },
        {
          "ion_type_name": "设计资质",
          "ion_name": "工程设计电力行业变电工程专业丙级",
          "ion_validity": "2020-05-26"
        },
        {
          "ion_type_name": "设计资质",
          "ion_name": "工程设计电力行业水力发电（含抽水蓄能、潮汐）专业乙级",
          "ion_validity": "2020-05-26"
        },
        {
          "ion_type_name": "设计资质",
          "ion_name": "工程设计电力行业送电工程专业丙级",
          "ion_validity": "2020-05-26"
        },
        {
          "ion_type_name": "勘察资质",
          "ion_name": "工程勘察工程测量专业乙级",
          "ion_validity": "2020-12-08"
        },
        {
          "ion_type_name": "勘察资质",
          "ion_name": "工程勘察岩土工程专业乙级",
          "ion_validity": "2020-12-08"
        },
        {
          "ion_type_name": "勘察资质",
          "ion_name": "工程勘察水文地质勘察专业乙级",
          "ion_validity": "2020-12-08"
        }
      ],
      "cpny_change": [
        
      ],
      "cpny_miscdct": [
        
      ]
    }
  ]
}

```
