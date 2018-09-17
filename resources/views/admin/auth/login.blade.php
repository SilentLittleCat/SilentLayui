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
        .silent-layui-app {
            background-color: #393d49;
        }
        .login-container {
            padding-top: 180px;
        }
        .login-header {
            text-align: center;
            font-size: 1.2rem;
            padding: 12px 0;
            color: #1a95fb;
        }
        .layui-form-item.has-error {
            color: #FF5722;
        }
        .layui-form-item.has-error input {
            border-color: #FF5722;
        }
        .login-card {
            margin: 0 50px;
        }
        .login-form {
            padding: 0 20px;
        }
    </style>
</head>

<body>

<div class="silent-layui-app">
    <div class="layui-container login-container">
        <div class="layui-row">
            <div class="layui-col-md6 layui-col-md-offset3">
                <div class="layui-card login-card">
                    <div class="layui-card-header login-header">管理员登录</div>
                    <div class="layui-card-body">
                        <form class="layui-form login-form" method="POST" action="/admin/login">

                            {{ csrf_field() }}
                            <div class="layui-form-item {{ $errors->has('phone') ? 'has-error' : '' }}">
                                <input type="text" name="phone" placeholder="请输入手机号" autocomplete="off" class="layui-input" required>
                                @if($errors->has('phone'))
                                    <span class="help-block">{{ $errors->first('phone') }}</span>
                                @endif
                            </div>
                            <div class="layui-form-item {{ $errors->has('password') ? 'has-error' : '' }}">
                                <input type="password" name="password" placeholder="请输入密码" autocomplete="off" class="layui-input" required>
                                @if($errors->has('password'))
                                    <span class="help-block">{{ $errors->first('password') }}</span>
                                @endif
                            </div>
                            <div class="layui-form-item">
                                <button class="layui-btn layui-btn-normal layui-btn-fluid">登录</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="/plugins/jquery/jquery-3.3.1.min.js"></script>
<script src="/plugins/layui/layui.all.js"></script>
<script type="text/javascript">
    $(function () {
        $('.silent-layui-app').css('height', window.innerHeight);
    })
</script>
</body>

</html>