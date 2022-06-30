@extends('layouts.default')

@push('head_scripts')
<script type='text/javascript'>

    function act_confirm() {
        $('.confirmAction').on('click', function (e) {
            var message = $(this).attr('data-message');
            var title = $(this).attr('data-title');
            var cancel_text = $(this).attr('data-cancel-txt');
            var action_text = $(this).attr('data-action-txt');
            var action_btn_class = $(this).attr('data-action-class');
            var form = $(this).closest('form').clone().appendTo('body');

            e.preventDefault();
            e.stopPropagation();

            bootbox.dialog({
                message: message,
                title: title,
                buttons: {
                    cancel_btn: {
                        label: cancel_text,
                        className: "btn-secondary"
                    },
                    action_btn: {
                        label: action_text,
                        className: action_btn_class,
                        callback: function () {
                            form.submit();
                        }
                    }
                }
            });
        });
    }

    function popover_init() {
        $('[data-bs-toggle="popover"]').on('click',function(e){
            e.preventDefault();
        }).popover();
        var click_in_process = false;
        var hidePopover = function () {
            if (!click_in_process) {
                $(this).popover('hide');
            }
        }
        , togglePopover = function () {
            $(this).popover('toggle');
            $('#action_button_menu').parent().parent().addClass('menu-popover');
        };
        $('.menu-popover').popover().on('click', togglePopover).on('blur', hidePopover);
        $('.menu-popover').on('shown.bs.popover', function () {
            $('.popover').mousedown(function () {
                click_in_process = true;
            });
            $('.popover').mouseup(function () {
                click_in_process = false;
                $(this).popover('hide');
            });
            act_confirm();
        });

    }

    function tooltip_init() {
        $('[data-bs-toggle="tooltip"]').tooltip({container: 'body'});
    }

    $(function () {
        var initComplete = function () {
            var api = this.api();
            var column = api.column(1);
            var select = $('<select id="select_role">' +
                           '<option value="0">-- {{ js_escape(trans('langAllUsers')) }} --</option>' +
                           '<option value="teacher">{{ js_escape(trans('langTeacher')) }}</option>' +
                           '<option value="student">{{ js_escape(trans('langStudent')) }}</option>' +
                           '<option value="editor">{{ js_escape(trans('langEditor')) }}</option>' +
                           '<option value="tutor">{{ js_escape(trans('langTutor')) }}</option>' +
                        @if (get_config('opencourses_enable'))
                           '<option value="reviewer">{{ js_escape(trans('langOpenCoursesReviewer')) }}</option>' +
                        @endif
                           '</select>')
                .appendTo($(column.footer()).empty());
        }
        var oTable = $('#users_table_{{ $course_code }}').DataTable({
            initComplete: initComplete,
            createdRow: function(row, data, dataIndex) {
                if (data[5] == 1) {
                    $(row). addClass('not_visible');
                }
            },
            bStateSave: true,
            bProcessing: true,
            bServerSide: true,
            sScrollX: true,
            drawCallback: function(oSettings) {
                tooltip_init();
                popover_init();
            },
            sAjaxSource: '{{ $ajaxUrl }}',
            aLengthMenu: [
               [10, 15, 20 , -1],
               [10, 15, 20, '{{ js_escape(trans('langAllOfThem')) }}']
            ],
            sPaginationType: 'full_numbers',
            bSort: true,
            aaSorting: [[0, 'desc']],
            aoColumnDefs: [
                { sClass: 'option-btn-cell', aTargets: [ -1 ] },
                { bSortable: false, aTargets: [ 1 ] },
                { sClass:'text-center', bSortable: false, aTargets: [ 2 ] },
                { bSortable: false, aTargets: [ 4 ] }
            ],
            oLanguage: {
                sLengthMenu: '{{ js_escape(trans('langDisplay') . ' _MENU_ ' . trans('langResults2')) }}',
                sZeroRecords: '{{ js_escape(trans('langNoResult')) }}',
                sInfo: '{{ js_escape(trans('langDisplayed') . ' _START_ ' .
                                     trans('langTill') . ' _END_ ' . trans('langFrom2') .
                                     ' _TOTAL_ ' . trans('langTotalResults')) }}',
                sInfoEmpty: '{{ js_escape(trans('langDisplayed') . ' 0 ' . trans('langTill') .
                                          ' 0 ' . trans('langFrom2') . ' 0 ' . trans('langResults2')) }}',
                sInfoFiltered: '',
                sInfoPostFix:  '',
                sSearch:       '',
                sUrl:          '',
                oPaginate: {
                    sFirst: '&laquo;',
                    sPrevious: '&lsaquo;',
                    sNext: '&rsaquo;',
                    sLast: '&raquo;'
                }
            }
        });

        // Apply the filter
        $(document).on('change', 'select#select_role', function (e) {
            oTable
                .column($(this).parent().index() + ':visible')
                .search($('select#select_role').val())
                .draw();
        });
        $(document).on('click', '.delete_btn', function (e) {
            e.preventDefault();
            var row_id = $(this).data('id');
            bootbox.confirm('{{ js_escape(trans('langDeleteUser') . ' ' . trans('langDeleteUser2')) }}',
                function (result) {
                    if (result) {
                        $.ajax({
                            type: 'POST',
                            url: '',
                            datatype: 'json',
                            data: {
                                action: 'delete',
                                value: row_id
                            },
                            success: function(data) {
                                var info = oTable.page.info();
                                var per_page = info.length;
                                var page_number = info.page;
                                if (info.recordsDisplay % info.length == 1) {
                                    if (page_number != 0) {
                                        page_number--;
                                    }
                                }
                                $('#tool_title').after('<p class="success">{{ js_escape(trans('langUserDeleted')) }}</p>');
                                $('.success').delay(3000).fadeOut(1500);
                                oTable.page(page_number).draw(false);
                            },
                            error: function(xhr, textStatus, error) {
                                console.log(xhr.statusText);
                                console.log(textStatus);
                                console.log(error);
                            }
                        });
                    }
                });
        });
        $('.dataTables_filter input')
            .attr({ style: 'width: 200px',
                    class: 'form-control input-sm',
                    placeholder: '{{ js_escape(trans('langName') . ', Username, Email') }}' });
        $('.success').delay(3000).fadeOut(1500);
    });
