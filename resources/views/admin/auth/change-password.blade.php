@extends('admin.layout-content')

@section('header')
    <style>

    </style>
@endsection

@section('content')
    <div class="layui-card">
        <div class="layui-card-header sg-card-header">修改密码</div>
        <div class="layui-card-body">
            <form class="layui-form layui-container" method="POST" action="/admin/change-password">

                {{ csrf_field() }}
                <input type="hidden" name="id" value="{{ Auth::guard('admin')->user()->id }}">
                <div class="layui-form-item layui-col-sm8 layui-col-sm-offset2 {{ $errors->has('password') ? 'has-error' : '' }}">
                    <label class="layui-form-label">新密码</label>
                    <div class="layui-input-block">
                        <input type="password" name="password" placeholder="请输入密码" autocomplete="off" class="layui-input" required lay-verify="required">
                        @if($errors->has('password'))
                            <span class="help-block">{{ $errors->first('password') }}</span>
                        @endif
                    </div>
                </div>
                <div class="layui-form-item layui-col-sm8 layui-col-sm-offset2 {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
                    <label class="layui-form-label">重复密码</label>
                    <div class="layui-input-block">
                        <input type="password" name="password_confirmation" placeholder="请再次输入密码" autocomplete="off" class="layui-input" required lay-verify="required">
                        @if($errors->has('password_confirmation'))
                            <span class="help-block">{{ $errors->first('password_confirmation') }}</span>
                        @endif
                    </div>
                </div>
                <div class="layui-form-item layui-col-sm-offset2">
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