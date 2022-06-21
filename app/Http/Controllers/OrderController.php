<?php

namespace App\Http\Controllers;

use App\Models\DetailOrder;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    //

    public function orderQty()
    {
        $data = Order::with('detailOrder')->get();

        return response()->json(['code' => 201, 'status' => true, 'messages' => 'Berhasil Mendapatkan Data', 'data' => $data]);
    }
    public function AddorderQty(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'model'     => 'required',
            'quantity'  => 'required|numeric',
            'invoice'   => 'required',
            'harga'     => 'required|numeric'
        ]);
        if ($validator->fails()) {
            # code...
            return response()->json(['code' => 400, 'status' => false, 'messages' => $validator->errors()]);
        }

        DB::beginTransaction();

        try {
            $data = Order::where('model', strtoupper($request->model))->first();

            // dd($data);
            if ($data == NULL) {
                $order = Order::create([
                    'model'         => strtoupper($request->model),
                    'ordered_qty'   => $request->quantity,
                    'average_price' => ($request->harga / 100) * count($request->harga),
                ]);

                DetailOrder::create([
                    'order_id'  => $order->id,
                    'qty'       => $request->quantity,
                    'invoice'   => $request->invoice,
                    'price'     => $request->harga,
                ]);

                DB::commit();

                return response()->json(['code' => 201, 'status' => true, 'messages' => 'Berhasil Menambahkan Data']);
            } else {
                $order = Order::where('model', strtoupper($request->model))->update([
                    'ordered_qty'   => ($data->ordered_qty + $request->quantity),
                    'average_price' => ($request->harga / 100) * 1,
                ]);

                DetailOrder::create([
                    'order_id'  => $data->id,
                    'qty'       => $request->quantity,
                    'invoice'   => $request->invoice,
                    'price'     => $request->harga,
                ]);
                DB::commit();
                return response()->json(['code' => 201, 'status' => true, 'messages' => 'Berhasil Menambahkan Data']);
            }
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return response()->json(['code' => 400, 'status' => false, 'messages' => $th]);
        }
    }

    public function AddCurrentQty(Request $request)
    {
        // 
        // dd($request->all());

        $order = Order::where('model', strtoupper($request->model))->first();
        if ($order->ordered_qty == 0) {
            # code...
            DB::beginTransaction();

            try {
                $order->update([
                    'ordered_qty'   => ($order->ordered_qty - $request->current_qty),
                    'current_qty'   => $order->current_qty + $request->current_qty,
                ]);

                $detail = DetailOrder::where('order_id', $order->id)->get();

                $index = $request->current_qty;
                // dd($index);
                foreach ($detail as $item) {
                    // 
                    $detailData = DetailOrder::where('id', $item->id)->first();

                    // dd($index);
                    // dd($detailData->qty);
                    if ($index >= $detailData->qty) {
                        $detailData->delete();
                        $index = ($index - $detailData->qty);
                        // dd($index);
                        // dd($index . 'xx');

                        if ($index == 0) {
                            # code...
                            DB::commit();
                            return response()->json(['code' => 201, 'status' => true, 'messages' => 'Berhasil Mengubah Data']);
                        }
                    } else {

                        // dd($detailData->id . $detailData->qty - $index);
                        $detailData->update(['qty' => ($detailData->qty - $index)]);
                        $index = ($index - $detailData->qty);
                        // dd($index . "------" . $detailData->qty);
                        if ($index == 0) {
                            # code...
                            DB::commit();
                            return response()->json(['code' => 201, 'status' => true, 'messages' => 'Berhasil Mengubah Data']);
                        }
                    }
                }

                DB::commit();

                return response()->json(['code' => 201, 'status' => true, 'messages' => 'Berhasil Mengubah Data']);
            } catch (\Throwable $th) {
                //throw $th;
                // dd($th);
                DB::rollBack();
                return response()->json(['code' => 400, 'status' => false, 'messages' => $th]);
            }
        } else {
            $order->update([
                'current_qty'   => $order->current_qty + $request->current_qty,
            ]);

            return response()->json(['code' => 201, 'status' => true, 'messages' => 'Berhasil Mengubah Data']);
        }
    }
    // dd($order);
}
