<?php
namespace app\common\validate;

use think\Validate;

class ManagerLoginValidate extends Validate{
    protected $rule=[
        ['username','require','用户名不能为空'],
        ['password', 'require', '密码不能为空'],
        ['code', 'require', '验证码不能为空']
    ];
}