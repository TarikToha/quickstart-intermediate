@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="alert alert-danger">
            <h4><strong><span class="glyphicon glyphicon-remove"></span> File Not Found</strong>
                <br><br>

                <p><span class="glyphicon glyphicon-minus"></span>
                    This happens as your link does not contain any paper downloadable web link.
                </p>
                <p><span class="glyphicon glyphicon-minus"></span>
                    Please submit a link that contains a downloadable web link for the paper.
                </p>
            </h4>
        </div>
    </div>
@endsection

