@include('partials.errors')

{!! Form::open(['method' => 'PATCH', 'files' => true, 'action' => ['ProfileController@update',$user->id]]) !!}
<div class="col-md-6">
    <div class="form-group form-control-default required @if($errors->has('first_name')) has-error @endif">
        {!! Form::label('first_name', 'First Name') !!}
        {!! Form::text('first_name', $user->first_name, ['class' => 'form-control']) !!}
    </div>
</div>
<div class="col-md-6">
    <div class="form-group form-control-default required @if($errors->has('first_last')) has-error @endif">
        {!! Form::label('last_name', 'Last Name') !!}
        {!! Form::text('last_name', $user->last_name, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="col-md-12">
    <div class="form-group form-control-default required @if($errors->has('first_email')) has-error @endif">
        {!! Form::label('email', 'Email', ['class' => 'col-sm-1 control-label']) !!}
        {!! Form::text('email', $user->email, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="col-md-6">
    <div class="form-group form-control-default">
        {!! Form::label('phone_one', 'Phone One') !!}
        {!! Form::text('phone_one', $user->phone_one, ['class' => 'form-control']) !!}
    </div>
</div>
<div class="col-md-6">
    <div class="form-group form-control-default">
        {!! Form::label('phone_two', 'Phone Two') !!}
        {!! Form::text('phone_two', $user->phone_two, ['class' => 'form-control']) !!}
    </div>
</div>
<div class="col-md-12">
    <div class="form-group form-control-default">
        {!! Form::label('birthdate', 'Birthday') !!}
        {!! Form::text('birthdate', $user->present()->birthday('m/d/Y'), ['class' => 'form-control datepicker']) !!}
    </div>
</div>
<div class="col-md-12">
    <div class="form-group form-control-default">
        {!! Form::label('profile_picture', 'Profile picture') !!}

        {!! Form::file('profile_picture', ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group margin-none">
    <div class="col-sm-offset-1 col-sm-11">
        <button type="submit" class="btn btn-primary">Update Profile</button>
    </div>
</div>
{!! Form::close() !!}