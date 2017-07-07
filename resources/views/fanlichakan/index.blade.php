@extends('layout.layout')
@section('con')
    <div class="mws-panel grid_8">
        <div class="mws-panel-header">
            <span><i class="icon-table"></i>会员每日返利</span>
        </div>

        <div class="mws-panel-body no-padding">
            <div id="DataTables_Table_1_wrapper" class="dataTables_wrapper" role="grid">
            <div class="dataTables_filter" id="DataTables_Table_0_filter">
                <label class="huiyuan">点击查询:</label> <input type="text" aria-controls="DataTables_Table_0" placeholder="返利职位" value="" name="caozuo">
            </div>
            <script type="text/javascript">
                //点击查询相应的会员
                $('.huiyuan').click(function()
                {
                    //获取会员的姓名
                    var name = $('input[name=caozuo]').val();
                    if(name==''){
                        alert('请输入职位再查询');
                    }else{
                        //发送ajax请求数据
                        $.ajax({
                            url:'/admin/fanlichakan/ajax',
                            data:{'name':name},
                            type:'get',
                            dataType:'json',
                            success:function(mes)
                            {
                                if(mes==1)
                                {
                                    alert('没有这一阶段的返利人员')
                                }else{
                                    //将会员的信息写在下面
                                    $('tbody[role=alert]').empty();
                                   $.each(mes,function(key,val){
                                    $('tbody[role=alert]').append('<tr><td class="">'+val.name+'</td><td class="">'+val.fanliname+'</td><td class="">'+val.fanlimoney+'</td></tr>\
                                        ')
                                   })
                                }
                            }
                        })
                    }
                })
            </script>
                <table class="mws-datatable-fn mws-table dataTable" id="DataTables_Table_1" aria-describedby="DataTables_Table_1_info" >
                    <thead>
                    <tr role="row">
                        <th class="sorting_asc" role="columnheader" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" style="width: 60px;">会员姓名
                        </th>
                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 70px;">返利职位
                        </th>
                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 70px;">返利佣金
                        </th>
                    </tr>
                    </thead>

                    <tbody role="alert" aria-live="polite" aria-relevant="all">
                    @foreach($res as $v)
                        <tr>
                            <td class="">{{$v['name']}}</td>
                            <td class="">{{$v['fanliname']}}</td>
                            <td class="">{{$v['fanlimoney']}}</td>
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