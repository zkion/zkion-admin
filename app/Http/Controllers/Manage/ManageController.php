<?php

namespace App\Http\Controllers\Manage;

use App\Models\Manage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ManageController extends BaseController
{
    public function index(Request $request)
    {
        $where = [];
        if ($request->name) $where[] = ['name', 'like', '%'. trim($request->name) .'%'];
        $goods = Manage::query()->where($where)->with('departments')->orderByDesc('id')->paginate();
        return $this->success([
            'data' => $goods->items(),
            'pagination' => [
                'total' => $goods->total(),
                'current_page' => $goods->currentPage(),
            ]
        ]);
    }

    public function detail(Request $request, $id)
    {
        try {
            $record = Manage::query()->with('departments')->find($id);
            return $this->success($record);
        }catch (\Exception $exception) {
            return $this->fail('员工删除失败！');
        }
    }

    public function updateOrCreate(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'bail|required',
            'departments' => 'bail|required',
        ],[
            'name.required' => '请填写员工名称',
            'departments.required' => '请选择部门',
        ]);
        if ($validator->fails()) return $this->fail($validator->errors()->first());

        DB::beginTransaction();
        try {
            $data['name'] = $request->name;
            if ($request->password) $data['password'] = trim($request->password);
            if ($request->real_name) $data['real_name'] = trim($request->real_name);

            $manage = Manage::query()->updateOrCreate([
                'id' => $request->id
            ], $data);
            if ($request->id) {
                $manage->departments()->sync($request->departments);
            } else {
                $manage->departments()->attach($request->departments);
            }
            DB::commit();
            return $this->message('操作成功！');
        }catch (\Exception $e) {
            DB::rollBack();
            return $this->message('操作失败！', 400);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $record = Manage::query()->find($id);
            $record->delete();
            return $this->message('员工删除成功！');
        }catch (\Exception $exception) {
            return $this->fail('员工删除失败！');
        }
    }
}
