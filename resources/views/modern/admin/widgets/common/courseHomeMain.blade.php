<div class="panel panel-primary margin-top-fat mt-3">
    <div class="panel-heading">
        <h4 class="panel-title">
            {{ trans('langCourseHomeMainContent') }}
        </h4>
    </div>
    <div class="panel-body Borders" id="course_home_widget_main" data-widget-area-id="5">
        @foreach ($course_home_main_area_widgets as $key => $course_home_main_area_widget)
        <div class="panel{{!isset($courseWidgets) || isset($courseWidgets) && $course_home_main_area_widget->is_course_admin_widget ? ' panel-success widget' : ' panel-default'}} mt-3" data-widget-id="{{ $course_home_main_area_widget->id }}" data-widget-widget-area-id="{{ $key }}">
            <div class="panel-heading">
                <a data-bs-toggle="collapse" data-bs-target="#widget_desc_{{ $key }}" href="#widget_desc_{{ $key }}" class="text-white widget_title">
                    {{ $course_home_main_area_widget->getName() }} <span></span> <small class="float-end">{{ $course_home_main_area_widget->is_course_admin_widget ? trans('langWidgetCourse') : trans('langWidgetAdmin') }}</small>
                </a>
            </div>
            @if (!isset($courseWidgets) || isset($courseWidgets) && $course_home_main_area_widget->is_course_admin_widget)
                <div id="widget_desc_{{ $key }}" class="panel-collapse collapse in collapsed">
                    <div class="panel-body">
                        {!! $course_home_main_area_widget->getOptionsForm($key) !!}
                    </div>
                    <div class="panel-footer clearfix d-flex justify-content-center align-items-center">
                        <a href="#" class="remove btn deleteAdminBtn">
                            {{ trans('langDelete') }}
                        </a>
                      
                        <a href="#" class="btn submitAdminBtn submitOptions ms-1">
                            {{ trans('langSubmit') }}
                        </a>
                       
                    </div>
                </div>
            @endif
        </div>
        @endforeach
    </div>
</div>

