<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">email</div>

                <div class="panel-body">
					你好!<br/>
					感谢你注册平台。 <br/>
					你的登录邮箱为：<?php echo $user->email; ?>。请点击以下链接激活帐号：<br/>
					<a href="{{url('/user/activateemail')}}?email=<?php echo $user->email; ?>&code={{$code}}">{{url('/user/activateemail')}}?email=<?php echo $user->email; ?>&code={{$code}}</a><br/>
					如果以上链接无法点击，请将上面的地址复制到你的浏览器(如IE)的地址栏进入平台。
                </div>
            </div>
        </div>
    </div>
</div>