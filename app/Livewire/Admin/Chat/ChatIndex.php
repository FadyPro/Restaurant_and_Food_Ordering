<?php

namespace App\Livewire\Admin\Chat;

use App\Events\ChatEvent;
use App\Models\Chat;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

#[Layout('layouts.admin.master')]
class ChatIndex extends Component
{
    public $message,$receiver_id,$msg_temp_id,$senderId;
    public $user_name;
    public $messages = [];

    public function render()
    {
        $userId = auth()->user()->id;

        $senders = Chat::select('sender_id')
            ->with('sender')
            ->where('receiver_id', $userId)
            ->where('sender_id', '!=', $userId)
            ->selectRaw('MAX(created_at) as latest_message_sent')
            ->groupBy('sender_id')
            ->orderByDesc('latest_message_sent')
            ->get();

        return view('livewire.admin.chat.chat-index', compact('senders', 'userId'));
    }
    public function getConversation($senderId) {
        $receiverId = auth()->user()->id;

        $this->user_name = User::where('id', $senderId)->first();

        $this->receiver_id = $senderId;

        Chat::where('sender_id', $senderId)->where('receiver_id', $receiverId)->where('seen', 0)->update(['seen' => 1]);

        $this->messages = Chat::whereIn('sender_id', [$senderId, $receiverId])
            ->whereIn('receiver_id', [$senderId, $receiverId])
            ->with(['sender'])
            ->orderBy('created_at', 'desc')
            ->get();
        $this->dispatch('scroll-bottom');
    }

    public function sendMessage() {

        $this->validate([
            'message' => ['required', 'max:1000'],
            'receiver_id' => ['required', 'integer']
        ],[
            'message.required' => 'The message field is required.',
            'receiver_id.required' => 'The receiver is required.'
        ]);

        $chat = new Chat();
        $chat->sender_id = auth()->user()->id;
        $chat->receiver_id = $this->receiver_id;
        $chat->message = $this->message;
        $chat->save();

        $avatar = asset(auth()->user()->avatar);
        $senderId = auth()->user()->id;
//        broadcast(new ChatEvent($this->message, $avatar, $this->receiver_id, $senderId))->toOthers();
        $this->reset('message');
        $this->getConversation($this->receiver_id);
        $this->dispatch('scroll-bottom');
    }
}
