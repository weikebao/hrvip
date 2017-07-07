@extends('layout.layout')
@section('con')
    <div class="mws-panel grid_8">
        <div class="mws-panel-header">
            <span>返利要求添加</span>
        </div>
        <div class="mws-panel-body no-padding">
            <form class="mws-form" action="/admin/fanli/adds" >
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <div class="mws-form-inline">
                    <div class="mws-form-row">
                        <label class="mws-form-label">返利职位名称</label>
                        <div class="mws-form-item">
                            <input type="text" class="medium" name='name' required value="">
                        </div>
                    </div>
                    <div class="mws-form-row">
                        <label class="mws-form-label">返利金额</label>
                        <div class="mws-form-item">
                            <input type="text" class="medium" name='free' required value="">
                        </div>
                    </div>
                    <div class="mws-form-row">
                        <label class="mws-form-label">部门一要求</label>
                        <div class="mws-form-item">
                            <input type="text" class="medium" name='bumenyi' required value="">
                        </div>
                    </div>
                    <div class="mws-form-row">
                        <label class="mws-form-label">部门二要求</label>
                        <div class="mws-form-item">
                            <input type="text" class="medium" name='bumener' required value="">
                        </div>
                    </div>
                    <div class="mws-form-row">
                        <label class="mws-form-label">部门三要求</label>
                        <div class="mws-form-item">
                            <input type="text" class="medium" name='bumensan' required value="">
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