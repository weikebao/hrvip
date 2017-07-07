@extends('layout.layout')
@section('con')
    <div class="mws-panel grid_8">
        <div class="mws-panel-header">
            <span>会员分配页面</span>
        </div>
        <div class="mws-panel-body no-padding">
            <form class="mws-form" action="/admin/tuihuiyuan/fenpeis" >
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <div class="mws-form-inline">
                    <div class="mws-form-row">
                        <label class="mws-form-label">会员名称</label>
                        <div class="mws-form-item">
                            <input type="text" class="medium" name='name' required value="{{$first['name']}}" readonly="readonly">
                            <input type="hidden" name="fid" value="{{$first['id']}}">
                        </div>
                    </div>
                   <div class="mws-form-row bordered">
                        <label class="mws-form-label">选择推荐人姓名</label>
                        <div class="mws-form-item">
                            <select class="small" name="id" >
                            @foreach($res as $val)
                                <option value="{{$val['id']}}"><i>{{$val['name']}}</i> : 总共推荐了{{$val['zuoqujian']+$val['youqujian']}}人</option>
                            @endforeach
                            </select>

                             <div class="dataTables_paginate paging_full_numbers" id="pages">
                               分页浏览 : {!! $res->render() !!}
                            </div>
                        </div>
                    </div>

                   <div class="mws-form-row">
                        <label class="mws-form-label" id="click">点击查询会员</label>
                        <div class="mws-form-item">
                            <input type="text" class="medium" name='click' value="" >
                        </div>
                    </div>
                    <script type="text/javascript">
                        //点击查询会员时查询所有人名称将名称放到上面
                        $('#click').click(function()
                        {
                            //获取表格中的内容
                            var name = $('input[name=click]').val();
                            if(name!='')
                            {
                                $.ajax({
                                    url:'/admin/tuihuiyuan/huiyuanlist',
                                    data:{'name':name},
                                    dataType:'json',
                                    success:function(mes)
                                    {

                                        //将数据写到上面
                                        $('select[name=id]').empty();
                                        $.each(mes,function(key,val)
                                        {
                                        var num = val.zuoqujian+val.youqujian;
                                        $('select[name=id]').append('<option value="'+val.id+'"><i>'+val.name+'</i> : 总共推荐了'+num+'人</option>\
                                                ')
                                        })
                                    }
                                })
                            }else
                            {
                                alert('请添加要搜索的会员姓名');
                            }
                        })
                    </script>
                    <div class="mws-button-row">
                        <input type="submit" value="点击提交" class="btn btn-danger">
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection