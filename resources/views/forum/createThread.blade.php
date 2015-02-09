@extends('layouts.forum')

@section('content')



    <div class="panel panel-primary">
        <div class="panel-heading panel-heading-primary">
            Create a post
        </div>
        <div class="panel-body">

            @include('partials.errors')

            {!! Form::open(['class' => 'form-horizontal']) !!}
                <div class="form-group @if($errors->has('title')) has-error @endif">
                     {!! Form::label('title', 'Title', ['class' => 'col-sm-1 control-label']) !!}
                    <div class="col-sm-11">
                        {!! Form::text('title', null, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="form-group @if($errors->has('message')) has-error @endif">
                    {!! Form::label('message', 'Message', ['class' => 'col-sm-1 control-label']) !!}
                    <div class="col-sm-11">
                        {!! Form::textarea('message', null, ['class' => 'form-control', 'rows' => 5]) !!}
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
                        {!! Form::text('tags', null, ['class' => 'form-control', 'auto-complete' => 'off']) !!}
                    </div>
                </div>
                <div class="form-group margin-none">
                    <div class="col-sm-offset-1 col-sm-11">
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>

@stop

@section('pageHeader')

    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">

@endsection

@section('pageFooter')

    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js" type="text/javascript"></script>
    <script type="text/javascript">

        $(document).ready(function() {
            function split( val ) {
                return val.split( /,\s*/ );
            }
            function extractLast( term ) {
                return split( term ).pop();
            }

            $( "#tags" )
                // don't navigate away from the field on tab when selecting an item
                    .bind( "keydown", function( event ) {
                        if ( event.keyCode === $.ui.keyCode.TAB &&
                                $( this ).autocomplete( "instance" ).menu.active ) {
                            event.preventDefault();
                        }
                    })
                    .autocomplete({
                        source: function( request, response ) {
                            $.getJSON( "/tags/search/" + extractLast( request.term ), response );
                        },
                        search: function() {
                            // custom minLength
                            var term = extractLast( this.value );
                            if ( term.length < 2 ) {
                                return false;
                            }
                        },
                        focus: function() {
                            // prevent value inserted on focus
                            return false;
                        },
                        select: function( event, ui ) {
                            var terms = split( this.value );
                            // remove the current input
                            terms.pop();
                            // add the selected item
                            terms.push( ui.item.value );
                            // add placeholder to get the comma-and-space at the end
                            terms.push( "" );
                            this.value = terms.join( ", " );
                            return false;
                        }
                    });
        });

    </script>

 @endsection