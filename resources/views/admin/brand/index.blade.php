@extends('admin.layouts.adminshop')
@section('title','品牌列表')
@section('content')
<!-- 内容主体区域 -->
    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 50px;">
      <legend><span class="layui-breadcrumb">
      <a href="/">首页</a>
      <a href="/demo/">商品品牌</a>
      <a><cite>品牌列表</cite></a>
      </span></legend>
    </fieldset>

    <form class="layui-form" action="">
    <div class="layui-form-item">
    <div class="layui-inline">
      <div class="layui-input-inline" style="padding-left: 40px;">
        <input type="tel" name="brand_name" value="{{$query['brand_name']??''}}" placeholder="请输入品牌名称" lay-verify="required|phone" autocomplete="off" class="layui-input">
      </div>
    </div>
    <div class="layui-inline">
      <div class="layui-input-inline">
        <input type="text" name="brand_url" value="{{$query['brand_url']??''}}" placeholder="请输入品牌网址" lay-verify="email" autocomplete="off" class="layui-input">
      </div>
    </div>
       <div class="layui-inline">
      <div class="layui-input-inline">
       <button class="layui-btn layui-btn-warm">搜索</button>
      </div>
    </div>
  </div>
</form>
    <div class="layui-form" style="padding: 15px;">
  <table class="layui-table">
    <colgroup>
      <col width="150">
      <col width="150">
      <col width="200">
      <col>
    </colgroup>
    <thead>
      <tr>
        <th width="5%"><input type="checkbox" name="allcheckbox" lay-skin="primary"></th>
        <th>品牌ID</th>
        <th>品牌名称</th>
        <th>品牌网址</th>
        <th>品牌logo</th>
        <th>品牌内容</th>
        <th>操作</th>
      </tr> 
    </thead>
    <tbody>
      @foreach($brand as $v)
      <tr>
        <td><input type="checkbox" name="brandcheck[]" lay-skin="primary" value="{{$v->brand_id}}"></td>
        <td>{{$v->brand_id}}</td>
        <td id="{{$v->brand_id}}" oldval="{{$v->brand_name}}"><span class="brand_name">{{$v->brand_name}}</span></td>
        <td>{{$v->brand_url}}</td>
        
        <td>
          @if($v->brand_logo)
          <img src="{{$v->brand_logo}}" width="60">
          @endif
        </td>
        <td>{{$v->brand_desc}}</td>
        <td>
          <a href="{{url('/brand/edit/'.$v->brand_id)}}" class="layui-btn layui-btn-warm">修改</a>
          <!-- <a href="javascript:void(0)" onclick="if(confirm('确定删除此记录吗')){ location.href='{{url('/brand/delete/'.$v->brand_id)}}';}" class="layui-btn layui-btn-danger">删除</a> -->
          <a href="javascript:void(0)" onclick="deleteById({{$v->brand_id}})" class="layui-btn layui-btn-danger">删除</a>
        </td>
      </tr>
      @endforeach
      <tr>
      <td colspan="7">
        {{$brand->appends($query)->links('vendor.pagination.adminshop')}}
         <button type="button" class="layui-btn layui-btn-warm moredel">批量删除</button>
      </td>
      </tr>
    </tbody>
    
  </table>
</div>

<script src="/static/admin/layui/layui.js"></script>
<script src="/static/admin/js/jquery.min.js"></script>
<script>
//JavaScript代码区域
layui.use(['element','form'], function(){
  var element = layui.element;
  var form=layui.form;
});

//即点即改
$(document).on('click','.brand_name',function(){
//$('.brand_name').click(function(){
  var brand_name=$(this).text();
  var id=$(this).parent().attr('id');
  $(this).parent().html('<input type=text class="chagename input_name_'+id+'" value='+brand_name+'>');
  $('.input_name_'+id).val('').focus().val(brand_name);
});
$(document).on('blur','.chagename',function(){
  var newname=$(this).val();
  if(!newname){
    alert('内容不能空');return;
  }
  var oldval=$(this).parent().attr('oldval');
  if(newname==oldval){
    $(this).parent().html('<span class="brand_name">'+newname+'</span>');
    return;
  }
  var id=$(this).parent().attr('id');
  var obj=$(this);
  $.get('/brand/change',{id:id,brand_name:newname},function(res){
    //alert(res.msg);
    if(res.code==0){
      obj.parent().html('<span class="brand_name">'+newname+'</span>');
    }
  },'json')
})

//全选、反选
$(document).on('click','.layui-form-checkbox:first',function(){
  var checkedval=$('input[name="allcheckbox"]').prop('checked');
   $('input[name="brandcheck[]"]').prop('checked',checkedval);
  if(checkedval){
    $('.layui-form-checkbox:gt(0)').addClass('layui-form-checked');
  }else{
     $('.layui-form-checkbox:gt(0)').removeClass('layui-form-checked');
  }
});

//批量删除
$(document).on('click','.moredel',function(){
  var ids=new Array();
 $('input[name="brandcheck[]"]:checked').each(function(i,k){
  ids.push($(this).val());
 });
 $.get('/brand/delete/',{id:ids},function(res){
    alert(res.msg);
    location.reload();
  },'json')
})

//ajax删除
function deleteById(brand_id){
  if(!brand_id){
    return;
  }
  $.get('/brand/delete/'+brand_id,function(res){
    alert(res.msg);
    location.reload();
  },'json')
}
//ajax无刷新
$(document).on('click','.layui-laypage a',function(){
  var url=$(this).attr('href');
  $.get(url,function(res){
    $('tbody').html(res);
     layui.use(['element','form'], function(){
    var element = layui.element;
    var form=layui.form;
    form.render();
  });
  })
  return false;
});
</script>
  @endsection

  
