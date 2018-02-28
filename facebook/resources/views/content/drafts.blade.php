@extends('layouts.inner')
@section('title', 'Drafts')

@section('inner')


                <ul class="nav nav-pills">
                    <li role="presentation"><a href="<?= route('content.create') ?>">Create New Post</a></li>
                    <li role="presentation"  class="active"><a href="/drafts">Drafts</a></li>
                </ul>
<br />
<div class="panel panel-default">
    <div class="panel-body">
                  <div class="row">


                              <div class="col-sm-12">
                  <h4>Draft Posts</h4>

              <p>Drafts are posts that have not been scheduled yet.</p>

              <? if(count($posts) == 0) : ?>
              <br />
              <div class="alert alert-warning" role="alert">
                <strong>Notice:</strong> You have no draft posts.
              </div>
              <? else: ?>


              <table class="table">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Message</th>
                      <th>Creation date</th>
                      <th></th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <? foreach($posts as $post) : ?>
                    <tr>
                      <td>#<?= $post->id ?></td>
                      <td><?= str_limit($post->message, 20) ?></td>
                      <td><?= $post->created_at->diffForHumans() ?></td>
                      <td><a href="/content/<?= $post->id ?>/edit">Edit/Publish</a></td>
                      <td><a class="delete-confirm" data-url="/content/<?= $post->id ?>" data-text="Are you sure you want to post #<?= $post->id ?>?" href="#" data-id="<?= $post->id ?>">Delete</a></td>
                    </tr>
                    <? endforeach; ?>
                  </tbody>
                </table>

                {{ $posts->links() }}

                <? endif; ?>
        </div>
        </div>
        </div>

	</div>



@endsection
