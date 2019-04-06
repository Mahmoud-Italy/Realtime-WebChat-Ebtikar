   {!! Form::Open(['id'=>'frmSignup','url'=>'signup','class'=>'hidden']) !!}
        <h2>Signup</h2>

          @if(Session::has('error'))
            <p class="alert alert-danger">{{ Session::get('error') }}</p>
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
              
          <label>
              <p class="label-txt">NAME</p>
              <input type="text" class="input" name="name">
              <div class="line-box"><div class="line"></div></div>
          </label>
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
        <button type="submit">Signup</button> or <a href="javascript:void(0);" class="openLogin">Login</a>
      {!! Form::Close() !!}
