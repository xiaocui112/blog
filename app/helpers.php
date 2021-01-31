<?php
// 辅助函数文件
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

/**
 * 获取当前路由名
 *
 * @return string
 */
function route_class(): string
{
    return str_replace('.', '-', Route::currentRouteName());
}
/**
 * 判断是否是指定的路由与参数
 *
 * @param string $routname
 * @param string $parm
 * @param integer $value
 * @return string
 */
function urlActivePar(string $routname, string $parm, int $value): string
{
    return active_class((if_route($routname) && if_route_param($parm, $value)), "active click-bottom-style");
}
/**
 * 是否符合指定路由
 *
 * @param string $routname
 * @return string
 */
function urlActive(string $routname): string
{
    return active_class(if_route($routname), "active click-bottom-style");
}
/**
 * 截取长度,html标签是被转为空
 *
 * @param string $value
 * @param integer $length
 * @return string
 */
function make_excerpt(string $value, int $length = 200): string
{
    $excerpt = trim(preg_replace('/\r\n|\r|\n+/', '', strip_tags($value)));
    return Str::limit($excerpt, $length);
}
