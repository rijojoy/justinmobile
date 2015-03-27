<!DOCTYPE html>
<html lang="en">
    <head>
        <style>
            table {
                background-color: transparent;
                page-break-inside: avoid;
            }

            .table {
                width: 100%;
                max-width: 100%;
                margin-bottom: 20px;
            }
            .table > thead > tr > th,
            .table > tbody > tr > th,
            .table > tfoot > tr > th,
            .table > thead > tr > td,
            .table > tbody > tr > td,
            .table > tfoot > tr > td {
                padding: 8px;
                line-height: 1.42857143;
                vertical-align: top;
                border-top: 1px solid #ddd;
            }
            .table > thead > tr > th {
                vertical-align: bottom;
                border-bottom: 2px solid #ddd;
            }
            .table > caption + thead > tr:first-child > th,
            .table > colgroup + thead > tr:first-child > th,
            .table > thead:first-child > tr:first-child > th,
            .table > caption + thead > tr:first-child > td,
            .table > colgroup + thead > tr:first-child > td,
            .table > thead:first-child > tr:first-child > td {
                border-top: 0;
            }
            .table > tbody + tbody {
                border-top: 2px solid #ddd;
            }
            .table .table {
                background-color: #fff;
            }
            .table-bordered {
                border: 1px solid #ddd;
            }
            .table-bordered > thead > tr > th,
            .table-bordered > tbody > tr > th,
            .table-bordered > tfoot > tr > th,
            .table-bordered > thead > tr > td,
            .table-bordered > tbody > tr > td,
            .table-bordered > tfoot > tr > td {
                border: 1px solid #ddd;
            }
            .table-bordered > thead > tr > th,
            .table-bordered > thead > tr > td {
                border-bottom-width: 2px;
            }
            .table-striped > tbody > tr:nth-child(odd) {
                background-color: #EEEEEE;
            }
            .text-center {
                text-align: center;
            }
        </style>
    </head>
    <body>
        <div class="container" >
            <h4 class="text-center">Packing Slip / Sell Order Details</h4>
            <div class="content">
                <p>
                    Please check the details below and let us know if they need to be changed. Include this Packing Slip with your {{$device}} when you send it to us.


                </p>
                <table class="table table-striped table-bordered">
                    <tbody>
                        <tr>
                            <td>Sell Order Number</td>
                            <td>{{$orderID}}</td>
                        </tr>
                        <tr>
                            <td>Date order placed</td>
                            <td>{{date("d-m-Y");}}</td>
                        </tr>
                        <tr>
                            <td>Our offer</td>
                            <td>£{{$price}}</td>
                        </tr>
                        <tr>
                            <td>Our offer is guaranteed until</td>
                            <td>{{date("d-m-Y", strtotime(date("d-m-Y") . " + 14 days"))}}</td>
                        </tr>
                    </tbody>
                </table>

                <p>
                    Personal Details
                </p>
                <table class="table table-striped table-bordered">
                    <tbody>
                        <tr>
                            <td>Name</td>
                            <td>{{$name}}</td>
                        </tr>
                        <tr>
                            <td>Email Address</td>
                            <td>{{$email}}</td>
                        </tr>
                        <tr>
                            <td>Phone Number</td>
                            <td>{{$phone}}</td>
                        </tr>
                        <tr>
                            <td>Address</td>
                            <td>{{$address}}</td>
                        </tr>
                    </tbody>
                </table>

                <p>
                    Device Details
                </p>
                <table class="table table-striped table-bordered">
                    <tbody>
                        <tr>
                            @foreach($product as $productDetail)
                            <td>{{$productDetail}}</td>
                            @endforeach
                        </tr>
                        @foreach($deviceProperites as $propertyName => $propertyArray)
                        <tr>
                            <td>{{$propertyName}}</td>
                            @if(is_array($propertyArray["name"]))
                            <td>
                                @foreach($propertyArray["name"] as $prop)
                                {{$prop." "}}
                                @endforeach
                            </td>
                            @else
                            <td>{{$propertyArray["name"]}}</td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <p>
                    Payment Details
                </p>
                <table class="table table-striped table-bordered">
                    <tbody>
                        @foreach($payment as $columnName => $value)
                        <tr>
                            <td>{{$columnName}}</td>
                            <td>{{$value}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>