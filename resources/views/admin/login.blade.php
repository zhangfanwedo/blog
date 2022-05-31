<!doctype html>
<html  class="x-admin-sm">
<head>
	<meta charset="UTF-8">
	<title>后台登录-X-admin2.2</title>
	<meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />

    @include('admin.public.styles')
    @include('admin.public.script')

</head>
<body class="login-bg">

    <div class="login layui-anim layui-anim-up">
        <div class="message">后台管理登录</div>
        <div id="darkbannerwrap"></div>

        <form method="post" class="layui-form" action="{{url('/admin/doLogin')}}">
        @csrf
            <input name="username" placeholder="用户名"  type="text" lay-verify="required" class="layui-input" >
            <hr class="hr15">
            <input name="password" lay-verify="required" placeholder="密码"  type="password" class="layui-input">
            <hr class="hr15">
            <input name="captcha" type="text" placeholder="验证码">
            <hr class="hr10">
            <img src="/code/captcha" alt="验证码" id="code" onclick="my_captcha(this);return false;">
            <li>不区分大小写</li>
            <hr class="hr20">
            {{-- <input type="submit" value="提交"> --}}
            <input value="登录" lay-submit lay-filter="login" style="width:100%;" type="submit">
            <hr class="hr20" >
        </form>
        @if (count($errors)>0)
            <div class="alert alert-danger">
                <ul>
                    @if(is_object($errors))
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                    @else
                        <li>{{$errors}}</li>
                    @endif
                </ul>
            </div>
        @endif
    </div>

    <!-- 提交按钮 -->
    <script>
        $(function  () {
            layui.use('form', function(){
              var form = layui.form;
              // layer.msg('玩命卖萌中', function(){
              //   //关闭后的操作
              //   });
              //监听提交
            //   form.on('submit(login)', function(data){
            //     //alert(888)
            //     layer.msg(JSON.stringify(data.field),function(){
            //         location.href='/admin/doLogin/'
            //     });
            //     return false;
            //   });
            });
        })
    </script>

    <!-- 底部结束 -->
    <script>
        //百度统计可去掉
        var _hmt = _hmt || [];
        (function() {
        var hm = document.createElement("script");
        hm.src = "https://hm.baidu.com/hm.js?b393d153aeb26b46e9431fabaf0f6190";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(hm, s);
        })();
    </script>

    <!-- 点击验证码更换图片 -->
    <script type="text/javascript">
        function my_captcha(obj){
        //更换地址
        obj.src='/code/captcha?code='+Math.random();
        }
    </script>






</body>
</html>
