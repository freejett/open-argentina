<div class="box box-info padding-1">
    <div class="box-body">

{{--        <div class="form-group">--}}
{{--            {{ Form::label('chat_id') }}--}}
{{--            {{ Form::text('chat_id', $news->chat_id, ['class' => 'form-control' . ($errors->has('chat_id') ? ' is-invalid' : ''), 'placeholder' => 'Chat Id']) }}--}}
{{--            {!! $errors->first('chat_id', '<div class="invalid-feedback">:message</div>') !!}--}}
{{--        </div>--}}
{{--        <div class="form-group">--}}
{{--            {{ Form::label('msg_id') }}--}}
{{--            {{ Form::text('msg_id', $news->msg_id, ['class' => 'form-control' . ($errors->has('msg_id') ? ' is-invalid' : ''), 'placeholder' => 'Msg Id']) }}--}}
{{--            {!! $errors->first('msg_id', '<div class="invalid-feedback">:message</div>') !!}--}}
{{--        </div>--}}
{{--        <div class="form-group">--}}
{{--            {{ Form::label('date') }}--}}
{{--            {{ Form::text('date', $news->date, ['class' => 'form-control' . ($errors->has('date') ? ' is-invalid' : ''), 'placeholder' => 'Date']) }}--}}
{{--            {!! $errors->first('date', '<div class="invalid-feedback">:message</div>') !!}--}}
{{--        </div>--}}
        <div class="form-group">
            {{ Form::label('title') }}
            {{ Form::text('title', $news->title, ['class' => 'form-control' . ($errors->has('title') ? ' is-invalid' : ''), 'placeholder' => 'Title']) }}
            {!! $errors->first('title', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('body') }}
            {{ Form::textarea('body', $news->body, ['class' => 'form-control' . ($errors->has('body') ? ' is-invalid' : ''), 'placeholder' => 'Body']) }}
            {!! $errors->first('body', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('announcement') }}
            {{ Form::textarea('announcement', $news->announcement, ['class' => 'form-control' . ($errors->has('announcement') ? ' is-invalid' : ''), 'placeholder' => 'Announcement']) }}
            {!! $errors->first('announcement', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('cover') }}
            {{ Form::text('cover', $news->cover, ['class' => 'form-control' . ($errors->has('cover') ? ' is-invalid' : ''), 'placeholder' => 'Cover']) }}
            {!! $errors->first('cover', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('link') }}
            {{ Form::text('link', $news->link, ['class' => 'form-control' . ($errors->has('link') ? ' is-invalid' : ''), 'placeholder' => 'Link']) }}
            {!! $errors->first('link', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('status') }}
            {{ Form::text('status', $news->status, ['class' => 'form-control' . ($errors->has('status') ? ' is-invalid' : ''), 'placeholder' => 'Status']) }}
            {!! $errors->first('status', '<div class="invalid-feedback">:message</div>') !!}
        </div>

    </div>
    <div class="box-footer mt20 mt-5">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>
