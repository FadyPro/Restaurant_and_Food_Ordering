<?php

namespace App\Livewire\Home\DashBoard\Sections;

use App\Models\Chat;
use App\Events\ChatEvent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.home.master')]
class MessageSection extends Component
{
    public $receiver_id = 1, $message,$msg_temp_id;


    public function render()
    {
        $userId = auth()->user()->id;

        $senderId = 1;
        $receiverId = auth()->user()->id;
        Chat::where('sender_id', $senderId)->where('receiver_id', $receiverId)->where('seen', 0)->update(['seen' => 1]);
        $messages = Chat::whereIn('sender_id', [$senderId, $receiverId])
            ->whereIn('receiver_id', [$senderId, $receiverId])
            ->with(['sender'])
            ->orderBy('created_at', 'asc')
            ->get();
        return view('livewire.home.dash-board.sections.message-section', compact('userId', 'messages'));
    }
    public function logout()
    {
        Auth::guard('web')->logout();
        Session::invalidate();
        Session::regenerateToken();
        return redirect('/');
    }
    public function sendMessage() {
        $this->validate([
            'message' => ['required', 'max:1000'],
            'receiver_id' => ['required', 'integer']
        ]);

        $chat = new Chat();
        $chat->sender_id = auth()->user()->id;
        $chat->receiver_id = $this->receiver_id;
        $chat->message = $this->message;
        $chat->save();

        $avatar = asset(auth()->user()->avatar);
        $senderId = auth()->user()->id;
        broadcast(new ChatEvent($this->message, $avatar, $this->receiver_id, $senderId))->toOthers();
        $this->dispatch('scroll-bottom');
        $this->reset('message');
        return response(['status' => 'success', 'msgId' => $this->msg_temp_id]);
    }

    public function getConversation() {
        $senderId = 1;
        $receiverId = auth()->user()->id;
        Chat::where('sender_id', $senderId)->where('receiver_id', $receiverId)->where('seen', 0)->update(['seen' => 1]);

        $messages = Chat::whereIn('sender_id', [$senderId, $receiverId])
            ->whereIn('receiver_id', [$senderId, $receiverId])
            ->with(['sender'])
            ->orderBy('created_at', 'asc')
            ->get();
        return response($messages);
    }
}
