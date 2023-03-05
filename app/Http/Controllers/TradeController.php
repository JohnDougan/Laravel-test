<?php

namespace App\Http\Controllers;

use App\Models\Trade;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class TradeController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getGoods()
    {
        $model = new Trade();
        $user = \App\Models\User::getUserData(Auth::id());

        $goods = $model->getGoods($user->id);
        $allGoods = $model->getGoods();

        return view('sellerGoods', ['user'=>$user, 'active'=>'goods','goods'=>$goods,'allGoods'=>$allGoods]);
    }

    public function getOrders()
    {
        $model = new Trade();
        $user = \App\Models\User::getUserData(Auth::id());

        if($user->type == 'buyer') {
            return view('buyerOrders', ['user'=>$user, 'active'=>'orders','orders'=>$model->getOrders(Auth::id()),'allGoods'=>$model->getGoods()]);
        } else {
            return view('sellerOrders', ['user'=>$user, 'active'=>'orders','orders'=>$model->getSellerOrders(Auth::id())]);
        }

    }

    public function actionGoodsAdd(Request $request)
    {
        $model = new Trade();
        $model->addGoods($request);

        return redirect()->route('goods');
    }

    public function actionOrdersAdd(Request $request)
    {
        $model = new Trade();
        $model->addOrder($request);

        return redirect()->route('orders');
    }
}
