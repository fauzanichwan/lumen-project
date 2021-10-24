<?php

namespace App\Http\Controllers;

use Validator;
use App\Transaction;

use App\Http\Helpers\Role;
use App\Http\Helpers\TimeStamp;
use App\Http\Helpers\Mailer;

use DateTime;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;

class TransactionController extends Controller {

    private $request;
    private $date;

    public function __construct(Request $request) {
        $this->request = $request;
        
        $date = new DateTime;
        $this->date = $date->getTimestamp(); 
    }

    public function insert() {
        
        $validator = Validator::make($this->request->all(), [
            'code' => 'required',
            'amount' => 'required|numeric'
        ]);
      
        if ($validator->fails()) {
            return response()->json([
                'data' => false,
                'message' => $validator->errors()->first()
            ], Response::HTTP_BAD_REQUEST);
        }

        try {
            $insert = Transaction::create([
                'code' => $this->request->code,
                'amount' => $this->request->amount,
                'created_by' => 'system',
                'created_at' => $this->date,
                'updated_by' => 'system',
                'updated_at' => $this->date
            ]);

            if ($insert) {
                return response()->json([
                    'data' => true,
                    'message' => 'Success to insert data'
                ], Response::HTTP_OK);
            }

            return response()->json([
                'data' => false,
                'message' => 'Failed to insert data'
            ], Response::HTTP_BAD_REQUEST);
        } catch (Exception $e) {
            return response()->json([
                'data' => false,
                'msg' => $e->getMessage() 
            ], Response::HTT_BAD_REQUEST);
        }
    }

    public function getAll() {
        try {
            $datas = Transaction::all();

            if ($datas) {
                return response()->json([
                    'data' => $datas,
                    'message' => null
                ], Response::HTTP_OK);
            }
        } catch (Exception $e) {
            return response()->json([
                'data' => false,
                'msg' => $e->getMessage() 
            ], Response::HTT_BAD_REQUEST);
        }
    }

}