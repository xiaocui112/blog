@extends('layouts.app')
@section('content')
<div class="container">
    <div class="col-md-10 offset-md-1">
        <div class="card">
            <div class="card-body">
                <h2>
                    <i class="far fa-edit"></i>
                    @if($topic->id)
                    编辑话题
                    @else
                    新建话题
                    @endif
                </h2>
                <hr>
                @if($topic->id)
                <form action="{{route('topics.update',$topic->id)}}" method="POST">
                    @method('Put')
                    @else
                    <form action="{{route('topics.store')}}" method="POST">
                        @endif
                        @csrf
                        @include("shared._error")
                        <div class="form-group">
                            <input type="text" class="form-control" name="title" value="{{old('title',$topic->title)}}"
                                placeholder="填写标题" required>
                        </div>
                        <div class="form-group">
                            <select class="form-control" name="category_id" required id="">
                                <option value="" hidden disabled {{$topic->id?'':'selected'}}>选择分类</option>
                                @foreach($Categorys as $cate)
                                <option value="{{$cate->id}}" {{$topic->
                                    category_id==$cate->id?"selected":""}}>{{$cate->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <textarea name="body" id="editor" class="form-control" rows="6" placeholder="填写至少三个字符的内容"
                                required>{{old('body',$topic->body)}}</textarea>
                        </div>
                        <div class="well well-sm">
                            <button type="submit" class="form-control btn-primary">
                                <i class="far fa-save mr-2" aria-hidden="true"></i>保存
                            </button>
                        </div>
                    </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('styles')
<link rel="stylesheet" href="{{asset('css/simditor.css')}}">
@endsection

@section('scripts')
<script type="text/javascript" src="{{ asset('js/module.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/hotkeys.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/uploader.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/simditor.js') }}"></script>
<script>
    $(document).ready(function () {
        var editor = new Simditor({
            textarea: $('#editor'),
            upload: {
                url: "{{ route('topics.upload_image') }}",
                params: {
                    _token: '{{ csrf_token() }}'
                },
                fileKey: 'upload_file',
                connectionCount: 3,
                leaveConfirm: '文件上传中，关闭此页面将取消上传。'
            },
            pasteImage: true,
        });
    });
</script>
@endsection