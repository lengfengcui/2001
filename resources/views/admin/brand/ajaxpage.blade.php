@foreach($brand as $v)
      <tr>
        <td width="5%"><input type="checkbox" name="allcheckbox" lay-skin="primary"></td>
        <td>{{$v->brand_id}}</td>
        <td>{{$v->brand_name}}</td>
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