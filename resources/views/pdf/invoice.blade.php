<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
    <meta name="csrf-token" content="{{ csrf_token() }}">

	<title>Editable Invoice</title>
    {{-- <link rel="stylesheet" href="{{asset('pdf/bootstrap.min.css')}}"> --}}
	<link rel='stylesheet' type='text/css' href='{{asset("pdf/css/style.css")}}' />
	<link rel='stylesheet' type='text/css' href='{{asset("pdf/css/print.css")}}' media="print" />
	<script type='text/javascript' src='{{asset("pdf/js/jquery-1.3.2.min.js")}}'></script>
	<script type='text/javascript' src='{{asset("pdf/js/example.js")}}'></script>
    <style>
    body {
            padding: .25cm;
        }
    /* @page {
        size: 21cm 29.7cm;
        margin: 0.25cm;
        padding: .25in;
        } */
    </style>
</head>

<body>

	<div id="page-wrap">

		<textarea id="header">CASH RECIEPT</textarea>

		<div id="identity">

            <textarea id="address">
                Chris Coyier
                123 Appleseed Street
                Appleville, WI 53719

                Phone: (555) 555-5555
            </textarea>

            <div id="logo">

              <div id="logoctr">
                <a href="javascript:;" id="change-logo" title="Change logo">Change Logo</a>
                <a href="javascript:;" id="save-logo" title="Save changes">Save</a>
                |
                <a href="javascript:;" id="delete-logo" title="Delete logo">Delete Logo</a>
                <a href="javascript:;" id="cancel-logo" title="Cancel changes">Cancel</a>
              </div>

              <div id="logohelp">
                <input id="imageloc" type="text" size="50" value="" /><br />
                (max width: 540px, max height: 100px)
              </div>
              <img id="image" src="{{asset('schools/logos/logo.png')}}" alt="logo" />
            </div>

		</div>

		<div style="clear:both"></div>

		<div id="customer">
            <textarea id="customer-title">
                Reciept Title
            </textarea> <br>
        </div>
        <div id="customer">
           <textarea id="address">
                Chris Coyier
                123 Appleseed Street
                Appleville, WI 53719

                Phone: (555) 555-5555
            </textarea>
        </div>




            <table id="meta" style="float: right;">
                <tr>
                    <td class="meta-head">Invoice #</td>
                    <td><textarea>000123</textarea></td>
                </tr>
                <tr>

                    <td class="meta-head">Date</td>
                    <td><textarea id="date">December 15, 2009</textarea></td>
                </tr>
                <tr>
                    <td class="meta-head">Amount Due</td>
                    <td><div class="due">$875.00</div></td>
                </tr>

            </table>

		</div>

		<table id="items">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Description</th>
                    <th>Unit Cost</th>
                    <th>Quantity</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>


                @foreach ($data as $item)
                <tr class="item-row">
                    <td class="item-name"><div class="delete-wpr"><textarea>{{$item['name']}}</textarea></div></td>

                    <td class="description"><textarea>{{$item['description']}}</textarea></td>
                    <td><textarea class="cost">{{'UGX '.$item['Unit Cost']}}</textarea></td>
                    <td><textarea class="qty">{{$item['Quantity']}}</textarea></td>
                    <td><span class="price">{{'UGX '.$item['Price']}}</span></td>
                </tr>
              @endforeach


            </tbody>



          @foreach ($data as $item)
            <tr class="item-row">
                <td class="item-name"><div class="delete-wpr"><textarea>{{$item['name']}}</textarea></div></td>

                <td class="description"><textarea>{{$item['description']}}</textarea></td>
                <td><textarea class="cost">{{'UGX '.$item['Unit Cost']}}</textarea></td>
                <td><textarea class="qty">{{$item['Quantity']}}</textarea></td>
                <td><span class="price">{{'UGX '.$item['Price']}}</span></td>
            </tr>
          @endforeach



		  {{-- <tr id="hiderow">
		    <td colspan="5"><a id="addrow" href="javascript:;" title="Add a row">Add a row</a></td>
		  </tr> --}}

		  <tr>
		      <td colspan="2" class="blank"> </td>
		      <td colspan="2" class="total-line">Subtotal</td>
		      <td class="total-value"><div id="subtotal">$875.00</div></td>
		  </tr>
		  <tr>

		      <td colspan="2" class="blank"> </td>
		      <td colspan="2" class="total-line">Total</td>
		      <td class="total-value"><div id="total">$875.00</div></td>
		  </tr>
		  <tr>
		      <td colspan="2" class="blank"> </td>
		      <td colspan="2" class="total-line">Amount Paid</td>

		      <td class="total-value"><textarea id="paid">$0.00</textarea></td>
		  </tr>
		  <tr>
		      <td colspan="2" class="blank"> </td>
		      <td colspan="2" class="total-line balance">Balance Due</td>
		      <td class="total-value balance"><div class="due">$875.00</div></td>
		  </tr>

		</table>

		<div id="terms">
		  <h5>Terms</h5>
		  <textarea>NET 30 Days. Finance Charge of 1.5% will be made on unpaid balances after 30 days.</textarea>
		</div>

	</div>

</body>

</html>
