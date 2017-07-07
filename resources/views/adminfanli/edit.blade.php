@extends('layout.layout')
@section('con')
    <div class="mws-panel grid_8">
        <div class="mws-panel-header">
            <span>返利要求修改</span>
        </div>
        <div class="mws-panel-body no-padding">
            <form class="mws-form" method = "post" action="/admin/fanli/edits" >
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <input type="hidden" name="id" value="{{$res['fanliid']}}">
                <div class="mws-form-inline">
                    <div class="mws-form-row">
                        <label class="mws-form-label">返利职位名称</label>
                        <div class="mws-form-item">
                            <input type="text" class="medium" name='name' required value="{{$res['fanliname']}}">
                        </div>
                    </div>
                    <div class="mws-form-row">
                        <label class="mws-form-label">返利金额</label>
                        <div class="mws-form-item">
                            <input type="text" class="medium" name='free' required value="{{$res['fanlimoney']}}">
                        </div>
                    </div>
                    <div class="mws-form-row">
                        <label class="mws-form-label">部门一要求</label>
                        <div class="mws-form-item">
                            <input type="text" class="medium" name='bumenyi' required value="{{$res['bumenyi']}}">
                        </div>
                    </div>
                    <div class="mws-form-row">
                        <label class="mws-form-label">部门二要求</label>
                        <div class="mws-form-item">
                            <input type="text" class="medium" name='bumener' required value="{{$res['bumener']}}">
                        </div>
                    </div>
                    <div class="mws-form-row">
                        <label class="mws-form-label">部门三要求</label>
                        <div class="mws-form-item">
                            <input type="text" class="medium" name='bumensan' required value="{{$res['bumensan']}}">
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