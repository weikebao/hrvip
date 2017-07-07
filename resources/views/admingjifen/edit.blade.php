@extends('layout.layout')
@section('con')
    <div class="mws-panel grid_8">
        <div class="mws-panel-header">
            <span>返利积分设置</span>
        </div>
        <div class="mws-panel-body no-padding">
            <form class="mws-form" method="post" action="/admin/gjifen/edits" >
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <input type="hidden" name="fid" value="{{$res['fid']}}">
                <div class="mws-form-inline">
                    <div class="mws-form-row">
                        <label class="mws-form-label">返还积分商品名称</label>
                        <div class="mws-form-item">
                            <input type="text" class="medium" name='name' readonly="readonly" value="{{$res['name']}}====={{$res['property']}}">
                        </div>
                    </div>
                    <div class="mws-form-row">
                        <label class="mws-form-label">返还积分</label>
                        <div class="mws-form-item">
                            <input type="text" class="medium" name='point' required value="{{$res['return_points']}}">
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