<?php

namespace App\Http\Controllers;

use ExponentPhpSDK\Expo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TestController extends Controller
{
    public function index(){
		try {
			$expo = Expo::normalSetup();

			// $expo->subscribe('', 'ExponentPushToken[zoAiFCI0QR96u6bw91n4NL]');

			$expo->notify('', ['to' => 'ExponentPushToken[zoAiFCI0QR96u6bw91n4NL]', 'title' => 'Hola desdel backend', 'body' => 'quepdo']);

			echo 'success';
		} catch (\Throwable $th) {
			Log::error($th->getMessage());

			echo 'failed';
		}
	}
}
