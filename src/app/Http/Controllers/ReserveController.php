<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Reserve;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ReserveController extends Controller
{

    public function reserve(Request $request)
    {

        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $this->validate($request, [
            'date' => 'required|date',
            'time' => 'required',
            'number_of_people' => 'required|integer',
        ], [
            'date.required' => '日付を入力してください。',
            'date.date' => '日付の形式が無効です。',
            'time.required' => '時間を入力してください。',
            'number_of_people.required' => '人数を入力してください。',
            'number_of_people.integer' => '人数は整数で入力してください。',
        ]);

        $is_reserved = Reserve::where([
            ['user_id', Auth::id()],
            ['date', $request->input('date')],
            ['time', $request->input('time')],
        ])->exists();

        if ($is_reserved) {
            return back()->withErrors(['time' => '同時刻に予約済みです。'])->withInput();
        }

        $reserve = new Reserve();
        $reserve->user_id = Auth::id();
        $reserve->shop_id = $request->input('shop_id');
        $reserve->date = $request->input('date');
        $reserve->time = $request->input('time');
        $reserve->number_of_people = $request->input('number_of_people');

        if ($request->filled('cource')) {
            $reserve->cource = $request->input('cource');
            return view('payment.payment', compact('reserve'));
        } else {


            $qrCode = QrCode::size(150)->generate(route('owner-reserve', ['id' => $reserve->shop_id]));
            $tempPath = tempnam(sys_get_temp_dir(), 'qr_');
            file_put_contents($tempPath, $qrCode);
            $path = Storage::disk('s3')->putFile('qr_codes', new File($tempPath));
            $reserve->qr = Storage::disk('s3')->url($path);
            $reserve->save();
            unlink($tempPath);
            $reserve->save();
            return view('reserve.done', compact('reserve'));
        }
    }

    public function delete(Request $request)
    {
        $reserve_id = $request->input('id');

        $reserve = Reserve::where('id', $reserve_id)->first();

        if ($reserve) {
            $reserve->delete();
        }

        return redirect()->route('mypage');
    }


    public function edit(Request $request)
    {
        $reserve = $request->input('id');
        $reservation = Reserve::where('id', $reserve)->first();
        return view('reserve.reserve_edit', compact('reservation'));
    }


    public function update(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $this->validate($request, [
            'date' => 'required|date',
            'time' => 'required',
            'number_of_people' => 'required|integer',
        ]);

        $reservation = Reserve::find($request->input('id'));

        if ($request->input('number_of_people') != $reservation->number_of_people) {
            $reservation->number_of_people = $request->input('number_of_people');
            $reservation->save();
            return view('reserve.edit_done');
        } elseif ($request->input('date') != $reservation->date || $request->input('time') != $reservation->time) {
            $is_reserved = Reserve::where([
                ['user_id', Auth::id()],
                ['date', $request->input('date')],
                ['time', $request->input('time')],
            ])->exists();

            if ($is_reserved) {
                return back()->withErrors(['time' => '同時刻に予約済みです。'])->withInput();
            }
        }

        $reservation->date = $request->input('date');
        $reservation->time = $request->input('time');
        $reservation->save();

        return view('reserve.edit_done');
    }
}
