<?php

use App\Models\BanWord;
use Illuminate\Database\Seeder;

/**
 * 导入屏蔽词
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class BanWordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $files = scandir(database_path('data/ban_word'));
        foreach ($files as $file) {
            if ($file == '.' || $file == '..') continue;
            $content = file_get_contents(database_path('data/ban_word/'.$file));
            $words = explode("@", $content);
            $wordsLen = count($words);
            for ($i = 0; $i < $wordsLen; $i++) {
                $words[$i] = trim($words[$i]);
                if ((strlen($words[$i]) > 0 && !empty($words[$i])) && !BanWord::where('word', '=', $words[$i])->exists()) {
                    Banword::create(['word' => $words[$i],]);
                }
            }
        }
    }
}
