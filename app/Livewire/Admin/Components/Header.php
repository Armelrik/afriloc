<?php

namespace App\Livewire\Admin\Components;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Header extends Component
{
    public function render()
    {
        $user = Auth::user();
        
        // Récupérer les notifications non lues
        $unreadNotifications = $user ? Notification::where('utilisateur_id', $user->id)
            ->nonLues()
            ->latest('date_envoi')
            ->take(10)
            ->get() : collect([]);
        
        $unreadCount = $user ? Notification::where('utilisateur_id', $user->id)
            ->nonLues()
            ->count() : 0;
        
        return view('livewire.admin.components.header', [
            'user' => $user,
            'notifications' => $unreadNotifications,
            'unreadCount' => $unreadCount,
        ]);
    }

    public function changeLanguage($lang)
    {
        session(['locale' => $lang]);
        return redirect()->back();
    }

    public function markAsRead($notificationId)
    {
        $notification = Notification::find($notificationId);
        if ($notification && $notification->utilisateur_id === Auth::id()) {
            $notification->marquerCommeLue();
            $this->dispatch('notification-read');
        }
    }

    public function markAllAsRead()
    {
        Notification::where('utilisateur_id', Auth::id())
            ->nonLues()
            ->update([
                'est_lue' => true,
                'date_lecture' => now(),
            ]);
        $this->dispatch('notifications-read');
    }
}


