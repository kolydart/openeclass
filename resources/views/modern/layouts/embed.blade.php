<!-- BEGIN mainBlock -->
<!DOCTYPE HTML>
<html style="height: 100%;" lang="{{ $language }}">
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <title>{{ $pageTitle }}</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- jQuery -->
    <script type="text/javascript" src="{{ $urlAppend }}js/jquery-3.6.0.min.js"></script>

    <!-- Latest compiled and minified JavaScript -->
    <!-- <script src="{{ $template_base }}/js/bootstrap.min.js"></script> -->
    <!-- Bootstrap v5 -->
    <link rel="stylesheet" type="text/css" href="{{ $urlAppend }}template/modern/css/bootstrap.min.css"/>
    <script type="text/javascript" src="{{$urlAppend}}js/bootstrap.bundle.min.js"></script>

    <!-- new link for input icon -->
    <!-- Font Awesome - A font of icons -->
    <link rel="stylesheet" href="{{ $urlAppend }}template/modern/css/all.css">
    <link href="{{ $urlAppend }}template/modern/css/font-awesome-4.7.0/css/font-awesome.css" rel="stylesheet">

    <!-- DataTables and Checkitor -->
    <link rel="stylesheet" href="{{ $urlAppend }}template/modern/css/jquery.dataTables.min.css">
    <script src="{{ $urlAppend }}js/jquery.dataTables.min.js"></script>
    <script src="{{ $urlAppend }}js/classic-ckeditor.js"></script>

     <!-- BootBox -->
    <script src="{{ $urlAppend }}js/bootbox/bootbox.min.js"></script>
    <!-- SlimScroll -->
    <script src="{{ $urlAppend }}js/jquery.slimscroll.min.js"></script>
    <!-- BlockUI -->
    <script src="{{ $urlAppend }}js/blockui-master/jquery.blockUI.js"></script>
    <!-- Tinymce -->
    <script src="{{ $urlAppend }}js/tinymce/tinymce.min.js"></script>
    <!-- Screenfull -->
    <script src="{{ $urlAppend }}js/screenfull/screenfull.min.js"></script>

    <script>
    bootbox.setDefaults({
      locale: "{{ $language }}"
    });
    </script>


    <!-- Our css modern if we need it -->
    <link rel="stylesheet" type="text/css" href="{{ $urlAppend }}template/modern/css/slick.css"/>
    <link rel="stylesheet" type="text/css" href="{{ $urlAppend }}template/modern/css/sidebar.css"/>
    <link rel="stylesheet" type="text/css" href="{{ $urlAppend }}template/modern/css/new_calendar.css"/>
    <link rel="stylesheet" type="text/css" href="{{ $urlAppend }}template/modern/css/slick-theme.css"/>
    <link rel="stylesheet" type="text/css" href="{{ $urlAppend }}template/modern/css/default.css"/>


    @if (isset($styles_str) && $styles_str)
    <style>
        {!! $styles_str !!}
    </style>
    @endif

    <!-- Our js modern -->
    <script type="text/javascript" src="{{ $urlAppend }}js/slick.min.js"></script>
    <script type="text/javascript" src="{{ $urlAppend }}js/custom.js"></script>
    <script type="text/javascript" src="{{ $urlAppend }}js/viewStudentTeacher.js"></script>
    <script type="text/javascript" src="{{ $urlAppend }}js/sidebar_slider_action.js"></script>

    {!! $head_content !!}

    @stack('head_styles')

</head>
<body class='h-100'>
    <div class="container h-100">
        <div class="row h-100" id="Frame">
            {{-- <div id="background-cheat" class="col-xs-10 col-xs-push-2" style="height: 100%;"></div> --}}
            <div id="main-content" class="col-10 h-100 overflow-scroll">
                <div class="row row-main">
                    <div class="col-md-12 add-gutter">
                        @if ($messages)
                            <div class='row'>
                                <div class='col-12'>{!! $messages !!}</div>
                            </div>
                        @endif
                        @yield('content')
                    </div>
                </div>
            </div>
            <div id="leftnav" class="col-2 sidebar embeded bg-light">
                <div class="panel-group mt-1" id="sidebar-accordion">
                    <div class="panel">
                        @foreach ($toolArr as $key => $tool_group)
                        <div id="collapse{{ $key }}" class="panel-collapse list-group collapse{{ $tool_group[0]['class'] }}">
                            @foreach ($tool_group[1] as $key2 => $tool)
                            <a href="{{ $tool_group[2][$key2] }}" class="list-group-item {{ module_path($tool_group[2][$key2]) == $current_module_dir ? " active" : ""}}">
                                <span class="fa {{ $tool_group[3][$key2] }} fa-fw"></span>
                                <span>{!! $tool !!}</span>
                            </a>
                            @endforeach
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
