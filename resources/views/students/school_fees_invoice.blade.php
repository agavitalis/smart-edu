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
                <h3>Invoice</h3>
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
            <div class="col-md-8 col-md-offset-2">
                <div class="x_panel">
                    <div class="x_title hide">
                        <h2>School Fees Invoice</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>

                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                        <section class="content invoice">
                            <!-- title row -->
                            <div class="row">
                                <div class="col-xs-12 invoice-header text-center">
                                    <h3>
                                        Shalom Academy
                                    </h3>
                                    <h5>
                                        Prime College of Immaculata
                                    </h5>
                                    <h6>
                                        Prime College of Immaculata
                                        Prime College of Immaculata
                                        Prime College of Immaculata
                                    </h6>
                                </div>
                                <!-- /.col -->
                            </div>
                            <hr class="zero-margin">
                            <!-- info row -->
                            <div class="row invoice-info">
                                <div class="col-sm-2 col-xs-2 invoice-col">
                                    <div class="pull-right">
                                        <!-- Current avatar -->
                                        <img class="img-responsive result-img" src="../images/picture.jpg" alt="Avatar"
                                            title="Change the avatar">
                                    </div>
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-8 col-xs-8 invoice-col">

                                    <address>

                                        <div class="col-md-12  col-sm-12 col-xs-12 invoice-col text-center">
                                            <p> <strong>Name: {{Auth::user()->name}}</strong> </p>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="col-sm-6 col-xs-6 text-right">

                                            <p><strong>Gender:</strong> {{Auth::user()->gender}}
                                                <br><strong>Registration No:</strong> {{Auth::user()->username}}
                                                <br><strong>Email:</strong> {{Auth::user()->email}}
                                                <br><strong>Phone:</strong> {{Auth::user()->phone}}
                                            </p>
                                        </div>

                                        <div class="col-sm-6 col-xs-6 pull-right">
                                            <p><strong>Session:</strong> {{$school_fees->session}}
                                                <br><strong>Level:</strong> {{$school_fees->level}}
                                                <br><strong>Class:</strong> {{$school_fees->klass}}
                                                <br><strong>Term:</strong> {{$school_fees->term}}
                                            </p>
                                        </div>


                                    </address>

                                </div>

                                <!-- /.col -->
                                <div class="col-sm-2 col-xs-2 invoice-col pull-right">
                                    <div class="pull-left">
                                        <!-- Current avatar -->
                                        <img class="img-responsive result-img" src="../images/picture.jpg" alt="Avatar"
                                            title="Change the avatar">
                                    </div>
                                </div>
                                <!-- /.col -->
                            </div>
                            <div class="clearfix"></div>
                            <hr class="zero-margin">
                            <div class="row margin-b">
                                <div class="col-xs-12  margin-b">
                                    <div class="col-sm-6 col-xs-6 text-right ">
                                        <h2><strong>Amount:&nbsp</strong>NGN {{$school_fees->amount}}
                                        </h2>
                                    </div>

                                    <div class="col-sm-6 col-xs-6 ">
                                        <h2>
                                            <strong>Payment Status:&nbsp</strong> Paid

                                            </h3>
                                    </div>
                                </div>
                            </div>
                            <hr class="zero-margin">
                            <!-- /.row -->

                            <!-- Table row -->
                            <div class="row">
                                <div class="col-xs-12">
                                    <table class="table result-print table-striped">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Amount(NGN)</th>
                                                <th>Status</th>
                                                <th>Session</th>
                                                <th>Term</th>
                                                <th>Class</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <tr>
                                                <td>#</td>
                                                <td style="width:20%;">{{$school_fees->amount}}</td>
                                                <td>Paid</td>
                                                <td>{{$school_fees->session}}</td>
                                                <td>{{$school_fees->term}}</td>
                                                <td>{{$school_fees->klass}}</td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->

                            <div class="row">
                                <!-- accepted payments column -->
                                <div class="col-xs-7">
                                    <p>
                                    <h2>School Fees Payment Invoice</h2>
                                    </p>
                                    <table class=" result-print table-striped" style="margin-left:2em;margin-top:1em;">
                                        <tbody>
                                            <tr>
                                                <th>Invoive Number:</th>
                                                <td style="padding-top:.2em;">08443324</td>
                                            </tr>
                                            <tr>
                                                <th>Date Generated: </th>
                                                <td style="padding-top:.2em;">4th June 2021</td>
                                            </tr>
                                            <tr>
                                                <th>Invoice Status:</th>
                                                <td style="padding-top:.2em;">Paid</td>
                                            </tr>


                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.col -->
                                <div class="col-xs-5">
                                    <p><i>BarCode</i></p>
                                    <div>
                                        <div style="text-align: center;">

                                            <img src="data:image/png;base64,{{DNS1D::getBarcodePNG('123456789', 'C39+',1,60,array(0,0,0), true)}}"
                                                alt="barcode" /><br><br>

                                        </div>
                                    </div>
                                </div>
                                <!-- /.col -->
                            </div>

                            <!-- /.row -->
                            <div class="clearfix"></div>
                            <hr class="zero-margin">
                            <div class="row invoice-info">
                                <!-- title row -->
                                <div class="row">
                                    <div class="col-xs-12 invoice-header text-center">

                                        <h5>
                                            Original School Fees Recipt
                                        </h5>
                                        <h6>
                                            This recipt is subject for futher verification by the school admin.
                                        </h6>
                                    </div>
                                    <!-- /.col -->
                                </div>
                            </div>

                            <!-- this row will not appear when printing -->
                            <div class="row no-print">
                                <div class="col-xs-12">
                                    <button class="btn btn-success pull-right" onclick=""><i
                                            class="fa fa-google-wallet"></i> Pay Now</button>
                                    <button class="btn btn-default pull-right" onclick="printthis()"><i
                                            class="fa fa-print"></i> Print</button>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    function printthis() {
        $(".nav.toggle").hide();
        $(".page-title").hide();
        $(".no-print").hide();
        $(".navbar-nav").hide();
        window.print();
    }
    </script>
</div>
<!-- /page content -->


@endsection


@section('footer')
@include("partials.students.footer")
@endsection

@section('scripts')
<script src="https://api.ravepay.co/flwv3-pug/getpaidx/api/flwpbf-inline.js"></script>
<script src="../../js/school_fees.js"></script>
@endsection