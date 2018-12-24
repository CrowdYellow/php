@extends('layouts.app')

@include('vendor.ueditor.assets')
@section('content')
    {{--内容区域 start--}}
    <div class="container">
        <div class="row">
            {{--主体部分 start--}}
            <div class="col-md-9">
                {{--问题区域 start--}}
                <div class="panel panel-default">
                    <div class="panel-heading border-hide">
                        <i class="fa fa-tags"></i>
                        @foreach($question->topics as $topic)
                            <a href="{{url('/topic/'.$topic->id)}}" class="topic">{{$topic->name}}</a>
                        @endforeach
                    </div>
                    <div class="panel-heading font-b">{{$question->title}}</div>

                    <div class="panel-body"><p>{!! $question->body !!}</p></div>
                    <div class="panel-footer-set">
                        @if(Auth::check() && user()->owns($question))
                            <a href="{{url('/question/'.$question->id.'/edit')}}">编辑</a>
                            <form action="{{url('/question/'.$question->id)}}" method="POST" class="delete-form">
                                {{ method_field('DELETE') }}
                                {{ csrf_field() }}
                                <button class="button is-naked delete-button">删除</button>
                            </form>
                        @endif
                    </div>
                </div>
                {{--问题区域 end--}}

                {{--回答区域 start--}}
                <div class="panel panel-default">
                    <div class="panel-heading">{{$question->answers_count}}个回答</div>
                </div>
                @foreach($question->answers as $answer)
                <div class="col-md-1">
                    <img width="40" class="img-thumbnail img-circle" src="{{ $answer->user->photos }}" alt="{{ $answer->user->name }}">
                </div>

                <div class="panel panel-default col-md-offset-1 triangle">
                    <div class="panel-heading"><h4 class="media-heading"><a href="#">{{ $answer->user->name }}</a></h4></div>
                    <div class="panel-body">
                        <div class="media">
                            <div class="media-left">
                                <button class="btn btn-default">0</button>
                            </div>
                            <div class="media-body">
                                <div class="media-body">{!! $answer->body !!}</div>
                            </div>
                            <div class="media-bottom"><a href="#">0评论</a></div>
                        </div>
                    </div>
                </div>
                @endforeach
                {{--<div class="panel panel-default">--}}
                    {{--<div class="panel-heading">{{$question->answers_count}}个回答</div>--}}
                    {{--@foreach($question->answers as $answer)--}}
                    {{--<div class="panel-body">--}}
                        {{--<div class="media">--}}
                            {{--<div class="media-left">--}}
                                {{--<button class="btn btn-default">0</button>--}}
                            {{--</div>--}}
                            {{--<div class="media-body">--}}
                                {{--<h4 class="media-heading"><a href="#">{{ $answer->user->name }}</a></h4>--}}
                                {{--<div class="media-body">{!! $answer->body !!}</div>--}}
                            {{--</div>--}}
                            {{--<div class="media-bottom"><a href="#">0评论</a></div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--@endforeach--}}
                {{--</div>--}}
                {{--回答区域 end--}}

                {{--编辑回答 start--}}
                <div class="panel panel-default">
                    <div class="panel-body">
                        @if(Auth::check())
                        <form class="form-horizontal" action="{{url('/questions/'.$question->id.'/answer')}}" method="post">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <div class="col-md-12">
                                    <script id="container" name="body" type="text/plain">{!! old('body') !!}</script>
                                </div>
                            </div>
                            <button class="btn btn-success pull-right" type="submit">提交答案</button>
                        </form>
                        @else
                            <a href="{{ url('login') }}" class="btn btn-success btn-block">登录提交答案</a>
                        @endif
                    </div>
                </div>
                {{--编辑回答 end--}}
            </div>
            {{--主体部分 end--}}

            {{--侧边栏 start--}}
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="media">
                            <div class="media-heading text-center padding-tb-0">
                                <a href="#">
                                    <img class="img-circle img-80" alt="Taylor Swift" src="{{asset($question->user->photos)}}">
                                </a>
                            </div>
                            <div class="media-body text-center padding-tb-0">
                                <div class="row padding-tb-0">
                                    <div class="col-md-12"><a href="#">{{$question->user->name}}</a></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">回答</div>
                                    <div class="col-md-4">问题</div>
                                    <div class="col-md-4">关注</div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 user-basic-info">{{$question->user->answers_count}}</div>
                                    <div class="col-md-4 user-basic-info">{{$question->user->questions_count}}</div>
                                    <div class="col-md-4 user-basic-info">{{$question->user->followers_count}}</div>
                                </div>
                            </div>
                            @if(Auth::check() && !user()->owns($question))
                            <div class="media-bottom padding-tb-0">
                                <button class="btn btn-block btn-default btn-color-green"><i class="fa fa-plus"></i>&nbsp;&nbsp; 关注</button>
                                <button class="btn btn-block btn-default"><i class="fa fa-envelope"></i>&nbsp;&nbsp; 私信</button>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading text-center"><h2>1</h2> <span>关注者</span></div>
                    <div class="panel-body">
                        @if(Auth::check() && !user()->owns($question))
                        <button class="btn btn-default"><i class="fa fa-heart"></i> 关注该问题</button>
                        @endif
                        <a href="#editor" class="btn btn-primary pull-right"><i class="fa fa-pencil"></i> 撰写答案</a>
                    </div>
                </div>
            </div>
            {{--侧边栏 end--}}
        </div>
    </div>
    {{--内容区域 end--}}
@section('js')
    <script type="text/javascript">
        var ue = UE.getEditor('container', {
            toolbars: [
                ['bold', 'italic', 'underline', 'strikethrough', 'blockquote', 'insertunorderedlist', 'insertorderedlist', 'justifyleft','justifycenter', 'justifyright',  'link', 'insertimage', 'fullscreen']
            ],
            elementPathEnabled: false,
            enableContextMenu: false,
            autoClearEmptyNode:true,
            wordCount:false,
            imagePopup:false,
            autotypeset:{ indent: true,imageBlockLine: 'center' }
        });
        ue.ready(function() {
            ue.execCommand('serverparam', '_token', '{{ csrf_token() }}'); // 设置 CSRF token.
        });
    </script>
@endsection
@endsection
