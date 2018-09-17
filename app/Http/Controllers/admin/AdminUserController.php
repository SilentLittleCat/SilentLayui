<?php

namespace App\Http\Controllers\Admin;

use App\Models\AdminUser;
use Illuminate\Http\Request;

class AdminUserController extends BaseController
{
    protected $model;

    protected $category;

    protected $model_name = '管理员';

    protected $pre_uri = '/admin/admin-users/';

    protected $view_path = 'admin.admin-users.';

    protected $redirect_index = '/admin/admin-users/index';

    public function __construct()
    {
        $this->model = new AdminUser();
    }

    public function index()
    {
        list($model, $model_name, $pre_uri) = array($this->model, $this->model_name, $this->pre_uri);
        return view($this->view_path . 'index', compact('model', 'model_name','pre_uri'));
    }

    public function get()
    {
        $items = $this->model->orderBy('updated_at', 'desc')->select(['id', 'username', 'phone', 'avatar', 'admin_role_id'])->get();

        foreach($items as $item) {
            $item->admin_role_name = $item->getAdminRoleName();
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
        $data = $request->input('data');
        $data['password'] = bcrypt($data['password']);
        $res = $this->model->create($data);
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
        $data = $request->input('data');
        if($request->input('update_password') == 1) {
            $data['password'] = bcrypt($request->input('password'));
        }
        $res = $this->model->where('id', $request->input('id'))->update($data);
        if(!$res) return back()->withErrors(['sg_error_info' => '数据库保存失败！']);
        return back()->with(['sg_success_info' => '编辑成功']);
    }

    public function delete(Request $request)
    {
        if(empty($request->input('id')) || empty($item = $this->model->find($request->input('id')))) return response()->json(['status' => 'fail', 'info' => '找不到要删除的数据']);
        $res = $item->delete();
        if (!$res) return response()->json(['status' => 'fail', 'info' => '删除失败']);
        return response()->json(['status' => 'success', 'info' => '操作成功']);
    }

    public function deleteMany(Request $request)
    {
        if(empty($request->input('ids'))) return response()->json(['status' => 'fail', 'info' => '数据错误']);
        $ids = json_decode($request->input('ids'));
        if(!is_array($ids)) return response()->json(['status' => 'fail', 'info' => '数据错误']);
        $res = $this->model->whereIn('id', $ids)->delete();
        if (!$res) return response()->json(['status' => 'fail', 'info' => '删除失败']);
        return response()->json(['status' => 'success', 'info' => '操作成功']);
    }
}
