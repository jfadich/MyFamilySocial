@extends('layouts.forum')

@section('content')



    <div class="panel panel-primary">
        <div class="panel-heading panel-heading-primary">
            <strong>Edit</strong>
        </div>
        <div class="panel-body">

            @include('partials.errors')

            {!! Form::open(['class' => 'form-horizontal', 'method' => 'PATCH', 'action' => ['ForumController@update',$thread->slug]]) !!}

                @include('forum._threadForm', ['submitText' => 'Edit Topic'])

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