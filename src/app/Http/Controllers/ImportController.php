<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use Illuminate\Support\Facades\DB;

class ImportController extends Controller
{
    public function showImportForm()
    {
        return view('admin.import');
    }

    public function import(Request $request)
    {
        $file = $request->file('csv_file');
        $data = file_get_contents($file);

        $data = mb_convert_encoding($data, 'UTF-8', 'auto');
        $data = str_replace("\xEF\xBB\xBF", '', $data);

        $rows = array_map("str_getcsv", explode("\n", $data));
        $header = array_map('trim', array_shift($rows));

        $area_map = [
            '東京都' => 1,
            '大阪府' => 2,
            '福岡県' => 3,
        ];

        $genre_map = [
            '寿司' => 1,
            '焼肉' => 2,
            '居酒屋' => 3,
            'イタリアン' => 4,
            'ラーメン' => 5,
        ];

        $errors = [];

        foreach ($rows as $key => $row) {
            $row = array_combine($header, array_map('trim', $row));

            if (empty($row['店舗名'])) {
                $errors[] = ": 店舗名を入力してください。";
            } elseif (mb_strlen($row['店舗名']) > 50) {
                $errors[] = ": 店舗名は50文字以内で入力してください。";
            }

            if (empty($row['地域'])) {
                $errors[] = ": 地域を入力してください。";
            } elseif (!isset($area_map[$row['地域']])) {
                $errors[] = ": 地域は東京都、大阪府、福岡県のどれかを記入してください。";
            }

            if (empty($row['ジャンル'])) {
                $errors[] = ": ジャンルを入力してください。";
            } elseif (!isset($genre_map[$row['ジャンル']])) {
                $errors[] = ": ジャンルは寿司、焼肉、イタリアン、居酒屋、ラーメンのどれかを記入してください。";
            }

            if (empty($row['店舗概要'])) {
                $errors[] = ": 店舗概要を入力してください。";
            } elseif (mb_strlen($row['店舗概要']) > 255) {
                $errors[] = ": 店舗概要は255文字以内で入力してください。";
            }

            if (empty($row['画像URL'])) {
                $errors[] = ": 画像URLを入力してください。";
            } else {
                $urlHeaders = @get_headers($row['画像URL']);
                if (!$urlHeaders || strpos($urlHeaders[0], '200 OK') === false) {
                    $errors[] = ": 画像URLが無効です。インターネット上にアップロードされている画像のURLを入力してください。";
                }
            }

        }


        if (!empty($errors)) {
            return redirect()->route('import-form')->with('error', implode('<br>', $errors));
        }

        foreach ($rows as $row) {
        }

        return redirect()->route('import-form')->with('success', 'ショップが追加されました。');
    }

}
