<?php

namespace Thebikramlama\Hbl\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HblController extends Controller
{
	private $error_types = [
		'missing-merchant' => 'Looks like, you are missing "Merchant ID".',
		'missing-secret' => 'Looks like, you are missing the "Secret Key".'
	];

    public function index() {
    	$data = $_GET;
    	$data['methodUrl'] = config('hbl.methodUrl');
    	$data['redirectWait'] = config('hbl.redirectWait');

    	return view('hbl::payment')->with($data);
    }

    public function error( Request $request ) {
    	$message = 'Something went wrong.';
    	if ( !is_null($request->type) && array_key_exists($request->type, $this->error_types) ) {
    		$message = $this->error_types[$request->type];
    	}

    	return view('hbl::error', compact('message'));
    }
}
