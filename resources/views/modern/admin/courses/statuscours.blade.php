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
                          
                          <form role='form' class='form-horizontal' action="{{ $_SERVER['SCRIPT_NAME'] }}?c={{$course->code}}" method='post'>                
                              <div class='form-group'>
                                      <label for='localize' class='col-sm-6 control-label-notes mb-2'>{{ trans('langAvailableTypes') }}</label>
                                      <div class='radio mb-4'>
                                        <label>
                                          <input class='input-StatusCourse' id='courseopen' type='radio' name='formvisible' value='2'{!! $course->visible == 2 ? ' checked': '' !!}>
                                          <label for="courseopen">
                                            {!! course_access_icon(COURSE_OPEN) !!}
                                          </label>
                                          {{ trans('langPublic') }}
                                        </label>
                                      </div>
                                      
                                      <div class='radio mb-4'>
                                        <label>
                                          <input class='input-StatusCourse' id='coursewithregistration' type='radio' name='formvisible' value='1'{!! $course->visible == 1 ? ' checked': '' !!}>
                                          <label for="coursewithregistration">
                                            {!! course_access_icon(COURSE_REGISTRATION) !!}
                                          </label>
                                          {{ trans('langPrivOpen') }}
                                        </label>
                                      </div>


                                      <div class='radio mb-4'>
                                        <label>
                                          <input class='input-StatusCourse' id='courseclose' type='radio' name='formvisible' value='0'{!! $course->visible == 0 ? ' checked': '' !!}>
                                          <label for="courseclose">
                                            {!! course_access_icon(COURSE_CLOSED) !!}
                                          </label>
                                          {{ trans('langClosedCourseShort') }}
                                        </label>
                                      </div>


                                      <div class='radio'>
                                        <label>
                                          <input class='input-StatusCourse' id='courseinactive' type='radio' name='formvisible' value='3'{!! $course->visible == 3 ? ' checked': '' !!}>
                                          <label for="courseinactive">
                                            {!!  course_access_icon(COURSE_INACTIVE) !!}
                                          </label>
                                          {{ trans('langInactiveCourse') }}
                                        </label>
                                      </div>                   
                                 
                              </div>
                              <div class='form-group mt-5'>
                                  <div class='col-12 d-flex justify-content-center align-items-center'>
                                      <input class='btn submitAdminBtn' type='submit' name='submit' value='{{ trans('langModify') }}'>
                                  </div>
                              </div>
                          </form>
                      </div>
                    </div>
              </div>
          </div>
      </div>
    </div>
</div>
@endsection