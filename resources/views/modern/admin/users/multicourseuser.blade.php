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

                    
                    <div class='col-12'>
                       <div class='alert alert-info'>{{ trans('langAskManyUsersToCourses') }}</div>
                    </div>


                    {!! isset($action_bar) ?  $action_bar : '' !!}

                    <div class='col-lg-6 col-12 d-none d-md-none d-lg-block'>
                        <div class='col-12 h-100 left-form'></div>
                    </div>

                    <div class='col-lg-6 col-12'>
                        <div class='form-wrapper form-edit rounded'>
                        
                        <form role='form' class='form-horizontal' method='post' action='{{ $_SERVER['SCRIPT_NAME'] }}'>
                            <fieldset>
                            <h4 class='control-label-notes'>{{ trans('langUsersData') }}</h4>
                                <div class='form-group'>
                                    <div class='radio'>
                                    <label>
                                        <input type='radio' name='type' value='uname' checked>{{ trans('langUsername') }}
                                    </label>
                                    </div>
                                <div class='col-sm-12'>{!! text_area('user_info', 10, 30, '') !!}</div>
                            </div>
                            </fieldset>
                            <div class='mt-4'></div>
                            <fieldset>
                            <h4 class='control-label-notes'>{{ trans('langCourseCodes') }}</h4>
                            <div class='form-group'>
                                    <div class='col-sm-12'>{!! text_area('courses_codes', 10, 30, '') !!}</div>
                                </div>
                                {!! showSecondFactorChallenge() !!}
                                <div class='col-12 mt-5 d-flex justify-content-center align-items-center'>
                                    <input class='btn submitAdminBtn' type='submit' name='submit' value='{{ trans('langRegistration') }}'>
                                </div>
                            </fieldset>
                            {!! generate_csrf_token_form_field() !!}
                        </form>
                    </div></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection