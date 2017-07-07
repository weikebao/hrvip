@extends('layout.layout')
@section('con')
    <div class="mws-panel grid_8">
        <div class="mws-panel-header">
            <span><i class="icon-table"></i>流水记录</span>
        </div>

       <div class="mws-panel-body no-padding">
            <div id="DataTables_Table_1_wrapper" class="dataTables_wrapper" role="grid">

            <div id="DataTables_Table_0_length" class="dataTables_length mws-form-row dataTables_filter">
                <label class="mws-form-label queding">输入手机号</label>
               <input class=" mws-form-label" type="text" name="phone" value="" />
            </div>
            <div id="DataTables_Table_0_length" class="dataTables_length mws-form-row dataTables_filter">
                <label class="mws-form-label queding">选择类型</label>
               <select class=" mws-form-label" name="leixing" />
                <option value="1">交易记录</option>
                <option value="2">返现记录</option>
                <option value="3">充值记录</option>
                <option value="4">提现记录</option>
                <option value="5">兑换记录</option>
                <option value="6">转账记录</option>
               </select>
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
        var  phone = $('input[name=phone]').val();
        var  leixing = $('select[name=leixing]').val();
        if(yue>12||yue<1)
        {
            alert('请输入正确查询条件')
        }else{
            //发送ajax请求输入的条件
            $.ajax({
                url:'/admin/feiyong/xiangxiajax',
                data:{'_token':$('input[name="_token"]').val(),'yue':yue,'phone':phone,'leixing':leixing},
                type:'post',
                dataType:'json',
                success:function(mes)
                {
                    console.log(mes);
                   if(mes.length!=0)
                   {
                    $('.ceshi').empty();
                    $.each(mes,function(key,val)
                    {  
                        $('.ceshi').append('<tr><td>'+val.time+'</td><td class=" ">'+val.total+'</td></tr>\
                        '); 
                    })
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
        var  phone = $('input[name=phone]').val();
        var  leixing = $('select[name=leixing]').val();
        if(riqi=='')
        {
            alert('请输入查询条件');
        }else
        {
            //发送ajax请求输入的条件
            $.ajax({
                url:'/admin/feiyong/xiangxiajaxs',
                data:{'_token':$('input[name="_token"]').val(),'riqi':riqi,'phone':phone,'leixing':leixing},
                type:'post',
                dataType:'json',
                success:function(mes)
                {
                   if(mes.length!=0)
                   {
                    $('.ceshi').empty();
                    $.each(mes,function(key,val)
                    {  
                        $('.ceshi').append('<tr><td>'+val.time+'</td><td class=" ">'+val.total+'</td></tr>\
                        '); 
                    })
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
                        <th class="sorting_asc" role="columnheader" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" style="width: 20px;">日期
                        </th>
                        <th class="sorting_asc" role="columnheader" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" style="width: 60px;">金额
                        </th>
                    </tr>
                    </thead>

                    <tbody role="alert" aria-live="polite" aria-relevant="all" class="ceshi">
                      
                    </tbody>
                </table>
                <div class="dataTables_paginate paging_full_numbers" id="pages">
                </div>
            </div>
        </div>
    </div>

@endsection