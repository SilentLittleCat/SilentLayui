<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" type="image/png" sizes="16x16" href="/images/icons/SL-icon.png">
    <title>后台管理</title>

    <link rel="stylesheet" href="/plugins/layui/css/layui.css">

    <style>
        .layui-layout-admin .layui-logo {
            font-family: "Courier New", Courier, monospace;
            color: white;
            font-weight: bold;
        }
        .silent-layui-container.layui-layout-admin .layui-body {
            bottom: 0;
        }
        .silent-layui-container .layui-body {
            background-color: #f2f2f2;
            overflow: hidden;
        }
    </style>
</head>

<body class="layui-layout-body">

<div class="layui-layout layui-layout-admin silent-layui-container">
    <div class="layui-header">
        <div class="layui-logo">Silent Layui</div>
        <ul class="layui-nav layui-layout-right">
            <li class="layui-nav-item">
                <a href="javascript:;">
                    <img src="/images/avatars/avatar.png" class="layui-nav-img">
                    {{ Auth::guard('admin')->user()->username }}
                </a>
                <dl class="layui-nav-child" id="sg-header-actions">
                    <dd><a href="/admin/change-password" class="sg-change-password">修改密码</a></dd>
                    <dd><a href="/admin/logout" class="sg-logout">退出登录</a></dd>
                </dl>
            </li>
        </ul>
    </div>

    <div class="layui-side layui-bg-black silent-layui-sidebar">
        <div class="layui-side-scroll">
            <ul class="layui-nav layui-nav-tree">
                @foreach(Auth::guard('admin')->user()->getAdminMenus() as $first_menu)
                    <li class="layui-nav-item">
                        <a class="" href="#"><i class="{{ $first_menu->icon }}"></i> {{ $first_menu->name }}</a>
                        <dl class="layui-nav-child">
                            @foreach($first_menu->second_menus as $second_menu)
                                <dd><a href="{{ $second_menu->link }}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $second_menu->name }}</a></dd>
                            @endforeach
                        </dl>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="layui-body">
        <iframe id="main-iframe" src="/admin/index/welcome" frameborder="0" width="100%"></iframe>
    </div>

    <form id="sg-logout-form" action="/admin/logout" method="POST">

        {{ csrf_field() }}
    </form>
</div>

<script src="/plugins/jquery/jquery-3.3.1.min.js"></script>
<script src="/plugins/layui/layui.js"></script>
<script type="text/javascript">
    $(function () {
        function stopDefault( e )
        {
            if ( e && e.preventDefault )
                e.preventDefault();
            else
                window.event.returnValue = false;
        }

        $('#main-iframe').css('height', window.innerHeight - 61);
        $(window).resize(function() {
            $('#main-iframe').css('height', window.innerHeight - 61);
        });

        layui.use('element');

        $('.silent-layui-sidebar').on('click', 'a', function (event) {
            stopDefault(event);

            var href = $(this).attr('href');
            if(href !== '#') {
                $('#main-iframe').attr('src', href);
            }
        });

        $('#sg-header-actions').on('click', '.sg-change-password', function () {
            event.preventDefault();
            $('#main-iframe').attr('src', $(this).attr('href'));
        }).on('click', '.sg-logout', function () {
            event.preventDefault();
            $('#sg-logout-form').submit();
        });
    })
</script>
</body>

</html>