<?php

namespace App\Http\Controllers\Manage;

use App\Models\Manage;
use App\Models\Organization\PermissionGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Mockery\Exception;
use Spatie\Permission\Exceptions\PermissionAlreadyExists;
use Spatie\Permission\Models\Permission;

class PermissionController extends BaseController
{
    public function index(Request $request)
    {
        $permissions = PermissionGroup::query()->with('permissions')->get();
        return $this->success($permissions);
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
        DB::beginTransaction();
        try {
            if ($request->newGroup) {
                $group = PermissionGroup::query()->updateOrCreate([
                    'name' => $request->group_name,
                    'guard' => $request->guard,
                ]);
            } else {
                $group = PermissionGroup::query()->find($request->group);
                if (!$group) return $this->fail('请选择分组！');
            }
            if ($request->id) {
                $newPermission = Permission::query()->where('id', $request->id)->update([
                    'name' => $request->name,
                    'cn_name' => $request->cn_name,
                    'group' => $group->id,
                    'guard_name' => $request->guard,
                    'guard_cn_name' => '后台',
                ]);
            } else {
                if ($request->handleType == 'single') {
                    $newPermission = Permission::create([
                        'name' => $request->name,
                        'cn_name' => $request->cn_name,
                        'group' => $group->id,
                        'guard_name' => $request->guard,
                        'guard_cn_name' => '后台',
                    ]);
                } else {
                    $permissions = explode("\n", strtr($request->permissions, "\r", ''));
                    foreach ($permissions as $permission) {
                        $permission = explode('|', $permission);
                        $newPermission = Permission::create([
                            'name' => $permission[1],
                            'cn_name' => $permission[0],
                            'group' => $group->id,
                            'guard_name' => $request->guard,
                            'guard_cn_name' => '后台',
                        ]);
                    }
                }
            }
            DB::commit();
            return $this->message('操作成功！');
        }catch (\Exception $e) {
            DB::rollBack();
            if ($e instanceof PermissionAlreadyExists) {
                return $this->message('权限已存在！', 400);
            }
            return $this->message('操作失败！', 400);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $record = Permission::query()->find($id);
            $record->delete();
            return $this->message('权限删除成功！');
        }catch (\Exception $exception) {
            return $this->fail('权限删除失败！');
        }
    }

    public function groups(Request $request)
    {
        return $this->success(PermissionGroup::query()->where('guard', 'manage')->get());
    }

    public function group(Request $request, $id)
    {
        return $this->success(PermissionGroup::query()->find($id));
    }

    public function updateGroup(Request $request)
    {
        try {
            PermissionGroup::query()->updateOrCreate(['id' => $request->id], ['name' => $request->name]);
            return $this->message('分组更新成功！');
        }catch (Exception $exception) {
            return $this->message('分组更新失败！');
        }
    }

    public function destroyGroup(Request $request, $id)
    {
        try {
            $record = PermissionGroup::query()->find($id);
            if (Permission::query()->where('group', $id)->count()) {
                return $this->fail('分组下还有权限，无法删除！');
            }
            $record->delete();
            return $this->message('分组删除成功！');
        }catch (\Exception $exception) {
            return $this->fail('分组删除失败！');
        }
    }
}
