<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminMenu extends Model
{
    protected $table = 'admin_menus';

    protected $guarded = [];

    public function getFatherMenuOptions()
    {
        $items = collect([0 => ['id' => 0, 'name' => '顶级分类']]);
        $first_menus = $this->where('fa_id', 0)->select(['id', 'name'])->orderBy('sort')->get()->toArray();
        return $items->concat($first_menus);
    }

    public function getValidator(Request $request, $type)
    {
        $validator = Validator::make($request->input('data'), [
            'name' => 'required',
            'link' => 'required',
            'show' => 'required|in:1,2',
            'fa_id' => 'required|integer|min:0',
            'sort' => 'required|integer|min:0',
        ], [
            'name.required' => '名称必填',
            'icon.required' => '图标必填',
            'link.required' => '链接必填',
            'show.required' => '显示必填',
            'show.in' => '显示参数错误',
            'fa_id.required' => '父菜单必填',
            'fa_id.integer' => '父菜单参数错误',
            'fa_id.min' => '父菜单参数错误',
            'sort.required' => '排序必填',
            'sort.integer' => '排序必须为0或正整数',
            'sort.min' => '排序必须为0或正整数',
        ]);
        return $validator;
    }

    public function getShowLabel()
    {
        return $this['show'] == 1 ? '<span class="layui-badge layui-bg-green">是</span>' : '<span class="layui-badge layui-bg-red">否</span>';
    }
}
