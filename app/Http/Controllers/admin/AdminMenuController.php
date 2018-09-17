<?php

namespace App\Http\Controllers\Admin;

use App\Models\AdminMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminMenuController extends BaseController
{
    protected $model;

    protected $category;

    protected $model_name = '菜单';

    protected $pre_uri = '/admin/admin-menus/';

    protected $view_path = 'admin.admin-menus.';

    protected $redirect_index = '/admin/admin-menus/index';

    public function __construct()
    {
        $this->model = new AdminMenu();
    }

    public function index()
    {
        list($model, $model_name, $pre_uri) = array($this->model, $this->model_name, $this->pre_uri);
        return view($this->view_path . 'index', compact('model', 'model_name','pre_uri'));
    }

    public function get()
    {
        $first_menus = $this->model->where('fa_id', 0)->orderBy('sort')->get();
        $items = collect();
        foreach($first_menus as $menu) {
            $menu->show = $menu->getShowLabel();
            $items->push($menu);
            $second_menus = $this->model->where('fa_id', $menu->id)->orderBy('sort')->get();
            foreach ($second_menus as $second_menu) {
                $second_menu->name = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $second_menu->name;
                $second_menu->show = $second_menu->getShowLabel();
            }
            $items = $items->concat($second_menus);
        }

        return response()->json(['code' => 0, 'message' => '', 'count' => $items->count(), 'data' => $items]);
    }

    public function create()
    {
        list($model, $model_name, $pre_uri) = array($this->model, $this->model_name, $this->pre_uri);
        return view($this->view_path . 'create', compact('model', 'model_name','pre_uri'));
    }

    public function store(Request $request)
    {
        if(empty($request->input('data')) || !is_array($request->input('data'))) return back()->withErrors(['sg_error_info' => '数据错误']);
        $validator = $this->model->getValidator($request, 'store');
        if($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $res = $this->model->create($request->input('data'));
        if(empty($res)) return back()->withErrors(['sg_error_info' => '保存失败']);
        return redirect($this->pre_uri . 'create')->with(['sg_success_info' => '创建成功']);
    }

    public function edit(Request $request)
    {
        if(empty($request->input('id')) || empty($item = $this->model->find($request->input('id')))) return back()->withErrors(['sg_error_info' => '找不到要编辑的数据']);
        list($model, $model_name, $pre_uri) = array($this->model, $this->model_name, $this->pre_uri);
        return view($this->view_path . 'edit', compact('model', 'model_name', 'pre_uri', 'item'));
    }

    public function update(Request $request)
    {
        if(empty($request->input('id')) || empty($item = $this->model->find($request->input('id')))) return back()->withErrors(['sg_error_info' => '找不到要编辑的数据']);
        if(empty($request->input('data')) || !is_array($request->input('data'))) return back()->withErrors(['sg_error_info' => '数据错误']);
        $validator = $this->model->getValidator($request, 'update');
        if($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $res = $this->model->where('id', $request->input('id'))->update($request->input('data'));
        if(!$res) return back()->withErrors(['sg_error_info' => '数据库保存失败！']);
        return back()->with(['sg_success_info' => '编辑成功']);
    }

    public function delete(Request $request)
    {
        if(empty($request->input('id')) || empty($item = $this->model->find($request->input('id')))) return response()->json(['status' => 'fail', 'info' => '找不到要删除的数据']);
        $this->model->where('fa_id', $item->id)->delete();
        $res = $item->delete();
        if (!$res) return response()->json(['status' => 'fail', 'info' => '删除失败']);
        return response()->json(['status' => 'success', 'info' => '操作成功']);
    }

    public function deleteMany(Request $request)
    {
        if(empty($request->input('ids'))) return response()->json(['status' => 'fail', 'info' => '数据错误']);
        $ids = json_decode($request->input('ids'));
        if(!is_array($ids)) return response()->json(['status' => 'fail', 'info' => '数据错误']);
        $this->model->whereIn('fa_id', $ids)->delete();
        $res = $this->model->whereIn('id', $ids)->delete();
        if (!$res) return response()->json(['status' => 'fail', 'info' => '删除失败']);
        return response()->json(['status' => 'success', 'info' => '操作成功']);
    }
}
