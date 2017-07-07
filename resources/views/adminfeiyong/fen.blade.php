@extends('layout.layout')
@section('con')
   <div class="mws-panel grid_8">
        <div class="mws-panel-header">
            <span>选择返利职位</span>
        </div>
        <div class="mws-panel-body">
            <div class="mws-panel-content">
                <div style="margin-bottom:16px;">
                    <div class="btn-toolbar">
                        <a href="/admin/feiyong/fenlei?id=1" type="button" class="btn btn-large" disabled="disabled">VIP代理商</a>
                        <a href="/admin/feiyong/fenlei?id=2" type="button" class="btn btn-large" disabled="disabled">红钻代理商</a>
                        <a href="/admin/feiyong/fenlei?id=3" type="button" class="btn btn-large" disabled="disabled">橙钻代理商</a>
                        <a href="/admin/feiyong/fenlei?id=4" type="button" class="btn  btn-large" disabled="disabled">黄钻代理商</a>
                        <a href="/admin/feiyong/fenlei?id=5" type="button" class="btn btn-large" disabled="disabled">绿钻代理商</a>
                        <a href="/admin/feiyong/fenlei?id=6" type="button" class="btn btn-large" disabled="disabled">青钻代理商</a>
                        <a href="/admin/feiyong/fenlei?id=7" type="button" class="btn btn-large" disabled="disabled">蓝钻代理商</a>
                        <a href="/admin/feiyong/fenlei?id=8" type="button" class="btn btn-large" disabled="disabled">紫钻代理商</a>
                        <a href="/admin/feiyong/fenlei?id=9" type="button" class="btn btn-large" disabled="disabled">彩钻大使</a>
                        <a href="/admin/feiyong/fenlei?id=10" type="button" class="btn btn-large" disabled="disabled">银钻大使</a>
                        <a href="/admin/feiyong/fenlei?id=11" type="button" class="btn btn-large" disabled="disabled">金钻大使</a>
                        <a href="/admin/feiyong/fenlei?id=12" type="button" class="btn btn-large" disabled="disabled">黑钻大使</a>
                        <a href="/admin/feiyong/fenlei?id=13" type="button" class="btn btn-large" disabled="disabled">至尊大使</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $('button').live('click',function(){
            //根据点击的按钮不同加载不同的职位返利信息

        })
    </script>

@endsection