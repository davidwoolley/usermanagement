@extends('user::layout.default')

@section('content')
<form action="{{ URL::to('/forgotpassword') }}" id="password-reset-form" class="form-horizontal well" method="POST" accept-char="UTF-8">
    {{ Form::token(); }}
    <fieldset>

		<legend>Reset password</legend>
               <div class="controls">
                    <div class="text-error">{{ Session::get('message') }}</div>
                </div>

		<!-- Email Address -->
		<div class="control-group">
			<label class="control-label" for="email">Email:</label>
			<div class="controls">
				<div class="input-append">
					<input type="email" name="email" id="email" value="{{ Input::old('email') }}" placeholder="user@example.com" required>
					<span class="add-on"><i class="icon-envelope"></i></span>
				</div>
			</div>
		</div>

	</fieldset>

	<div class="form-actions">
		<a class="btn" href="{{ URL::to('/login') }}">Cancel</a>
		<button class="btn btn-primary" type="submit"/>Reset</button>
	</div>
</form>
@stop