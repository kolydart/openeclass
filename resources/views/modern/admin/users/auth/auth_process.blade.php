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
                        
                        <form class='form-horizontal' name='authmenu' method='post' action='{{ $_SERVER['SCRIPT_NAME'] }}'>
                        <fieldset>	
                            <input type='hidden' name='auth' value='{{ intval($auth) }}'>
                            @if ($auth == 1)
                                @include('admin.users.auth.methods.eclass')
                            @elseif ($auth == 2)
                                @include('admin.users.auth.methods.pop3')
                                @include('admin.users.auth.methods.eclass')
                            @elseif ($auth == 3)
                                @include('admin.users.auth.methods.imap')
                                @include('admin.users.auth.methods.eclass') 
                            @elseif ($auth == 4)
                                @include('admin.users.auth.methods.ldap')
                                @include('admin.users.auth.methods.eclass')   
                            @elseif ($auth == 5)
                                @include('admin.users.auth.methods.db')
                                @include('admin.users.auth.methods.eclass')
                            @elseif ($auth == 6)
                                @include('admin.users.auth.methods.shib')
                                @include('admin.users.auth.methods.eclass')
                            @elseif ($auth == 7)
                                @include('admin.users.auth.methods.cas')
                                @include('admin.users.auth.methods.eclass')
                            @else
                                @include('admin.users.auth.methods.hybrid')
                            @endif
                            {!! showSecondFactorChallenge() !!}
                            
                            <div class='form-group mt-5'>
                                <div class='col-12 d-flex justify-content-center align-items-center'>
                                 
                                       
                                            <input class='btn submitAdminBtn' type='submit' name='submit' value='{{ trans('langModify') }}'>
                                     
                                       
                                            <a class='btn cancelAdminBtn ms-1' href='auth.php'>{{ trans('langCancel') }}</a>
                                       
                                   
                                </div>
                            </div>
                        </fieldset>
                        {!! generate_csrf_token_form_field() !!}
                        </form>
                    </div> </div>
                </div>
            </div>
        </div>
    </div>
</div>           
@endsection