
@extends('layouts.default')

@push('head_scripts')
    <script type='text/javascript'>
        $(document).ready(function() {

            $(document).on('click', '.expand:not(.revert)', function(e) {
                e.preventDefault();
                $('.faq-section .panel-collapse').addClass('show');
                $(this).toggleClass('revert');
                $(this).children().eq(0).toggleClass('fa-plus-circle').toggleClass('fa-minus-circle');
                $(this).children().eq(1).html('{{ trans('langFaqCloseAll') }}');
            });

            $(document).on('click', '.expand.revert', function(e) {
                e.preventDefault();
                $('.faq-section .panel-collapse').removeClass('show');
                $('.faq-section .panel-collapse').addClass('hide');
                $(this).toggleClass('revert');
                $(this).children().eq(0).toggleClass('fa-minus-circle').toggleClass('fa-plus-circle');
                $(this).children().eq(1).html('{{ trans('langFaqExpandAll') }}');
            });

            $(document).on('click', '.forDelete', function(e) {
                e.preventDefault();
                idDelete = $(this).data('id');
                idOrder = $(this).data('order');
                elem_rem = $(this).parents('.list-group-item');
                var ids = [];
                $('.faq-section .list-group-item').each(function () {
                    ids.push($(this).data('id'));
                });
                bootbox.confirm('{{ trans('langConfirmDelete') }}', function(result) {
                    if (result) {

                        $.ajax({
                            type: 'post',
                            data: {
                                toDelete: idDelete,
                                oldOrder: idOrder
                            },
                            success: function() {

                                elem_rem.remove();

                                $('.indexing').each(function (i){
                                    $(this).html(i+1);
                                });

                                $('.tooltip').remove();

                                moreDeletes = $('.alert-success').length;

                                if (moreDeletes > 0){
                                    $('.alert-success').html('{{ trans('langFaqDeleteSuccess') }}');
                                } else {
                                    $('.row.action_bar').before('<div class=\'alert alert-success\'>{{ trans('langFaqDeleteSuccess') }}</div>');
                                }

                                location.reload();

                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush

@if (!$modify && !$new)
    @push('head_scripts')
        <script src="{{ $urlServer }}/js/sortable/Sortable.min.js"></script>
        <script type='text/javascript'>
            $(document).ready(function() {
                Sortable.create(accordion, {
                    handle: '.fa-arrows',
                    animation: 150,
                    onEnd: function (evt) {

                        var itemEl = $(evt.item);

                        var idReorder = itemEl.attr('data-id');
                        var prevIdReorder = itemEl.prev().attr('data-id');

                        $.ajax({
                            type: 'post',
                            dataType: 'text',
                            data: {
                                toReorder: idReorder,
                                prevReorder: prevIdReorder,
                            },
                            success: function(data) {
                                $('.indexing').each(function (i){
                                    $(this).html(i+1);
                                });
                            }
                        })
                    }

                });
            });
        </script>
    @endpush
@endif

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

                    {!! $action_bar !!}

                    @if ($modify || $new)

                        <div class='col-lg-6 col-12 d-none d-md-none d-lg-block'>
                            <div class='col-12 h-100 left-form'></div>
                        </div>
                        <div class='col-lg-6 col-12'>
                            <div class='form-wrapper form-edit rounded'>

                                <form role='form' class='form-horizontal' method='post' action='{{ $_SERVER['SCRIPT_NAME'] }}'>
                                    <input type='hidden' name='id' value='{{ $id }}'>
                                    <div class='form-group'>
                                        <label for='question' class='col-sm-12 control-label-notes'>{{ trans('langFaqQuestion') }} <sup><small>(<span class='text-danger'>*</span>)</small></sup>:</label>
                                        <div class='col-sm-12'>
                                            @if ($modify)
                                                <input class='form-control' placeholder="{{ trans('langFaqQuestion') }}..." type='text' name='question' value="{{ $faq_mod->title }}" />
                                            @else
                                                <input class='form-control' placeholder="{{ trans('langFaqQuestion') }}..." type='text' name='question' value="" />
                                            @endif
                                        </div>
                                    </div>
                                    <div class='form-group mt-4'>
                                        <label for='answer' class='col-sm-12 control-label-notes'>{{ trans('langFaqAnswer') }} <sup><small>(<span class='text-danger'>*</span>)</small></sup>:</label>
                                        <div class='col-sm-12'>{!! $editor !!}</div>
                                    </div>
                                    <div class='form-group mt-4'>
                                        <div class='col-sm-offset-2 col-sm-10'>
                                            <sup><small>(<span class='text-danger'>*</span>)</small></sup> <small class='text-muted'>{{ trans('langCPFFieldRequired') }}</small>
                                        </div>
                                    </div>
                                    <div class='form-group mt-5'>
                                        <div class='col-12 d-flex justify-content-center align-items-center'>
                                            <button type="submit" class="btn submitAdminBtn" name="{{ $new? "submitFaq" : "modifyFaq" }}" value="{{ trans('submitBtnValue') }}">{{ trans('langSave') }}</button>
                                            <a href="{{ $_SERVER['SCRIPT_NAME'] }}" class="btn cancelAdminBtn ms-1">{{ trans('langCancel') }}</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class='col-12'>
                            <div class='accordion panel-group faq-section' id='accordion' role='tablist' aria-multiselectable='true'>
                                @if (count($faqs) == 0)
                                    <div class='panel list-group-item'>
                                        <div class='text-center text-muted'><em>{{ trans('langFaqNoEntries') }}</em> <br><br> <em>{{ trans('langFaqAddNew') }}</em></div>
                                    </div>
                                @else
                                    @foreach ($faqs as $key => $faq)
                                        <div class='accordion-item' data-id='{{ $faq->id }}'>
                                            <div class='accordion-header' role='tab' id='heading-{{ $faq->id }}'>
                                                <div class='row'>
                                                    <div class='col-12'>
                                                        <button class="accordion-button btn btn-transparent" type='button' data-bs-toggle='collapse' data-bs-target='#faq-{{ $faq->id }}' aria-expanded='true' aria-controls='#{{ $faq->id }}'>
                                                            <span class="control-label-notes">{{ $key+1 }}. {!! $faq->title !!}</span>
                                                        </button>
                                                    </div>
                                                    <div class='col-12'>
                                                        <a class='forDelete' href='javascript:void(0);' data-id='{{ $faq->id }}' data-order='{{ $faq->order }}'><span class='fa fa-times text-danger float-end p-2' data-bs-toggle='tooltip' data-bs-placement='top' title='{{ trans('langDelete') }}'></span></a>
                                                        <a href='javascript:void(0);'><span class='fa fa-arrows text-dark float-end p-2' data-bs-toggle='tooltip' data-bs-placement='top' title='{{ trans('langReorder') }}'></span></a>
                                                        <a href='{{ $_SERVER['SCRIPT_NAME'] }}?faq=modify&id={{ $faq->id }}'><span class='fa fa-pencil-square lightBlueText float-end p-2' data-bs-toggle='tooltip' data-bs-placement='top' title='{{ trans('langEdit') }}'></span></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id='faq-{{ $faq->id }}' class='panel-collapse accordion-collapse collapse' role='tabpanel' data-bs-parent='#accordion' aria-labelledby='heading{{ $faq->id }}'>
                                                <div class='accordion-body'>
                                                    <p><strong><u>{{ trans('langFaqAnswer') }}:</u></strong></p>
                                                    {!! $faq->body !!}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
