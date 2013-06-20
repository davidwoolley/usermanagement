@extends('user::layout.default')

@section('content')
<form action="{{ URL::to('/forgotconfirmation') }}" id="password-reset-form" class="form-horizontal well" method="POST" accept-char="UTF-8">
    {{ Form::token() }}
    {{ Form::hidden('hash', $hash) }}
    <fieldset>

		<legend>Reset password</legend>
               <div class="controls">
                    <div class="text-error">{{ Session::get('message') }}</div>
                </div>

		<!-- Password -->
		<div class="control-group">
			<label class="control-label" for="password">Password:</label>
			<div class="controls">
				<div class="input-append">
					<input type="password" name="password" id="password" placeholder="Password" required>
					<span class="add-on"><i class="icon-key"></i></span>
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