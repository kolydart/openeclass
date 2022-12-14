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
                    <div class='col-12'>
                        <table id='course_results_table' class='table-default'>
                            <thead>
                                <tr class='list-header'>
                                <th>{{ trans('langCourseCode') }}</th>
                                <th>{{ trans('langGroupAccess') }}</th>
                                <th>{{ trans('langFaculty') }}</th>
                                <th class='text-center'>{!! icon('fa-cogs') !!}</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    @if (isset($_GET['formsearchfaculte']) and $_GET['formsearchfaculte'] and is_numeric(getDirectReference($_GET['formsearchfaculte'])))
                        <div class='col-12 mt-3'>
                            <form action='multieditcourse.php' method='post'>
                                <!--redirect all request vars towards action-->
                                @foreach ($_REQUEST as $key => $value)
                                    <input type='hidden' name='{!! q($key) !!}' value='{!! q($value) !!}'>
                                @endforeach

                                <input class='btn submitAdminBtn' type='submit' name='move_submit' value='{{ trans('langChangeDepartment') }}'>
                                {!! generate_csrf_token_form_field() !!}
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
