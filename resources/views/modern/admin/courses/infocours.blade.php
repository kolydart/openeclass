@extends('layouts.default')

@section('content')

<div class="pb-lg-3 pt-lg-3 pb-0 pt-0">

    <div class="container-fluid main-container">

        <div class="row rowMedium">

            <div class="col-12 justify-content-center col_maincontent_active_Homepage">
                    
                <div class="row p-lg-5 p-md-5 ps-1 pe-1 pt-5 pb-5">

                    @include('layouts.common.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

                    @include('layouts.partials.legend_view',['is_editor' => $is_editor, 'course_code' => $course_code])
    
                    

                    @if(Session::has('message'))
                    <div class='col-12 all-alerts'>
                        <div class="alert {{ Session::get('alert-class', 'alert-info') }} alert-dismissible fade show" role="alert">
                            @if(is_array(Session::get('message')))
                                @php $messageArray = array(); $messageArray = Session::get('message'); @endphp
                                @foreach($messageArray as $message)
                                    {!! $message !!}
                                @endforeach
                            @else
                                {!! Session::get('message') !!}
                            @endif
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                    @endif

                    
                    {!! isset($action_bar) ?  $action_bar : '' !!}

                    <div class='col-lg-6 col-12 d-none d-md-none d-lg-block'>
                        <div class='col-12 h-100 left-form'></div>
                    </div>

                    <div class='col-lg-6 col-12'>
                        <div class='form-wrapper form-edit rounded'>
                            
                            <form role='form' class='form-horizontal' action='{{ $_SERVER['SCRIPT_NAME'] }}?c={{ $course->code }}' method='post' onsubmit='return validateNodePickerForm();'>
                                <fieldset>
                                    <div class='form-group'>
                                        <label for='Faculty' class='col-sm-12 control-label-notes'>{{ trans('langFaculty') }}</label>
                                        <div class='col-sm-12'>
                                            {!! $node_picker !!}
                                        </div>
                                    </div>
                                    <div class='form-group mt-4'>
                                        <label for='fcode' class='col-sm-12 control-label-notes'>{{ trans('langCode') }}</label>
                                        <div class='col-sm-12'>
                                            <input type='text' class='form-control' name='fcode' id='fcode' value='{{ $course->code }}'>
                                        </div>
                                    </div>
                                    <div class='form-group mt-4'>
                                        <label for='title' class='col-sm-12 control-label-notes'>{{ trans('langCourseTitle') }}</label>
                                        <div class='col-sm-12'>
                                            <input type='text' class='form-control' name='title' id='title' value='{{ $course->title }}'>
                                        </div>
                                    </div>
                                    <div class='form-group mt-4'>
                                        <label for='titulary' class='col-sm-12 control-label-notes'>{{ trans('langTeachers') }}</label>
                                        <div class='col-sm-12'>
                                            <input type='text' class='form-control' name='titulary' id='titulary' value='{{ $course->prof_name }}'>
                                        </div>
                                    </div>
                                    {!! showSecondFactorChallenge() !!}
                                    {!! generate_csrf_token_form_field() !!}    
                                    <div class='form-group mt-5'>
                                        <div class='col-12 d-flex justify-content-center aling-items-center'>
                                            <input class='btn submitAdminBtn' type='submit' name='submit' value='{{ trans('langModify') }}'>
                                        </div>
                                    </div>
                                </fieldset>
                            </form>
                        </div>  
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>              
@endsection