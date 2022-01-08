<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Symfony\Component\Routing\Route;

use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\DidriveController;

// echo '<pre>'; print_r( $_POST ); echo '</pre>';

class DidrivePageController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function savePage(Request $request, $module)
    {

        $in = [
            'res' => false
        ];

        if (empty(DidriveController::$modules[$module])) {

            $in['error'] = 'no find mod #' . __LINE__;

            // throw new \Exception("no find mod", 1);
        } else {

            $in['nowMod'] =
            $nowMod = DidriveController::$modules[$module];

            // dd(DidriveController::$modules[$module] , $request->data_new );

            $dataFileLink = $_SERVER['DOCUMENT_ROOT'] . '/' . $nowMod['path'] . $nowMod['file'];
            if (file_exists($dataFileLink)) {

                $in['in_data'] =  $request->data_new ;
                $in['res2'] = file_put_contents($dataFileLink, $request->data_new );
                $in['res'] = true;
                // dd('file e', $dataFileLink, $request->data_new);

            }
            // else {
            //     // dd('file n', $dataFileLink, $request->data_new);
            // }
        }

        return response()->json($in);
    }
}
