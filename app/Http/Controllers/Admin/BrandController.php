<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Http\Requests\StoreBrandPost;
use Validator;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brand_name=request()->brand_name;
        $where=[];
        if($brand_name){
            $where[]=['brand_name','like',"%$brand_name%"];
        }
        $brand_url=request()->brand_url;
        if($brand_url){
            $where[]=['brand_url','like',"%$brand_url%"];
        }
        $brand=Brand::orderBy('brand_id','desc')->where($where)->paginate(3);
        if(request()->ajax()){
            return view('admin.brand.ajaxpage',['brand'=>$brand,'query'=>request()->all()]);
        }
        return view('admin.brand.index',['brand'=>$brand,'query'=>request()->all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.brand.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    //public function store(StoreBrandPost $request)
    {
        // $request->validate([
        //     'brand_name' => 'required|unique:brand',
        //     'brand_url' => 'required',
        //     ],[
        //         'brand_name.required'=>'品牌名称不能为空',
        //         'brand_name.unique'=>'品牌名称已存在',
        //         'brand_url.required'=>'品牌网址不能为空',
        //     ]);

        $validator = Validator::make($request->all(),
            [
            'brand_name' => 'required|unique:brand',
            'brand_url' => 'required',
            ],[
                'brand_name.required'=>'品牌名称不能为空',
                'brand_name.unique'=>'品牌名称已存在',
                'brand_url.required'=>'品牌网址不能为空',
            ]);
        if ($validator->fails()) {
            return redirect('brand/create')
            ->withErrors($validator)
            ->withInput();
        }

        $post=$request->except(['_token','file']);
        //dd($post);
        $res=Brand::insert($post);
        //dd($res);
        if($res){
            return redirect('/brand');
        }
    }
    public function upload(Request $request){
        if ($request->hasFile('file') && $request->file('file')->isValid()) {
                $photo=$request->file;
                $store_result = $photo->store('photo');
                return $this->success('上传成功',env('IMG_URL').$store_result);
                //return json_encode(['code'=>0,'msg'=>'上传成功','data'=>env('IMG_URL').$store_result]);
                }
                return $this->error('上传失败');
                //return json_encode(['code'=>2,'msg'=>'上传失败']);
            }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $brand=Brand::find($id);
        //dd($brand);
        return view('admin.brand.edit',['brand'=>$brand]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreBrandPost $request, $id)
    {
        $post=$request->except(['_token','file']);
        //dd($post);
        $res=Brand::where('brand_id',$id)->update($post);
        //dd($res);
        if($res!==false){
            return redirect('/brand');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id=0)
    {
        $id=request()->id?:$id;
        //dd($id);
        if(!$id){
            return;
        }
        $res=Brand::destroy($id);
        if(request()->ajax()){
            return $this->success('删除成功');
            //return response()->json(['code'=>0,'msg'=>'删除成功!']);
        }
        if($res){
            return redirect('/brand');
        }
    }
    public function change(Request $request){
        $brand_name=$request->brand_name;
        $id=$request->id;
        if(!$brand_name || !$id){
            return $this->error('缺少参数');
            //return response()->json(['code'=>3,'msg'=>'缺少参数']);
        }
        $res=Brand::where('brand_id',$id)->update(['brand_name'=>$brand_name]);
        if($res){
            return $this->success('修改成功');
            //return response()->json(['code'=>0,'msg'=>'修改成功']);
        }
    }
}
