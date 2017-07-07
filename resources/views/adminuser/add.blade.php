@extends('layout.layout')
@section('con')
    <div class="mws-panel grid_8">
        <div class="mws-panel-header">
            <span>添加管理员</span>
        </div>
        <div class="mws-panel-body no-padding">
            <form class="mws-form" action="/admin/user/adds?action=adds" >
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <div class="mws-form-inline">
                    <div class="mws-form-row">
                        <label class="mws-form-label">管理员姓名</label>
                        <div class="mws-form-item">
                            <input type="text" class="medium" name='name' required value="">
                        </div>
                    </div>
                    <div class="mws-form-row">
                        <label class="mws-form-label">管理员账号</label>
                        <div class="mws-form-item">
                            <input type="text" class="medium" name='phone' required value="">
                        </div>
                    </div>
                    <div class="mws-form-row">
                        <label class="mws-form-label">管理员密码</label>
                        <div class="mws-form-item">
                            <input type="text" class="medium" name='pass' required value="">
                        </div>
                    </div>

                    <div class="mws-button-row">
                        <input type="submit" value="点击提交" class="btn btn-danger">
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection