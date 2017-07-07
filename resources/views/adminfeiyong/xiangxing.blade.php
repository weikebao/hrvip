@extends('layout.layout')
@section('con')
    <div class="mws-panel grid_8">
        <div class="mws-panel-header">
            <span><i class="icon-table"></i>查看会员返利详情</span>
        </div>

        <div class="mws-panel-body no-padding">
            <div id="DataTables_Table_1_wrapper" class="dataTables_wrapper" role="grid">
            <div class="dataTables_filter" id="DataTables_Table_0_filter">
                <label class="huiyuan">点击查询:</label> <input type="text" aria-controls="DataTables_Table_0" placeholder="手机号" value="" name="caozuo">
                <input type="hidden" name="id" value="{{$id}}">
            </div>
            <script type="text/javascript">
                //点击查询相应的会员
                $('.huiyuan').click(function()
                {
                    //获取会员的姓名
                    var name = $('input[name=caozuo]').val();
                    var id = $('input[name=id]').val();
                    if(name==''){
                        alert('请输入手机号码再查询');
                    }else{
                        //发送ajax请求数据
                        $.ajax({
                            url:'/admin/feiyong/xiangxingajax',
                            data:{'name':name,'id':id},
                            type:'get',
                            dataType:'json',
                            success:function(mes)
                            {
                                if(mes==1)
                                {
                                    alert('没有这个返利人员')
                                }else{
                                    //将会员的信息写在下面
                                    $('tbody[role=alert]').empty();
                                    $('tbody[role=alert]').append('<tr><td class="">'+mes.name+'</td><td class="">'+mes.phone+'</td></tr>\
                                        ')
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
                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 70px;">会员ID
                        </th>
                    </tr>
                    </thead>

                    <tbody role="alert" aria-live="polite" aria-relevant="all">
                    @foreach($data as $v)
                        <tr>
                            <td class="">{{$v['name']}}</td>
                            <td class="">{{$v['phone']}}</td>
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