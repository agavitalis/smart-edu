@extends('layouts.main')

@section('header')
@include('partials.students.header')
@endsection

@section('body')
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Your School Fees Recipts</h3>
            </div>

            <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search for...">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button">Go!</button>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col col-md-10 col-md-offset-1">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Yours School Fees Recipts</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>

                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                        <p>Here is a list of your the fees paid</p>

                        <!-- start project list -->
                        <table class="table table-striped projects">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Session</th>
                                    <th>Level</th>
                                    <th>Term</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th style="width: 20%">Print Recipt</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($school_fees_recipts as $school_fees_recipt )
                                <tr>
                                    <td>#</td>
                                    <td>
                                        <a>{{$school_fees_recipt->session}}</a>
                                    </td>
                                    <td>
                                        <a>{{$school_fees_recipt->level}}</a>
                                    </td>
                                    <td>
                                        <a>{{$school_fees_recipt->term}}</a>
                                    </td>
                                    <td>
                                        <a>{{$school_fees_recipt->amount}}</a>
                                    </td>
                                    <td>
                                        <a>{{$school_fees_recipt->status}}</a>
                                    </td>

                                    <td>
                                        <form action="/student/generate_school_fees_invoice" method="post">
                                            {{csrf_field()}}
                                            <input type="hidden" name="session" value="{{$school_fees_recipt->session}}">
                                            <input type="hidden" name="level" value="{{$school_fees_recipt->level}}">
                                            <input type="hidden" name="term" value="{{$school_fees_recipt->term}}">
                                            <button type="submit"><i class="fa fa-print"></i> &nbsp Print</button>
                                        </form>
                                    </td>

                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                        <!-- end project list -->

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- /page content -->

@endsection

@section('footer')
@include("partials.students.footer")
@endsection