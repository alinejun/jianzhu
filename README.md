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

## 人员筛选(请求参数修改)

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



## 企业人员联查（符合条件的企业数量）

   **url**: /index/getData

   **请求方式**：post

   **请求参数（示例）：**

  ```
  {
  	"request":{
  	     "company_condition":{
  	     	"code":"414,352,(322|189)"
  	     },
  	     "people_condition":{
  	     	"register_type":"二级注册建造师,二级注册建造师",
      		"register_major":"建筑工程,建筑工程"
  	     }
  	}
  }
  ```

   **返回参数：**

|      字段名      | 类型   | 说明                       |
| :--------------: | ------ | -------------------------- |
|       code       | int    | 错误码                     |
|       msg        | string | 消息                       |
|       count       | array  | 符合条件的企业数量       |

  

   **返回示例：**

   ```
    {
          "code": 1,
          "msg": "成功",
          "count": 3,
          "exe_time": "16.591045"
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

## 项目筛选条件

**url**: /project/projectcondition

**请求方式**：get



**请求参数：**

无

**返回参数：**

|      字段名      | 类型   | 说明                       |
| :--------------: | ------ | --------------------------|
|       code       | int    | 错误码                     |
|       msg        | string | 消息                       |
|       data       | array  | 返回数据                   |
|     project_type | array  | 项目分类数组               |
|   project_nature | array  | 建设性质数组               |
|   project_use    | array  | 工程用途数组               |
|      bid_way     | array  | 招标类型数组               |
|   contract_type  | array  | 合同类别数组               |



**返回示例：**

```
示例1：
/project/projectcondition
{
  "code": 1,
  "msg": "success",
  "data": {
    "project_type": [
      "房屋建筑工程",
      "市政工程",
      "其他"
    ],
    "project_nature": [
      "新建",
      "改建",
      "其他",
      "迁建",
      "扩建",
      "恢复"
    ],
    "project_use": [
      "道路",
      "其他",
      "工业建筑",
      "居住建筑",
      "商住楼",
      "公共建筑",
      "科教文卫建筑",
      "桥隧",
      "交通运输类",
      "办公建筑",
      "公共交通",
      "农业建筑",
      "商业建筑",
      "排水",
      "风景园林",
      "给水",
      "居住建筑配套工程",
      "工业建筑配套工程",
      "公共建筑配套工程",
      "燃气",
      "旅游建筑",
      "热力",
      "环境园林",
      "农业建筑配套工程",
      "通信建筑"
    ],
    "bid_way": [
      "公开招标",
      "邀请招标",
      "直接委托",
      "其他"
    ],
    "contract_type": [
      "施工总包",
      "监理",
      "设计",
      "勘察",
      "施工分包",
      "工程总承包",
      "专业承包",
      "施工劳务",
      "项目管理",
      "设计施工一体化"
    ]
  }
}
```
## 项目数据数量

**url**: /project/getProjectDataNum

**请求方式**：get


**请求参数：**

| 字段名 | 类型 | 说明 |
| ------ | ---- | ---- |
| project_type   | string|项目分类 |
| project_nature | string|建设性质 |
| project_use   | string|工程用途 |
| bid_way   | string|招标类型 |
| bid_money   | int|中标金额 |
| bid_date_start   | string|中标日期开始 |
| bid_date_end   | string|中标日期结束 |
| contract_type   | string|合同类别 |
| contract_money   | int|合同金额 |
| contract_scale   | int|建设规模 |
| contract_date_start   | string|合同签订日期开始 |
| contract_date_end   | string|合同签订时期结束 |
| finish_money   | int|实际造价 |
| finish_area   | int|实际面积 |
| finish_realbegin_start   | string|实际开工日期开始 |
| finish_realbegin_end   | string|实际开工日期结束 |
| finish_realfinish_start   | string|实际竣工验收日期开始 |
| finish_realfinish_end   | string|实际竣工验收日期结束 |

**返回参数：**

|      字段名      | 类型   | 说明                       |
| :--------------: | ------ | --------------------------|
|       code       | int    | 错误码                     |
|       msg        | string | 消息                       |
|       data       | int    | 返回符合筛选条件的项目数量 |


**返回示例：**
ps:说明注释:所有返回数量的都是公司的数量
```
示例1：
/project/getProjectDataNum?finish_realbegin_start='2018-01-01'&finish_realbegin_end='2018-02-02'&project_use='其他'&project_nature='改建'
{
  "code": 1,
  "msg": "success",
  "data": 82
}
```

## 项目数据详情

**url**: /project/getProjectDataDetail

**请求方式**：get

**注意事项**
1.page 和 page_size
由于数据量庞大，所有就不统计 page_total 以及 total_num 了，前端只给下一页和上一页的按钮和自定义页面显示条数即可
2.根据筛选项的不同会以不同的方式连接表来查询符合条件的项目
**请求参数：**

| 字段名 | 类型 | 说明 |
| ------ | ---- | ---- |
| project_type   | string|项目分类 |
| project_nature | string|建设性质 |
| project_use   | string|工程用途 |
| bid_way   | string|招标类型 |
| bid_money   | int|中标金额 |
| bid_date_start   | string|中标日期开始 |
| bid_date_end   | string|中标日期结束 |
| contract_type   | string|合同类别 |
| contract_money   | int|合同金额 |
| contract_scale   | int|建设规模 |
| contract_date_start   | string|合同签订日期开始 |
| contract_date_end   | string|合同签订时期结束 |
| finish_money   | int|实际造价 |
| finish_area   | int|实际面积 |
| finish_realbegin_start   | string|实际开工日期开始 |
| finish_realbegin_end   | string|实际开工日期结束 |
| finish_realfinish_start   | string|实际竣工验收日期开始 |
| finish_realfinish_end   | string|实际竣工验收日期结束 |
| page   | int| 页数：例如1,2,3,4,5 我设置了默认值 1|
| page_size   | int| 每页数量：例如10,20 我设置了默认值 10  |

**返回参数：**

|      字段名      | 类型   | 说明                       |
| :--------------: | ------ | --------------------------|
|       code       | int    | 错误码                     |
|       msg        | string | 消息                       |
|       data       | int    | 返回符合筛选条件的项目数量     |
|   project_name      |string|项目名称                      |
|   project_type      |string|项目分类                      |
|   project_nature    |string|建设性质                      |
|   project_use       |string|工程用途                      |
|   project_allmoney  |string|总投资                        |
|   project_acreage   |string|总面积                        |
|   bid_date          |date  |中标日期(y-m-d)               |
|   bid_money         |string|中标金额(万元)                 |
|   bid_pname         |string|项目经理／总监理工程师姓名       |
|   bid_pnum          |string|项目经理／总监理工程师身份证号码  |
|   bid_url           |string|网站招投标-详情页面             |
|   contract_type     |string|合同类别                      |
|   contract_money    |string|合同金额(万元)                 |
|   contract_signtime |date  |合同签订日期                   |
|   contract_scale    |string|建设规模                      |
|   contract_add_url  |string|网站合同备案-详情页面          |
|   finish_money      |string|实际造价(万元)                 |
|   finish_area       |string|实际面积(平方米)               |
|   finish_realbegin  |date  |实际开工日期                   |
|   finish_realfinish |date  |实际竣工验收日期               |
|   finish_unitdsn    |string|设计单位                      |
|   finish_unitspv    |string|监理单位                      |
|   finish_unitcst    |string|施工单位                      |
|   finish_add_url    |string|网站竣工验收备案-详情页面      |


**返回示例：**
ps:说明注释:所有返回数量的都是公司的数量
```
示例1：
/project/getProjectDataDetail?project_use='其他'&project_nature='改建'
{
  "code": 1,
  "msg": "success",
  "data": [
    {
      "project_name": "巴彦北路道路、雨水管道及路灯工程",
      "project_type": "市政工程",
      "project_nature": "改建",
      "project_use": "其他",
      "project_allmoney": "3429（万元）",
      "project_acreage": "-",
      "bid_date": "2017-12-25",
      "bid_money": "3429",
      "bid_pname": "庞保军",
      "bid_pnum": "None",
      "bid_url": "http://jzsc.mohurd.gov.cn/dataservice/query/project/tenderInfo/3707063",
      "contract_type": "施工总包",
      "contract_money": "3429",
      "contract_signtime": "2007-09-10",
      "contract_scale": "新建道路全长2412米，雨水管道工程4109米，路灯工程4824米",
      "contract_add_url": "http://jzsc.mohurd.gov.cn/dataservice/query/project/contractInfo/2052699",
      "finish_money": "6291.72",
      "finish_area": "-",
      "finish_realbegin": "2007-09-22",
      "finish_realfinish": "2015-01-27",
      "finish_unitdsn": "呼和浩特市市政工程设计研究院",
      "finish_unitspv": "呼和浩特市宏祥市政工程咨询监理有限责任公司",
      "finish_unitcst": "呼和浩特市政公路工程有限责任公司",
      "finish_add_url": "http://jzsc.mohurd.gov.cn/dataservice/query/project/bafinishInfo/403775"
    },
    {
      "project_name": "附院地下通道",
      "project_type": "市政工程",
      "project_nature": "改建",
      "project_use": "其他",
      "project_allmoney": "2811（万元）",
      "project_acreage": "-",
      "bid_date": "2017-12-25",
      "bid_money": "2811",
      "bid_pname": "庞保军",
      "bid_pnum": "None",
      "bid_url": "http://jzsc.mohurd.gov.cn/dataservice/query/project/tenderInfo/3707234",
      "contract_type": "施工总包",
      "contract_money": "2811",
      "contract_signtime": "2010-06-29",
      "contract_scale": "红线宽度12米，长度50米,共2407平米。",
      "contract_add_url": "http://jzsc.mohurd.gov.cn/dataservice/query/project/contractInfo/2052704",
      "finish_money": "3600",
      "finish_area": "-",
      "finish_realbegin": "2010-06-29",
      "finish_realfinish": "2011-01-10",
      "finish_unitdsn": "呼和浩特市同心德市政工程设计研究有限公司",
      "finish_unitspv": "呼和浩特市宏祥市政工程咨询监理有限责任公司",
      "finish_unitcst": "呼和浩特市政公路工程有限责任公司",
      "finish_add_url": "http://jzsc.mohurd.gov.cn/dataservice/query/project/bafinishInfo/403881"
    },
    {
      "project_name": "世纪六路（锡林路-金一路）道路及雨污水管道工程",
      "project_type": "市政工程",
      "project_nature": "改建",
      "project_use": "其他",
      "project_allmoney": "1710（万元）",
      "project_acreage": "-",
      "bid_date": "2010-10-30",
      "bid_money": "1710",
      "bid_pname": "刘志平",
      "bid_pnum": "None",
      "bid_url": "http://jzsc.mohurd.gov.cn/dataservice/query/project/tenderInfo/3707102",
      "contract_type": "施工总包",
      "contract_money": "1710",
      "contract_signtime": "2010-11-01",
      "contract_scale": "长：1424.83米，宽：40米",
      "contract_add_url": "http://jzsc.mohurd.gov.cn/dataservice/query/project/contractInfo/2052807",
      "finish_money": "1632.92",
      "finish_area": "-",
      "finish_realbegin": "2010-10-30",
      "finish_realfinish": "2012-09-20",
      "finish_unitdsn": "呼和浩特市同心德市政工程设计研究院有限公司",
      "finish_unitspv": "呼和浩特市宏祥市政工程咨询监理有限责任公司",
      "finish_unitcst": "呼和浩特市政公路工程有限责任公司",
      "finish_add_url": "http://jzsc.mohurd.gov.cn/dataservice/query/project/bafinishInfo/403822"
    },
    {
      "project_name": "达旗民族中学教学楼改造与抗震加固工程",
      "project_type": "房屋建筑工程",
      "project_nature": "改建",
      "project_use": "其他",
      "project_allmoney": "357.39（万元）",
      "project_acreage": "4021（平方米）",
      "bid_date": "2012-07-17",
      "bid_money": "357.39",
      "bid_pname": "张俊剑",
      "bid_pnum": "None",
      "bid_url": "http://jzsc.mohurd.gov.cn/dataservice/query/project/tenderInfo/3707418",
      "contract_type": "施工总包",
      "contract_money": "357.39",
      "contract_signtime": "2012-07-20",
      "contract_scale": "建筑面积为4021平米。",
      "contract_add_url": "http://jzsc.mohurd.gov.cn/dataservice/query/project/contractInfo/2053185",
      "finish_money": "357.39",
      "finish_area": "4201.00",
      "finish_realbegin": "2012-07-20",
      "finish_realfinish": "2012-08-25",
      "finish_unitdsn": "达拉特旗宏阳建筑设计有限责任公司",
      "finish_unitspv": "达旗方圆建设监理服务有限责任公司",
      "finish_unitcst": "鄂尔多斯市明阳建筑有限责任公司",
      "finish_add_url": "http://jzsc.mohurd.gov.cn/dataservice/query/project/bafinishInfo/404012"
    },
    {
      "project_name": "鄂前旗敖勒召其镇2012市政项目改造工程-第五标段-敖镇污水处理厂、附属工程及尾水工程",
      "project_type": "市政工程",
      "project_nature": "改建",
      "project_use": "其他",
      "project_allmoney": "1918.73（万元）",
      "project_acreage": "-",
      "bid_date": "2012-05-18",
      "bid_money": "1918.73",
      "bid_pname": "燕伟",
      "bid_pnum": "None",
      "bid_url": "http://jzsc.mohurd.gov.cn/dataservice/query/project/tenderInfo/3707016",
      "contract_type": "工程总承包",
      "contract_money": "1918.73",
      "contract_signtime": "2012-05-20",
      "contract_scale": "污水处理厂建筑面积3000平方米，单层门式钢架结；尾水工程（再生水）共长9860.55m，中水厂（人工湖、环湖路）道路长度共2773.301m，宽4.5米。",
      "contract_add_url": "http://jzsc.mohurd.gov.cn/dataservice/query/project/contractInfo/2053229",
      "finish_money": "1918.74",
      "finish_area": "-",
      "finish_realbegin": "2012-05-17",
      "finish_realfinish": "2012-07-14",
      "finish_unitdsn": "泛华建设集团有限公司",
      "finish_unitspv": "陕西永明项目管理有限公司",
      "finish_unitcst": "内蒙古兴源水务集团有限公司",
      "finish_add_url": "http://jzsc.mohurd.gov.cn/dataservice/query/project/bafinishInfo/403733"
    },
    {
      "project_name": "杭锦旗锡尼镇旧城区道路、管网改造工程五标",
      "project_type": "市政工程",
      "project_nature": "改建",
      "project_use": "其他",
      "project_allmoney": "1774.69（万元）",
      "project_acreage": "-",
      "bid_date": "2010-08-19",
      "bid_money": "1774.69",
      "bid_pname": "岳守荣",
      "bid_pnum": "None",
      "bid_url": "http://jzsc.mohurd.gov.cn/dataservice/query/project/tenderInfo/3707554",
      "contract_type": "施工总包",
      "contract_money": "1774.69",
      "contract_signtime": "2010-08-20",
      "contract_scale": "草原路，长度约1468米，宽约24米",
      "contract_add_url": "http://jzsc.mohurd.gov.cn/dataservice/query/project/contractInfo/2053322",
      "finish_money": "1774.69",
      "finish_area": "1487.22",
      "finish_realbegin": "2010-08-20",
      "finish_realfinish": "2011-06-30",
      "finish_unitdsn": "中国中轻国际工程有限公司",
      "finish_unitspv": "内蒙古广誉建设监理有限责任公司",
      "finish_unitcst": "内蒙古巨达路桥有限责任公司",
      "finish_add_url": "http://jzsc.mohurd.gov.cn/dataservice/query/project/bafinishInfo/404198"
    },
    {
      "project_name": "杭锦旗锡尼镇旧城区道路、管网改造工程十标",
      "project_type": "市政工程",
      "project_nature": "改建",
      "project_use": "其他",
      "project_allmoney": "220.39（万元）",
      "project_acreage": "-",
      "bid_date": "2010-08-19",
      "bid_money": "220.39",
      "bid_pname": "岳守荣",
      "bid_pnum": "None",
      "bid_url": "http://jzsc.mohurd.gov.cn/dataservice/query/project/tenderInfo/3707555",
      "contract_type": "施工总包",
      "contract_money": "220.39",
      "contract_signtime": "2010-08-20",
      "contract_scale": "胜利路，698米",
      "contract_add_url": "http://jzsc.mohurd.gov.cn/dataservice/query/project/contractInfo/2053324",
      "finish_money": "220.39",
      "finish_area": "0.00",
      "finish_realbegin": "2010-08-20",
      "finish_realfinish": "2011-06-30",
      "finish_unitdsn": "中国中轻国际工程有限公司",
      "finish_unitspv": "内蒙古广誉建设监理有限责任公司",
      "finish_unitcst": "内蒙古巨达路桥有限责任公司",
      "finish_add_url": "http://jzsc.mohurd.gov.cn/dataservice/query/project/bafinishInfo/404199"
    },
    {
      "project_name": "杭锦旗锡尼镇旧城区道路、管网改造工程七标",
      "project_type": "市政工程",
      "project_nature": "改建",
      "project_use": "其他",
      "project_allmoney": "418.5（万元）",
      "project_acreage": "-",
      "bid_date": "2010-08-19",
      "bid_money": "418.5",
      "bid_pname": "岳守荣",
      "bid_pnum": "None",
      "bid_url": "http://jzsc.mohurd.gov.cn/dataservice/query/project/tenderInfo/3707556",
      "contract_type": "施工总包",
      "contract_money": "418.5",
      "contract_signtime": "2010-08-20",
      "contract_scale": "光明东路，410米，宽24米",
      "contract_add_url": "http://jzsc.mohurd.gov.cn/dataservice/query/project/contractInfo/2053325",
      "finish_money": "418.5",
      "finish_area": "0.00",
      "finish_realbegin": "2010-08-20",
      "finish_realfinish": "2011-06-30",
      "finish_unitdsn": "中国中轻国际工程有限公司",
      "finish_unitspv": "内蒙古广誉建设监理有限责任公司",
      "finish_unitcst": "内蒙古巨达路桥有限责任公司",
      "finish_add_url": "http://jzsc.mohurd.gov.cn/dataservice/query/project/bafinishInfo/404200"
    },
    {
      "project_name": "杭锦旗锡尼镇旧城道路管网建设工程-穿沙公路、北外环路、东环路管网及附属工程二标段",
      "project_type": "市政工程",
      "project_nature": "改建",
      "project_use": "其他",
      "project_allmoney": "1524.36（万元）",
      "project_acreage": "-",
      "bid_date": "2011-04-25",
      "bid_money": "779.56",
      "bid_pname": "岳守荣",
      "bid_pnum": "None",
      "bid_url": "http://jzsc.mohurd.gov.cn/dataservice/query/project/tenderInfo/3707557",
      "contract_type": "施工总包",
      "contract_money": "779.56",
      "contract_signtime": "2011-05-04",
      "contract_scale": "光明东路（宜锡路到东环路）道路及管网，全长约390米；胜利路道路，全长约770米",
      "contract_add_url": "http://jzsc.mohurd.gov.cn/dataservice/query/project/contractInfo/2053326",
      "finish_money": "779.56",
      "finish_area": "0.00",
      "finish_realbegin": "2011-05-01",
      "finish_realfinish": "2011-10-31",
      "finish_unitdsn": "中国中轻国际工程有限公司",
      "finish_unitspv": "榆林市大成建设监理有限公司",
      "finish_unitcst": "内蒙古巨达路桥有限责任公司",
      "finish_add_url": "http://jzsc.mohurd.gov.cn/dataservice/query/project/bafinishInfo/404201"
    },
    {
      "project_name": "杭锦旗锡尼镇林荫路道路俩侧铺装维修改造工程",
      "project_type": "市政工程",
      "project_nature": "改建",
      "project_use": "其他",
      "project_allmoney": "944.66（万元）",
      "project_acreage": "-",
      "bid_date": "2016-08-16",
      "bid_money": "944.66",
      "bid_pname": "王振刚",
      "bid_pnum": "None",
      "bid_url": "http://jzsc.mohurd.gov.cn/dataservice/query/project/tenderInfo/3706838",
      "contract_type": "施工总包",
      "contract_money": "944.66",
      "contract_signtime": "2016-08-22",
      "contract_scale": "全长5040.822米，包括铺装，路缘石，树穴石，景观等。",
      "contract_add_url": "http://jzsc.mohurd.gov.cn/dataservice/query/project/contractInfo/2053328",
      "finish_money": "944.66",
      "finish_area": "-",
      "finish_realbegin": "2016-08-22",
      "finish_realfinish": "2016-09-20",
      "finish_unitdsn": "中国市政工程华北设计院",
      "finish_unitspv": "内蒙古首信建设监理有限公司",
      "finish_unitcst": "杭锦旗恒升房屋建筑工程有限责任公司",
      "finish_add_url": "http://jzsc.mohurd.gov.cn/dataservice/query/project/bafinishInfo/404160"
    }
  ]
}
```


## 企业单查（符合条件的企业数量）

   **url**: /index/getData

   **请求方式**：post

   **请求参数（示例）：**

  ```
  {
  	"request":{
  	     "company_condition":{
  	     	"code":"414,352,(322|189)"
  	     }
  	}
  }
  ```

   **返回参数：**

|      字段名      | 类型   | 说明                       |
| :--------------: | ------ | -------------------------- |
|       code       | int    | 错误码                     |
|       msg        | string | 消息                       |
|       count       | array  | 符合条件的企业数量       |

  

   **返回示例：**

   ```
    {
          "code": 1,
          "msg": "success",
          "count": 37
      }
   ```


## 项目单查（符合条件的企业数量）

   **url**: /index/getData

   **请求方式**：post

   **请求参数（示例）：**

  ```
  {
    	"request":{
    	     "project_condition":{
    	     	"finish_realbegin_start":"2018-01-01",
    	     	"finish_realbegin_end":"2018-02-02",
    	     	"project_use":"其他",
    	     	"project_nature":"改建"
    	     }
    	}
    }
  ```

   **返回参数：**

|      字段名      | 类型   | 说明                       |
| :--------------: | ------ | -------------------------- |
|       code       | int    | 错误码                     |
|       msg        | string | 消息                       |
|       count       | array  | 符合条件的企业数量       |

  

   **返回示例：**

   ```
    {
          "code": 1,
          "msg": "success",
          "count": 87
      }
   ```


## 企业项目联合查询（符合条件的企业数量）

   **url**: /index/getData

   **请求方式**：post

   **请求参数（示例）：**

  ```
 {
   	"request":{
   		"company_condition":{
   	     	"code":"414,352,(322|189)"
   	     },
   	     "project_condition":{
   	     	"finish_realbegin_start":"2018-01-01",
   	     	"finish_realbegin_end":"2018-02-02",
   	     	"project_use":"其他",
   	     	"project_nature":"改建"
   	     }
   	}
   }
  ```

   **返回参数：**

|      字段名      | 类型   | 说明                       |
| :--------------: | ------ | -------------------------- |
|       code       | int    | 错误码                     |
|       msg        | string | 消息                       |
|       count       | array  | 符合条件的企业数量       |

  

   **返回示例：**

   ```
    {
          "code": 1,
          "msg": "success",
          "count": 0
      }
   ```

   

## 人员项目联合查询（符合条件的企业数量）

   **url**: /index/getData

   **请求方式**：post

   **请求参数（示例）：**

  ```
{
  	"request":{
  		"people_condition":{
  	     	"register_type":"二级注册建造师,二级注册建造师",
      		"register_major":"建筑工程,建筑工程"
  	     },
  	      "project_condition":{
    	     	"finish_realbegin_start":"2018-01-01",
    	     	"finish_realbegin_end":"2018-02-02",
    	     	"project_use":"其他",
    	     	"project_nature":"改建"
         }
  	}
  }
  ```

   **返回参数：**

|      字段名      | 类型   | 说明                       |
| :--------------: | ------ | -------------------------- |
|       code       | int    | 错误码                     |
|       msg        | string | 消息                       |
|       count       | array  | 符合条件的企业数量       |

  

   **返回示例：**

   ```
    {
          "code": 1,
          "msg": "success",
          "count": 35
      }
   ```

   

## 人员企业项目 三个 联合查询（符合条件的企业数量）

   **url**: /index/getData

   **请求方式**：post

   **请求参数（示例）：**

  ```
{
  	"request":{
  		"company_condition":{
   	     	"code":"431"
   	     },
  		"people_condition":{
  	     	"register_type":"二级注册建造师,二级注册建造师",
      		"register_major":"建筑工程,建筑工程"
  	     },
  	      "project_condition":{
    	     	"finish_realbegin_start":"2018-05-01",
    	     	"finish_realbegin_end":"2018-06-02",
    	     	"project_use":"其他",
    	     	"project_nature":"改建"
    	     }
  	}
}
  ```

   **返回参数：**

|      字段名      | 类型   | 说明                       |
| :--------------: | ------ | -------------------------- |
|       code       | int    | 错误码                     |
|       msg        | string | 消息                       |
|       count       | array  | 符合条件的企业数量       |

  

   **返回示例：**

   ```
    {
          "code": 1,
          "msg": "success",
          "count": 3
      }
   ```

## 人员详情

   **url**: /index/getData

   **请求方式**：post

   **请求参数（示例）：**

```
  {
  	"request":{
  	     "people_condition_detail":{
  	     	"register_type":"一级注册建造师,一级注册建造师",
      		"register_major":"机电工程,建筑工程",
      		"page_size":10,
      		"page_num":0
  	     }
  	}
  }
```

   **返回参数：**

|     字段名      | 类型   | 说明               |
| :-------------: | ------ | ------------------ |
|      code       | int    | 错误码             |
|       msg       | string | 消息               |
|   people_list   | array  | 符合条件的人员信息 |
|    people_id    | int    | 人员id             |
|  register_type  | array  | 注册类型           |
| register_major  | array  | 注册专业           |
|  register_unit  | array  | 注册单位           |
|  register_date  | array  | 注册日期           |
|   people_name   | string | 人员姓名           |
|   people_sex    | string | 人员性别           |
| people_cardtype | string | 证件类型           |
| people_cardnum  | string | 证件号码           |

  

   **返回示例：**

```
{
    "code": 1,
    "msg": "成功",
    "people_list": [
        {
            "people_id": 2177,
            "register_type": [
                "一级注册建造师",
                "一级注册建造师"
            ],
            "register_major": [
                "机电工程",
                "建筑工程"
            ],
            "register_unit": [
                "江苏天亿建设工程有限公司",
                "江苏天亿建设工程有限公司"
            ],
            "register_date": [
                "2016年11月04日",
                "2016年11月04日"
            ],
            "people_name": "陈明",
            "people_sex": "男",
            "people_cardtype": "居民身份证",
            "people_cardnum": "3209111979******18"
        },
        {
            "people_id": 2344,
            "register_type": [
                "一级注册建造师",
                "一级注册建造师"
            ],
            "register_major": [
                "机电工程",
                "建筑工程"
            ],
            "register_unit": [
                "许昌腾飞建设工程集团有限公司",
                "许昌腾飞建设工程集团有限公司"
            ],
            "register_date": [
                "2020年08月21日",
                "2021年09月19日"
            ],
            "people_name": "刘汉强",
            "people_sex": "男",
            "people_cardtype": "居民身份证",
            "people_cardnum": "4110231985******1X"
        },
        {
            "people_id": 2361,
            "register_type": [
                "一级注册建造师",
                "一级注册建造师"
            ],
            "register_major": [
                "建筑工程",
                "机电工程"
            ],
            "register_unit": [
                "许昌腾飞建设工程集团有限公司",
                "许昌腾飞建设工程集团有限公司"
            ],
            "register_date": [
                "2021年09月19日",
                "2019年08月30日"
            ],
            "people_name": "姚俊德",
            "people_sex": "男",
            "people_cardtype": "居民身份证",
            "people_cardnum": "4110241988******9X"
        },
        {
            "people_id": 2723,
            "register_type": [
                "一级注册建造师",
                "一级注册建造师"
            ],
            "register_major": [
                "建筑工程",
                "机电工程"
            ],
            "register_unit": [
                "中建五局安装工程有限公司",
                "中建五局安装工程有限公司"
            ],
            "register_date": [
                "2015年11月12日",
                "2012年04月13日"
            ],
            "people_name": "刘苑",
            "people_sex": "女",
            "people_cardtype": "居民身份证",
            "people_cardnum": "4301031969******48"
        },
        {
            "people_id": 2778,
            "register_type": [
                "一级注册建造师",
                "一级注册建造师"
            ],
            "register_major": [
                "建筑工程",
                "机电工程"
            ],
            "register_unit": [
                "七冶建设集团有限责任公司",
                "七冶建设集团有限责任公司"
            ],
            "register_date": [
                "2020年09月26日",
                "2010年11月19日"
            ],
            "people_name": "杨轶",
            "people_sex": "男",
            "people_cardtype": "居民身份证",
            "people_cardnum": "2201041975******3X"
        },
        {
            "people_id": 2864,
            "register_type": [
                "一级注册建造师",
                "一级注册建造师"
            ],
            "register_major": [
                "机电工程",
                "建筑工程"
            ],
            "register_unit": [
                "中建五局安装工程有限公司",
                "中建五局安装工程有限公司"
            ],
            "register_date": [
                "2011年04月28日",
                "2011年04月28日"
            ],
            "people_name": "陈铭峰",
            "people_sex": "男",
            "people_cardtype": "居民身份证",
            "people_cardnum": "4301031973******39"
        },
        {
            "people_id": 2869,
            "register_type": [
                "一级注册建造师",
                "一级注册建造师"
            ],
            "register_major": [
                "机电工程",
                "建筑工程"
            ],
            "register_unit": [
                "中建五局安装工程有限公司",
                "中建五局安装工程有限公司"
            ],
            "register_date": [
                "2011年04月28日",
                "2011年04月28日"
            ],
            "people_name": "姜小敏",
            "people_sex": "男",
            "people_cardtype": "居民身份证",
            "people_cardnum": "4301031966******77"
        },
        {
            "people_id": 2944,
            "register_type": [
                "一级注册建造师",
                "一级注册建造师"
            ],
            "register_major": [
                "机电工程",
                "建筑工程"
            ],
            "register_unit": [
                "七冶建设集团有限责任公司",
                "七冶建设集团有限责任公司"
            ],
            "register_date": [
                "2013年04月29日",
                "2014年09月28日"
            ],
            "people_name": "李峰",
            "people_sex": "男",
            "people_cardtype": "居民身份证",
            "people_cardnum": "5225021969******14"
        },
        {
            "people_id": 3148,
            "register_type": [
                "一级注册建造师",
                "一级注册建造师"
            ],
            "register_major": [
                "建筑工程",
                "机电工程"
            ],
            "register_unit": [
                "七冶建设集团有限责任公司",
                "七冶建设集团有限责任公司"
            ],
            "register_date": [
                "2021年11月21日",
                "2021年11月21日"
            ],
            "people_name": "杨锴",
            "people_sex": "男",
            "people_cardtype": "居民身份证",
            "people_cardnum": "5201131977******30"
        },
        {
            "people_id": 3218,
            "register_type": [
                "一级注册建造师",
                "一级注册建造师"
            ],
            "register_major": [
                "机电工程",
                "建筑工程"
            ],
            "register_unit": [
                "山东寿光第一建筑有限公司",
                "山东寿光第一建筑有限公司"
            ],
            "register_date": [
                "2010年11月19日",
                "2015年09月25日"
            ],
            "people_name": "高承峰",
            "people_sex": "男",
            "people_cardtype": "居民身份证",
            "people_cardnum": "3723301973******7X"
        }
    ],
    "exe_time": "2.532941"
}
```

