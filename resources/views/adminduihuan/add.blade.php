@extends('layout.layout')
@section('con')
    <div class="mws-panel grid_8">
        <div class="mws-panel-header">
            <span>积分兑换比例</span>
        </div>
        <div class="mws-panel-body no-padding">
            <form class="mws-form" method="post" action="/admin/duihuan/adds" >
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <div class="mws-form-inline">
                    <div class="mws-form-row">
                        <label class="mws-form-label">积分数量</label>
                        <div class="mws-form-item">
                            <input type="text" class="medium" name='jifen' required value="">
                        </div>
                    </div>
                    <div class="mws-form-row">
                        <label class="mws-form-label">抵消金额</label>
                        <div class="mws-form-item">
                            <input type="text" class="medium" name='money' required value="">
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