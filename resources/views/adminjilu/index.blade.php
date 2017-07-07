@extends('layout.layout')
@section('con')
    <div class="mws-panel grid_8">
        <div class="mws-panel-header">
            <span><i class="icon-table"></i>操作记录列表</span>
        </div>
        <div class="mws-panel-body no-padding">
            <div id="DataTables_Table_1_wrapper" class="dataTables_wrapper" role="grid">


            <div id="DataTables_Table_0_length" class="dataTables_length mws-form-row dataTables_filter">
                <label class="mws-form-label queding">确定</label>
               <input class="Wdate mws-form-label" type="text" onClick="WdatePicker()" readonly="readonly" name="riqi" value=""/> 
            </div>


                <div class="dataTables_filter" id="DataTables_Table_0_filter">
                <label>点击操作查询: <input type="text" aria-controls="DataTables_Table_0" placeholder="增加;删除;修改" value="" name="caozuo"></label></div>
              <!--  <input type="hidden" name="token" value="<?php echo csrf_token(); ?>"> -->
               {{csrf_field()}}
<script type="text/javascript">
    //点击查询按钮发送ajax
    $('.queding').click(function()
    {
        var riqi = $('input[name=riqi]').val();
        var caozuo = $('input[name=caozuo]').val();
        if(riqi=='' && caozuo=='')
        {
            alert('请输入查询条件');
        }else
        {
            //发送ajax请求输入的条件
            $.ajax({
                url:'/admin/caozuo/ajax',
                data:{'_token':$('input[name="_token"]').val(),'riqi':riqi,'caozuo':caozuo},
                type:'post',
                dataType:'json',
                success:function(mes)
                {
                   if(mes.d=='错误')
                   {
                    alert(mes.a);
                   }else if(mes.d=='操作')
                   {
                    $('.ceshi').empty();
                    $('#pages').empty();
                    $.each(mes,function(key,val)
                    {   if(val!='操作')
                        {
                          $('.ceshi').append('<tr><td>'+val.gid+'</td><td class=" ">'+val.dongzuo+'</td><td class=" ">'+val.time+'</td></tr>\
                        ');  
                        }
                    })
                   }else if(mes.d=='日期')
                   {
                    $('.ceshi').empty();
                    $('#pages').empty();
                    $.each(mes,function(key,val)
                    {   if(val!='日期')
                        {
                          $('.ceshi').append('<tr><td>'+val.gid+'</td><td class=" ">'+val.dongzuo+'</td><td class=" ">'+val.time+'</td></tr>\
                        ');  
                        }
                    })   
                   }else if(mes.d=='日期操作')
                   {
                     $('.ceshi').empty();
                    $('#pages').empty();
                    $.each(mes,function(key,val)
                    {   if(val!='日期操作')
                        {
                          $('.ceshi').append('<tr><td>'+val.gid+'</td><td class=" ">'+val.dongzuo+'</td><td class=" ">'+val.time+'</td></tr>\
                        ');  
                        }
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
                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 267px;">管理员姓名
                        </th>
                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 267px;">操作结果
                        </th>                        
                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending" style="width: 179px;">操作时间
                        </th>
                    </tr>
                    </thead>

                    <tbody role="alert" aria-live="polite" aria-relevant="all" class="ceshi">
                           @foreach($res as $v)
                        <tr>
                            <td>{{$v['gid']}}</td>
                            <td class=" ">
                                {{$v['dongzuo']}}
                            </td>
                            <td class=" ">
                               {{$v['time']}}
                            </td>
                        </tr>
                           @endforeach
                    </tbody>
                </table>
                <div class="dataTables_info" id="DataTables_Table_1_info"></div>
                <div class="dataTables_paginate paging_full_numbers" id="pages">
                {!! $res->render() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
