<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" type="image/png" sizes="16x16" href="/images/icons/SL-icon.png">
    <title>后台管理</title>

    <link rel="stylesheet" href="/plugins/layui/css/layui.css">
    <script src="/plugins/jquery/jquery-3.3.1.min.js"></script>

    <style>
        .silent-layout-content {
            padding: 15px 15px 0 15px;
        }
        .sg-card-header {
            color: #00b6ed;
            font-size: 1.1rem;
        }
        .sg-card-create {
            float: right;
            display: inline;
        }
        .layui-form-item.has-error {
            color: #FF5722;
        }
        .layui-form-item.has-error input {
            border-color: #FF5722;
        }
        .sg-create-container {
            margin-top: 50px;
        }
        .layui-form-item .sg-table-multi-select .layui-form-checkbox {
            margin-top: 0;
        }
        .sg-table-multi-select .layui-table {
            margin: 0;
            border-width: 0;
        }
        .sg-table-multi-select {
            width: 220px;
            height: 300px;
            overflow-y: scroll;
            border: 1px solid #e6e6e6;
        }
        .sg-table-multi-select::-webkit-scrollbar {
            display: none;
        }
    </style>
    @yield('header')
</head>

<body>

<div class="silent-layout-content">
    @yield('content')
</div>

<script src="/plugins/layui/layui.js"></script>
<script type="text/javascript">
    $(function () {
        layui.use(['element', 'layer'], function () {
            @if($errors->has('sg_error_info'))
                layer.msg("{{ $errors->first('sg_error_info') }}", {
                    icon: 2
                });
            @endif

            @if(session('sg_success_info'))
                layer.msg("{{ session('sg_success_info') }}", {
                    icon: 1
                });
            @endif
        });
    })
</script>
@yield('footer')
</body>

</html>