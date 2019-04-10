<!DOCTYPE html>
<html>
<head>
    <title>Order Email</title>
</head>
<body>
    <table width="700px">
        <thead>
            <tr><td>&nbsp;</td></tr>
            <tr><td><img src="{{asset('images/logo/logo.png')}}"></td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td>Hello {{ $name }},</td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td>Thank you for shopping with us. Your order details are as below:</td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td><b>Order No: {{ $order_id }}</b></td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr>
                <td>
                    <table width="95%" cellpadding="5" cellspacing="5" bgcolor="#f7f4f4">
                        <tr bgcolor="#cccccc">
                            <td><b>Product Name</td></b>
                            <td><b>Product Code</td></b>
                            <td><b>Color</td></b>  
                            <td><b>Size</td></b>
                            <td><b>Quantity</td></b>
                            <td><b>Unit Price</td></b>                        
                        </tr>
                        @foreach($productdetails['orders'] as $product)
                            <tr>
                                <td>{{$product['product_name']}}</td>
                                <td>{{$product['product_code']}}</td>
                                <td>{{$product['product_color']}}</td>
                                <td>{{$product['product_size']}}</td>
                                <td>{{$product['product_qty']}}</td>
                                <td>{{$product['product_price']}}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="5" align="right"><b>Shipping Charges</b>
                            </td>
                            <td>
                                Rs.{{ $productdetails['shipping_charges'] }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5" align="right"><b>Coupon Discount</b></td>
                            <td>
                                Rs.{{ $productdetails['coupon_amount'] }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5" align="right"><b>Grand Total</b></td>
                            <td>
                                Rs.{{ $productdetails['grand_total'] }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table width="100%">
                        <tr>
                            <td width="50%">
                                <table>
                                    <tr>
                                        <td><b>Bill To:</b></td>
                                    </tr>
                                    <tr>
                                        <td>{{$userDetails['name']}}</td>
                                    </tr>
                                     <tr>
                                        <td>{{$userDetails['address']}}</td>
                                    </tr>
                                     <tr>
                                        <td>{{$userDetails['city']}}</td>
                                    </tr>
                                     <tr>
                                        <td>{{$userDetails['state']}}</td>
                                    </tr>
                                     <tr>
                                        <td>{{$userDetails['country']}}</td>
                                    </tr>
                                     <tr>
                                        <td>{{$userDetails['pincode']}}</td>
                                    </tr>
                                     <tr>
                                        <td>{{$userDetails['mobile']}}</td>
                                    </tr>
                                </table>
                            </td>
                            <td width="50%">
                                <table>
                                    <tr>
                                        <td><b>Ship To:</b></td>
                                    </tr>
                                    <tr>
                                        <td>{{$productdetails['name']}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{$productdetails['address']}}</td>
                                    </tr>
                                     <tr>
                                        <td>{{$productdetails['city']}}</td>
                                    </tr>
                                     <tr>
                                        <td>{{$productdetails['state']}}</td>
                                    </tr>
                                     <tr>
                                        <td>{{$productdetails['country']}}</td>
                                    </tr>
                                     <tr>
                                        <td>{{$productdetails['pincode']}}</td>
                                    </tr>
                                     <tr>
                                        <td>{{$productdetails['mobile']}}</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
             <tr><td>&nbsp;</td></tr>
             <hr>
              <tr><td>For any enquiries, you can contact us at <a href="mailto:coolsijan12@gmail.com">info@eshop-website.com</a></td></tr>
              <tr><td>&nbsp;</td></tr>
            <tr><td>Thanks & Regards,</td></tr>
            <tr><td>E-Shoppe</td></tr>
        </thead>
    </table>
</body>
</html>