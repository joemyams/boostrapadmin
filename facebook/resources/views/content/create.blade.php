@extends('layouts.inner')
@section('title', (isset($post))?'Edit post':'Schedule a new post')

@section('inner')

    <div class="row">
    	<div class="col-md-12">
        <? if(!isset($post)) : ?>

                <ul class="nav nav-pills">
                    <li role="presentation" class="active"><a href="<?= route('content.create') ?>">Create New Post</a></li>
                    <li role="presentation"><a href="/drafts">Drafts</a></li>
                    <?/*<li role="presentation"><a href="<?= route('feeds.index') ?>">RSS Feeds</a></li>*/?>
                </ul>
              <? else: ?>

<? if($post->is_draft): ?>
<a href="<?= url('drafts') ?>"><i class="fa fa-chevron-left" aria-hidden="true"></i> Back to drafts</a>
<? else: ?>
<a href="<?= route('queue.create') ?>?tab=<?= (!$post->scheduled_at)?'in_queue':'custom_schedule' ?>&accounts=<?= implode(',', $social_accounts->pluck('id')->toArray()) ?>"><i class="fa fa-chevron-left" aria-hidden="true"></i> Back to schedule</a>
<? endif; ?>
<? endif; ?>
<br />

                  <div class="row">


                              <div class="col-sm-12">
                                  <? if(isset($post)) : ?>
                                  <edit-post :post="{{json_encode($post, JSON_NUMERIC_CHECK)}}" :groups="{{json_encode($groups)}}" :social-accounts="{{json_encode($social_accounts)}}"></edit-post>
                                  <? else: ?>
                                  <post :groups="{{json_encode($groups)}}" :social-accounts="{{json_encode($social_accounts)}}"></post>
                                  <? endif; ?>
                              </div>

                    </div>

        </div>

	</div>




@endsection
