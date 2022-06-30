@extends('layouts.default')

@section('content')


<div class="pb-3 pt-3">

    <div class="container-fluid main-container">

        <div class="row">

            <div class="col-xl-2 col-lg-2 col-md-0 col-sm-0 col-0 justify-content-center col_sidebar_active"> 
                <div class="d-none d-sm-block d-sm-none d-md-block d-md-none d-lg-block">
                    @include('layouts.partials.sidebar',['is_editor' => $is_editor])
                </div>
            </div>

            <div class="col-xl-10 col-lg-10 col-md-12 col-sm-12 col-12 justify-content-center col_maincontent_active">
                    
                <div class="row p-5">

                    <nav class="navbar navbar-expand-lg navrbar_menu_btn">
                        <button type="button" id="menu-btn" class="d-none d-sm-block d-sm-none d-md-block d-md-none d-lg-block btn btn-primary menu_btn_button">
                            <i class="fas fa-align-left"></i>
                            <span></span>
                        </button>
                        
                       
                        <a class="btn btn-primary d-lg-none mr-auto" type="button" data-bs-toggle="offcanvas" href="#collapseTools" role="button" aria-controls="collapseTools" style="margin-top:-10px;">
                            <i class="fas fa-tools"></i>
                        </a>
                    </nav>

                    <nav class="navbar_breadcrumb" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ $urlAppend }}main/portfolio.php">{{trans('langPortfolio')}}</a></li>
                            <li class="breadcrumb-item"><a href="{{ $urlAppend }}main/my_courses.php">{{trans('mycourses')}}</a></li>
                            <li class="breadcrumb-item"><a href="{{$urlServer}}courses/{{$course_code}}/index.php">{{$currentCourseName}}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{$toolName}}</li>
                        </ol>
                    </nav>


                    <div class="offcanvas offcanvas-start d-lg-none mr-auto" tabindex="-1" id="collapseTools" aria-labelledby="offcanvasExampleLabel">
                        <div class="offcanvas-header">
                            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body">
                            @include('layouts.partials.sidebar',['is_editor' => $is_editor])
                        </div>
                    </div>


                    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="row p-2"></div><div class="row p-2"></div>
                        <legend class="float-none w-auto py-2 px-4 notes-legend"><span class="pos_TitleCourse"><i class="fas fa-folder-open" aria-hidden="true"></i> {{$toolName}} {{trans('langsOfCourse')}} <<strong>{{$currentCourseName}} <small>({{$course_code}})</small></strong>></span>
                            <div class="float-end manage-course-tools">
                                @if($is_editor)
                                    @include('layouts.partials.manageCourse',[$urlAppend => $urlAppend,'coursePrivateCode' => $course_code])              
                                @endif
                            </div>
                        </legend>
                    </div>

                    <div class="row p-2"></div><div class="row p-2"></div>
                    <span class="control-label-notes ms-1">{{trans('langTeacher')}}: <small>{{course_id_to_prof($course_id)}}</small></span>
                    <div class="row p-2"></div><div class="row p-2"></div>

                    {!! $action_bar !!}

                    <div class="row p-2"></div>
                    
                    <div class='form-wrapper'>
                        <form class='form-horizontal' action='{{ $targetUrl }}' method='post'>
                            <div class='form-group'>
                                <div class='col-sm-12'>
                                    <label class='control-label-notes'>{{ trans('langcreator') }}: 
                                        <span class="text-black-50 form-control-static">{{ $creatorName }}</span>

                                    </label>
                                    <!-- <p class='form-control-static'>{{ $creatorName }}</p>  -->
                                </div>
                            </div>

                            <div class="row p-2"></div>

                            @if ($request_types)
                                <div class='form-group'>
                                    <label for='requestType' class='col-sm-6 control-label-notes'>{{ trans('langType') }}:</label>
                                    <div class='col-sm-12'>
                                        <select class='form-control' name='requestType' id='requestType'>
                                            <option value='0'>{{ trans('langRequestBasicType') }}</option>
                                            @foreach ($request_types as $type)
                                                <option value='{{ $type->id }}'>{{ getSerializedMessage($type->name) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endif

                            <div class="row p-2"></div>

                            <div class='form-group'>
                                <label for='requestTitle' class='col-sm-6 control-label-notes'>{{ trans('langTitle') }}:</label>
                                <div class='col-sm-12'>
                                    <input type='text' class='form-control' id='requestTitle' name='requestTitle' required>
                                </div>
                            </div>

                            <div class="row p-2"></div>

                            <div class='form-group'>
                                <label for='requestDescription' class='col-sm-6 control-label-notes'>{{ trans('langDescription') }}:</label>
                                <div class='col-sm-12'>
                                    {!! $descriptionEditor !!}
                                </div>
                            </div>

                            <div class="row p-2"></div>

                            <div class='form-group'>
                                <label for='assignTo' class='col-sm-6 control-label-notes'>{{ trans("m['WorkAssignTo']") }}:</label>
                                <div class='col-sm-12'>
                                    <select class='form-control' name='assignTo[]' multiple id='assignTo'>
                                        @foreach ($course_users as $cu)
                                            <option value='{{ $cu->user_id }}'>{{$cu->name}} ({{$cu->email}})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row p-2"></div>

                            <div class='form-group'>
                                <label for='requestWatchers' class='col-sm-6 control-label-notes'>{{ trans('langWatchers') }}:</label>
                                <div class='col-sm-12'>
                                    <select class='form-control' name='requestWatchers[]' multiple id='requestWatchers'>
                                        @foreach ($course_users as $cu)
                                            @if ($uid != $cu->user_id)
                                                <option value='{{ $cu->user_id }}'>{{$cu->name}} ({{$cu->email}})</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            @if ($request_types)
                                <div class="row p-2"></div>
                                @foreach ($request_types as $type)
                                    @include('modules.request.extra_fields',
                                        ['type_name' => $type->name,
                                        'type_id' => $type->id,
                                        'fields_info' => $request_fields[$type->id]])
                                @endforeach
                            @endif

                            <div class="row p-2"></div>

                            <div class='form-group'>
                                <div class='col-sm-10 col-sm-offset-2'>
                                    <div class='checkbox'>
                                        <label>
                                            <input type='checkbox' name='send_mail' value='on' checked> {{ trans('langSendInfoMail') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row p-2"></div>

                            <div class='form-group'>
                                <div class='col-xs-offset-2 col-xs-10'>
                                    <button class='btn btn-primary' type='submit'>{{ trans('langSubmit') }}</button>
                                    <a class='btn btn-secondary' href='{{ $backUrl }}'>{{ trans('langCancel') }}</a>
                                </div>
                            </div>

                            {!! generate_csrf_token_form_field() !!}
                        </form>
                    </div>
                        


                </div>
            </div>


        </div>
    </div>
</div>


<script>$(function () {
    $('#requestWatchers').select2();
    $('#assignTo').select2();
    @if ($request_types)
        $('#requestType').change(function () {
            var type_id = $(this).val();
            $('.extra-fields-set').hide();
            $('#fields_' + type_id).show();
        }).change();
    @endif
})</script>
@endsection