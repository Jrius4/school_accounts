<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>
    <link rel="stylesheet" href="{{asset('pdf/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('pdf/custom/css/invoice.css')}}">
</head>
<body>
    <div id="page-wrapper"  class="page">
        <header>
            <div class="page-title">
                <h2>CASH RECIEPT</h2>
            </div>
            <div class="clear-fix"></div>
            <div class="row">
                <div class="MainAddress">
                    <p>
                        Lorem, ipsum dolor sit amet consectetur adipisicing elit. A officia sint nesciunt possimus obcaecati. Quae labore blanditiis ad at, sequi ut praesentium vero atque recusandae eos illo nobis rerum accusamus.
                    </p>
                </div>
                <div class="MainLogo">
                    <img src="schools/logos/logo-white-one.jpg" alt="" srcset="">
                </div>
            </div>

            <div class="clear-fix"></div>

            <div class="row">
                <div class="InvoiceTitle">
                    <p>
                        Lorem, ipsum dolor sit amet consectetur adipisicing elit. A officia sint nesciunt possimus obcaecati. Quae labore blanditiis ad at, sequi ut praesentium vero atque recusandae eos illo nobis rerum accusamus.
                    </p>
                </div>
                <div class="InvoiceMeta">
                    <table class="table-meta">
                        <tr>
                            <th>
                                # Invoice
                            </th>
                            <td>
                                {{$invoice->token}}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Category
                            </th>
                            <td>
                                {{$invoice->expensetype}}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Date
                            </th>
                            <td>{{$date->parse($invoice->created_at)->format('D,d/M/Y,H:i:s')}}</td>
                        </tr>
                        <tr>
                            <th>Amount</th>
                            <td>
                                {{'UGX '.$invoice->expenseTotal}}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

        </header>
        <div class="clear-fix"></div>
        <section class="row">
            <table class="table">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Description</th>
                        <th>Quantity</th>
                        <th>Unit</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count(json_decode($invoice->expenseItems,true)) > 0)
                        <tr>
                            <td>Expense Items</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </section>
    </div>



    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body p-0">
                        <div class="row p-5">
                            <div class="col-md-6">
                                <img src="http://via.placeholder.com/400x90?text=logo">
                            </div>

                            <div class="col-md-6 text-right">
                                <p class="font-weight-bold mb-1">Invoice #550</p>
                                <p class="text-muted">Due to: 4 Dec, 2019</p>
                            </div>
                        </div>

                        <hr class="my-5">

                        <div class="row pb-5 p-5">
                            <div class="col-md-6">
                                <p class="font-weight-bold mb-4">Client Information</p>
                                <p class="mb-1">John Doe, Mrs Emma Downson</p>
                                <p>Acme Inc</p>
                                <p class="mb-1">Berlin, Germany</p>
                                <p class="mb-1">6781 45P</p>
                            </div>

                            <div class="col-md-6 text-right">
                                <p class="font-weight-bold mb-4">Payment Details</p>
                                <p class="mb-1"><span class="text-muted">VAT: </span> 1425782</p>
                                <p class="mb-1"><span class="text-muted">VAT ID: </span> 10253642</p>
                                <p class="mb-1"><span class="text-muted">Payment Type: </span> Root</p>
                                <p class="mb-1"><span class="text-muted">Name: </span> John Doe</p>
                            </div>
                        </div>

                        <div class="row p-5">
                            <div class="col-md-12">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="border-0 text-uppercase small font-weight-bold">ID</th>
                                            <th class="border-0 text-uppercase small font-weight-bold">Item</th>
                                            <th class="border-0 text-uppercase small font-weight-bold">Description</th>
                                            <th class="border-0 text-uppercase small font-weight-bold">Quantity</th>
                                            <th class="border-0 text-uppercase small font-weight-bold">Unit Cost</th>
                                            <th class="border-0 text-uppercase small font-weight-bold">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Software</td>
                                            <td>LTS Versions</td>
                                            <td>21</td>
                                            <td>$321</td>
                                            <td>$3452</td>
                                        </tr>
                                        <tr>
                                            <td>1</td>
                                            <td>Software</td>
                                            <td>Support</td>
                                            <td>234</td>
                                            <td>$6356</td>
                                            <td>$23423</td>
                                        </tr>
                                        <tr>
                                            <td>1</td>
                                            <td>Software</td>
                                            <td>Sofware Collection</td>
                                            <td>4534</td>
                                            <td>$354</td>
                                            <td>$23434</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="d-flex flex-row-reverse bg-dark text-white p-4">
                            <div class="py-3 px-5 text-right">
                                <div class="mb-2">Grand Total</div>
                                <div class="h2 font-weight-light">$234,234</div>
                            </div>

                            <div class="py-3 px-5 text-right">
                                <div class="mb-2">Discount</div>
                                <div class="h2 font-weight-light">10%</div>
                            </div>

                            <div class="py-3 px-5 text-right">
                                <div class="mb-2">Sub - Total amount</div>
                                <div class="h2 font-weight-light">$32,432</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-light mt-5 mb-5 text-center small">by : <a class="text-light" target="_blank" href="http://totoprayogo.com">totoprayogo.com</a></div>

    </div>
</body>
</html>
