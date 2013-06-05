@layout('layout.basic')

@section('content')
<form action="{{ URL::to('/register') }}" id="register-form" class="form-horizontal well" method="POST" accept-char="UTF-8">
    {{ Form::token(); }}

	<fieldset>
		<legend>Registration</legend>
                <div class="controls">
                    <div class="text-error">{{ Session::get('message') }}</div>
                </div>
		<!-- First Name -->
		<div class="control-group">
			<label class="control-label" for="first_name">First Name:</label>
			<div class="controls">
				<div class="input-append">
					<input type="text" name="first_name" id="first_name" value="{{ Input::old('first_name') }}" placeholder="First Name" required>
					<span class="add-on"><i class="icon-user"></i></span>
				</div>
<!--				<span class="help-block">Type your first name.</span>-->
			</div>
		</div>

		<!-- Last Name -->
		<div class="control-group">
			<label class="control-label" for="last_name">Last Name:</label>
			<div class="controls">
				<div class="input-append">
					<input type="text" name="last_name" id="last_name" value="{{ Input::old('last_name') }}" placeholder="Last Name" required>
					<span class="add-on"><i class="icon-user"></i></span>
				</div>
<!--				<span class="help-block">Type your last name.</span>-->
			</div>
		</div>

		<!-- Email Address -->
		<div class="control-group {{ $errors->has('email') ? 'error' : '' }}">
			<label class="control-label" for="email">Email:</label>
			<div class="controls">
				<div class="input-append">
					<input type="email" name="email" id="email" value="{{ Input::old('email') }}" placeholder="Email" required>
					<span class="add-on"><i class="icon-envelope"></i></span>
				</div>
                                {{ $errors->first('email') }}
<!--				<span class="help-block">Type your email address.</span>-->
			</div>
		</div>

		<!-- Email Confirm -->
		<div class="control-group {{ $errors->has('email_confirmation') ? 'error' : '' }}">
			<label class="control-label" for="email_confirmation">Confirm Email:</label>
			<div class="controls">
				<div class="input-append">
					<input type="email" name="email_confirmation" id="email_confirmation" value="" placeholder="Confirm Email" required>
					<span class="add-on"><i class="icon-envelope"></i></span>
				</div>
                                {{ $errors->first('email_confirmation') }}
<!--				<span class="help-block">Confirm your email address.</span>-->
			</div>
		</div>

		<!-- Password -->
		<div class="control-group {{ $errors->has('password') ? 'error' : '' }}">
			<label class="control-label" for="password">Password:</label>
			<div class="controls">
				<div class="input-append">
					<input type="password" name="password" id="password" placeholder="Password" required>
					<span class="add-on"><i class="icon-key"></i></span>
				</div>
                                {{ $errors->first('password') }}
<!--				<span class="help-block">Type your password.</span>-->
			</div>
		</div>

		<!-- Password Confirm -->
		<div class="control-group {{ $errors->has('password_confirmation') ? 'error' : '' }}">
			<label class="control-label" for="password_confirmation">Confirm Password:</label>
			<div class="controls">
				<div class="input-append">
					<input type="password" name="password_confirmation" id="" placeholder="Confirm Password" required>
					<span class="add-on"><i class="icon-key"></i></span>
				</div>
                                {{ $errors->first('password_confirmation') }}
<!--				<span class="help-block">Confirm your password.</span>-->
			</div>
		</div>
	</fieldset>

	<p class="messages"></p>

	<div class="form-actions">
		<a class="btn" href="{{ URL::to('/') }}">Cancel</a>
		<button class="btn btn-primary" type="submit">Register</button>
	</div>
</form>
@endsection
