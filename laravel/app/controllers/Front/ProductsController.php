<?php

namespace Front;

class ProductsController extends \BaseController
{

    public function getProduct($product_slug = null)
    {
        $products = \Product::orderBy('default', 'asc')->get();
        if ($product_slug)
        {
            $product = \Product::where('slug', $product_slug)->firstOrFail();
        }
        else
        {
            $product = \Product::where('default', 1)->firstOrFail();
        }
        return \View::make('front.products.product', array('products' => $products, 'product' => $product));
    }

    public function postOrder()
    {
        $request = \Request::instance();
        $order = json_decode($request->getContent(), true);
        $payment_array = array();

        foreach ($order['person'] as $property => $value)
        {
            $person["person.{$property}"] = $value;
        }

        $validata = array('product' => $order['product'], 'model' => $order['model']) + $person;

        $rules = array(
            'product' => 'required|exists:products,id',
            'model' => 'required|exists:products_models,id',
            'person.name' => 'required',
            'person.email' => 'required|email',
            'person.address' => 'required',
            'person.phone' => 'required',
            'person.payment' => 'required|in:paypal,bank,cheque,bitcoin',
        );

        $messages = array(
            'person.email.email' => 'The email field must contain a valid email address',
            'person.paypal-email.email' => 'The PayPal email field must contain a valid email address',
        );

        if ($validata['person.payment'] == 'paypal')
        {
            $payment_array["Payment Method"] = "PayPal";
            $payment_array["PayPal Email"] = $order['person']['paypal-email'];

            $rules['person.paypal-email'] = 'required|email';
            unset($order['person']['cheque-name'], $order['person']['bank-accountnumber'], $order['person']['bank-sortcode'], $order['person']['bitcoin-address']);
        }
        else if ($validata['person.payment'] == 'bank')
        {
            $payment_array["Payment Method"] = "Bank Transfer";
            $payment_array["Account Number"] = $order['person']['bank-accountnumber'];
            $payment_array["Sort Code"] = $order['person']['bank-sortcode'];

            $rules['person.bank-accountnumber'] = 'required';
            $rules['person.bank-sortcode'] = 'required';
            unset($order['person']['paypal-email'], $order['person']['cheque-name'], $order['person']['bitcoin-address']);
        }
        else if ($validata['person.payment'] == 'cheque')
        {
            $payment_array["Payment Method"] = "Cheque";
            $payment_array["Name on Cheque"] = $order['person']['cheque-name'];

            $rules['person.cheque-name'] = 'required';
            unset($order['person']['paypal-email'], $order['person']['bank-accountnumber'], $order['person']['bank-sortcode'], $order['person']['bitcoin-address']);
        }
        else if ($validata['person.payment'] == 'bitcoin')
        {
            $payment_array["Payment Method"] = "Bitcoin";
            $payment_array["Bitcoin Address"] = $order['person']['bitcoin-address'];

            $rules['person.bitcoin-address'] = 'required';
            unset($order['person']['paypal-email'], $order['person']['bank-accountnumber'], $order['person']['bank-sortcode'], $order['person']['cheque-name']);
        }

        $validator = \Validator::make($validata, $rules, $messages);
        $errors = [];

        if ($validator->fails())
        {
            foreach ($validator->messages()->all() as $message)
            {
                $errors[] = $message;
            }
        }


        $product = \Product::where('id', $order['product'])->firstOrFail();
        $model = \ProductModel::where('id', $order['model'])->firstOrFail();

        $pdf_product_array = array($product->name, $model->name);


        foreach ($model->propertyies()->get() as $property)
        {
            $properties_cache[$property->id] = $property->toArray();
            $options = [];
            $pdf_property_array[$property->name] = array();

            $orderPropID = $order['properties'][$property->id];

            foreach ($property->options()->get() as $option)
            {
                if (is_array($orderPropID))
                {
                    $name = "";
                    foreach ($orderPropID as $orderProp)
                    {
                        if ($orderProp == $option->id)
                        {
                            $pdf_property_array[$property->name]["name"][] = $option->name;
                        }
                    }
                }
                elseif ($orderPropID == $option->id)
                {
                    $pdf_property_array[$property->name]["name"] = $option->name;
                }

                $options_cache[$option->id] = $option->toArray();
                $options[$option->id] = $property->id;
            }

            if ($property->required)
            {
                if (!isset($order['properties'][$property->id]))
                {
                    $errors[] = $property->name . ' is required';
                }
            }
        }


        if (empty($errors))
        {

            $dorder = new \Order;
            $dorder->product_id = $product->id;
            $dorder->product_cache = json_encode($product->toArray());
            $dorder->model_id = $model->id;
            $dorder->model_cache = json_encode($model->toArray());
            $dorder->properties_cache = json_encode($properties_cache);
            $dorder->options_input = json_encode($order['properties']);
            $dorder->options_cache = json_encode($options_cache);
            $dorder->personal_info = json_encode($order['person']);
            $dorder->order_info = json_encode($order);
            $dorder->status_id = \OrderStatus::first()->id;
            $dorder->save();

//Sean - Hash a customID for display purposes - start
            $hashedID = \Crypt::encrypt($dorder->id);

            $savedOrder = \Order::find($dorder->id);
            $savedOrder->hashed_id = $hashedID;
            $savedOrder->save();
//Sean - Hash a customID for display purposes - end

            $payment_methods = ['paypal' => 'PayPal', 'bank' => 'Bank Transfer', 'cheque' => 'Cheque', 'bitcoin' => 'Bitcoin'];

            $device_status = null;
            foreach ($order['properties'] as $property_id => $option_id)
            {
                $value = $options_cache[$option_id]['name'];
                if ($value == 'I will print it')
                {
                    $device_status = 1;
                    break;
                }
                if ($value == 'Post it to me')
                {
                    $device_status = 1;
                    break;
                }
            }

            //Create PDF - sean - start
            $pdfDataArray = array();

            $pdf = \App::make('dompdf');

            $pdfDataArray["orderID"] = $dorder->id;
            $pdfDataArray["price"] = $order['person']['myprice'];
            $pdfDataArray["device"] = $product->name;
            $pdfDataArray["email"] = $order['person']['email'];
            $pdfDataArray["name"] = $order['person']['name'];
            $pdfDataArray["phone"] = $order['person']['phone'];
            $pdfDataArray["address"] = $order['person']['address'];
            $payment_array["Voucher code"] = $order['person']['voucher'];
            $pdfDataArray["payment"] = $payment_array;
            $pdfDataArray["product"] = $pdf_product_array;
            $pdfDataArray["deviceProperites"] = $pdf_property_array;


            $pdf->loadView('pdf.createPdf', $pdfDataArray)->setPaper('a4')->setOrientation('portrait')->setWarnings(true)->save('pdf/' . $hashedID . '.pdf');
            //Create PDF - sean - end
            // send email
            $data = array(
                'email' => $order['person']['email'],
                'name' => $order['person']['name'],
                'order_id' => $dorder->id,
                'product' => $product->name,
                'model' => $model->name,
                'price' => $order['person']['myprice'],
                'payment_method' => $payment_methods[$order['person']['payment']],
                'device_status' => $device_status,
                'hashed_id' => $hashedID
            );

            \Mail::send('emails.orders.created', $data, function($message) use ($data) {
                $message->from(\Config::get('mail.from.address'), \Config::get('mail.from.name'));
                $message->to($data['email'], $data['name'])->subject('Sell Order #' . $data['order_id'] . ' confirmation');
                $message->attach("/home/gecko/public_html/postage_label.pdf");
                $message->attach("pdf/" . $data['hashed_id'] . ".pdf", array('as' => 'Packing Slip / Sell Order Details'));
            });

            return \Response::json(array('result' => 'success', 'orderid' => $hashedID));
        }
        else
        {
            $err = implode(". ", $errors);
            return \Response::json(array('result' => 'error', 'messages' => $err));
        }
    }

}
