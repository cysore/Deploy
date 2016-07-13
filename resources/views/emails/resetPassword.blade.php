<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">reset email</div>

                <div class="panel-body">
					亲爱的liujun: <br/>
					点击以下链接完成重置密码，如不是本人操作，请忽略，谢谢！ <br/>
					<a href="{{url('/FindPass/ResetPassword')}}?id=<?php echo $user->id; ?>&token={{$token}}">{{url('/FindPass/ResetPassword')}}?id=<?php echo $user->id; ?>&token={{$token}}</a><br/>
					如果以上链接无法点击，请将上面的地址复制到你的浏览器(如IE)的地址栏进行密码重置！
                </div>
            </div>
        </div>
    </div>
</div>