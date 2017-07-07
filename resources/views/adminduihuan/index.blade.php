@extends('layout.layout')
@section('con')
    <div class="mws-panel grid_8">
        <div class="mws-panel-header">
            <span><i class="icon-table"></i>积分兑换比例<b ><!-- <a href="/admin/jifen/index" style="color:red;margin-left: 75%;">回到首页</a></b> --></span>
        </div>

        <div class="mws-panel-body no-padding">
            <div id="DataTables_Table_1_wrapper" class="dataTables_wrapper" role="grid">
                <table class="mws-datatable-fn mws-table dataTable" id="DataTables_Table_1" aria-describedby="DataTables_Table_1_info" >
                    <thead>
                    <tr role="row">
                        <th class="sorting_asc" role="columnheader" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" style="width: 20px;">积分数量
                        </th>
                        <th class="sorting_asc" role="columnheader" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" style="width: 60px;">抵消金额
                        </th>
                        
                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending" style="width: 70px;">操作管理
                        </th>
                    </tr>
                    </thead>

                    <tbody role="alert" aria-live="polite" aria-relevant="all">
                    @foreach($res as $v)
                        <tr>
                            <td class="">{{$v['jifen']}}</td>
                            <td class="">{{$v['money']}}</td>
                           
                            <td class="">
                                <a href="/admin/duihuan/edit/{{$v['id']}}">修改积分兑换设置</a>|
                                <a href="/admin/duihuan/del/{{$v['id']}}">删除积分兑换设置</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="dataTables_paginate paging_full_numbers" id="pages">
              
                </div>
            </div>
        </div>
    </div>

@endsection