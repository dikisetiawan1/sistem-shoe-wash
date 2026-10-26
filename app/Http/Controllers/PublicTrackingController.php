<?php

namespace App\Http\Controllers;
use App\Models\Orders;
use Illuminate\Http\Request;


class PublicTrackingController extends Controller
{
    public function show($id)
    {
        // Ambil data order berdasarkan ID, pastikan relasi items dan details ikut dimuat
        $order = Orders::with(['customers', 'items.category', 'items.service'])
            ->findOrFail($id);

        return view('tracking.public-show', compact('order'));
    }
}
