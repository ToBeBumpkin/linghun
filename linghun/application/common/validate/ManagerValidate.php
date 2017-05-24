<?php

namespace app\common\validate;

use think\Validate;

class ManagerValidate extends Validate{
    protected $rule=[
        ['username','unique:manager','管理员已经存在']
    ];
}