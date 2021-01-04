<?php

namespace App\Http\Controllers\Manage;

use App\Models\Goods\GoodsCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;

class GoodsCategoryController extends BaseController
{
    public function query()
    {
        $categories = Cache::rememberForever('goods_categories', function () {
            return GoodsCategory::get()->toTree()->toArray();
        });
        return $this->apiResponse($categories);
    }

    public function detail(Request $request)
    {
        $detail = GoodsCategory::find($request->cId);
        $detail->parent_ids = Arr::pluck($detail->ancestors, 'id');
        return $this->apiResponse($detail);
    }



    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'bail|required',
        ],[
            'name.required' => '请填写分类名'
        ]);

        if ($validator->fails()) return $this->fail($validator->errors()->first());

        DB::beginTransaction();
        try {
//            return implode($request->parent_ids,'_');
            $cover = null;
            if ($request->hasFile('cover')) {
                $saveCover = $request->file('cover')->storeAs(
                    '/images/goods/category/' . Carbon::now()->toDateString(), Carbon::now()->timestamp.Uuid::uuid4()->getHex() . '.' . $request->file('cover')->getClientOriginalExtension()
                );
                $cover = env('APP_URL') . '/uploads/' . $saveCover;
            }
            $formData = $request->except(['cover','parent','parent_names']);
            $formData['goods_model_id'] = $formData['goods_model_id']?:0;
            $formData['parent'] = $formData['goods_model_id']?:0;
            $formData['is_show'] = $formData['is_show']?1:0;
            $formData['cover'] = $cover;
//return $formData;
            $node = GoodsCategory::create($formData);
            if ($request->parent_ids) {
                $parentId = Arr::last(explode(',', $request->parent_ids));
                $parentNode = GoodsCategory::find($parentId);
                $parentNode->appendNode($node);

                $node->last_pid = $parentId;
                $node->save();
            }
            DB::commit();
            return $this->message('分类添加成功');
        }catch (\Exception $e) {
            DB::rollBack();
            return $this->message('分类添加失败', 400);
        }
    }

    public function update(Request $request, $cId)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'bail|required',
        ],[
            'name.required' => '请填写分类名'
        ]);

        if ($validator->fails()) return $this->fail($validator->errors()->first());

        DB::beginTransaction();
        try {
            $node = GoodsCategory::find($cId);
//            return implode($request->parent_ids,'_');
            $node->cover = $request->cover;
            if ($request->hasFile('cover')) {
                $saveCover = $request->file('cover')->storeAs(
                    '/images/goods/category/' . Carbon::now()->toDateString(), Carbon::now()->timestamp.Uuid::uuid4()->getHex() . '.' . $request->file('cover')->getClientOriginalExtension()
                );
                $node->cover = env('APP_URL') . '/uploads/' . $saveCover;
            }
            if ($request->parent_ids) {
                $parentId = Arr::last(explode(',', $request->parent_ids));
                if ($parentId <> $node->last_pid) {
                    $node->parent_id = $parentId;
                    $node->last_pid = $parentId;
                }
            }

            $node->name = $request->name;
            $node->sub_name = $request->sub_name;
            $node->goods_model_id = $request->goods_model_id ?: 0;
            $node->icon = $request->icon;
            $node->sort = $request->sort;
            $node->layout_id = $request->layout_id;
            $node->is_recommend = $request->is_recommend;
            $node->is_show = $request->is_show ? 1 : 0;
            $node->status = $request->status;
            $node->link = $request->link;
            $node->keywords = $request->keywords;
            $node->description = $request->description;
            $node->save();

            DB::commit();
            return $this->message('分类修改成功');
        }catch (\Exception $e) {
            DB::rollBack();
            return $this->message('分类修改失败', 400);
        }
    }

    public function delete(Request $request, $cId)
    {
        try {
            $category = GoodsCategory::where('id', '=', $cId)->delete();
            return $this->message('分类删除成功！');
        }catch (\Exception $exception) {
            return $this->fail('分类删除失败！');
        }
    }
}
