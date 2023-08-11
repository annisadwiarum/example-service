<?php

namespace App\Http\Controllers;

use App\Models\Presence;
use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\Request;

class PresenceController extends Controller
{
    public ?Attendance $attendance = null;
    public $holiday;
    public $data;

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['']]);
    }

    public function send_presence(Request $request)
    {
        $user = auth()->user();
        $thisUser = User::with('position.attendance')->find($user->id);

        dd($thisUser->position);

        // Cari data attendance yang sedang aktif
        $this->attendance = Attendance::where('start_time', '<=', now())
            ->where('end_time', '>=', now())
            ->first();

        if (!$this->attendance) {
            return response()->json(['message' => 'Tidak ada absensi aktif saat ini.']);
        }

        // Cek apakah user sudah mengirim kehadiran
        $existingPresence = Presence::where([
            'user_id' => $user->id,
            'attendance_id' => $this->attendance->id,
            'presence_date' => now()->toDateString(),
        ])->first();

        if ($existingPresence) {
            return response()->json(['message' => 'Anda telah mengirim kehadiran pada absensi ini.']);
        }

        // Simpan kehadiran user
        Presence::create([
            'user_id' => $user->id,
            'attendance_id' => $this->attendance->id,
            'presence_date' => now()->toDateString(),
            'presence_enter_time' => now()->toTimeString(),
            'presence_out_time' => null,
        ]);

        return response()->json(['message' => 'Kehadiran Anda berhasil dikirim.']);
    }
}
