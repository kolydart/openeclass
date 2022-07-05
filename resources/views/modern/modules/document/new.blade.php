@extends('layouts.default')

@section('content')

<div class="pb-3 pt-3">

    <div class="container-fluid main-container">

        <div class="row">

                <div id="background-cheat-leftnav" class="col-xl-2 col-lg-2 col-md-0 col-sm-0 col-0 justify-content-center col_sidebar_active"> 
                    <div class="d-none d-sm-block d-sm-none d-md-block d-md-none d-lg-block">
                    @if($course_code)
                        @include('layouts.partials.sidebar',['is_editor' => $is_editor])
                    @else
                        @include('layouts.partials.sidebarAdmin')
                    @endif
                    </div>
                </div>

                <div class="col-xl-10 col-lg-10 col-md-12 col-sm-12 col-12 justify-content-center col_maincontent_active">
                    
                    <div class="row p-lg-5 p-md-5 ps-1 pe-2 pt-5 pb-5">

                        <nav class="navbar navbar-expand-lg navrbar_menu_btn">
                                <button type="button" id="menu-btn" class="d-none d-sm-block d-sm-none d-md-block d-md-none d-lg-block btn btn-primary menu_btn_button">
                                    <i class="fas fa-align-left"></i>
                                    <span></span>
                                </button>
                                
                            
                                <a class="btn btn-primary d-lg-none mr-auto" type="button" data-bs-toggle="offcanvas" href="#collapseTools" role="button" aria-controls="collapseTools" style="margin-top:-10px;">
                                    <i class="fas fa-tools"></i>
                                </a>
                        </nav>
                        
                        @include('layouts.common.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

                        <div class="offcanvas offcanvas-start d-lg-none mr-auto" tabindex="-1" id="collapseTools" aria-labelledby="offcanvasExampleLabel">
                            <div class="offcanvas-header">
                                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                            </div>
                            <div class="offcanvas-body">
                            @if($course_code)
                                @include('layouts.partials.sidebar',['is_editor' => $is_editor])
                            @else
                                @include('layouts.partials.sidebarAdmin')
                            @endif
                            </div>
                        </div>

                        @include('layouts.partials.legend_view',['is_editor' => $is_editor, 'course_code' => $course_code])
                    

                    
                   

                    {!! $backButton !!}

                    @if(Session::has('message'))
                    <div class='col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mt-5'>
                        <p class="alert {{ Session::get('alert-class', 'alert-info') }} alert-dismissible fade show" role="alert">
                            {{ Session::get('message') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </p>
                    </div>
                    @endif


                    @if ($can_upload == 1)
                        <div class='form-wrapper'>
                            <form class='form-horizontal' role='form' action='{{ $upload_target_url }}' method='post'>
                                <input type='hidden' name='{{ $pathName }}' value='{{ $pathValue }}'>
                                {!! $group_hidden_input !!}
                                @if ($back)
                                    <input type='hidden' name='back' value='{{ $back }}'>
                                @endif
                                @if ($sections)
                                    <div class='form-group'>
                                        <label for='section' class='col-sm-2 control-label-notes'>{{ trans('langSection') }}:</label>
                                        <div class='col-sm-12'>
                                            {!! selection($sections, 'section_id', $section_id) !!}
                                        </div>
                                    </div>
                                @endif

                                <div class="row p-2"></div>

                                @if ($filename)
                                    <div class='form-group'>
                                        <label for='file_name' class='col-sm-6 control-label-notes'>{{ trans('langFileName') }}:</label>
                                        <div class='col-sm-12'>
                                            <p class='form-control-static'>{{ $filename }}</p>
                                        </div>
                                    </div>
                                @endif

                                <div class="row p-2"></div>

                                <div class='form-group{{ Session::getError('file_title') ? ' has-error' : '' }}'>
                                    <label for='file_title' class='col-sm-6 control-label-notes'>{{ trans('langTitle') }}:</label>
                                    <div class='col-sm-12'>
                                        <input type='text' class='form-control' id='file_title' name='file_title' value='{{ $title }}'>
                                        <span class='help-block'>{{ Session::getError('file_title') }}</span>
                                    </div>
                                </div>

                                <div class="row p-2"></div>

                                <div class='form-group'>
                                    <label for='file_title' class='col-sm-6 control-label-notes'>{{ trans('langContent') }}:</label>
                                    <div class='col-sm-12'>
                                        {!! $rich_text_editor !!}
                                    </div>
                                </div>

                                <div class="row p-2"></div>

                                <div class='form-group'>
                                    <div class='col-xs-offset-2 col-xs-10'>
                                        <div class='form-group'>
                                            <div class='col-xs-offset-2 col-xs-10'>
                                                <button class='btn btn-primary' type='submit'>{{ trans('langSave') }}</button>
                                                <a class='btn btn-secondary' href='{{ $backUrl }}'>{{ trans('langCancel') }}</a>
                                            </div>
                                        </div>
                                        {!! generate_csrf_token_form_field() !!}
                                    </div>
                                </div>
                            </form>
                        </div>
                    @else
                        <div class='alert alert-warning'>{{ trans('langNotAllowed') }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
