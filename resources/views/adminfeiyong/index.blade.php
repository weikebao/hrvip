@extends('layout.layout')
@section('con')
    <div class="mws-panel grid_8">
        <div class="mws-panel-header">
            <span><i class="icon-table"></i>费用统计表</span>
        </div>

       <div class="mws-panel-body no-padding">
            <div id="DataTables_Table_1_wrapper" class="dataTables_wrapper" role="grid">

            <div id="DataTables_Table_0_length" class="dataTables_length mws-form-row dataTables_filter">
                <label class="mws-form-label queding">当前总费用</label>
               <input class=" mws-form-label" type="text" name="acount" value="{{$acount}}" readonly="readonly" />元
            </div>

            <div id="DataTables_Table_0_length" class="dataTables_length mws-form-row dataTables_filter">
                <label class="mws-form-label queding">选择日期(确定)</label>
               <input class="Wdate mws-form-label" type="text" onClick="WdatePicker()" readonly="readonly" name="riqi" value=""/> 
            </div>


                <div class="dataTables_filter" id="DataTables_Table_0_filter">
                <label class="yue">输入月份查询:</label> <input type="text" aria-controls="DataTables_Table_0" placeholder="请输入月份" value="" name="caozuo"></div>
               <input type="hidden" name="token" value="<?php echo csrf_token(); ?>">
               {{csrf_field()}}
<script type="text/javascript">
    //点击查询按钮发送ajax
    $('.yue').click(function(){
        var yue = $('input[name=caozuo]').val();
        if(yue>12||yue<1)
        {
            alert('请输入正确查询条件')
        }else{
            //发送ajax请求输入的条件
            $.ajax({
                url:'/admin/feiyong/ajaxs',
                data:{'_token':$('input[name="_token"]').val(),'yue':yue},
                type:'post',
                dataType:'json',
                success:function(mes)
                {
                   if(mes.length!=0)
                   {
                    $('.ceshi').empty();
                    $('#pages').empty();
                    $.each(mes,function(key,val)
                    {  
                        $('.ceshi').append('<tr><td>'+val.yid+'</td><td class=" ">'+val.yphone+'</td><td>'+val.yfanmoney+'</td><td class=" ">'+val.Jtime+'</td></tr>\
                        '); 
                    })
                    //将综合数据放到首页位置
                    $('input[name=acount]').val('');
                    if(mes.d!=0){
                            $('input[name=acount]').val(mes.d);
                        }
                    $('tr:last').remove();
                   }else{
                    alert('暂无数据');
                   }
                }
            })
        }
    })

    $('.queding').click(function()
    {
        var riqi = $('input[name=riqi]').val();
        if(riqi=='')
        {
            alert('请输入查询条件');
        }else
        {
            //发送ajax请求输入的条件
            $.ajax({
                url:'/admin/feiyong/ajax',
                data:{'_token':$('input[name="_token"]').val(),'riqi':riqi},
                type:'post',
                dataType:'json',
                success:function(mes)
                {
                   if(mes.length!=0)
                   {
                    $('.ceshi').empty();
                    $('#pages').empty();
                    $.each(mes,function(key,val)
                    {  
                        $('.ceshi').append('<tr><td>'+val.yid+'</td><td class=" ">'+val.yphone+'</td><td>'+val.yfanmoney+'</td><td class=" ">'+val.Jtime+'</td></tr>\
                        '); 
                    })
                    //将综合数据放到首页位置
                    $('input[name=acount]').val('');
                    if(mes.d!=0){
                            $('input[name=acount]').val(mes.d);
                        }
                    $('tr:last').remove();
                   }else{
                    alert('暂无数据');
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
                        <th class="sorting_asc" role="columnheader" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" style="width: 60px;">会员账号
                        </th>
                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 70px;">会员返利金额
                        </th>
                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending" style="width: 70px;">返利日期
                        </th>
                    </tr>
                    </thead>

                    <tbody role="alert" aria-live="polite" aria-relevant="all" class="ceshi">
                    @foreach($res as $v)
                    <tr >
                        <td>{{$v['yid']}}</td>
                        <td>{{$v['yphone']}}</td>
                        <td>{{$v['yfanmoney']}}</td>
                        <td>{{$v['Jtime']}}</td>
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