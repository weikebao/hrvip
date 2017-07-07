@extends('layout.layout')
@section('con')
    <div class="mws-panel grid_8">
        <div class="mws-panel-header">
            <span><i class="icon-table"></i>会员积分来源列表<b ><a href="/admin/jifen/index" style="color:red;margin-left: 75%;">回到首页</a></b></span>
        </div>

        <div class="mws-panel-body no-padding">
            <div id="DataTables_Table_1_wrapper" class="dataTables_wrapper" role="grid">
            <!-- <div class="dataTables_filter" id="DataTables_Table_0_filter">
                <label class="huiyuan">点击会员查询:</label> <input type="text" aria-controls="DataTables_Table_0" placeholder="会员姓名" value="" name="caozuo">
            </div> -->
            <script type="text/javascript">
                //点击查询相应的会员
                // $('.huiyuan').click(function()
                // {
                //     //获取会员的姓名
                //     var name = $('input[name=caozuo]').val();
                //     if(name==''){
                //         alert('请输入姓名再查询');
                //     }else{
                //         //发送ajax请求数据
                //         $.ajax({
                //             url:'/admin/jifen/ajax',
                //             data:{'name':name},
                //             type:'get',
                //             dataType:'json',
                //             success:function(mes)
                //             {
                //                 if(mes==1)
                //                 {
                //                     alert('您要查询的会员不存在')
                //                 }else{
                //                     //将会员的信息写在下面
                //                     $('tbody[role=alert]').empty();
                                  
                //                    $.each(mes,function(key,val){
                //                     var jifen ='0';
                //                     if(val.jifen==0){
                //                         jifen = '0';
                //                     }else{
                //                         jifen  = val.jifen;
                //                     }
                //                     $('tbody[role=alert]').append('<tr><td class="">'+val.id+'</td><td class="">'+val.name+'</td><td class="">'+val.phone+'</td><td class="">'+jifen+'积分</td><td class=""><a href="/admin/jifen/laiyuan/'+val.id+'">积分来源情况</a></td></tr>\
                //                         ')
                //                    })
                //                 }
                //             }
                //         })
                //     }
                // })
            </script>
                <table class="mws-datatable-fn mws-table dataTable" id="DataTables_Table_1" aria-describedby="DataTables_Table_1_info" >
                    <thead>
                    <tr role="row">
                        <th class="sorting_asc" role="columnheader" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" style="width: 20px;">积分数量
                        </th>
                        <th class="sorting_asc" role="columnheader" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" style="width: 60px;">来源信息
                        </th>
                        <th class="sorting_asc" role="columnheader" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" style="width: 60px;">积分开始或转赠日期
                        </th>
                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 70px;">积分结束日期
                        </th>
                    </tr>
                    </thead>

                    <tbody role="alert" aria-live="polite" aria-relevant="all">
                    @foreach($res as $v)
                        <tr>
                            <td class="">{{$v['amount']}}</td>
                            <td class="">{{$v['from']}}{{$v['to']}}</td>
                            <td class="">{{$v['start_time']}}</td>
                            <td class="">{{$v['end_time']}}</td>
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