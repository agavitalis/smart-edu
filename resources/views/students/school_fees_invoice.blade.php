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
                                            <p style="margin-bottom:0px"> <strong>Name: {{Auth::user()->name}}</strong> </p>
                                            <p>Gender: {{Auth::user()->gender}} </p>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="col-sm-6 col-xs-6 text-right">

                                            <p>
                                                <strong>Registration No:</strong> {{Auth::user()->username}}
                                                <br><strong>Email:</strong> {{Auth::user()->email}}
                                                <br><strong>Phone:</strong> {{Auth::user()->phone}}
                                            </p>
                                        </div>

                                        <div class="col-sm-6 col-xs-6 pull-right">
                                            <p><strong>Session:</strong> {{$school_fee_invoice->session}}
                                                <br><strong>Level:</strong> {{$school_fee_invoice->level}}
                                                <br><strong>Term:</strong> {{$school_fee_invoice->term}}
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
                                        <h2><strong>Amount:&nbsp</strong>NGN {{$school_fee_invoice->amount}}
                                        </h2>
                                    </div>

                                    <div class="col-sm-6 col-xs-6 ">
                                        <h2>
                                            <strong>Payment Status:&nbsp</strong> {{$school_fee_invoice->status}}

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
                                                <th>Amount(NGN)</th>
                                                <th>Status</th>
                                                <th>Session</th>
                                                <th>Level</th>
                                                <th>Term</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <tr>
                                                <td>{{$school_fee_invoice->amount}}</td>
                                                <td>Paid</td>
                                                <td>{{$school_fee_invoice->session}}</td>
                                                <td>{{$school_fee_invoice->level}}</td>
                                                <td>{{$school_fee_invoice->term}}</td>
                                                
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->
                            <form>
                                @csrf
                                <input type="hidden" id="session" value="{{$school_fee_invoice->session}}">
                                <input type="hidden" id="level" value="{{$school_fee_invoice->level}}">
                                <input type="hidden" id="term" value="{{$school_fee_invoice->term}}">
                                <input type="hidden" id="amount" value="{{$school_fee_invoice->amount}}">
                                <input type="hidden" id="email" value="{{Auth::user()->email}}">
                                <input type="hidden" id="username" value="{{Auth::user()->username}}">
                                <input type="hidden" id="phone" value="{{Auth::user()->phone}}">
                            
                            </form>

                            <div class="row">
                                <!-- accepted payments column -->
                                <div class="col-xs-12">
                                    <p>
                                    <h2>School Fees Payment Invoice</h2>
                                    </p>
                                    <table class=" result-print table-striped" style="margin-left:2em;margin-top:1em;">
                                        <tbody>
                                            <tr>
                                                <th>Invoive Number:</th>
                                                <td style="padding-top:.2em;">{{$school_fee_invoice->invoice_number}}</td>
                                            </tr>
                                            <tr>
                                                <th>Date Generated: </th>
                                                <td style="padding-top:.2em;">{{$school_fee_invoice->created_at}}</td>
                                            </tr>
                                            <tr>
                                                <th>Invoice Status:</th>
                                                <td style="padding-top:.2em;">{{$school_fee_invoice->status}}</td>
                                            </tr>
                                            @if($school_fee_invoice->status === "PAID")
                                            <tr>
                                                <th>Date Paid:</th>
                                                <td style="padding-top:.2em;">{{$school_fee_invoice->updated_at}}</td>
                                            </tr>
                                            @endif
                                           
                                 

                                        </tbody>
                                    </table>
                                </div>
                                
                                <!-- /.col -->
                                <div class="col-xs-12">
                                    <p style="margin-top:1em"><i>Barcode</i></p>
                                    <div>
                                        <div style="text-align: center;">

                                            <img src="data:image/png;base64,{{DNS1D::getBarcodePNG($school_fee_invoice->invoice_number, 'C39+',1,60,array(0,0,0), true)}}"
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
                                    @if($school_fee_invoice->status !== "PAID")
                                    <button class="btn btn-success pull-right pay"><i
                                            class="fa fa-google-wallet"></i> Pay Now</button>
                                    @endif
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