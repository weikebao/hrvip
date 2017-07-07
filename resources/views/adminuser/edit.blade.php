@extends('layout.layout')
@section('con')
    <div class="mws-panel grid_8">
        <div class="mws-panel-header">
            <span>修改管理员</span>
        </div>
        <div class="mws-panel-body no-padding">
            <form class="mws-form" action="/admin/user/edits?action=edits" >
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <input type="hidden" name="id" value="{{$res['id']}}">
                <div class="mws-form-inline">
                    <div class="mws-form-row">
                        <label class="mws-form-label">管理员姓名</label>
                        <div class="mws-form-item">
                            <input type="text" class="medium" required value="{{$res['name']}}" disabled>
                        </div>
                    </div>
                    <div class="mws-form-row">
                        <label class="mws-form-label">管理模块</label>
                        <div class="mws-form-item">
                            <input type="text" class="medium"  required value="@foreach($mokuai as $v){{$v['mname']}} |||@endforeach
                            " disabled>
                        </div>
                    </div>
                    <div class="mws-form-row">
                        <table class="mws-table">
                            <thead>
                                <tr>
                                    <th class="checkbox-column">
                                        <input type="checkbox">
                                    </th>
                                    <th>管理模块ID</th>
                                    <th>管理模块名称</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($mokuais as $val)
                                <tr>
                                    <td class="checkbox-column">
                                        <input type="checkbox" name="duo[]" value="{{$val['mid']}}">
                                    </td>
                                    <td>{{$val['mid']}}</td>
                                    <td>{{$val['mname']}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mws-button-row">
                        <input type="submit" value="点击提交" class="btn btn-danger">
                        {{--<input type="reset" value="重置" class="btn ">--}}
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection