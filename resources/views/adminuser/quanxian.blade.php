@extends('layout.layout')
@section('con')
    <div class="mws-panel grid_8">
        <div class="mws-panel-header">
            <span>管理员权限添加</span>
        </div>
        <div class="mws-panel-body no-padding">
            <form class="mws-form" action="/admin/user/quanadds?action=quanxianadd" >
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <div class="mws-form-inline">
                   <div class="mws-form-row bordered">
                        <label class="mws-form-label">管理员姓名</label>
                        <div class="mws-form-item">
                            <select class="large" name="guanli">
                            @foreach($name as $val)
                                <option value="{{$val['id']}}">{{$val['name']}}</option>
                            @endforeach
                            </select>
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
                            @foreach($res as $val)
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
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection