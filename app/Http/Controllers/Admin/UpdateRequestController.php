<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UpdateRequest;
use Illuminate\Http\Request;

class UpdateRequestController extends Controller
{
    public function index()
    {
        $requests = UpdateRequest::where('status', 'pending')
                    ->with(['user', 'product'])
                    ->orderBy('created_at', 'desc')
                    ->paginate(20);

        return view('admin.update_requests.index', compact('requests'));
    }

    public function complete(UpdateRequest $updateRequest)
    {
        $updateRequest->update(['status' => 'completed']);
        // Here you could send email notification
        return back()->with('success', 'Solicitud marcada como completada.');
    }

    public function destroy(UpdateRequest $updateRequest)
    {
        $updateRequest->delete(); // Soft delete or force? Product has Cascade, but Request doesn't utilize SoftDeletes yet.
        return back()->with('success', 'Solicitud eliminada.');
    }
}
