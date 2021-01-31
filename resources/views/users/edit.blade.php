@extends('layouts.app')
@section('title',"编辑个人资料")
@section('content')
<div class="container">
    <div class="col-md-8 offset-md-2 ">
        <div class="card shadow">
            <div class="card-header">
                <h4>
                    <i class="glyphicon glyphicon-edit"></i>编辑个人资料
                </h4>
            </div>
            <div class="card-body">
                @include('shared._error')
                <form action="{{route('users.update',Auth::id())}}" method="post" enctype="multipart/form-data">
                    @method("PUT")
                    @csrf
                    <div class="form-group">
                        <label for="name-field">用户名</label>
                        <input type="text" name="name" id="" class="form-control"
                            value="{{old('name',Auth::user()->name)}}">
                    </div>
                    <div class="from-group">
                        <label for="email-field">邮箱</label>
                        <input type="email" name="email" id="" class="form-control"
                            value="{{old('email',Auth::user()->email)}}">
                    </div>
                    <div class="form-group">
                        <label for="introduction-field">个人简介</label>
                        <textarea name="introduction" id="" rows="3"
                            class="form-control">{{old('introduction',Auth::user()->introduction)}}</textarea>
                    </div>
                    <div class="form-group mb-4">
                        <label class="avatar-label">用户头像</label>
                        <input type="file" name="avatar" id="" class=" form-control-file">
                        @if($user->avatar)
                        <br>
                        <img src="{{$user->avatarFullUrls()}}" alt=" "
                            style="overflow:hidden; max-width: 200px; max-height: 200px;"
                            class="thumbnail img-responsive">
                        @endif
                    </div>
                    <div class="well well-sm">
                        <button type="submit" class="form-control btn-primary">保存</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection