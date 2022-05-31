<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * 获取用户列表.
     * @param Request $request
     * @return 用户列表页面
     */
    public function index(Request $request)
    {
        // $input = $request->all();

        // dd($input);
        $user = User::orderBy('user_id','asc')
        ->where(function($query) use($request){
            $username = $request->input('username');
            if(!empty($username)){
                $query->where('user_name','like','%'.$username.'%');
            }
        })
        ->paginate($request->input('num') ? $request->input('num') : 3);
    
        return view('admin.admin-list',compact('user','request'));
    }

    /**
     * 返回用户添加页面
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.admin-add');
    }

    /**
     * 数据库插入操作
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //1.接收前台数据 username phone email pass repass
        $input = $request->all();
        $username = $input['username'];
        $phone =$input['phone'];
        $email = $input['email'];
        $pass = md5($input['pass']);

        //2.进行表单验证
        $user = User::where('user_name',$username)->first();
        if($user){
            $data =[
                'status'=>1,
                'message'=>'添加失败，已存在该用户'
            ];
            return $data;
        }

        //3.添加至数据库
        $res = User::create([
            'user_name'=>$username,
            'user_pass'=>$pass,
            'email'=>$email,
            'phone'=>$phone,
        ]);

        //4.给客户端进行反馈
        if($res){
            $data =[
                'status'=>0,
                'message'=>'添加成功'
            ];

        }else{
            $data =[
                'status'=>1,
                'message'=>'添加失败'
            ];
        }
        return $data;
    }


    /**
     * 显示一条数据
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * 返回修改页面.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * 执行修改操作.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 执行删除操作.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
