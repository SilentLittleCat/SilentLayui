@extends('admin.layout-content')

@section('header')
    <style>

    </style>
@endsection

@section('content')
    <div class="layui-container sg-create-container">
        <div class="layui-col-sm8 layui-col-sm-offset2">
            <form class="layui-form" method="POST" action="{{ $pre_uri . 'update' }}">

                {{ csrf_field() }}
                <input type="hidden" name="id" value="{{ $item->id }}">
                <div class="layui-form-item {{ $errors->has('name') ? 'has-error' : '' }}">
                    <label class="layui-form-label">名称</label>
                    <div class="layui-input-block">
                        <input type="text" name="data[name]" value="{{ isset(old('data')['name']) ? old('data')['name'] : $item->name }}" required lay-verify="required" placeholder="请输入名称" autocomplete="off" class="layui-input">
                        @if($errors->has('name'))
                            <span class="help-block">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                </div>
                <div class="layui-form-item {{ $errors->has('desp') ? 'has-error' : '' }}">
                    <label class="layui-form-label">描述</label>
                    <div class="layui-input-block">
                        <input type="text" name="data[desp]" value="{{ isset(old('data')['desp']) ? old('data')['desp'] : $item->desp }}" required lay-verify="required" placeholder="请输入描述" autocomplete="off" class="layui-input">
                        @if($errors->has('desp'))
                            <span class="help-block">{{ $errors->first('desp') }}</span>
                        @endif
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layout-inline">
                        <label class="layui-form-label">菜单权限</label>
                        <div class="layui-input-inline">
                            @include('shared.multi-select', ['id' => 'sg-menu-permissions', 'name' => 'menuPermissions[]',  'options' => $model->getMenuPermissionOptions(), 'selected_options' => $item->getMenuIds()])
                        </div>
                    </div>
                    <div class="layout-inline">
                        <label class="layui-form-label">操作权限</label>
                        <div class="layui-input-inline">
                            @include('shared.multi-select', ['id' => 'sg-action-permissions', 'name' => 'actionPermissions[]',  'options' => $model->getActionPermissionOptions(), 'selected_options' => $item->getActionIds()])
                        </div>
                    </div>
                </div>
                <div class="layui-form-item {{ $errors->has('sort') ? 'has-error' : '' }}">
                    <label class="layui-form-label">排序</label>
                    <div class="layui-input-block">
                        <input type="number" name="data[sort]" value="{{ isset(old('data')['sort']) ? old('data')['sort'] : $item->sort }}" required lay-verify="required|integer" placeholder="请输入排序（大于等于0的整数）" autocomplete="off" class="layui-input">
                        @if($errors->has('sort'))
                            <span class="help-block">{{ $errors->first('sort') }}</span>
                        @endif
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <button class="layui-btn" lay-submit lay-filter="formDemo">提交</button>
                        <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('footer')
    <script>
        $(function () {
            layui.use('form', function(){
                var form = layui.form;

                form.verify({
                    integer: function (value) {
                        var pattern = /^[1-9]\d*$/;
                        if(!(pattern.test(value) || value === '0')) {
                            return '排序必须为大于等于0的整数';
                        }
                    }
                })
            });
        })
    </script>
@endsection