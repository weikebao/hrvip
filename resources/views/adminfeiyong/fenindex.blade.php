@extends('layout.layout')
@section('con')
    <div class="mws-panel grid_8">
        <div class="mws-panel-header">
            <span><i class="icon-table"></i>档位费用统计表     <a href="/admin/feiyong/fen" style="margin-left: 75%">返回首页</a>    </span>
        </div>

       <div class="mws-panel-body no-padding">
            <div id="DataTables_Table_1_wrapper" class="dataTables_wrapper" role="grid">
                <table class="mws-datatable-fn mws-table dataTable" id="DataTables_Table_1" aria-describedby="DataTables_Table_1_info" >
                    <thead>
                    <tr role="row">
                        <th class="sorting_asc" role="columnheader" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" style="width: 20px;">返利人数
                        </th>
                        <th class="sorting_asc" role="columnheader" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" style="width: 60px;">总费用
                        </th>
                    </tr>
                    </thead>

                    <tbody role="alert" aria-live="polite" aria-relevant="all" class="ceshi">
                    <tr>
                        <td><a href="/admin/feiyong/xiangxing/{{$id}}">{{$res['num']}}</a></td>
                        <td>{{$res['money']}}</td>
                    </tr>
                    </tbody>
                </table>
                <div class="dataTables_paginate paging_full_numbers" id="pages">
                </div>
            </div>
        </div>
    </div>

@endsection