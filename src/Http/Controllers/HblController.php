<?php

namespace Thebikramlama\Hbl\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HblController extends Controller
{
	private $error_types = [
		'missing-merchant' => 'Looks like, you are missing "Merchant ID".',
		'missing-secret' => 'Looks like, you are missing the "Secret Key".',
		'missing-data' => 'Looks like, required data are missing.',
		'invalid-data' => 'Payment information does not exist.'
	];

	public function index( Request $request ) {
		$data = $this->validateData($request);
		$data['methodUrl'] = config('hbl.methodUrl');
		$data['clickContinue'] = config('hbl.clickContinue');
		$data['redirectWait'] = (int) config('hbl.redirectWait');

		return view('hbl::payment')->with($data);
	}

	public function error( Request $request ) {
		$message = 'Unknown error occurred!';
		if ( !is_null($request->type) && array_key_exists($request->type, $this->error_types) ) {
			$message = $this->error_types[$request->type];
		}

		return view('hbl::error', compact('message'));
	}

	private function validateData( $request ) {

		if ( $request->payment_id == null || $request->payment_id == '' ) return redirect()->route('hbl.error', 'missing-data')->send();
		if ( cache()->get( $request->payment_id ) == null ) return redirect()->route('hbl.error', 'invalid-data')->send();

		$data = cache()->get( $request->payment_id );
		cache()->forget( $request->payment_id );

		return $data;
	}
}
