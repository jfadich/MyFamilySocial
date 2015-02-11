    {!! Form::hidden('thread_id', $thread->id) !!}
<div class="form-group @if($errors->has('title')) has-error @endif">
    {!! Form::label('title', 'Title', ['class' => 'col-sm-1 control-label']) !!}
    <div class="col-sm-11">
        {!! Form::text('title', $thread->title, ['class' => 'form-control']) !!}
    </div>
</div>
<div class="form-group @if($errors->has('message')) has-error @endif">
    {!! Form::label('message', 'Message', ['class' => 'col-sm-1 control-label']) !!}
    <div class="col-sm-11">
        {!! Form::textarea('body', $thread->body, ['class' => 'form-control', 'rows' => 5]) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('category', 'Category', ['class' => 'col-sm-1 control-label']) !!}
    <div class="col-sm-11">
        {!! Form::select('category',$categories->lists('name', 'id'),null,['class' => 'form-control']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('tags', 'Tags', ['class' => 'col-sm-1 control-label']) !!}
    <div class="col-sm-11">
        {!! Form::text('tags', implode(', ', $thread->tags()->lists('name')), ['class' => 'form-control', 'auto-complete' => 'off']) !!}
    </div>
</div>
<div class="form-group margin-none">
    <div class="col-sm-offset-1 col-sm-11">
        <button type="submit" class="btn btn-primary">{{ $submitText }}</button>
    </div>
</div>
