@extends('admin.layout-content')

@section('header')
    <style>

    </style>
@endsection

@section('content')
    <div class="layui-card">
        <div class="layui-card-header sg-card-header">
            {{ $model_name . '列表' }}
            <div class="sg-card-create">
                <button id="sg-create-btn" class="layui-btn layui-btn-sm">创建{{ $model_name }}</button>
            </div>
        </div>
        <div class="layui-card-body">
            <div class="layui-btn-group" id="sg-table-top-container">
                <button class="layui-btn layui-btn-sm layui-btn-danger btn-delete-many">批量删除</button>
            </div>
            <table id="sg-main-table" class="layui-hide" lay-filter="tableEvent"></table>
            <script type="text/html" id="sg-table-bar">
                <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
                <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="delete">删除</a>
            </script>
        </div>
    </div>
@endsection

@section('footer')
    <script>
        $(function () {
            layui.use(['table', 'layer'], function(){
                var table = layui.table,
                    layer = layui.layer,
                    top_window = window;

                table.render({
                    elem: '#sg-main-table',
                    url: '{{ $pre_uri }}' + 'get',
                    cellMinWidth: 80,
                    cols: [[
                        { type:'checkbox' },
                        { field:'username', title: '用户名', align: 'center' },
                        { field:'phone', title: '手机', align: 'center' },
                        { field:'admin_role_name', title: '角色', align: 'center' },
                        { title: '操作', align:'center', toolbar: '#sg-table-bar' }
                    ]],
                    page: {
                        layout: ['count', 'prev', 'page', 'next', 'skip', 'refresh'],
                        limit: 15
                    },
                    even: true
                });
                table.on('tool(tableEvent)', function(obj){
                    var data = obj.data;
                    if(obj.event === 'delete'){
                        layer.confirm('确定要删除吗？', function(index) {
                            $.ajax({
                                method: 'POST',
                                url: '{{ $pre_uri }}' + 'delete',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                data: {
                                    id: data.id
                                },
                                success: function (data) {
                                    if(data.status === 'success') {
                                        obj.del();
                                    } else {
                                        layer.msg(data.info, {
                                            icon: 2
                                        });
                                    }
                                    layer.close(index);
                                },
                                error: function () {
                                    layer.close(index);
                                    layer.msg('删除失败', {
                                        icon: 2
                                    });
                                }
                            });
                        });
                    } else if(obj.event === 'edit') {
                        layer.open({
                            title: '编辑' + '{{ $model_name }}',
                            type: 2,
                            area: ['90%', '90%'],
                            content: '{{ $pre_uri }}' + 'edit?id=' + data.id,
                            end: function () {
                                top_window.location.reload();
                            }
                        });
                    }
                });

                $('#sg-create-btn').on('click', function () {
                    layer.open({
                        title: '创建' + '{{ $model_name }}',
                        type: 2,
                        area: ['90%', '90%'],
                        content: '{{ $pre_uri }}' + 'create',
                        end: function () {
                            top_window.location.reload();
                        }
                    });
                });

                $('#sg-table-top-container').on('click', '.btn-delete-many', function () {
                    layer.confirm('确定要删除所有选中行吗？', function () {
                        var data = table.checkStatus('sg-main-table').data;
                        if(data.length <= 0) {
                            layer.msg('选择不能为空', {
                                icon: 2
                            });
                            return false;
                        }
                        var ids = [];
                        for(var i = 0; i < data.length; ++i) {
                            ids.push(data[i]['id']);
                        }
                        $.ajax({
                            method: 'POST',
                            url: '{{ $pre_uri }}' + 'deleteMany',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            data: {
                                ids: JSON.stringify(ids)
                            },
                            success: function (data) {
                                if(data.status === 'success') {
                                    top_window.location.reload();
                                } else {
                                    layer.msg(data.info, {
                                        icon: 2
                                    });
                                }

                            },
                            error: function () {
                                layer.msg('删除失败', {
                                    icon: 2
                                });
                            }
                        });
                    })
                });
            });
        })
    </script>
@endsection