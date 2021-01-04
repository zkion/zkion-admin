<?php

namespace App\Http\Controllers\Manage;

use App\Models\System\File;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

class UploadController extends BaseController
{
    public function index(Request $request)
    {
        return $request->all();
    }

    public function upload(Request $request)
    {
        DB::beginTransaction();
        try {
            if (!$request->hasFile('file')) return $this->fail('没有找到文件');
            $for = $request->For;
            $forName = '';
            switch ($for) {
                case 'goods-photos':
                    $forName = '商品相册';
            }
            $path = '/images/' . Str::finish(str_replace('-', '/', $for), '/');
            $file = $request->file('file');
            $type = $file->getMimeType();
            $filename = $file->getClientOriginalName();
            $savePath = $file->storeAs(
                $path . Carbon::now()->toDateString(), Carbon::now()->timestamp.Uuid::uuid4()->getHex() . '.' . $file->getClientOriginalExtension()
            );
            $saveFile = File::query()->create([
                'uuid' => Uuid::uuid4()->getHex(),
                'for' => $for,
                'for_name' => $forName,
                'type' => $type,
                'filename' => $filename,
                'url' => Str::finish(rtrim(env('APP_URL'), '/'), '/') . 'uploads/' . $savePath,
                'path' => $type,
            ]);
            DB::commit();
            return $this->apiResponse([
                'uid' => $saveFile->uuid,
                'url' => Str::finish(rtrim(env('APP_URL'), '/'), '/') . 'uploads/' . $savePath,
            ]);
        }catch (\Exception $exception) {
            DB::rollBack();
            return $this->fail('上传失败');
        }
    }
}
