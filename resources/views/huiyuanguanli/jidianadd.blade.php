<!-- @extends('layout.layout') -->
@section('con')
    <div class="mws-panel grid_8">
        <div class="mws-panel-header">
            <span>添加基点会员</span>
        </div>
        <div class="mws-panel-body no-padding">
            <form class="mws-form" method="post" action="/admin/tuihuiyuan/jidianadds" >
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <div class="mws-form-inline">
                    <div class="mws-form-row">
                        <label class="mws-form-label">会员姓名</label>
                        <div class="mws-form-item">
                            <input type="text" class="medium" name='name' required value="">
                        </div>
                    </div>
                    <div class="mws-form-row">
                        <label class="mws-form-label">会员账号(手机号)</label>
                        <div class="mws-form-item">
                            <input type="text" class="medium" name='phone' required value="">
                        </div>
                    </div>
                    <div class="mws-form-row">
                        <label class="mws-form-label">会员密码</label>
                        <div class="mws-form-item">
                            <input type="text" class="medium" name='pass' required value="">
                        </div>
                    </div>
                    
                    <div class="mws-form-row bordered">
                        <label class="mws-form-label">会员的性质</label>
                        <div class="mws-form-item">
                            <select class="small jidian" name="jidian">
                                <option value="1">公司会员(不可更换)
                                <option value="2">
                                公司会员(可更换)
                            </select>
                        </div>
                    </div>
                    <div class="mws-button-row">
                        <input type="submit" value="点击提交" class="btn btn-danger">
                        
                        <a href="/admin/tuihuiyuan/index" style="color:red;border:1px solid;margin-left:150px;">返回首页</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection