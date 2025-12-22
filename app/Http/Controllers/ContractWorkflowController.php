<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContractWorkflowController extends Controller
{
    public function show($id)
    {
        $contract = Contract::with(['job', 'clientProfile.user', 'freelancerProfile.user'])->findOrFail($id);
        $user = Auth::user();

        // Security Check: Ensure only the involved parties can view this
        $isClient = $user->role === 'client' && $contract->client_profile_id == $user->clientProfile->id;
        $isFreelancer = $user->role === 'freelancer' && $contract->freelancer_profile_id == $user->freelancerProfile->id;

        if (!$isClient && !$isFreelancer) {
            abort(403, 'Unauthorized access to this contract.');
        }

        return view('contracts.show', compact('contract'));
    }

    public function submitWork(Request $request, $contractId)
    {
        $contract = Contract::with('job')->findOrFail($contractId);

        // Security: Only the freelancer of this contract can submit
        if (Auth::user()->freelancerProfile->id !== $contract->freelancer_profile_id) {
            abort(403);
        }

        $contract->job->update(['status' => 'waiting_for_review']);

        return back()->with('status', __('common.work_submitted_success'));
    }

    // 2. Client Approves Work
    public function approveWork(Request $request, $contractId)
    {
        $contract = Contract::with('job')->findOrFail($contractId);

        // Security: Only client
        if (Auth::user()->clientProfile->id !== $contract->client_profile_id) {
            abort(403);
        }

        // Status moves to Waiting for Payment
        $contract->job->update(['status' => 'waiting_for_payment']);

        return back()->with('status', __('common.work_approved_success'));
    }

    // 3. Client Requests Revision
    public function rejectWork(Request $request, $contractId)
    {
        $contract = Contract::with('job')->findOrFail($contractId);

        if (Auth::user()->clientProfile->id !== $contract->client_profile_id) {
            abort(403);
        }

        // Status goes back to In Progress
        $contract->job->update(['status' => 'in_progress']);

        return back()->with('status', __('common.revision_requested'));
    }

    // 4. Client Marks Payment Sent
    public function markPaid(Request $request, $contractId)
    {
        $contract = Contract::with('job')->findOrFail($contractId);

        if (Auth::user()->clientProfile->id !== $contract->client_profile_id) {
            abort(403);
        }

        $contract->job->update(['status' => 'payment_verification']);

        return back()->with('status', __('common.payment_marked_sent'));
    }

    // 5. Freelancer Confirms Payment (FINISH)
    public function confirmPayment(Request $request, $contractId)
    {
        $contract = Contract::with('job')->findOrFail($contractId);

        if (Auth::user()->freelancerProfile->id !== $contract->freelancer_profile_id) {
            abort(403);
        }

        // Update Job AND Contract to completed
        $contract->job->update(['status' => 'completed']);
        $contract->update(['status' => 'completed']);

        return back()->with('status', __('common.payment_confirmed_success'));
    }
}
