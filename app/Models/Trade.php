<?php


namespace App\Models;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Trade
{
    public function getGoods($user = null)
    {
        if($user) {
            return DB::select("SELECT g.title, sg.* FROM sellers_goods as sg LEFT JOIN goods as g ON g.id = sg.good WHERE sg.user = :user ORDER BY g.title", ['user' => Auth::id()]);
        }
        return DB::table('goods')->orderBy('title')->get()->toArray();
    }

    public function getOrders($user = null)
    {
        $items = DB::table('orders_goods')
            ->leftJoin('orders', 'orders.id', '=', 'orders_goods.order')
            ->leftJoin('goods', 'goods.id', '=', 'orders_goods.good')
            ->orderBy('orders_goods.order')
            ->orderBy('goods.title');
        if($user) $items->where('orders.user', $user);
        $items = $items->get(['goods.title', 'orders_goods.*'])->toArray();
        $out = [];
        if($items)
            foreach($items as $item) {
                $out[$item->order][] = $item;
            }
        return $out;
    }

    public function getsellerOrders($user)
    {
        $orders = $this->getOrders();

        $goods = DB::table('sellers_goods')->where('user', $user)->get();

        // Время поджимает и я не могу пока придумать лучшего решения.
        $out = [];
        if ($orders) {
            foreach ($orders as $key => $order) {
                foreach ($order as $key1 => $item) {
                    $have = $this->checkPosition($item, $goods);
                    if(!$have) continue 2;
                    $order[$key1]->have = $have;
                }
                $out[$key] = $order;
            }
        }
        return $out;
    }

    private function checkPosition($item, $goods)
    {
        $count = 0;
        foreach($goods as $good) {
            if($good->price >= $item->priceMin &&
                $good->price <= $item->priceMax &&
                ($item->state == 'used' || $good->state == 'new') &&
                $good->good == $item->good) $count += $good->count;
        }
        if($count >= $item->count) return $count;

        return null;
    }

    public function addGoods(Request $request)
    {
        if (!$request->exists('goodsTitle')) return false;

        // Сперва поиск товара
        $item = DB::table('goods')->where('title', $request->get('goodsTitle'))->value('id');

        // если такого товара еще нет - добавляем
        if (!$item) $item = DB::table('goods')->insertGetId(['title'=>$request->get('goodsTitle')]);


        // Поиск товара, подходящего по другим параметрам
        if (!$request->exists('goodsPrice')) return false;
        $sellerItem = DB::table('sellers_goods')
            ->where('user', Auth::id())
            ->where('good', $item)
            ->where('price', $request->get('godsPrice'))
            ->where('state', $request->exists('GoodsUsed')?'used':'new')
            ->value('id');

        if($sellerItem) {
            if (!$request->exists('goodsCount')) return false;
            DB::update("UPDATE sellers_goods SET count = count + :count WHERE id = :id", ['id'=>$sellerItem, 'count'=>$request->get('GoodsCount')]);
        }
        else {
            $params = [
                'good' => $item,
                'user' => Auth::id(),
                'price' => $request->get('goodsPrice'),
                'count' => $request->get('goodsCount'),
                'state' => $request->exists('goodsUsed')?'used':'new'
            ];
            DB::table('sellers_goods')->insert($params);
        }
        return true;
    }

    public function addOrder(Request $request)
    {
        if(!$request->exists('orderGood') ||
            !$request->exists('orderPriceMin') ||
            !$request->exists('orderPriceMax') ||
            !$request->exists('orderCount') ||
            !$request->exists('orderUsed')
        ) return false;
        $items = $request->get('orderGood');
        $pricesMin = $request->get('orderPriceMin');
        $pricesMax = $request->get('orderPriceMax');
        $count = $request->get('orderCount');
        $used = $request->get('orderUsed');

        $id = DB::table('orders')->insertGetId(['user'=>Auth::id()]);
        if($items) {
            foreach($items as $key => $item) {
                $good = DB::table('goods')->where('id', $item)->value('id');
                if(!$good) continue;
                if(!isset($pricesMin[$key]) || !isset($pricesMax[$key]) || !isset($used[$key]) || !isset($count[$key])) continue;
                $params = [
                    'order' => $id,
                    'good' => $good,
                    'priceMin' => $pricesMin[$key],
                    'priceMax' => $pricesMax[$key],
                    'count' => $count[$key],
                    'state' => $used[$key] == 'new'?'new':'used'
                ];
                DB::table('orders_goods')->insert($params);
            }
        }
        return true;
    }
}
