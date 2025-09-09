<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Payment::where('student_id', auth()->id())->get();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'payment_id' => [
                'required',
                'integer',
                'exists:payments,id,student_id,' . auth()->id()
            ]
        ]);

        $payment = Payment::where('id', $request->payment_id)
            ->where('student_id', auth()->id())
            ->firstOrFail();

        $payment->update([
            'status' => 'paid',
            'paid_at' => now()
        ]);

        return response()->json([
            'message' => 'Payment successful',
            'data' => $payment
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
