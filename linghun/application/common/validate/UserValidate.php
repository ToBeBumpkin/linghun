<?php

namespace app\common\validate;

use think\Validate;

class UserValidate extends Validate{
    protected $rule=[
        ['username','unique:user','用户已经存在']
    ];
}