</script>
@endpush

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
                    

                    @if($course_code)
                    <nav class="navbar_breadcrumb" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ $urlAppend }}main/portfolio.php">Χαρτοφυλάκιο</a></li>
                            <li class="breadcrumb-item"><a href="{{ $urlAppend }}main/my_courses.php">Τα μαθήματά μου</a></li>
                            <li class="breadcrumb-item"><a href="{{$urlServer}}courses/{{$course_code}}/index.php">{{$currentCourseName}}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{$toolName}}</li>
                        </ol>
                    </nav>

                    
                    @else
                        <nav class="navbar_breadcrumb" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ $urlAppend }}main/portfolio.php"><i class="fas fa-home"></i> Χαρτοφυλάκιο χρήστη</a></li>
                                <li class="breadcrumb-item"><a href="{{ $urlAppend }}main/my_courses.php"><i class="fas fa-graduation-cap"></i> Τα μαθήματά μου</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{$toolName}}</li>
                            </ol>
                        </nav>
                    @endif


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
                        <legend class="float-none w-auto py-2 px-4 notes-legend"><span class="pos_TitleCourse"><i class="fas fa-folder-open" aria-hidden="true"></i> {{$toolName}} @if($course_code)του μαθήματος <<strong>{{$currentCourseName}} <small>({{$course_code}})</small></strong>></span>@endif
                            <div class="manage-course-tools"style="float:right">
                                @if($is_editor == 1)
                                    @include('layouts.partials.manageCourse',[$urlAppend => $urlAppend,'coursePrivateCode' => $course_code])              
                                @endif
                            </div>
                        </legend>
                    </div>

                    
                    @if($course_code)
                        <div class="row p-2"></div><div class="row p-2"></div>
                        <span class="control-label-notes ms-1">{{trans('langTeacher')}}: <small>{{course_id_to_prof($course_id)}}</small></span>
                        <div class="row p-2"></div><div class="row p-2"></div>
                    @endif

                    {!! $action_bar !!}
 
                    <table id='users_table_{{ $course_code }}' class='announcements_table w-100 ms-0'>
                        <thead>
                            <tr class="notes_thead text-light">
                                <th>{{ trans('langSurnameName') }}</th>
                                <th class='text-center'>{{ trans('langRole') }}</th>
                                <th class='text-center'>{{ trans('langGroup') }}</th>
                                <th class='text-center' width='80'>{{ trans('langRegistrationDate') }}</th>
                                <th class='text-center'>{!! icon('fa-cogs') !!}</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>

                </div>
            </div>

        </div>
    </div>
</div>


@endsection