
    <div class='col-12'>
        <div class='form-wrapper form-edit mt-2 rounded'>
			<form class='form-horizontal' role='form' method='post' action='{{ $base_url }}'>
				<fieldset>
					<input type='hidden' name='sourceFile' value='{{ $renamePath }}'>
					{!! $group_hidden_input !!}
					<div class='form-group'>
						<label for='renameTo' class='col-12 control-label-notes' >{{ $filenameLabel }}:</label>
						<div class='col-12'>
							<input class='form-control' type='text' name='renameTo' value='{{ $filename }}'>
						</div>
					</div>

					<div class='form-group mt-4'>
					    @if($menuTypeID == 3 or $menuTypeID == 1)
                        <div class='col-12 d-flex justify-content-start align-items-center'>
                            
                               
                                    <button class='btn submitAdminBtn' type='submit'>{{ trans('langRename') }}</button>
                               
                                
                                    <a class='btn cancelAdminBtn ms-1' href='{{ $backUrl }}'>{{ trans('langCancel') }}</a>
                              
                           
                        </div>
                        @else
						<div class='col-offset-2 col-10 d-flex justify-content-start align-items-center'>
                            <button class='btn submitAdminBtn' type='submit'>{{ trans('langRename') }}</button>
                            <a class='btn cancelAdminBtn ms-1' href='{{ $backUrl }}'>{{ trans('langCancel') }}</a>
						</div>
						@endif
					</div>
				</fieldset>
                {!! generate_csrf_token_form_field() !!}
			</form>
        </div>
    </div>

