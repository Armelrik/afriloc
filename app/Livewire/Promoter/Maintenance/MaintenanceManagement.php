<?php

namespace App\Livewire\Promoter\Maintenance;

use App\Models\MaintenanceRequest;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class MaintenanceManagement extends Component
{
    use WithPagination;

    public $statusFilter = 'all';
    public $priorityFilter = 'all';
    public $showRespondModal = false;
    public $showCompleteModal = false;
    public $selectedRequest = null;
    public $response = '';
    public $resolutionNotes = '';

    protected $respondRules = [
        'response' => 'required|string|min:10',
    ];

    protected $completeRules = [
        'resolutionNotes' => 'required|string|min:10',
    ];

    public function render()
    {
        $promoter = Auth::user()->promoter;

        $query = MaintenanceRequest::whereHas('property', function ($q) use ($promoter) {
            $q->where('promoter_id', $promoter->id);
        })
        ->with(['property', 'user', 'booking'])
        ->orderByRaw("CASE 
            WHEN priority = 'urgent' THEN 1
            WHEN priority = 'high' THEN 2
            WHEN priority = 'normal' THEN 3
            WHEN priority = 'low' THEN 4
        END")
        ->orderBy('created_at', 'desc');

        if ($this->statusFilter !== 'all') {
            $query->where('status', $this->statusFilter);
        }

        if ($this->priorityFilter !== 'all') {
            $query->where('priority', $this->priorityFilter);
        }

        $maintenanceRequests = $query->paginate(15);

        // Count urgent requests
        $urgentCount = MaintenanceRequest::whereHas('property', function ($q) use ($promoter) {
            $q->where('promoter_id', $promoter->id);
        })
        ->where('priority', 'urgent')
        ->whereIn('status', ['pending', 'in_progress'])
        ->count();

        return view('livewire.promoter.maintenance.maintenance-management', [
            'maintenanceRequests' => $maintenanceRequests,
            'urgentCount' => $urgentCount,
        ])->layout('layouts.app');
    }

    public function markInProgress($requestId)
    {
        $promoter = Auth::user()->promoter;
        
        $request = MaintenanceRequest::whereHas('property', function ($q) use ($promoter) {
            $q->where('promoter_id', $promoter->id);
        })->findOrFail($requestId);

        if ($request->status === 'pending') {
            $request->update([
                'status' => 'in_progress',
                'responded_by' => Auth::id(),
                'responded_at' => now(),
            ]);
            
            session()->flash('success', __('messages.promoter.maintenance_in_progress'));
        }
    }

    public function openRespondModal($requestId)
    {
        $promoter = Auth::user()->promoter;
        
        $this->selectedRequest = MaintenanceRequest::whereHas('property', function ($q) use ($promoter) {
            $q->where('promoter_id', $promoter->id);
        })->findOrFail($requestId);
        
        $this->showRespondModal = true;
        $this->response = $this->selectedRequest->response ?? '';
    }

    public function closeRespondModal()
    {
        $this->showRespondModal = false;
        $this->selectedRequest = null;
        $this->response = '';
    }

    public function addResponse()
    {
        $this->validate($this->respondRules);

        if ($this->selectedRequest) {
            $this->selectedRequest->update([
                'response' => $this->response,
                'responded_by' => Auth::id(),
                'responded_at' => now(),
            ]);
            
            // TODO: Send notification to client
            
            session()->flash('success', __('messages.promoter.response_added'));
        }

        $this->closeRespondModal();
    }

    public function openCompleteModal($requestId)
    {
        $promoter = Auth::user()->promoter;
        
        $this->selectedRequest = MaintenanceRequest::whereHas('property', function ($q) use ($promoter) {
            $q->where('promoter_id', $promoter->id);
        })->findOrFail($requestId);
        
        $this->showCompleteModal = true;
        $this->resolutionNotes = '';
    }

    public function closeCompleteModal()
    {
        $this->showCompleteModal = false;
        $this->selectedRequest = null;
        $this->resolutionNotes = '';
    }

    public function markCompleted()
    {
        $this->validate($this->completeRules);

        if ($this->selectedRequest) {
            $this->selectedRequest->update([
                'status' => 'completed',
                'response' => $this->resolutionNotes,
                'responded_by' => Auth::id(),
                'responded_at' => now(),
                'completed_at' => now(),
            ]);
            
            // TODO: Send notification to client
            
            session()->flash('success', __('messages.promoter.maintenance_completed'));
        }

        $this->closeCompleteModal();
    }
}


