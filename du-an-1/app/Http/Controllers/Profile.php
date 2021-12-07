<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class Profile extends Controller
{

    function index($page = 'info'){
        $user = DB::table('users')->select('Email','Fullname','Address','Phone')->where('UserId','=', Session('LoggedUser'))->get()->first();
        $orders = DB::table('orders')
            ->Join('status', 'orders.StatusId', '=','status.StatusId')
            ->select('orders.OrderId','orders.CreateAt','status.*','orders.ToPay')->where('UserId','=', Session('LoggedUser'))->orderBy('OrderId','desc')->get();
        return view('profile',compact('user','page','orders'));
    }
    function update(Request $request){
        $message = [
            'required' => 'Vui lòng nhập :attribute',
            'email' => 'Vui lòng nhập đúng định dạng email',
            'password.min' => 'Các kí tự không đươc ít hơn 6',
            'password.max' => 'Các kí tự không đươc nhiều hơn 50',
            'name.min' => 'Họ và Tên không đươc ít hơn 5',
            'name.max' => 'Họ và Tên không đươc nhiều hơn 100',
        ];
        $validate = Validator::make($request->all(),[
            'name' => 'required|min:5|max:100',
            'password' => 'required|min:6|max:50',
            'email' => 'required|email',
        ],$message);
        if ($validate->fails()) {
            return back()->withErrors($validate)->withInput();
        }
        $user = DB::table('users')->select('password')->where('UserId','=', Session('LoggedUser'))->get()->first();

        if (Hash::check($request->password,  $user->password)) {
            $query = DB::table('users')
                ->where('UserId','=', Session('LoggedUser'))
                    ->update([
                        'fullname' => $request->name,
                        'email' => $request->email,
                        'phone' => $request->phone,
                        'address' => $request->address,
                    ]);
            if($request){
                return back()->with('status','Cập nhật thành công');
            }else{
            return back()->with('status','Cập nhật thất bại đã có lỗi');
            }
        }else{
            return back()->with('status','Mật khẩu không chính xác');
        }
    }
    function changePassword(Request $request){
        $message = [
            'password-current.required' => 'Vui lòng nhập mật khẩu hiện tại',
            'password.required' => 'Vui lòng nhập mật khẩu mới',
            'password_confirmation.required' => 'Vui lòng xác nhận lại mật khẩu',
            'min' => 'Các kí tự không đươc ít hơn 6',
            'max' => 'Các kí tự không đươc nhiều hơn 50',
            'same' => 'Xác nhận mật khẩu không chính xác'
        ];
        $validate = Validator::make($request->all(),[
            'password-current' => 'required|min:6|max:50',
            'password' => ['required','min:6','max:50','same:password_confirmation'],
            'password_confirmation' => 'required|same:password',
        ],$message);
        if ($validate->fails()) {
            return redirect('/profile/change_pass')->withErrors($validate)->withInput();
        }
        $user = DB::table('users')->select('password')->where('UserId','=', Session('LoggedUser'))->get()->first();
        if (Hash::check($request->password,  $user->password)) {
            $query = DB::table('users')
                ->where('UserId','=', Session('LoggedUser'))
                ->update([
                    'password' => Hash::make($request->password),
                ]);
            if($request){
                return back()->with('status','Cập nhật thành công');
            }else{
                return back()->with('status','Cập nhật thất bại đã có lỗi');
            }
        }else{
            return back()->with('status','Mật khẩu không chính xác');
        }
    }

    function OrderDetail(Request $request, $OrderId) {
        $orderDetail = DB::table('orders')
            ->Join('orderdetail', 'orders.OrderId', '=','orderdetail.OrderId')
            ->Join('product', 'orderdetail.ProductId', '=','product.ProductId')
            ->Join('variant', 'orderdetail.VariantId', '=','variant.VariantId')
            ->Where('orders.UserId', Session('LoggedUser'))
            ->Where('orders.OrderId', $OrderId)
            ->Select('variant.Color', 'variant.VariantName', 'orderdetail.Quantity', 'product.Price as ProductPrice', 'variant.Price as VariantPrice', 'orders.ShipFee' ,'orders.ShipDate', 'orders.ToPay')
            ->get();
        return view('profile/orderdetail', compact('orderDetail'));
//        dd($orderDetail);
    }
}
