{!! Form::Open(['url'=>'userVerify','class'=>'']) !!}
        <h2>Verify Your Account</h2>

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
              <p class="label-txt">Verification key</p>
              <input type="text" class="input" name="activation_key">
              <div class="line-box"><div class="line"></div></div>
          </label>
        <button type="submit">Verify</button>
      {!! Form::Close() !!}