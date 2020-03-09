<?php

namespace Thebikramlama\Hbl\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HblController extends Controller
{
	private $error_types = [
		'missing-merchant' => 'Looks like, you are missing "Merchant ID".',
		'missing-secret' => 'Looks like, you are missing the "Secret Key".',
        'missing-data' => 'Looks like, required data are missing.'
	];

    public function index() {
    	$data = $this->validateData($_GET);
    	$data['methodUrl'] = config('hbl.methodUrl');
        $data['clickContinue'] = config('hbl.clickContinue');
    	$data['redirectWait'] = (int) config('hbl.redirectWait');

    	return view('hbl::payment')->with($data);
    }

    public function error( Request $request ) {
    	$message = 'Something went wrong.';
    	if ( !is_null($request->type) && array_key_exists($request->type, $this->error_types) ) {
    		$message = $this->error_types[$request->type];
    	}

    	return view('hbl::error', compact('message'));
    }

    private function validateData( $data ) {
        $request = json_decode(json_encode($data));

        foreach ([ "amount", "invoiceNo", "productDesc", "currencyCode", "nonSecure", "paymentGatewayID", "hashValue" ] as $field) {
            if ( !isset( $request->{$field} ) ) return redirect()->route('hbl.error', 'missing-data')->send();

            if( $request->{$field} == null || $request->{$field} == '' ) {
                return redirect()->route('hbl.error', 'missing-data')->send();
            }
        }

        return $data;
    } 
}
