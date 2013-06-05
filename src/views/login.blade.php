
@section('content')
<form class="form-horizontal well" action="{{ URL::to('/login') }}" method="post">
  <div class="control-group">
    <div class="controls">
        <div class="text-error">{{ Session::get('message') }}</div>
    </div>
  </div>
         
  <div class="control-group">
    <label class="control-label" for="inputEmail">Email</label>
    <div class="controls">
      <input type="text" id="inputEmail" placeholder="Email" name="email">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="inputPassword">Password</label>
    <div class="controls">
      <input type="password" id="inputPassword" placeholder="Password" name="password">
    </div>
  </div>
  <div class="control-group">
    <div class="controls">
      <label class="checkbox">
        <input type="checkbox"> Remember me
      </label>
      <button type="submit" class="btn">Sign in</button>
      <a href="{{ URL::to('/forgotpassword') }}">Forgot your password?</a>
    </div>
  </div>
</form>
@endsection
