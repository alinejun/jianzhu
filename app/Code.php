<?php
/**
 * Created by PhpStorm.
 * User: zhj
 * Date: 2019/1/31
 * Time: 18:23
 */
namespace app;
class Code{
    const
        SUCCESS                          = 1,
        ERROR                            = 0
    ;

    public static $MSG =[
        self::SUCCESS                       =>  '成功',
        self::ERROR                       =>  '失败',
    ];
}