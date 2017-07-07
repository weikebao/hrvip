@extends('layout.layout')
@section('con')
    <div class="mws-panel grid_8">
        <div class="mws-panel-header">
            <span><i class="icon-table"></i>全体会员列表</span>
        </div>
        <div class="mws-panel-body no-padding">
            <div id="DataTables_Table_1_wrapper" class="dataTables_wrapper" role="grid">
                <table class="mws-datatable-fn mws-table dataTable" id="DataTables_Table_1" aria-describedby="DataTables_Table_1_info" >
                    <thead>
                    <tr role="row">
                        <th class="sorting_asc" role="columnheader" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" style="width: 120px;">会员姓名
                        </th>
                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 100px;">会员手机号
                        </th>
                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 100px;">推荐总人数
                        </th>
                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 150px;">会员消费总金额
                        </th>
                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending" style="width: 210px;">操作管理
                        </th>
                    </tr>
                    </thead>

                    <tbody role="alert" aria-live="polite" aria-relevant="all">
                           @foreach($res as $v)
                        <tr>
                            <td class="">{{$v['name']}}</td>
                            <td class="">{{$v['phone']}}</td>
                            <td class="">{{$v['zuoqujian']+$v['youqujian']}}</td>
                            <td class="">{{$v['free']}}</td>
                            <td class="">
                                <a href="/admin/tuihuiyuan/zilist/{{$v['id']}}">查看子会员</a>
                            @if($v['jidian']!=1)
                                <a href="/admin/tuihuiyuan/listedit/{{$v['id']}}">划落此会员</a>
                            @endif
                            </td>
                        </tr>
                           @endforeach
                    </tbody>
                </table>
                <div class="dataTables_paginate paging_full_numbers" id="pages">
                {!! $res->render() !!}
                </div>
            </div>
        </div>
    </div>

@endsection