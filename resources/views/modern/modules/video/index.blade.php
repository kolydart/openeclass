<?php
    $display_tools = $is_editor && !$is_in_tinymce;
    $colspan = $display_tools ? 2 : 3;
    $embedParam = ((isset($_REQUEST['embedtype'])) ? '&amp;embedtype=' . urlencode($_REQUEST['embedtype']) : '') .
        ((isset($_REQUEST['docsfilter'])) ? '&amp;docsfilter=' . urlencode($_REQUEST['docsfilter']) : '');
    $expand_all = isset($_GET['d']) && $_GET['d'] == '1';

    if ($display_tools) {
        $actionBarArray = array(
            array('title' => $GLOBALS['langAddV'],
                  'url' => $urlAppend . "modules/video/edit.php?course=" . $course_code . "&amp;form_input=file",
                  'icon' => 'fa-plus-circle',
                  'level' => 'primary-label',
                  'button-class' => 'btn-success'),
            array('title' => $GLOBALS['langAddVideoLink'],
                  'url' => $urlAppend . "modules/video/edit.php?course=" . $course_code . "&amp;form_input=url",
                  'icon' => 'fa-plus-circle',
                  'level' => 'primary-label',
                  'button-class' => 'btn-success'),
            array('title' => $GLOBALS['langCategoryAdd'],
                  'url' => $urlAppend . "modules/video/editCategory.php?course=" . $course_code,
                  'icon' => 'fa-plus-circle'),
            array('title' => $GLOBALS['langQuotaBar'],
                  'url' => $urlAppend . "modules/video/index.php?course=" . $course_code . "&amp;showQuota=true",
                  'icon' => 'fa-pie-chart')
        );
        if (isDelosEnabled()) {
            $actionBarArray[] = array('title' => $GLOBALS['langAddOpenDelosVideoLink'],
                'url' => $urlAppend . "modules/video/edit.php?course=" . $course_code . "&amp;form_input=opendelos",
                'icon' => 'fa-plus-circle',
                'level' => 'primary-label',
                'button-class' => 'btn-success');
        }
        $action_bar = action_bar($actionBarArray);
    }
?>

