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

                    @if ($result)
                        <!--container for sorting-->
                        <div class='col-12' id='multi'>
                        
                        @foreach ($result as $res)
                            <div id='cat_{{ getIndirectReference($res->id) }}' class='table-responsive'>
                                <table class='table-default'>
                                <caption class='tile__name ps-1 pe-1'>
                                    <strong>{{ trans('langCategory') }} :</strong> {{ $res->name }}
                                    <div class='float-end'>
                                        {!! action_button(array(
                                            array(
                                                    'title' => trans('langCPFNewField'),
                                                    'url' => "$_SERVER[SCRIPT_NAME]?add_field=" . getIndirectReference($res->id),
                                                    'icon' => 'fa-plus-circle',
                                                    'level' => 'primary'
                                            ),
                                            array('title' => trans('langModify'),
                                                    'url' => "$_SERVER[SCRIPT_NAME]?edit_cat=" . getIndirectReference($res->id),
                                                    'icon' => 'fa-edit',
                                                    'level' => 'primary'
                                            ),
                                            array('title' => trans('langDelete'),
                                                    'url' => "$_SERVER[SCRIPT_NAME]?del_cat=" . getIndirectReference($res->id),
                                                    'icon' => 'fa-times',
                                                    'class' => 'delete',
                                                    'confirm' => trans('langCPFConfirmCatDelete')
                                            )
                                        )) !!}
                            
                                    </div>
                                </caption>            
                                <thead>
                                    <tr class='list-header'>
                                        <td class='text-white TextSemiBold'>{{ trans('langName') }}</td>
                                        <td class='text-white TextSemiBold'>{{ trans('langCPFShortName') }}</td>
                                        <td class='text-white TextSemiBold'>{{ trans('langDescription') }}</td>
                                        <td class='text-white TextSemiBold'>{{ trans('langCPFFieldDatatype') }}</td>
                                        <td class='text-white TextSemiBold'>{{ trans('langCPFFieldRequired') }}</td>
                                        <td class='text-white TextSemiBold'>{{ trans('langCPFFieldRegistration') }}</td>
                                        <td class='text-white TextSemiBold'>{{ trans('langCPFFieldUserType') }}</td>
                                        <td class='text-white TextSemiBold'>{{ trans('langCPFFieldVisibility') }}</td>
                                        <td class='text-white TextSemiBold'>{!! icon('fa-gears') !!}</td>
                                    </tr>
                                </thead>
                            
                                @if (count($form_data_array[$res->id]))                
                                    <tbody class='tile__list'>
                                    @foreach ($form_data_array[$res->id] as $f)
                                        <tr id='field_{{ getIndirectReference($f->id) }}'>
                                            <td>{{ $f->name }}</td>
                                            <td>{{ $f->shortname }}</td>
                                            <td>{!! standard_text_escape($f->description) !!}</td>
                                            <td>{{ $field_types[$f->datatype] }}</td>
                                            <td>{{ $yes_no[$f->required] }}</td>
                                            <td>{{ $yes_no[$f->registration] }}</td>
                                            <td>{{ $user_type[$f->user_type] }}</td>
                                            <td>{{ $visibility[$f->visibility] }}</td>
                                            <td>
                                                {!! action_button(array(
                                                    array('title' => trans('langModify'),
                                                        'url' => "$_SERVER[SCRIPT_NAME]?edit_field=" . getIndirectReference($f->id),
                                                        'icon' => 'fa-edit',
                                                    ),
                                                    array('title' => trans('langDelete'),
                                                        'url' => "$_SERVER[SCRIPT_NAME]?del_field=" . getIndirectReference($f->id),
                                                        'icon' => 'fa-times',
                                                        'class' => 'delete',
                                                        'confirm' => trans('langCPFConfirmFieldDelete')
                                                    )
                                                )) !!}
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                @else
                                    <tbody class='tile__list'>
                                        <tr class='ignore-item'>
                                            <td colspan='9' class='text-center'>
                                                <span class='not_visible'>{{ trans('langCPFNoFieldinCat') }}</span>
                                            </td>
                                        </tr>
                                    </tbody>           
                                @endif
                            
                                </table>
                            </div>
                        @endforeach
                        </div>
                        <form name='sortOrderForm' action='{{ $_SERVER['SCRIPT_NAME'] }}' method='post'>
                            {!! generate_csrf_token_form_field() !!}
                        </form>
                        <script src='custom_profile_fields.js'></script>
                    @else
                        <div class='col-sm-12'><div class='alert alert-warning'>{{ trans('langCPFNoCats') }}</div></div> 
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection