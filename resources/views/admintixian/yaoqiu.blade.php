@extends('layout.layout')
@section('con')
    <div class="mws-panel grid_8">
        <div class="mws-panel-header">
            <span><i class="icon-table"></i>提现要求<b ><!-- <a href="/admin/jifen/index" style="color:red;margin-left: 75%;">回到首页</a></b> --></span>
        </div>

        <div class="mws-panel-body no-padding">
            <div id="DataTables_Table_1_wrapper" class="dataTables_wrapper" role="grid">
                <table class="mws-datatable-fn mws-table dataTable" id="DataTables_Table_1" aria-describedby="DataTables_Table_1_info" >
                    <thead>
                    <tr role="row">
                        <th class="sorting_asc" role="columnheader" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" style="width: 20px;">提现手续费用
                        </th>
                        <th class="sorting_asc" role="columnheader" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" style="width: 20px;">最低提现要求
                        </th>
                        <th class="sorting_asc" role="columnheader" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" style="width: 20px;">操作要求
                        </th>
                    </tr>
                    </thead>

                    <tbody role="alert" aria-live="polite" aria-relevant="all">
                    @foreach($res as $v)
                        <tr>
                            <td class=""><input type="text" name="lilv" value="{{$v['lilv']}}"></td>
                            <td class=""><input type="text" name="money" value="{{$v['zuidimoney']}}"></td>
                            <input type="hidden" name="id" value="{{$v['id']}}">
                            <td class="yao">
                                <a>修改要求</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <script type="text/javascript">
                    $('.yao').click(function(){
                        //获取ajax
                        var money = $('input[name=money]').val();
                        var lilv = $('input[name=lilv]').val();
                        var id = $('input[name=id]').val();
                        $.ajax({
                            url:'/admin/tixian/yaoqiuedit',
                            data:{'money':money,'lilv':lilv,'id':id},
                            success:function(mes)
                            {
                                if(mes==1)
                                {
                                    alert('修改提现规则成功');
                                }else{
                                    alert('修改提现规则失败');
                                }
                            }
                        })
                    })
                </script>
            </div>
        </div>
    </div>

@endsection