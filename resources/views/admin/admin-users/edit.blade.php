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
                <div class="layui-form-item {{ $errors->has('username') ? 'has-error' : '' }}">
                    <label class="layui-form-label">用户名</label>
                    <div class="layui-input-block">
                        <input type="text" name="data[username]" value="{{ isset(old('data')['username']) ? old('data')['username'] : $item->username }}" required lay-verify="required" placeholder="请输入用户名" autocomplete="off" class="layui-input">
                        @if($errors->has('username'))
                            <span class="help-block">{{ $errors->first('username') }}</span>
                        @endif
                    </div>
                </div>
                <div class="layui-form-item {{ $errors->has('phone') ? 'has-error' : '' }}">
                    <label class="layui-form-label">手机</label>
                    <div class="layui-input-block">
                        <input type="text" name="data[phone]" value="{{ isset(old('data')['phone']) ? old('data')['phone'] : $item->phone }}" required lay-verify="required" placeholder="请输入手机" autocomplete="off" class="layui-input">
                        @if($errors->has('phone'))
                            <span class="help-block">{{ $errors->first('phone') }}</span>
                        @endif
                    </div>
                </div>
                <div class="layui-form-item {{ $errors->has('update_password') ? 'has-error' : '' }}">
                    <label class="layui-form-label">更新密码</label>
                    <div class="layui-input-block">
                        <input type="radio" name="update_password" value="1" title="是">
                        <input type="radio" name="update_password" value="2" title="否" checked>
                    </div>
                </div>
                <div class="layui-form-item {{ $errors->has('password') ? 'has-error' : '' }}">
                    <label class="layui-form-label">密码</label>
                    <div class="layui-input-block">
                        <input type="password" name="password" placeholder="请输入密码" autocomplete="off" class="layui-input">
                        @if($errors->has('password'))
                            <span class="help-block">{{ $errors->first('password') }}</span>
                        @endif
                    </div>
                </div>
                <div class="layui-form-item {{ $errors->has('admin_role_id') ? 'has-error' : '' }}">
                    <label class="layui-form-label">角色</label>
                    <div class="layui-input-block">
                        <select name="data[admin_role_id]" required lay-verify="required">
                            @foreach($model->getAdminRoleOptions() as $value)
                                <option value="{{ $value['id'] }}" {{ $item->admin_role_id == $value['id'] ? 'selected' : '' }}>{{ $value['name'] }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('admin_role_id'))
                            <span class="help-block">{{ $errors->first('admin_role_id') }}</span>
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
                // var form = layui.form;

                // form.verify({
                //     integer: function (value) {
                //         var pattern = /^[1-9]\d*$/;
                //         if(!(pattern.test(value) || value === '0')) {
                //             return '排序必须为大于等于0的整数';
                //         }
                //     }
                // })
            });
        })
    </script>
@endsection