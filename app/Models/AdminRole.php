<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminRole extends Model
{
    protected $table = 'admin_roles';

    protected $guarded = [];

    public function adminUser()
    {
        return $this->hasOne('App\Models\AdminUser', 'admin_role_id', 'id');
    }

    public function adminMenus()
    {
        return $this->belongsToMany('App\Models\AdminMenu', 'admin_role_menus', 'admin_role_id', 'admin_menu_id');
    }

    public function adminActions()
    {
        return $this->belongsToMany('App\Models\AdminAction', 'admin_role_actions', 'admin_role_id', 'admin_action_id');
    }

    public function getMenuIds()
    {
        return $this['adminMenus']->pluck('id')->toArray();
    }

    public function getActionIds()
    {
        return $this['adminActions']->pluck('id')->toArray();
    }

    public function getValidator(Request $request, $type)
    {
        $validator = Validator::make($request->input('data'), [
            'name' => 'required',
            'desp' => 'required',
            'sort' => 'required|integer'
        ], [
            'name.required' => '名称必填',
            'desp.required' => '描述必填',
            'sort.required' => '排序必填',
            'sort.integer' => '排序必须为大于等于0的整数',
        ]);
        if($request->input('data')['sort'] < 0) {
            $validator->errors()->add('sort', '排序必须为大于等于0的整数');
        }
        return $validator;
    }

    public function getMenuPermissionOptions()
    {
        $first_menus = AdminMenu::where('fa_id', 0)->orderBy('sort')->get();
        $items = collect();
        foreach($first_menus as $menu) {
            $items->push($menu);
            $second_menus = AdminMenu::where('fa_id', $menu->id)->orderBy('sort')->get();
            foreach ($second_menus as $second_menu) {
                $second_menu->name = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $second_menu->name;
            }
            $items = $items->concat($second_menus);
        }
        return $items;
    }

    public function getActionPermissionOptions()
    {
        return AdminAction::select(['id', 'name'])->get();
    }

    public function updateMenusAndActions(Request $request)
    {
        AdminRoleMenu::where('admin_role_id', $this['id'])->delete();
        if($request->has('menuPermissions') && is_array($request->input('menuPermissions'))) {
            foreach($request->input('menuPermissions') as $menu_id) {
                AdminRoleMenu::create([
                    'admin_role_id' => $this['id'],
                    'admin_menu_id' => $menu_id,
                ]);
            }
        }
        AdminRoleAction::where('admin_role_id', $this['id'])->delete();
        if($request->has('actionPermissions') && is_array($request->input('actionPermissions'))) {
            foreach($request->input('actionPermissions') as $action_id) {
                AdminRoleAction::create([
                    'admin_role_id' => $this['id'],
                    'admin_action_id' => $action_id,
                ]);
            }
        }
    }
}
