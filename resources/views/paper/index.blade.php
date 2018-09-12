@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>Your Moodle user name is {{ $moodle }}</strong>
            </div>

            <div class="panel-body">
                <div class="alert alert-info" style="text-align: center">
                    <strong>Only IEEE, ACM, ScienceDirect, and SpringerLink are supported</strong>
                </div>

                <!-- Display Validation Errors -->
            @include('common.errors')

            <!-- New Paper Form -->
                <form action="{{ url('paper') }}" method="POST" class="form-horizontal">
                {{ csrf_field() }}

                <!-- Paper Name -->
                    <div class="form-group">
                        <label for="paper-name" class="col-sm-3 control-label">New Paper</label>

                        <div class="col-sm-6">
                            <input type="url" name="link" id="paper-name" class="form-control"
                                   value="{{ old('paper') }}">
                            <span class="help-block">
                                    <strong>Paste the url as the following form:</strong>
                                    <br>https://ieeexplore.ieee.org/document/8422113/
                                    <br>https://www.sciencedirect.com/science/article/pii/S0957417417300751
                                    <br>https://dl.acm.org/citation.cfm?id=3025646
                                    <br>https://link.springer.com/article/10.1007/s10489-014-0604-3
                            </span>
                        </div>
                    </div>

                    <!-- Add Paper Button -->
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-6">
                            <button type="submit" class="btn btn-default">
                                <i class="fa fa-btn fa-plus"></i>Add paper
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="panel-footer text-right">
                <strong>Please email the failure cases to <a
                            href="mailto:ureportersite@gmail.com">ureportersite@gmail.com</a></strong>
            </div>
        </div>

        <!-- Current Papers -->
        @if (count($papers) > 0)
            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong>Current Papers</strong>
                </div>

                <div class="panel-body">
                    <table class="table table-striped table-hover paper-table">
                        <thead>
                        <th style="text-align: center">Paper</th>
                        </thead>
                        <tbody>
                        @foreach ($papers as $paper)
                            <tr>
                                <td class="table-text" style="text-align: center">
                                    <a href=" {{url('download_papers/'.$paper->name) }}">{{ $paper->name }}</a>
                                </td>
                                @if(Auth::user()->isAdmin())
                                    <td style="text-align: center">
                                        <form action="{{url('paper/' . $paper->id)}}" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}

                                            <button type="submit" id="delete-paper-{{ $paper->id }}"
                                                    class="btn btn-danger">
                                                <i class="fa fa-btn fa-trash"></i>Delete
                                            </button>
                                        </form>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
@endsection
