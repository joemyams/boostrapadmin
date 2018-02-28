@extends('layouts.inner')
@section('title', 'Queued Posts')

@section('inner')



          <div class="row">

            <div class="col-md-12">
                <h4>Queued Posts</h4><br />

                <form>

                  <div class="row">

                    <div class="col-md-12">

                      <queue :groups="{{json_encode($groups)}}" :socialAccounts="{{ $social_accounts->toJSON() }}" defaulttab=<?= $tab ?>></queue>
<?/*
                      <div class="panel panel-default">
  <div class="panel-body">
    <div class="row">

      <div class="col-md-9">
        <small class="text-muted"><a href=""><i class="fa fa-chevron-up" aria-hidden="true"></i></a> <a href=""><i class="fa fa-chevron-down" aria-hidden="true"></i></a> &nbsp;&nbsp;&nbsp;Scheduled for: 27th December 2017 <a href="">(reschedule)</a></small><br /><br />

    <p>"The posts here will be posted at their scheduled times. You can still edit or delete the post provided it is before the scheduled time."</p>
<a href="">Edit Post</a> | <a href="">Delete Post</a><br /><br />
<i class="mdi mdi-twitter light"></i>
<i class="mdi mdi-facebook light"></i>

  </div>
    <div class="col-md-3">
      <img class="img-responsive" src="https://placeholdit.imgix.net/~text?txtsize=33&txt=300%C3%97300&w=300&h=300" />
  </div>
  </div>
  </div>
</div>

                      <div class="panel panel-default">
  <div class="panel-body">
    <div class="row">

      <div class="col-md-9">
        <small class="text-muted">Scheduled for: 27th December 2017 <a href="">(reschedule)</a></small><br /><br />

    <p>"The posts here will be posted at their scheduled times. You can still edit or delete the post provided it is before the scheduled time."</p>
<a href="">Edit Post</a> | <a href="">Delete Post</a>
  </div>
    <div class="col-md-3">
      <img class="img-responsive" src="https://placeholdit.imgix.net/~text?txtsize=33&txt=300%C3%97300&w=300&h=300" />
  </div>
  </div>
  </div>
</div>*/?>


                  </div>


                  </div>






<br />
                </form>




        </div>
    </div>
</div>

@endsection
