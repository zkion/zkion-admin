<?php

namespace App\Http\Controllers\Manage;

use App\Http\Resources\Manage\GoodsCollection;
use App\Models\Goods\Goods;
use App\Models\Goods\GoodsCategory;
use App\Models\Goods\GoodsSku;
use App\Models\Goods\GoodsSpec;
use App\Models\Goods\GoodsSpecItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class GoodsController extends BaseController
{
    public function index(Request $request)
    {
        $where = [];
        if ($request->name) $where[] = ['name', 'like', '%'. trim($request->name) .'%'];
        if ($request->status) $where['status'] = $request->status;
        $goods = Goods::query()->with(['category','sku'])->where($where)->orderByDesc('id')->paginate();
        return $this->success([
            'data' => $goods->items(),
            'pagination' => [
                'total' => $goods->total(),
                'current_page' => $goods->currentPage(),
            ]
        ]);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            //商品数据格式化
            $goodsData['name'] = $request->name;
            $goodsData['subtitle'] = $request->subtitle;
            $goodsData['sn'] = Uuid::uuid4()->getHex();
            $goodsData['spec_type'] = $request->spec_type;
            $goodsData['pay_type'] = $request->pay_type;
            $goodsData['thumb'] = $request->thumb;
            $goodsData['brand_id'] = $request->brand_id ?: 0;
            $goodsData['category_id'] = last($request->category_ids);
            $goodsData['category_ids'] = $request->category_ids ? implode('_', $request->category_ids) : '';
            $goodsData['category_names'] = $request->category_names ? implode(',', $request->category_names) : '';
            $goodsData['region_id'] = $request->region_id ?: 0;
            $goodsData['region_ids'] = $request->region_ids ? implode(',', $request->region_ids) : '';
            $goodsData['keywords'] = $request->keywords;
            $goodsData['description'] = $request->description;
            $goodsData['is_free_shipping'] = $request->is_free_shipping ?: 0;
            $goodsData['status'] = $request->status ?: 1;
            $goodsData['tags'] = $request->tags;
            $goodsData['goods_content'] = $request->goods_content;
            $goodsData['sort'] = $request->sort ?: 0;
//            dd($goodsData);
            //添加商品
            $goods = Goods::query()->create($goodsData);

            //Sku数据格式化
            if ($request->spec_type == 1) {
                $skuData['name'] = $goods->name;
                $skuData['price'] = $request->price ?: 0;
                $skuData['marketPrice'] = $request->marketPrice ?: 0;
                $skuData['costPrice'] = $request->costPrice ?: 0;
                $skuData['stock'] = $request->stock ?: 0;
                $skuData['lower_stock'] = $request->lower_stock ?: 0;
                $skuData['goods_weight'] = $request->goods_weight ?: 0;
                $skuData['limit_buy'] = $request->limit_buy ?: 0;
                $skuData['goods_id'] = $goods->id;
//                $skuData['image'] = '';
                $skuData['is_default_sku'] = 1;
                $skuData['items'] = [];
                $skuData['key'] = $goods->id;
                $skuData['key_name'] = $goods->id;
                $skuData['status'] = $request->status ?: 0;
                $skuData['single'] = 1;
                $singleGoodsSku = GoodsSku::query()->create($skuData);
                //更新默认sku
                $goods->sku_id = $singleGoodsSku->id;
                $goods->save();
            }
            elseif ($request->spec_type == 2)
            {
                //多规格
                //添加规格
                $specs = $request->specs;
                foreach ($specs as $sk => $spec) {
                    $newSpec = GoodsSpec::query()->create([
                        'name' => $spec['name'],
                        'goods_id' => $goods->id,
                        'sid' => $spec['sid'],
                        'items' => $spec['items'],
                    ]);
                    //添加规格值
                    foreach ($spec['items'] as $sik => $specItem) {
                        $newSpecItem = GoodsSpecItem::query()->create([
                            'value' => $specItem['value'],
                            'goods_spec_id' => $newSpec->id,
                            'goods_id' => $goods->id,
                            'key' => $specItem['key'],
                            'sid' => $specItem['sid'],
                            'tid' => $specItem['tid'],
                            'image' => $specItem['image'],
                        ]);
                    }
                }
                //添加sku
                $skuItems = $request->skuItems;
                foreach ($skuItems as $skuKey => $skuItem) {
                    $multiGoodsSku = GoodsSku::query()->create([
                        'name' => $skuItem['skuName'],
                        'price' => $skuItem['price'] ?: 0,
                        'marketPrice' => $skuItem['marketPrice'] ?: 0,
                        'costPrice' => $skuItem['costPrice'] ?: 0,
                        'stock' => $skuItem['stock'] ?: 0,
                        'limit_buy' => isset($skuItem['limit_buy']) ? $skuItem['limit_buy'] : 0,
                        'goods_weight' => isset($skuItem['goods_weight']) ? $skuItem['goods_weight'] : 0,
                        'lower_stock' => isset($skuItem['lower_stock']) ? $skuItem['lower_stock'] : 0,
                        'goods_id' => $goods->id,
                        'image' => $skuItem['image'],
                        'items' => $skuItem['items'],
                        'key' => $skuItem['key'],
                        'key_name' => $skuItem['key'],
                        'is_default_sku' => $skuItem['is_default_sku'],
                        'status' => 1,
                    ]);
                }

            }
            DB::commit();
            return $this->message('添加成功');
        }catch (\Exception $exception) {
            DB::rollBack();
            dd($exception->getMessage());
        }
    }
}
