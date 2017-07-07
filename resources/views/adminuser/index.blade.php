@extends('layout.layout')
@section('con')
    <div class="mws-panel grid_8">
        <div class="mws-panel-header">
            <span><i class="icon-table"></i> 管理员列表</span>
        </div>
        <div class="mws-panel-body no-padding">
            <div id="DataTables_Table_1_wrapper" class="dataTables_wrapper" role="grid">
                <table class="mws-datatable-fn mws-table dataTable" id="DataTables_Table_1" aria-describedby="DataTables_Table_1_info" >
                    <thead>
                    <tr role="row">
                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 267px;">管理员姓名
                        </th>
                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 267px;">管理员账号(电话)
                        </th>
                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 267px;">管理员级别
                        </th>                        
                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending" style="width: 179px;">操作管理
                        </th>
                    </tr>
                    </thead>

                    <tbody role="alert" aria-live="polite" aria-relevant="all">
                           @foreach($res as $v)
                        <tr>
                            <td>{{$v['name']}}</td>
                            <td class=" ">
                                {{$v['phone']}}
                            </td>
                            <td>
                                @if($v['quanxian'] == 2)
                                    超级管理员
                                @elseif($v['quanxian'] == 1)
                                    管理员
                                @endif

                            </td>
                            <td class=" ">
                                <a href="/admin/user/edit/{{$v['id']}}">修改</a> 
                                |
                                    <a href ="/admin/user/del/{{$v['id']}}">删除</a>
                                
                            </td>
                        </tr>
                           @endforeach
                    </tbody>
                </table>
                <div class="dataTables_info" id="DataTables_Table_1_info">Showing 1 to 10 of 57 entries</div>
                <div class="dataTables_paginate paging_full_numbers" id="pages">
                </div>
            </div>
        </div>
    </div>

@endsection