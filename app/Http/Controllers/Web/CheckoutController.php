<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests\CheckoutRequest;

use Gloudemans\Shoppingcart\Facades\Cart;

use Cartalyst\Stripe\Laravel\Facades\Stripe;
use GuzzleHttp\Client;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('web.checkout');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CheckoutRequest $request)
    {

    	$contents = Cart::content()->map(function($item) {
    		return $item->model->slug.','.$item->qty;
    	})->values()->toJson();

        try {
            //Configuracion de Guzzle
            $client = new Client([
                'base_uri' => 'https://api.instapago.com',
                'timeout' => 2.0,
            ]);

            $response = $client->request('POST', 'payment', [
                'form_params' => [
                    "KeyID" => "92A35F09-2024-47A8-99B8-D57B5FB6AB8A",
                    "PublicKeyId" => "fc41e73e4dba988a7bb3ec5c492006f1",
                    //"IP" => "127.0.0.1",
                    "Amount" => Cart::total() / 100, //monto a devitar
                    "Description"  => "primera operacion", //String con la descripcion de la transaccion
                    "CardHolder"=> $request()->input('name_on_card'),    //Nombre del tarjeta habiente "Cualquiera"
                    "CardHolderId"=>"12345678", //CI del tarjeta habiente "Cualquiera"
                    "CardNumber" => "4111111111111111", //numero de tarjeta de credito "4111111111111111" 
                    "CVC" => "123", //codigo secreto
                    "ExpirationDate" => "10/2022", //fecha de expiracion
                    "StatusId" => "2",  //Estatus en el que se creara la transaccion
                    //"Address" => " ",  
                    //"City" => " ", 
                    //"ZipCode" => " ",  
                    //"State" => " ",
                ]
            ]); 

        	/*
        	$charge = Stripe::charges()->create([
        		'amount' => Cart::total() / 100,
        		'currency' => 'CAD',
        		'source' => $request->stripeToken,
        		'description' => 'Order',
        		'receipt_email' => $request->email,
        		'metadata' => [
        			//Change to Order ID after we start using DB
        			// 'contents' => $contents,
        			// 'quantity' => Cart::instance('default')->count(),
        		],
        	]);
			*/
        	//Successful
        	Cart::instance('default')->destroy();

        	return redirect()->route('confirmation.index')->with('success_message', 'Thank You! Your payment has been successfully accepted!');

        } catch (Exception $e) {
        	//Hay que atrapar la exection del proveedor del punto de venta virtual
        	//Estas incluyen rechazada, en proceso y otras mas
        	return back()->withErrors('Error!' .$e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
