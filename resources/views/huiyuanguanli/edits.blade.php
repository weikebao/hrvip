@extends('layout.layout')
@section('con')
    <div class="mws-panel grid_8">
        <div class="mws-panel-header">
            <span>更换会员信息</span>
        </div>
        <div class="mws-panel-body no-padding">
            <form class="mws-form" action="/admin/tuihuiyuan/genghuan" >
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <div class="mws-form-inline">
                    <div class="mws-form-row">
                        <label class="mws-form-label">新会员姓名</label>
                        <div class="mws-form-item">
                            <input type="text" class="medium" name='name'  value="">
                        </div>
                    </div>
                    <div class="mws-form-row">
                        <label class="mws-form-label">新会员账号(手机号)</label>
                        <div class="mws-form-item">
                            <input type="text" class="medium" name='phone'  value="">
                        </div>
                    </div>
                    <div class="mws-form-row">
                        <label class="mws-form-label">新会员密码</label>
                        <div class="mws-form-item">
                            <input type="text" class="medium" name='pass'  value="">
                        </div>
                    </div>
                    <div class="mws-form-row">
                        <label class="mws-form-label">新会员地址</label>
                        <div class="mws-form-item">
                            <input type="text" class="medium" name='address'  value="">
                        </div>
                    </div>
                    <div class="mws-form-row bordered">
                        <label class="mws-form-label">修改类型</label>
                        <div class="mws-form-item">
                            <select class="small jidian" name="jidian">
                                <option value="1">更换新会员
                                <option value="2">
                                更换信息
                            </select>
                        </div>
                    </div>
                    <input type="hidden" name="zuojiedian" value="{{$res['zuojiedian']}}">
                    <input type="hidden" name="zuoqujian" value="{{$res['zuoqujian']}}">
                    <input type="hidden" name="youjiedian" value="{{$res['youjiedian']}}">
                    <input type="hidden" name="youqujian" value="{{$res['youqujian']}}">
                    <input type="hidden" name="sanjiedian" value="{{$res['sanjiedian']}}">
                    <input type="hidden" name="sanqujian" value="{{$res['sanqujian']}}">
                    <input type="hidden" name="tuipath" value="{{$res['tuipath']}}">
                    <input type="hidden" name="id" value="{{$res['id']}}">
                    <input type="hidden" name="suoshu" value="{{$res['suoshu']}}">
                    <input type="hidden" name="free" value="{{$res['free']}}">
                    <input type="hidden" name="jidians" value="{{$res['jidian']}}">
                    <input type="hidden" name="huiyuanstatus" value="{{$res['huiyuanstatus']}}">
                    <input type="hidden" name="firstgoumai" value="{{$res['firstgoumai']}}">
                    <input type="hidden" name="status" value="{{$res['status']}}">
                    <input type="hidden" name="taiyangbi" value="{{$res['taiyangbi']}}">
                    <input type="hidden" name="jifen" value="{{$res['jifen']}}">
                    <input type="hidden" name="fanlileixing" value="{{$res['fanlileixing']}}">
                    <input type="hidden" name="fanliriqi" value="{{$res['fanliriqi']}}">
                    <input type="hidden" name="xiaofei" value="{{$res['xiaofei']}}">
                    <input type="hidden" name="money" value="{{$res['money']}}">
                    <div class="mws-button-row">
                        <input type="submit" value="点击提交" class="btn btn-danger">
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection