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
