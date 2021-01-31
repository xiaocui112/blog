<?php

namespace App\Handlers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ImageUploadHandler
{
    /**
     * 允许文件类型
     */
    protected array $allowed_ext = ["png", "jpg", "gif", "jpeg"];
    /**
     * 保存用户上传的头像图片
     *
     * @param UploadedFile $file
     * @param string $folder 文件区
     * @return bool|array
     */
    public function save(UploadedFile $file, string $folder)
    {
        $folder_name = "uploads/images/" . $folder . "/" . date("Ym/d", time());
        $extension = strtolower($file->getClientOriginalExtension()) ?: "png";
        if (!in_array($extension, $this->allowed_ext)) {
            return false;
        };
        $file_static =  Storage::disk("public")->put($folder_name, $file);
        if (!$file_static) {
            return false;
        }
        // $fileimg = storage_path("public");
        // $this->reduceSize($fileimg . "/" . $file_static, 200);
        return [
            "path" => $file_static,
        ];
    }
    /**
     * 剪切图片
     *
     * @param string $file_path
     * @param integer $max_width
     * @return void
     */
    public function reduceSize(string $file_path, int $max_width)
    {
        // 先实例化，传参是文件的磁盘物理路径
        $image = Image::make($file_path);

        // 进行大小调整的操作
        $image->resize($max_width, null, function ($constraint) {

            // 设定宽度是 $max_width，高度等比例缩放
            $constraint->aspectRatio();

            // 防止裁图时图片尺寸变大
            $constraint->upsize();
        });

        // 对图片修改后进行保存
        $image->save();
    }
}
