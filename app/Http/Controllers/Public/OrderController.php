<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Order, Country, City, State};
use App\Http\Requests\OrderRequestFront;
use Stripe;
class OrderController extends Controller
{
    public function index(Request $request){
        $order = $request->user()->orders()->with('sstate','scountry')->orderby('id','desc')->paginate($_GET['perPage']);
        // $order = Order::with('sstate','scountry')->where('user_id', auth('api')->user()->id);
        // $order = $order->orderby('id','desc')->paginate($_GET['perPage']);
        return response()->json(['data'=>$order]);
    }
    public function get(Order $order){
        $order->load('products','products.product');
        return response()->json(['data'=>$order]);
    }
    public function store(OrderRequestFront $request){
        $error = ['errors'=>[]];
        try {
            $stripe = new \Stripe\StripeClient(
                env('STRIPE_SK')
            );
            $method = $stripe->paymentMethods->create([
                'type' => 'card',
                'card' => [
                    'number' => $request->card['number'],
                    'exp_month' => $request->card['month'],
                    'exp_year' => $request->card['year'],
                    'cvc' => $request->card['cvv'],
                ],
                'billing_details'=>[
                    'email'=>$request->billing_email,
                    'name'=>$request->billing_first_name.' '.$request->billing_last_name,
                    'address'=>[
                        'country'=>Country::find($request->billing_country)->iso_code,
                        'city'=>$request->billing_city,
                        'state'=>State::find($request->billing_state)->name,
                        'postal_code'=>$request->billing_zipcode,
                        'line1'=>$request->billing_address,
                    ]
                ]
            ]);
            if($method->id){
                $total = 0;
                foreach($request->items as $key=>$value){
                    $qty = intval($value['quantity']);
                    $price = floatval($value['product']['actual_price']);
                    $total+=($price*$qty);
                }
                $intent = $stripe->paymentIntents->create([
                    'amount' => ($total*100),
                    'currency' => 'usd',
                    // 'confirmation_method' => 'manual',
                    'payment_method_types' => ['card'],
                    'capture_method' => 'manual',
                    'payment_method' => $method->id,
                    'confirm' => true,
                ]);
                if($intent->id){
                    // $capture = $stripe->paymentIntents->capture(
                    //     $intent->id,
                    //     []
                    // );
                    $arr = $request->only(
                    'shipping_email',
                    'shipping_notes',
                    'shipping_first_name',
                    'shipping_last_name',
                    'shipping_address',
                    'shipping_city',
                    'shipping_country',
                    'shipping_company',
                    'shipping_state',
                    'shipping_zip',
                    'shipping_phone',

                    'billing_email',
                    'billing_first_name',
                    'billing_last_name',
                    'billing_address',
                    'billing_city',
                    'billing_country',
                    'billing_company',
                    'billing_state',
                    'billing_zipcode',
                    'billing_phone',
                    'discount_amount',
                    'tax_amount',
                    'tax_percent',
                    );
                    $arr['stripe_charge_id'] = $intent->id;
                    $order = Order::create($arr);
                    $total = 0;
                    foreach($request->items as $key=>$value){
                        $qty = intval($value['quantity']);
                        $price = floatval($value['product']['actual_price']);
                        $order->products()->create([
                            'product_id'=>$value['product']['id'],
                            'quantity'=>$value['quantity'],
                            'rowtotal'=>($price*$qty)
                        ]);
                        $total+=($price*$qty);
                    }
                    $order->subtotal = $total;
                    $total = ($total+$order->tax_amount);
                    $order->total = ($total-$order->discount_amount);
                    $order->save();
                    return response()->json(['data'=>$order]);
                }else{
                    $error['errors']['card.number'] = ['Unable to Authoize Payment'];
                }
            }else{
                $error['errors']['card.number'] = ['Card Details invalid'];
            }
        }catch(\Stripe\Exception\CardException $e) {
            $error['errors']['card.number'] = [$e->getError()->message];
        }catch (\Stripe\Exception\RateLimitException $e) {
            // Too many requests made to the API too quickly
            $error['errors']['card.number'] = [$e->getError()->message];
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            // Invalid parameters were supplied to Stripe's API
            $error['errors']['card.number'] = [$e->getError()->message];
        } catch (\Stripe\Exception\AuthenticationException $e) {
            // Authentication with Stripe's API failed
            // (maybe you changed API keys recently)
            $error['errors']['card.number'] = [$e->getError()->message];
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            // Network communication with Stripe failed
            $error['errors']['card.number'] = [$e->getError()->message];
        } catch (\Stripe\Exception\ApiErrorException $e) {
            // Display a very generic error to the user, and maybe send
            // yourself an email
            $error['errors']['card.number'] = [$e->getError()->message];
        } catch (\Exception $e) {
            // Something else happened, completely unrelated to Stripe
            $error['errors']['card.number'] = ['Something Happened'];
        }
        return response()->json($error,422);
    }
}
