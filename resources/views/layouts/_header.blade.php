<nav class="navbar navbar-expand-lg navbar-light bg-light navbar-static-top">
    <div class="container">
        <!-- Branding Image -->
        <a class="navbar-brand " href="{{ url('/') }}">
            LaraBBS
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
                <li class="nav-item {{urlActive('topics.index')}}"><a href="{{route('topics.index')}}"
                        class="nav-link">话题</a></li>
                @foreach($Categorys as $cate)
                <li class="nav-item {{urlActivePar('categories.show','category',$cate->id)}}"><a class="nav-link"
                        href="{{ route('categories.show', $cate->id) }}">{{$cate->name}}</a></li>
                @endforeach
            </ul>
            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav navbar-right">
                <!-- Authentication Links -->
                @guest
                <li class="nav-item"><a class="nav-link" href="{{route('login')}}">登录</a></li>
                <li class="nav-item"><a class="nav-link" href="{{route('register')}}">注册</a></li>
                @else
                <li class="nav-item">
                    <a href="{{route('topics.create')}}" class="nav-link mt-1 mr-3 font-weight-bold">
                        创建话题 <i class="fa fa-plus"></i>
                    </a>
                </li>
                <li class="nav-item notification-badge ">
                    <a href="{{route('notifications.index')}}"
                        class="nav-link mr-3 pr-1 pl-1 badge badge-pill badge-{{Auth::user()->notification_count>0?'hint':'secondary'}} text-white">
                        {{Auth::user()->notification_count}} 条通知
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a href="" class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <img src="{{Auth::user()->avatarFullUrls()}}" class="img-responsive img-circle" width="30px"
                            height="30px">
                        {{Auth::user()->name}}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a href="{{route('users.show',Auth::id())}}" class="dropdown-item">个人中心</a>
                        <a href="{{route('users.edit',Auth::id())}}" class="dropdown-item">编辑资料</a>
                        <div class="dropdown-divider"></div>
                        <a href="" class="dropdown-item" id="logout">
                            <form action="{{route('logout')}}" method="post">
                                @csrf
                                <button class="btn btn-block btn-danger" type="submit">退出</button>
                            </form>
                        </a>
                    </div>
                </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>