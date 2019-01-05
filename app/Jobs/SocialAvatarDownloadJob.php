<?php

namespace App\Jobs;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use SplFileInfo;

/**
 * 社交账户头像下载
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class SocialAvatarDownloadJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var User user
     */
    public $user;

    /**
     * @var string 微信头像地址
     */
    public $faceUrl;

    /**
     * Create a new job instance.
     *
     * @param User $user
     * @param string $faceUrl
     */
    public function __construct(User $user, $faceUrl)
    {
        $this->user = $user;
        $this->faceUrl = $faceUrl;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $path = UserService::getAvatarPath($this->user->id);
        $baseName = basename($this->faceUrl);
        if (($fileContent = @file_get_contents($this->faceUrl)) != false) {
            $tmpFile = storage_path($baseName);
            file_put_contents($tmpFile, $fileContent);
            $file = new SplFileInfo($tmpFile);
            $fileName = Str::random(40) . '.' . $file->getExtension();
            $filePath = $path . '/' . $fileName;
            Storage::disk(config('user.avatarDisk'))->put($filePath, $fileContent);
            unlink($tmpFile);
            $this->user->update(['avatar' => $filePath]);
        }
    }
}
