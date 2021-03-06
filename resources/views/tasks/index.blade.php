@extends('layout')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col col-md-4">
        <nav class="panel panel-default">
          <div class="panel-heading">フォルダ</div>
          <div class="panel-body">
            <a href="{{ route('folders.create') }}" class="btn btn-default btn-block">
              フォルダを追加する
            </a>
          </div>
          <div class="list-group">
            @foreach($folders as $folder)
              <a
                  href="{{ route('tasks.index', ['folder' => $folder->id]) }}"
                  class="list-group-item {{ $current_folder_id === $folder->id ? 'active' : '' }}"
              >
                {{ $folder->title }}
              </a>
            @endforeach
          </div>
        </nav>
      </div>
      <div class="column col-md-8">
        <div class="panel panel-default">
          <div class="panel-heading">タスク</div>
          <div class="panel-body">
            <div class="text-right">
                <a href="{{ route('tasks.create', ['folder' => $current_folder_id]) }}" class="btn btn-default btn-block">
                タスクを追加する
                </a>
                <form method="post" action="/folders/{{ $current_folder_id }}/delete">
                @csrf
                    <input type="submit" value="このフォルダを削除する" class="btn btn-default btn-block" onclick='return confirm("削除してもよろしいですか？");'>
                </form>
            </div>
          </div>
          <table class="table">
            <thead>
            <tr>
              <th>タイトル</th>
              <th>状態</th>
              <th>期限</th>
              <th>編集</th>
              <th>削除</th>
            </tr>
            </thead>
            <tbody>
            @foreach($tasks as $task)
              <tr>
                <td>{{ $task->title }}</td>
                <td>
                  <span class="label {{ $task->status_class }}">{{ $task->status_label }}</span>
                </td>
                <td>{{ $task->formatted_due_date }}</td>
                 <td>
                    <form method="get" action="/folders/{{ $task->folder_id }}/tasks/{{ $task->id }}/edit">
                    @csrf
                        <input type="submit" value="編集" class="btn btn-primary btn-xs">
                    </form>
                </td>
                <td>
                    <form method="post" action="/folders/{{ $task->folder_id }}/tasks/{{ $task->id }}/delete">
                    @csrf
                        <input type="submit" value="削除" class="btn btn-danger btn-xs" onclick='return confirm("削除してもよろしいですか？");'>
                    </form>
                </td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection