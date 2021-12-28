<?php
namespace App\Http\Controllers\Auth;
use App\Models\User; //透過這MOdel(User Model)對應到資料表users
use Illuminate\support\Facades\Hash;//引入雜湊類別，主要用於密碼的雜湊生成
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
//全部Usrcontroller中的函數皆使用auth中介層
public function __construct(){
    $this->middleware('auth');
}
//回傳修改會員資料的網頁介面，並指定View中“$hint"變數值為0,0代表不需顯示任何提示資訊在網頁中
public function modifyUser(){
    return view('auth.modify-user',['hint'=>'0']);
}
//19 需要傳入HTTP body: id.password.name.sex.telephone.birthday..這些可以透過Request類別物件$data取得
public function modifyUserData(Request $data){
    $user = User::findOrFail($data['id']); //ORM 撈資料
    if(!(Hash::check($data['password'], $user->password)))//透過Hashcheck 檢查密碼是否正確
        //23 如果密碼錯誤 View中hint變數值為2,2代表密碼錯誤
        return view('auth.modify-user',['hint' => '2']);
    //25 若密碼正確 將$data更新，並回到修改會員網頁介面
    else{
        $update_data=[
            'name'=>$data['name'],
            'sex'=>$data['sex'],
            'telephone'=>$data['telephone'],
            'birthday' => $data['birthday'],
            'memo'=> $data['memo']
        ];
        $user->update($update_data);
    }
    //1代表更新完成
    return view('auth.modify-user',['hint'=>'1']);
}
public function modifyUserPwd(){
    return view('auth.modify-pwd',['hint'=>'0']);
}
public function modifyUserPwdData(Request $data){
    $user = User::findOrFail($data['id']);
    if(!(Hash::check($data['password-old'],$user->password)))//檢查密碼是否對
        return view('auth.modify-pwd',['hint'=>'2']);
    else{
        if ($data['password-new'] === $data['password-conf']){
            $update_data=[
                'password' => Hash::make($data['password-new']),//另用雜湊修改密碼
            ];
            $user->update($update_data);  
            return view('auth.modify-pwd',['hint'=>'1']);
        }
        else{
            return view('auth.modify-pwd',['hint'=>'3']);
        }
    }
}
public function deleteUser(){
    return view('auth.delete-user', ['hint'=>'0']);
}
public function deleteUserData(Request $data){
    $user = User::findOrFail($data['id']);
    if(!(Hash::check($data['password'],$user->password)))
        return view('auth.delete-user',['hint'=>'2']);
    else{
        $user->delete();
        return view('auth.delete-user',['hint'=>'1']);
    }
}
}
