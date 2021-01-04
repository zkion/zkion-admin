<?php

namespace App\Http\Controllers\Manage;

use App\Models\Manage;
use App\Models\System\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MenuController extends BaseController
{
    public function index()
    {
        $menus = Cache::rememberForever('sys_menus', function () {
            return Menu::with('ancestors')->orderByDesc('sort')->get()->toTree()->toArray();
        });
        return $this->success($menus);
    }

    public function fix()
    {
        Menu::fixTree();
    }

    public function detail(Request $request, $mId)
    {
        $detail = Menu::find($mId);
        $detail->parent_ids = Arr::pluck($detail->ancestors, 'id');
        return $this->apiResponse($detail);
    }

    public function updateOrCreate(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'bail|required',
        ],[
            'name.required' => '请填写菜单名'
        ]);

        if ($validator->fails()) return $this->fail($validator->errors()->first());

        $data = [
            'name' => $request->name,
            'icon' => $request->icon,
            'sort' => $request->sort ?: 0,
            'is_show' => $request->is_show ? 1 : 0,
            'route' => $request->route,
        ];
        DB::beginTransaction();
        try {
            $node = Menu::updateOrCreate([
                'id' => $request->id
            ], $data);
            if ($request->parent_ids) {
                $parentId = Arr::last($request->parent_ids);
                $parentNode = Menu::find($parentId);
                $parentNode->appendNode($node);
            }
            DB::commit();
            return $this->message('操作成功！');
        }catch (\Exception $e) {
            DB::rollBack();
            return $this->message('操作失败！', 400);
        }
    }

    public function refresh(Request $request)
    {
        try {
            Cache::forget('sys_menus');
            return $this->message('操作成功！');
        }catch (\Exception $exception) {
            return $this->fail('操作失败！');
        }
    }

    public function delete(Request $request, $mId)
    {
        try {
            $category = Menu::where('id', '=', $mId)->delete();
            return $this->message('菜单删除成功！');
        }catch (\Exception $exception) {
            return $this->fail('菜单删除失败！');
        }
    }
}
