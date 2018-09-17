<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Validator;

class AdminUser extends Authenticatable
{
    use Notifiable;

    protected $table = 'admin_users';

    protected $guarded = [];

    public function getValidator(Request $request, $type)
    {
        if($type == 'store') {
            $validator = Validator::make($request->input('data'), [
                'username' => 'required',
                'phone' => 'required|unique:admin_users',
                'password' => 'required|min:6'
            ], [
                'username.required' => '名称必填',
                'phone.required' => '手机必填',
                'phone.unique' => '手机已存在',
                'password.required' => '密码必填',
                'password.min' => '密码不能少于6位',
            ]);
        } else {
            $validator = Validator::make($request->input('data'), [
                'username' => 'required',
                'phone' => 'required'
            ], [
                'username.required' => '名称必填',
                'phone.required' => '手机必填'
            ]);

            $tmp = $this->where([
                ['id', '<>', $request->input('id')],
                ['phone', '', $request->input('data')['phone']],
            ])->first();
            if(!empty($tmp)) {
                $validator->errors()->add('phone', '手机已存在');
                return $validator;
            }
            if($request->input('update_password') == 1 && strlen($request->input('password')) < 6) {
                $validator->errors()->add('password', '密码不能少于6位');
                return $validator;
            }
        }
        return $validator;
    }

    public function adminRole()
    {
        return $this->belongsTo('App\Models\AdminRole', 'admin_role_id', 'id');
    }

    public function getAdminRoleName()
    {
        return empty($this['adminRole']) ? '' : $this['adminRole']['name'];
    }

    public function getAdminRoleOptions()
    {
        return AdminRole::orderBy('sort')->select(['id', 'name'])->get()->toArray();
    }

    public function getAdminMenus()
    {
        $admin_role = $this['adminRole'];
        if(empty($admin_role)) return collect();
        $menus = $admin_role->adminMenus()->where('show', 1)->get();
        $items = $menus->where('fa_id', 0);
        foreach($items as $item) {
            $item->second_menus = $menus->where('fa_id', $item->id);
        }
        return $items;
    }

    public function checkMenuPermission(Request $request)
    {
        $url = substr($request->url(), strlen(url('/')));
        if(empty($url) || empty($admin_menu = AdminMenu::where('link', $url)->first())) return true;
        if(empty($this['admin_role_id'])) return false;
        $tmp = AdminRoleMenu::where([
            ['admin_role_id', '=', $this['admin_role_id']],
            ['admin_menu_id', '=', $admin_menu->id],
        ])->first();
        return empty($tmp) ? false : true;
    }
}
