@extends('layouts.inner')
@section('title', 'Settings')

@section('inner')


          <div class="row">

            <div class="col-md-12">
              <br />
              @if(session()->has('message'))
                  <div class="alert alert-success">
                      {{ session()->get('message') }}
                  </div>
              @endif

              @foreach ($errors->all() as $error)

                <div class="alert alert-danger">{{ $error }}</div>

              @endforeach

              <div class="panel panel-default">
              <div class="panel-body">
                <div class="row">

                  <div class="col-md-5">
<h4 id="password">Change password</h4>
<p>Great passwords use lower and uppercase characters, numbers and symbols such as !"$£%&. Make sure you remember it.</p>
                    </div>

                  <div class="col-md-7">
                    <form method="POST" action="<?= route('settings.store') ?>">
                      {{ csrf_field() }}
                      <div class="form-group">
                        <label for="exampleInputEmail1">Email</label>
                        <input type="email" class="form-control" name="email" placeholder="" value="<?= auth()->user()->email ?>" disabled>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">New password</label>
                        <input type="password" class="form-control" name="password" placeholder="">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword1">Confirm new password</label>
                        <input type="password" class="form-control" name="confirm_password" placeholder="">
                      </div>
                      <button type="submit" class="btn btn-primary">save</button>
                    </form>
                    </div>

                    </div>
                    </div>
                    </div>

                    @hasrole('admin')

                <hr />
                <div class="panel panel-default">
                <div class="panel-body">
                <div class="row">

                  <div class="col-md-5">
<h4 id="time">Time &amp; Date</h4>
<p>Select the timezone you want to post from.</p>
                    </div>

                  <div class="col-md-7">
                    <form method="POST" action="<?= route('settings.store') ?>">
                      {{ csrf_field() }}
                      <div class="form-group">
                        <label for="exampleInputEmail1">Timezone region</label>

                        {{ Form::select('timezone', $tzlist, $current_tz, ['class' => 'form-control']) }}
                      </div>
                      <button type="submit" class="btn btn-primary">save</button>
                    </form>
                    </div>

                    </div>
                    </div>
                    </div>
                    @endhasrole



                      <br />  <br />
                      <br />  <br />
                      <br />  <br />



</div>



            </div>


@endsection
