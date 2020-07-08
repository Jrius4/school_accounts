<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>
    <link rel="stylesheet" href="{{asset('pdf/bootstrap.min.css')}}">
{{-- <script src="{{asset('js/app.js')}}" defer></script> --}}
<script src="{{asset('chat/js/jquery.min.js')}}"></script>
<link rel="stylesheet" href="{{asset('pdf/custom/css/super.css')}}">
</head>
{{-- <body onload="window.print()"> --}}
<body>
    <div id="invoice">

        {{-- <div class="toolbar hidden-print">
            <div class="text-right">
                <button id="printInvoice" class="btn btn-info"><i class="fa fa-print"></i> Print</button>
                <button class="btn btn-info"><i class="fa fa-file-pdf-o"></i> Export as PDF</button>
            </div>
            <hr>
        </div> --}}
        <div class="invoice overflow-auto" id="printable" onload="window.print()">
            <div style="min-width: 600px">
                <header>
                    <div class="row">
                        <div class="col">
                            <a target="_blank" href="javascript:void(0);">
                                <img width="75" class="img-fluid" src="{{asset('schools/logos/logo-white-one.jpg')}}" data-holder-rendered="true" />
                            </a>
                        </div>
                        <div class="col company-details">
                            <h2 class="name">
                                <span  class="text-primary">
                                    FRIENDS ACADEMY  KITENDE

                                </span>
                            </h2>
                            <div>MIXED DAY AND BOARDING SECONDARY SCHOOL</div>
                            <div>(ARTS & SCIENCES)</div>
                            <div>P.O BOX 27626 KAMPALA</div>
                            <div>TEL:+256(0)303225968 <br>
                                friendsacademy.frack@gmail.com <br>
                                www.friendsacademyug.com</div>
                        </div>
                    </div>
                </header>
                <main>
                    <div class="row contacts">
                        <div class="col invoice-to">
                            <div class="text-gray-light">CASH RECIEPT:</div>
                            <h2 class="to">{{$invoice->requested_by}}</h2>
                            {{-- <div class="address">796 Silver Harbour, TX 79273, US</div>
                            <div class="email"><a href="mailto:john@example.com">john@example.com</a></div> --}}
                        </div>
                        <div class="col invoice-details">
                            <h1 class="invoice-id">INVOICE {{$invoice->token}}</h1>
                            <div class="date">CATEGORY: {{'# '.$invoice->expensetype}}</div>
                            <div class="date">Date of Invoice: {{$date->parse($invoice->created_at)->format('D,d/M/Y,H:i:s')}}</div>
                            <div class="date">CASH OUTFLOW: {{'UGX '.number_format($invoice->expenseTotal,0)}}</div>
                        </div>
                    </div>
                    <table border="0" cellspacing="0" cellpadding="0">
                        <thead>
                            @if ($invoice->expenseItems!== 'null' ?count(json_decode($invoice->expenseItems,true)) > 0:false)

                                <tr>
                                    <th>#</th>
                                    <th class="text-left">DESCRIPTION</th>
                                    <th class="text-right">UNITS</th>
                                    <th class="text-right">QUANTITY</th>
                                    <th class="text-right">TOTAL</th>
                                </tr>

                            @endif

                            @if ($invoice->expensetype == "Salary")
                                <tr>
                                    <th>#</th>
                                    <th class="text-left">DESCRIPTION</th>
                                    <th class="text-right">RECIEVED</th>
                                    <th class="text-right">BALANCE</th>
                                    <th class="text-right">TOTAL</th>
                                </tr>
                            @endif


                        </thead>
                        <tbody>
                            @if ($invoice->expenseItems !== 'null' ?count(json_decode($invoice->expenseItems,true)) > 0:false)
                                @foreach (json_decode($invoice->expenseItems,true) as $exp)


                                    <tr>
                                        <td class="no">{{$exp['id']}}</td>
                                        <td class="text-left">
                                            <h3>{{$exp['name']}}</h3>
                                            {{$exp['description']}}
                                        </td>
                                        <td class="unit">{{$exp['quantity'].' '.$exp['units']}}</td>
                                        <td class="qty">{{'UGX '.number_format($exp['rate'],0)}}</td>
                                        <td class="total">{{'UGX '.number_format($exp['amount'],0)}}</td>
                                    </tr>


                                @endforeach
                            @endif

                            <tr>
                                <td class="no">01</td>
                                <td class="text-left"><h3>Website Design</h3>Creating a recognizable design solution based on the company's existing visual identity</td>
                                <td class="unit">$40.00</td>
                                <td class="qty">30</td>
                                <td class="total">$1,200.00</td>
                            </tr>
                            @if ($invoice->expensetype == "Salary")
                                <tr>
                                    <td class="no">02</td>
                                    <td class="text-left">
                                    <h3>Salary Type : <small>{{$invoice->expensetype}}</small></h3>
                                    {{$invoice->overview}}
                                    </td>
                                    <td class="unit">{{'UGX '.number_format($invoice->expenseTotal,0)}}</td>
                                    <td class="qty">{{'UGX '.number_format(json_decode($invoice->worker,true)['wage_balance'],0)}}</td>
                                    <td class="total">{{'UGX '.number_format($invoice->expenseTotal,0)}}</td>
                                </tr>
                            @endif

                            <tr>
                                <td class="no">03</td>
                                <td class="text-left"><h3>Search Engines Optimization</h3>Optimize the site for search engines (SEO)</td>
                                <td class="unit">$40.00</td>
                                <td class="qty">20</td>
                                <td class="total">$800.00</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            {{-- {{-- <tr>
                                <td colspan="2"></td>
                                <td colspan="2">SUBTOTAL</td>
                                <td>$5,200.00</td>
                            </tr> --}}
                            {{-- <tr>
                                <td colspan="2"></td>
                                <td colspan="2">TAX 25%</td>
                                <td>$1,300.00</td>
                            </tr> --}}
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="2"></td>
                                <td colspan="2">GRAND TOTAL</td>
                                <td>{{'UGX '.number_format($invoice->expenseTotal,0)}}</td>
                            </tr>
                        </tfoot>
                    </table>
                    {{-- <div class="thanks">Thank you!</div> --}}
                    <div class="notices">
                        <div>NOTICE:</div>
                        <div class="notice">A finance charge of 1.5% will be made on unpaid balances after 30 days.</div>
                    </div>
                </main>
                <footer>
                    Invoice was created on a computer and is valid without the signature and seal.
                </footer>
            </div>
            <!--DO NOT DELETE THIS div. IT is responsible for showing footer always at the bottom-->
            <div></div>
        </div>
    </div>

    <script type="text/javascript">
     $('#printInvoice').click(function(){
            Popup($('#printable')[1].outerHTML);
            function Popup(data)
            {
                window.print();
                return true;
            }
        });

    </script>
</body>
</html>
