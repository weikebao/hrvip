@extends('layout.layout')
@section('con')
    <div class="mws-panel grid_8">
        <div class="mws-panel-header">
            <span><i class="icon-table"></i>公司会员列表<b ><a href="/admin/tuihuiyuan/index" style="color:red;margin-left: 75%;">回到首页</a></b></span>
        </div>
        <div class="mws-panel-body no-padding">
            <div id="DataTables_Table_1_wrapper" class="dataTables_wrapper" role="grid">
            <div class="dataTables_filter" id="DataTables_Table_0_filter">
                <label  class="huiyuan">点击会员查询: </label><input type="text" aria-controls="DataTables_Table_0" placeholder="会员姓名" value="" name="caozuo">
            </div>
            <script type="text/javascript">
                //点击查询要搜索的会员的信息
                $('.huiyuan').click(function()
                {
                    var name = $('input[name=caozuo]').val();
                    if(name=='')
                    {
                        alert('请输入要查询的会员姓名');
                    }else
                    {
                        //发送ajax查找数据
                         $.ajax({
                            url:'/admin/tuihuiyuan/ajax',
                            data:{'name':name},
                            type:'get',
                            dataType:'json',
                            success:function(mes)
                            {
                                if(mes==1)
                                {
                                     alert('您要查询的会员不存在')
                                 }else
                                 {
                                     $('tbody[role=alert]').empty();
                                        var genghuan = '';
                                        var free = '';
                                        if(mes.jidian==1)
                                        {
                                            genghuan ='不可更改';
                                        }else
                                        {
                                            genghuan ='<a href="">更换会员</a>';
                                        }
                                        if(mes.xiaofei==1)
                                        {
                                            free='已消费本月'
                                        }else
                                        {
                                            free='未消费';
                                        }
                                        $('tbody[role=alert]').append('<tr><td>'+mes.name+'</td><td>'+mes.phone+'</td><td>'+free+'</td><td>'+mes.zuoqujian+'</td><td>'+mes.youqujian+'</td><td>'+mes.sanqujian+'</td><td><a href="/admin/tuihuiyuan/list?wei=outo&id="'+mes.id+'"">查看会员(全部)</a></td></tr>\
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
                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 70px;">会员手机号
                        </th>
                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 70px;">会员消费情况
                        </th>
                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 70px;">一部门人数
                        </th>
                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 70px;">二部门人数
                        </th>
                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 70px;">三部门人数
                        </th>
                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending" style="width: 40px;">查看会员
                        </th>
                       <!--  <th class="sorting" role="columnheader" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending" style="width: 40px;">会员更换
                        </th> -->
                    </tr>
                    </thead>

                    <tbody role="alert" aria-live="polite" aria-relevant="all">
                    @foreach($res as $v)
                    <tr>
                        <td>{{$v['name']}}</td>
                        <td>{{$v['phone']}}</td>
                        <td>@if($v['xiaofei']==1)消费@else未消费@endif</td>
                        <td>{{$v['zuoqujian']}}</td>
                        <td>{{$v['youqujian']}}</td>
                        <td>{{$v['sanqujian']}}</td>
                        <td><a href="/admin/tuihuiyuan/list?wei=outo&id={{$v['id']}}">查看会员(全部)</a></td>
                       <!--  <td>更换会员</td> -->
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection