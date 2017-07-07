@extends('layout.layout')
@section('con')
    <div class="mws-panel grid_8">
        <div class="mws-panel-header">
            <span><i class="icon-table"></i>公司会员名重复列表<b ><a href="/admin/tuihuiyuan/index" style="color:red;margin-left: 75%;">回到首页</a></b></span>
        </div>

        <div class="mws-panel-body no-padding">
            <div id="DataTables_Table_1_wrapper" class="dataTables_wrapper" role="grid">
            <div class="dataTables_filter" id="DataTables_Table_0_filter">
                <label class="huiyuan">点击会员查询:</label> <input type="text" aria-controls="DataTables_Table_0" placeholder="会员姓名" value="" name="caozuo">
            </div>
            <script type="text/javascript">
                //点击查询相应的会员
                $('.huiyuan').click(function()
                {
                    //获取会员的姓名
                    var name = $('input[name=caozuo]').val();
                    if(name==''){
                        alert('请输入姓名再查询');
                    }else{
                        //发送ajax请求数据
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
                                }else{
                                    //将会员的信息写在下面
                                    $('tbody[role=alert]').empty();
                                    $.each(mes,function(key,val){
                                        var anniu = '';
                                        var anniu2 = '';
                                        var bumen = '';
                                        var genghuan = '';
                                        if(val.zuojiedian==''&&val.youjiedian!='')
                                        {
                                            anniu2 = '右节点已满';
                                        }else if(val.zuojiedian!=''&&val.youjiedian=='')
                                        {
                                            anniu2 = '左节点已满';
                                        }
                                        //判断显示的数据添加方式
                                        if(val.zuojiedian==''||val.youjiedian=='' || (val.zuoqujian>=375&&val.youqujian>=375&&val.sanjiedian=='')){
                                            //显示添加下级会员按钮
                                            anniu = '<a href="/admin/tuihuiyuan/add/"'+val.id+'"">增加下属会员('+anniu2+')</a>'
                                        }else
                                        {
                                            anniu = '左右两侧已满';
                                        }
                                        //按照部门判断可以查看的部门
                                        if(val.sanqujian!=0)
                                        {
                                            //显示三区间
                                            bumen = '<a href="/admin/tuihuiyuan/list?wei=zuo&id="'+val.id+'"">一部门查看</a>|<a href="/admin/tuihuiyuan/list?wei=you&id="'+val.id+'"">二部门查看</a>|<a href="/admin/tuihuiyuan/list?wei=san&id="'+val.id+'"">三部门查看</a>|<a href="/admin/tuihuiyuan/list?wei=outo&id="'+val.id+'"">全部会员</a>';
                                        }else{
                                             bumen = '<a href="/admin/tuihuiyuan/list?wei=zuo&id="'+val.id+'"">一部门查看</a>|<a href="/admin/tuihuiyuan/list?wei=you&id="'+val.id+'"">二部门查看</a>|<a href="/admin/tuihuiyuan/list?wei=outo&id="'+val.id+'"">全部会员</a>';
                                        }
                                        //判断会员是否可以更换
                                        if(val.jidian==1)
                                        {
                                            genghuan = '不可更换';
                                        }else
                                        {
                                            genghuan = '<a href="">更换会员</a>';
                                        }
                                        $('tbody[role=alert]').append('<tr><td class="">'+val.id+'</td><td class="">'+val.name+'</td><td class="">'+val.phone+'</td><td class="">'+val.zuoqujian+'</td><td class="">'+val.youqujian+'</td><td class="">'+val.sanqujian+'</td><td class="">'+anniu+'</td><td>'+bumen+'</td></tr>\
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
                        <th class="sorting_asc" role="columnheader" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" style="width: 20px;">会员ID
                        </th>
                        <th class="sorting_asc" role="columnheader" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" style="width: 60px;">会员姓名
                        </th>
                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 70px;">会员手机号
                        </th>
                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 50px;">一部门人数
                        </th>                        
                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 50px;">二部门人数
                        </th>
                         <th class="sorting" role="columnheader" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 50px;">三部门人数
                        </th> 
                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending" style="width: 70px;">是否允许添加会员
                        </th>
                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending" style="width: 70px;">操作管理
                        </th>
                    </tr>
                    </thead>

                    <tbody role="alert" aria-live="polite" aria-relevant="all">
                    @foreach($res as $v)
                        <tr>
                            <td class="">{{$v['id']}}</td>
                            <td class="">{{$v['name']}}</td>
                            <td class="">{{$v['phone']}}</td>
                            <td class="">{{$v['zuoqujian']}}</td>
                            <td class="">{{$v['youqujian']}}</td>
                            <td class="">{{$v['sanqujian']}}</td>
                            <td class="">
@if($v['zuojiedian']=='' || $v['youjiedian']=='' ||($v['zuoqujian']>=375 && $v['youqujian']>=375 && $v['sanjiedian']==''))
<a href="/admin/tuihuiyuan/add/{{$v['id']}}">
增加下属会员(
@if($v['youjiedian']==''&&$v['zuojiedian']!='')
左节点已满
@elseif($v['zuojiedian']==''&&$v['youjiedian']!='')
右节点已满
@endif
)</a>
@else
左右两侧已满
@endif
                            </td>
                            <td class=""><a href="/admin/tuihuiyuan/list?wei=zuo&id={{$v['id']}}">一部门查看</a>|<a href="/admin/tuihuiyuan/list?wei=you&id={{$v['id']}}">二部门查看</a>|@if(($v['zuoqujian']>=375&&$v['youqujian']>=375))<a href="/admin/tuihuiyuan/list?wei=san&id={{$v['id']}}">三部门查看</a>|@endif<a href="/admin/tuihuiyuan/list?wei=outo&id={{$v['id']}}">全部会员</a></td>
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