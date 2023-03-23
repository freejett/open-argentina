<div class="box box-info padding-1">
    <div class="box-body">

        <div class="form-group mb-3">
            {{ Form::label('chat_id') }}
            {{ Form::text('chat_id', $telegramChat->chat_id, ['class' => 'form-control' . ($errors->has('chat_id') ? ' is-invalid' : ''), 'placeholder' => 'Chat Id']) }}
            {!! $errors->first('chat_id', '<div class="invalid-feedback">:message</div>') !!}
        </div>
{{--        <div class="form-group mb-3">--}}
{{--            {{ Form::label('type_id') }}--}}
{{--            {{ Form::text('type_id', $telegramChat->type_id, ['class' => 'form-control' . ($errors->has('type_id') ? ' is-invalid' : ''), 'placeholder' => 'Type Id']) }}--}}
{{--            {!! $errors->first('type_id', '<div class="invalid-feedback">:message</div>') !!}--}}
{{--        </div>--}}
        <div class="form-group mb-3">
            {{ Form::label('title') }}
            {{ Form::text('title', $telegramChat->title, ['class' => 'form-control' . ($errors->has('title') ? ' is-invalid' : ''), 'placeholder' => 'Title']) }}
            {!! $errors->first('title', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group mb-3">
            {{ Form::label('username') }}
            {{ Form::text('username', $telegramChat->username, ['class' => 'form-control' . ($errors->has('username') ? ' is-invalid' : ''), 'placeholder' => 'Username']) }}
            {!! $errors->first('username', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group mb-3">
            {{ Form::label('about') }}
            {{ Form::text('about', $telegramChat->about, ['class' => 'form-control' . ($errors->has('about') ? ' is-invalid' : ''), 'placeholder' => 'About']) }}
            {!! $errors->first('about', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group mb-3">
            {{ Form::label('chat_photo') }}
            <hr>
{{--            {{ Form::text('chat_photo', $telegramChat->chat_photo, ['class' => 'form-control' . ($errors->has('chat_photo') ? ' is-invalid' : ''), 'placeholder' => 'Chat Photo']) }}--}}
{{--            {!! $errors->first('chat_photo', '<div class="invalid-feedback">:message</div>') !!}--}}
            @if($telegramChat->chat_photo)
                <img class="img-responsive img-circle telegram_avatar_min" style="max-width: 100px;" src="{{ asset($avatarPath . $telegramChat->chat_id .'/'. $telegramChat->chat_photo) }}" />
            @endif
        </div>
        <div class="form-group mb-3">
            {{ Form::label('contact') }}
            {{ Form::text('contact', $telegramChat->contact, ['class' => 'form-control' . ($errors->has('contact') ? ' is-invalid' : ''), 'placeholder' => 'Contact']) }}
            {!! $errors->first('contact', '<div class="invalid-feedback">:message</div>') !!}
        </div>

    </div>
    <div class="box-footer mt20  text-end">
        <button type="submit" class="btn btn-primary">{{ __('Сохранить') }}</button>
    </div>
</div>
