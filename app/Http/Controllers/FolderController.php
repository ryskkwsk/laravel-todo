<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Folder;
use App\Http\Requests\CreateFolder;
use Illuminate\Support\Facades\Auth;

class FolderController extends Controller
{
    public function showCreateForm()
    {
        return view('folders/create');
    }

    public function create(CreateFolder $request)
    {
        // フォルダモデルのインスタンスを作成する
        $folder = new Folder();
        // タイトルに入力値を代入する
        $folder->title = $request->title;
        // インスタンスの状態をデータベースに書き込む
        Auth::user()->folders()->save($folder);

        return redirect()->route('tasks.index', [
            'id' => $folder->id,
        ]);
    }

    public function delete(int $id)
    {
        $folder = Folder::find($id);
 
        $folder_task = $folder->tasks()->get();
        if(!empty($folder_task)){

            $folder_task->each->delete();
        }

        $folder->delete();

        // 選ばれたフォルダを取得する
        $first_folder = Auth::user()->folders()->first();
        if (is_null($first_folder )) {
            return view('home');
        }

        return redirect()->route('tasks.index', [
            'id' => $first_folder->id,
        ]);
    }
}