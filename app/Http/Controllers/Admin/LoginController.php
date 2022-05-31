<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Contracts\Session\Session;

class LoginController extends Controller
{
    //打开后台登录页面
    public function login()
    {
        return view('admin.login');
    }

    // 验证码生成
    public function captcha(Request $request)
    {

        $phrase = new PhraseBuilder;
        // 设置验证码位数
        $code = $phrase->build(4);
        // 生成验证码图片的Builder对象，配置相应属性
        $builder = new CaptchaBuilder($code, $phrase);
        // 设置背景颜色
        $builder->setBackgroundColor(220, 210, 230);
        $builder->setMaxAngle(25);
        $builder->setMaxBehindLines(0);
        $builder->setMaxFrontLines(0);
        // 可以设置图片宽高及字体
        $builder->build($width = 120, $height = 50, $font = null);
        // 获取验证码的内容
        $phrase = $builder->getPhrase();
        // 把内容存入session
        $request->session()->flash('captcha', $phrase);
        // 生成图片
        header("Cache-Control: no-cache, must-revalidate");
        header("Content-Type:image/jpeg");
        $builder->output();
        //return response($builder->output())->header('Content-type','image/jpeg'); //把验证码数据以jpeg图片的格式输出
    }

    public function doLogin(Request $request)
    {
        //1.接收表单提交的数据
        $input = $request->except('_token');
        //2.进行表单验证
        $rule = [
            'username'=>'required|between:4,18',
            'password'=>'required|between:4,18|alpha_dash',
        ];
        $msg = [
            'username.required'=>'用户名必须输入',
            'username.between'=>'用户名必须在4-18位之间',

            'password.required'=>'密码必须输入',
            'password.between'=>'密码必须在4-18位之间',
            'password.alpha_dash'=>'只可以含有字母、数字，短破折号（-）和下划线（）',
        ];
        $validator = Validator::make($input, $rule,$msg);

        if ($validator->fails()) {
            return redirect('admin/login')
                        ->withErrors($validator)
                        ->withInput();
        }

        //3.验证是否有此用户（用户名 密码 验证码）
            if(strtolower($input['captcha']) != strtolower($request->session()->get('captcha')))
            {
                return redirect('admin/login')->withErrors(['message' => '验证码错误']);
            }
            $user = User::where('user_name',$input['username'])->first();
            if(!$user){
                return redirect('admin/login')->withErrors(['message' => '没有该用户']);
            }

            if(md5($input['password']) != $user['user_pass'] )
            {
                return redirect('admin/login')->withErrors(['message' => '密码错误']);
            }

            //4.保存用户信息到session中
            $request->session()->put('user',$user);

            //5.跳转到后台首页
            return redirect('admin/index');


    }


    public function index()
    {
        return view('admin.index');
    }

    public function welcome()
    {
        return view('admin.welcome');
    }

    public function logout()
    {
        //1.清空session
        session()->flush();
        //2.重定向到登录页面
        return redirect('admin/login');
    }
}
