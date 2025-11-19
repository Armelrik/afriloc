<?php

namespace App\Livewire\Promoter\Messages;

use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class MessageInbox extends Component
{
    use WithPagination;

    public $selectedConversation = null;
    public $messageContent = '';
    public $conversations = [];

    public function mount()
    {
        $this->loadConversations();
    }

    public function render()
    {
        $messages = collect();

        if ($this->selectedConversation) {
            $messages = Message::where(function ($query) {
                $query->where('sender_id', Auth::id())
                      ->where('receiver_id', $this->selectedConversation);
            })
            ->orWhere(function ($query) {
                $query->where('sender_id', $this->selectedConversation)
                      ->where('receiver_id', Auth::id());
            })
            ->orderBy('created_at', 'asc')
            ->get();

            // Mark messages as read
            Message::where('receiver_id', Auth::id())
                ->where('sender_id', $this->selectedConversation)
                ->where('is_read', false)
                ->update(['is_read' => true]);
        }

        return view('livewire.promoter.messages.message-inbox', [
            'messages' => $messages,
        ])->layout('layouts.app');
    }

    public function loadConversations()
    {
        // Get all clients who have bookings on promoter's properties
        $promoter = Auth::user()->promoter;
        
        // Get unique client IDs from bookings
        $clientIds = \App\Models\Booking::whereHas('property', function ($q) use ($promoter) {
            $q->where('promoter_id', $promoter->id);
        })
        ->distinct('user_id')
        ->pluck('user_id');

        // Also get users who have sent messages
        $sentMessages = Message::where('sender_id', Auth::id())
            ->select('receiver_id as user_id')
            ->distinct()
            ->get();

        $receivedMessages = Message::where('receiver_id', Auth::id())
            ->select('sender_id as user_id')
            ->distinct()
            ->get();

        $messageUserIds = $sentMessages->merge($receivedMessages)->pluck('user_id')->unique();

        // Combine both lists
        $allUserIds = $clientIds->merge($messageUserIds)->unique();

        $this->conversations = User::whereIn('id', $allUserIds)
            ->with(['roles'])
            ->get()
            ->map(function ($user) {
                $unreadCount = Message::where('sender_id', $user->id)
                    ->where('receiver_id', Auth::id())
                    ->where('is_read', false)
                    ->count();

                $lastMessage = Message::where(function ($query) use ($user) {
                    $query->where('sender_id', Auth::id())
                          ->where('receiver_id', $user->id);
                })
                ->orWhere(function ($query) use ($user) {
                    $query->where('sender_id', $user->id)
                          ->where('receiver_id', Auth::id());
                })
                ->latest()
                ->first();

                return [
                    'user' => $user,
                    'unread_count' => $unreadCount,
                    'last_message' => $lastMessage,
                ];
            })
            ->sortByDesc(function ($conversation) {
                return $conversation['last_message'] ? $conversation['last_message']->created_at : null;
            });
    }

    public function selectConversation($userId)
    {
        $this->selectedConversation = $userId;
        $this->loadConversations();
    }

    public function sendMessage()
    {
        $this->validate([
            'messageContent' => 'required|string|max:1000',
            'selectedConversation' => 'required|exists:users,id',
        ]);

        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $this->selectedConversation,
            'message' => $this->messageContent,
            'is_read' => false,
        ]);

        $this->messageContent = '';
        $this->loadConversations();
    }
}


