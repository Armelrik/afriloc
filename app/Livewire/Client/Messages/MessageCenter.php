<?php

namespace App\Livewire\Client\Messages;

use App\Models\Message;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class MessageCenter extends Component
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
                $query->where('sender_id', auth()->id())
                      ->where('receiver_id', $this->selectedConversation);
            })
            ->orWhere(function ($query) {
                $query->where('sender_id', $this->selectedConversation)
                      ->where('receiver_id', auth()->id());
            })
            ->orderBy('created_at', 'asc')
            ->get();

            // Mark messages as read
            Message::where('receiver_id', auth()->id())
                ->where('sender_id', $this->selectedConversation)
                ->where('is_read', false)
                ->update(['is_read' => true]);
        }

        return view('livewire.client.messages.message-center', [
            'messages' => $messages,
        ])->layout('layouts.app');
    }

    public function loadConversations()
    {
        $sentMessages = Message::where('sender_id', auth()->id())
            ->select('receiver_id as user_id')
            ->distinct()
            ->get();

        $receivedMessages = Message::where('receiver_id', auth()->id())
            ->select('sender_id as user_id')
            ->distinct()
            ->get();

        $userIds = $sentMessages->merge($receivedMessages)->pluck('user_id')->unique();

        $this->conversations = User::whereIn('id', $userIds)
            ->with(['roles'])
            ->get()
            ->map(function ($user) {
                $unreadCount = Message::where('sender_id', $user->id)
                    ->where('receiver_id', auth()->id())
                    ->where('is_read', false)
                    ->count();

                return [
                    'user' => $user,
                    'unread_count' => $unreadCount,
                ];
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
            'sender_id' => auth()->id(),
            'receiver_id' => $this->selectedConversation,
            'message' => $this->messageContent,
            'is_read' => false,
        ]);

        $this->messageContent = '';
        $this->loadConversations();
    }
}

