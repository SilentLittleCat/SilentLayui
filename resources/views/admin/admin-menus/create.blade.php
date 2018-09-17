@extends('admin.layout-content')

@section('header')
    <style>

    </style>
@endsection

@section('content')
    <div class="layui-container sg-create-container">
        <div class="layui-col-sm8 layui-col-sm-offset2">
            <form class="layui-form" method="POST" action="{{ $pre_uri . 'store' }}">

                {{ csrf_field() }}
                <div class="layui-form-item {{ $errors->has('fa_id') ? 'has-error' : '' }}">
                    <label class="layui-form-label">父菜单</label>
                    <div class="layui-input-block">
                        <select name="data[fa_id]" required lay-verify="required">
                            @foreach($model->getFatherMenuOptions() as $value)
                                <option value="{{ $value['id'] }}" {{ isset(old('data')['fa_id']) == $value['id'] ? 'selected' : '' }}>{{ $value['name'] }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('fa_id'))
                            <span class="help-block">{{ $errors->first('fa_id') }}</span>
                        @endif
                    </div>
                </div>
                <div class="layui-form-item {{ $errors->has('name') ? 'has-error' : '' }}">
                    <label class="layui-form-label">名称</label>
                    <div class="layui-input-block">
                        <input type="text" name="data[name]" value="{{ isset(old('data')['name']) ? old('data')['name'] : '' }}" required lay-verify="required" placeholder="请输入名称" autocomplete="off" class="layui-input">
                        @if($errors->has('name'))
                            <span class="help-block">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                </div>
                <div class="layui-form-item {{ $errors->has('icon') ? 'has-error' : '' }}">
                    <label class="layui-form-label">图标</label>
                    <div class="layui-input-block">
                        <input type="text" name="data[icon]" value="{{ isset(old('data')['icon']) ? old('data')['icon'] : '' }}" placeholder="请输入图标" autocomplete="off" class="layui-input">
                        @if($errors->has('icon'))
                            <span class="help-block">{{ $errors->first('icon') }}</span>
                        @endif
                    </div>
                </div>
                <div class="layui-form-item {{ $errors->has('link') ? 'has-error' : '' }}">
                    <label class="layui-form-label">链接</label>
                    <div class="layui-input-block">
                        <input type="text" name="data[link]" value="{{ isset(old('data')['link']) ? old('data')['link'] : '' }}" required lay-verify="required" placeholder="请输入链接" autocomplete="off" class="layui-input">
                        @if($errors->has('link'))
                            <span class="help-block">{{ $errors->first('link') }}</span>
                        @endif
                    </div>
                </div>
                <div class="layui-form-item {{ $errors->has('show') ? 'has-error' : '' }}">
                    <label class="layui-form-label">显示</label>
                    <div class="layui-input-block">
                        <input type="radio" name="data[show]" value="1" title="是" {{ (isset(old('data')['show']) && old('data')['show'] == 2) ? '' : 'checked' }}>
                        <input type="radio" name="data[show]" value="2" title="否" {{ (isset(old('data')['show']) && old('data')['show'] == 2) ? 'checked' : '' }}>
                        @if($errors->has('show'))
                            <span class="help-block">{{ $errors->first('show') }}</span>
                        @endif
                    </div>
                </div>
                <div class="layui-form-item {{ $errors->has('sort') ? 'has-error' : '' }}">
                    <label class="layui-form-label">排序</label>
                    <div class="layui-input-block">
                        <input type="number" name="data[sort]" value="{{ isset(old('data')['sort']) ? old('data')['sort'] : '' }}" required lay-verify="required|integer" placeholder="请输入排序（大于等于0的整数）" autocomplete="off" class="layui-input">
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