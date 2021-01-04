<?php

namespace App\Http\Controllers\Manage;

use App\Models\Manage;
use App\Models\Organization\Department;
use App\Models\System\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DepartmentController extends BaseController
{
    public function index(Request $request)
    {
        $where = [];
        if ($request->name) $where[] = ['name', 'like', '%'. trim($request->name) .'%'];
        $paginated = Department::query()->where($where)->orderByDesc('id');
        if ($request->type == 'all') {
            $paginated = $paginated->get();
            return $this->success($paginated);
        } else {
            $paginated = $paginated->paginate();
        }
        return $this->success([
            'data' => $paginated->items(),
            'pagination' => [
                'total' => $paginated->total(),
                'current_page' => $paginated->currentPage(),
            ]
        ]);
    }

    public function detail(Request $request, $id)
    {
        try {
            $record = Department::query()->find($id);
            return $this->success($record);
        }catch (\Exception $exception) {
            return $this->fail('部门删除失败！');
        }
    }

    public function updateOrCreate(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'bail|required',
        ],[
            'name.required' => '请填写部门名称'
        ]);
        if ($validator->fails()) return $this->fail($validator->errors()->first());

        try {
            Department::query()->updateOrCreate([
                'id' => $request->id
            ], [
                'name' => $request->name,
            ]);
            return $this->message('操作成功！');
        }catch (\Exception $e) {
            DB::rollBack();
            return $this->message('操作失败！', 400);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $record = Department::query()->find($id);
            $record->delete();
            return $this->message('部门删除成功！');
        }catch (\Exception $exception) {
            return $this->fail('部门删除失败！');
        }
    }
}
