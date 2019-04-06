    {!! Form::Open(['id'=>'frmLogin','url'=>'login','class'=>'']) !!}
          <h2>Login</h2>

          @if(Session::has('error'))
            <p class="alert alert-danger">{{ Session::get('error') }}</p>
          @elseif(Session::has('warning'))
            <p class="alert alert-warning">{{ Session::get('warning') }}</p>
          @endif

          @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
          @endif
       
       
        @if(!Session::has('warning'))
          <label>
            <p class="label-txt">EMAIL</p>
            <input type="text" class="input" name="email">
            <div class="line-box"><div class="line"></div></div>
          </label>
          <label>
            <p class="label-txt">PASSWORD</p>
            <input type="password" class="input" name="password" autocomplete="off">
            <div class="line-box"><div class="line"></div></div>
          </label>
          <button type="submit">Login</button> or <a href="javascript:void(0);" class="openSignup">Signup</a>
        @endif
    {!! Form::Close() !!}