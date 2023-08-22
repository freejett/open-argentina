<div class="box box-info padding-1">
    <div class="box-body">

        <div class="form-group">
            {{ Form::label('title') }}
            {{ Form::text('title', $apartments->title, ['class' => 'form-control' . ($errors->has('title') ? ' is-invalid' : ''), 'placeholder' => 'Title']) }}
            {!! $errors->first('title', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('address') }}
            {{ Form::text('address', $apartments->address, ['class' => 'form-control' . ($errors->has('address') ? ' is-invalid' : ''), 'placeholder' => 'Address']) }}
            {!! $errors->first('address', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('full_address') }}
            {{ Form::text('full_address', $apartments->full_address, ['class' => 'form-control' . ($errors->has('full_address') ? ' is-invalid' : ''), 'placeholder' => 'Full Address']) }}
            {!! $errors->first('full_address', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('lat') }}
            {{ Form::text('lat', $apartments->lat, ['class' => 'form-control' . ($errors->has('lat') ? ' is-invalid' : ''), 'placeholder' => 'Lat']) }}
            {!! $errors->first('lat', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('lng') }}
            {{ Form::text('lng', $apartments->lng, ['class' => 'form-control' . ($errors->has('lng') ? ' is-invalid' : ''), 'placeholder' => 'Lng']) }}
            {!! $errors->first('lng', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('status') }}
            {{ Form::text('status', $apartments->status, ['class' => 'form-control' . ($errors->has('status') ? ' is-invalid' : ''), 'placeholder' => 'Status']) }}
            {!! $errors->first('status', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('price') }}
            {{ Form::text('price', $apartments->price, ['class' => 'form-control' . ($errors->has('price') ? ' is-invalid' : ''), 'placeholder' => 'Price']) }}
            {!! $errors->first('price', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('full_price') }}
            {{ Form::text('full_price', $apartments->full_price, ['class' => 'form-control' . ($errors->has('full_price') ? ' is-invalid' : ''), 'placeholder' => 'Full Price']) }}
            {!! $errors->first('full_price', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('pets_allowed') }}
            {{ Form::text('pets_allowed', $apartments->pets_allowed, ['class' => 'form-control' . ($errors->has('pets_allowed') ? ' is-invalid' : ''), 'placeholder' => 'Pets Allowed']) }}
            {!! $errors->first('pets_allowed', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('kids_allowed') }}
            {{ Form::text('kids_allowed', $apartments->kids_allowed, ['class' => 'form-control' . ($errors->has('kids_allowed') ? ' is-invalid' : ''), 'placeholder' => 'Kids Allowed']) }}
            {!! $errors->first('kids_allowed', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('advantages') }}
            {{ Form::text('advantages', $apartments->advantages, ['class' => 'form-control' . ($errors->has('advantages') ? ' is-invalid' : ''), 'placeholder' => 'Advantages']) }}
            {!! $errors->first('advantages', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('type') }}
            {{ Form::text('type', $apartments->type, ['class' => 'form-control' . ($errors->has('type') ? ' is-invalid' : ''), 'placeholder' => 'Type']) }}
            {!! $errors->first('type', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('number_of_rooms') }}
            {{ Form::text('number_of_rooms', $apartments->number_of_rooms, ['class' => 'form-control' . ($errors->has('number_of_rooms') ? ' is-invalid' : ''), 'placeholder' => 'Number Of Rooms']) }}
            {!! $errors->first('number_of_rooms', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('photo') }}
            {{ Form::text('photo', $apartments->photo, ['class' => 'form-control' . ($errors->has('photo') ? ' is-invalid' : ''), 'placeholder' => 'Photo']) }}
            {!! $errors->first('photo', '<div class="invalid-feedback">:message</div>') !!}
        </div>

    </div>
    <div class="box-footer mt20 mt-5">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>