@extends($is_in_tinymce ? 'layouts.embed' : 'layouts.default')

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
                            <li class="breadcrumb-item"><a href="{{ $urlAppend }}main/portfolio.php">Χαρτοφυλάκιο</a></li>
                            <li class="breadcrumb-item"><a href="{{ $urlAppend }}main/my_courses.php">Τα μαθήματά μου</a></li>
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
                        <legend class="float-none w-auto py-2 px-4 notes-legend"><span class="pos_TitleCourse"><i class="fas fa-folder-open" aria-hidden="true"></i> {{$toolName}} του μαθήματος <strong>{{$currentCourseName}} <small>({{$course_code}})</small></strong></span>
                            <div class="manage-course-tools"style="float:right">
                                @if($is_editor)
                                    @include('layouts.partials.manageCourse',[$urlAppend => $urlAppend,'coursePrivateCode' => $course_code])              
                                @endif
                            </div>
                        </legend>
                    </div>

                    <div class="row p-2"></div><div class="row p-2"></div>
                    <span class="control-label-notes ms-1">{{trans('langTeacher')}}: <small>{{course_id_to_prof($course_id)}}</small></span>
                    <div class="row p-2"></div><div class="row p-2"></div>

                    {!! isset($action_bar)? $action_bar: '' !!}

                    @if ($count_video > 0 or $count_video_links > 0)
                        @if (count($items))
                            <div class="row p-2"></div>
                            <div class='table-responsive'>
                                <table class='announcements_table nocategory-links'>
                                    <tr class='notes_thead'>
                                        <th class='first-item-col'>{!! headlink($GLOBALS['langVideoDirectory'], 'title') !!}</th>
                                        <th class='text-center text-whhite' style='width:134px'>{!! headlink($GLOBALS['langDate'], 'date') !!}</th>
                                        @if (!$is_in_tinymce)
                                            <th class='text-end text-white' style='padding-right:15px;'>{!! icon('fa-cogs') !!}</th>
                                        @endif
                                    </tr>
                                    @include('modules.video.common.videoList')
                                </table>
                            </div>
                                
                        @endif

                        @if ($num_of_categories > 0)

                            <div class='row p-2'></div>
                                    <div class='table-responsive'>
                                        <table class='announcements_table category-links'>
                                            <tr class='notes_thead'>
                                                <th class='first-item-col text-white'>{{ trans('langCatVideoDirectory') }}&nbsp;&nbsp;&nbsp;
                                                @if ($expand_all)
                                                    {!! icon('fa-folder-open', $GLOBALS['langViewHide'], $_SERVER["SCRIPT_NAME"] . "?course=" . $course_code . "&amp;d=0") !!}
                                                @else
                                                    {!! icon('fa-folder', $GLOBALS['langViewShow'], $_SERVER["SCRIPT_NAME"] . "?course=" . $course_code . "&amp;d=1") !!}
                                                @endif
                                                </th>
                                                <th class='text-center text-white' style='width:100px;'>{{ trans('langDate') }}</th>
                                                @if (!$is_in_tinymce)
                                                    <th class='cogsClass text-center text-white'>{!! icon('fa-cogs') !!}</th>
                                                @endif
                                            </tr>
                                        @foreach ($categories as $myrow)
                                            <?php
                                                $description = standard_text_escape($myrow->description);
                                                if ((isset($_GET['d']) and $_GET['d'] == 1) or ( isset($_GET['cat_id']) and $_GET['cat_id'] == $myrow->id)) {
                                                    $folder_icon = icon('fa-folder-open-o', $GLOBALS['langViewHide']);
                                                } else {
                                                    $folder_icon = icon('fa-folder-o', $GLOBALS['langViewShow']);
                                                }
                                            ?>
                                            <tr class='link-subcategory-title'><th class='category-link' colspan='{{ $colspan }}'>{!! $folder_icon !!}&nbsp;
                                            @if (isset($_GET['cat_id']) and $_GET['cat_id'] == $myrow->id)
                                                <a href='{!! $_SERVER["SCRIPT_NAME"] . "?course=" . $course_code . $embedParam !!}' class='open-category'>{{ $myrow->name }}</a>
                                            @else
                                                <a href='{!! $_SERVER["SCRIPT_NAME"] . "?course=" . $course_code . "&amp;cat_id=" . $myrow->id . $embedParam !!}' class='open-category'>{{ $myrow->name }}</a>
                                            @endif
                                            @if (!empty($description))
                                                <br><span class='link-description'>{{ $description }}</span>
                                            @endif
                                                </th>
                                                @if ($display_tools)
                                                    <td style='float:right' class='option-btn-cell'>
                                                        {!!
                                                        action_button(array(
                                                            array('title' => $GLOBALS['langEditChange'],
                                                                'icon' => 'fa-edit',
                                                                'url' => $urlAppend . "modules/video/editCategory.php?course=" . $course_code . "&amp;id=" . $myrow->id),
                                                            array('title' => $GLOBALS['langDelete'],
                                                                'icon' => 'fa-times',
                                                                'class' => 'delete',
                                                                'url' => $_SERVER['SCRIPT_NAME'] . "?course=" . $course_code . "&amp;id=" . $myrow->id . "&amp;delete=delcat",
                                                                'confirm' => $GLOBALS['langCatDel'])))
                                                        !!}
                                                    </td>
                                                @endif
                                            </tr>
                                            @if ($expand_all or (isset($_GET['cat_id']) and $_GET['cat_id'] == $myrow->id))
                                                <?php
                                                    $currentcatresults = getLinksOfCategory($myrow->id, $is_editor, $filterv, $order, $course_id, $filterl, $is_in_tinymce, $compatiblePlugin);
                                                ?>
                                                @include('modules.video.common.videoList', ['items' => $currentcatresults])
                                            @endif
                                        @endforeach
                                        </table>
                                    </div>
                                
                        @endif
                    @else
                        <div class='row p-2'></div>
                        M<div class='col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12'><div class='alert alert-warning' role='alert'>{{ trans('langNoVideo') }}</div></div>
                    @endif

                </div>
            </div>

        </div>
    </div>
</div>
@endsection