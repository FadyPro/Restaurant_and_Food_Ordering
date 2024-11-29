<div
    x-data="{height:0,chatBodyElement:document.getElementById('chatBody')}"
    x-init="() => {
        height = chatBodyElement.scrollHeight;
        $nextTick(() => {
            chatBodyElement.scrollTop =  height;
        })
    }"
    @scroll-bottom.window="
    $nextTick(() => {
        chatBodyElement.scrollTop =  height
    })"
>

<section class="section">
    <div class="section-header">
        <h1>Chat Box</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="#">Components</a></div>
            <div class="breadcrumb-item">Chat Box</div>
        </div>
    </div>

    <div class="section-body">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        Users
                    </div>
                    <div class="card-body chatbox p-0">
                        <ul class="list-group list-group-flush">
                            @foreach($senders as $sender)
                                @php
                                    $chatUser = \App\Models\User::find($sender->sender_id);
                                    $unseenMessages = \App\Models\Chat::where(['sender_id' => $chatUser->id, 'receiver_id' => auth()->user()->id, 'seen' => 0])->count();

                                @endphp
                                @php
                                    $not_seen =  \App\Models\Chat::where(['sender_id' => $chatUser->id, 'receiver_id' => auth()->user()->id, 'seen' => 1])->get() ?? null
                                @endphp
                                <a href="javascript:void(0)"  class="text-dark link">
                                    <li class="list-group-item" wire:click="getConversation({{$sender->sender_id}})" id="user_{{ $sender->id }}">
                                        @if($sender->sender->avatar)
                                            <img class="img-fluid avatar" src="{{ asset('/uploads/avatars/'.$sender->sender->avatar) }}">
                                        @else
                                            <img class="img-fluid avatar" src="https://cdn.pixabay.com/photo/2017/06/13/12/53/profile-2398782_1280.png">
                                        @endif
                                        @if($sender->is_online) <i class="fa fa-circle text-success online-icon"></i> @endif {{ $sender->sender->name }}
                                        @if(filled($unseenMessages))
                                            <div class="badge badge-primary rounded">{{ $unseenMessages }}</div>
                                        @endif
                                    </li>
                                </a>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        @if($user_name)
                            {{$user_name->name}}
                        @endif

                    </div>
                    <div class="card-body message-box">
                        @foreach($messages as $msg),
                        <div class="single-message @if($msg->sender_id !== auth()->id()) received @else sent @endif">
                            @if($msg->sender->avatar)
                                <img class="img-fluid avatar" src="{{ asset('/uploads/avatars/'.$msg->sender->avatar) }}">
                            @else
                                <img class="img-fluid avatar" src="https://cdn.pixabay.com/photo/2017/06/13/12/53/profile-2398782_1280.png">
                            @endif

                            <p class="font-weight-bolder my-0">{{ $msg->sender->name }}</p>
                            <p class="my-0">{{ $msg->message }}</p>
                            <small class="text-muted w-100">Sent</small>
                            {{--                                <small class="text-muted w-100">Sent <em>{{ $msg->created_at->format('Y-m-d h:i:s') }}</em></small>--}}
                        </div>
                        @endforeach
                    </div>
                    <div class="card-footer">
                        <form wire:submit.prevent="sendMessage" enctype="multipart/form-data">
                            <div wire:loading wire:target='sendMessage'>
                                Sending message . . .
                            </div>
                            <div class="row">
                                <div class="col-md-7">
                                    <input wire:model="message" class="form-control input shadow-none w-100 d-inline-block" placeholder="Type a message">
                                </div>

                                <div class="col-md-4">
                                    <button class="btn btn-primary d-inline-block w-100"><i class="far fa-paper-plane"></i> Send</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>


    <style>
        .avatar {
            height: 50px;
            width: 50px;
        }
        .list-group-item:hover, .list-group-item:focus {
            background: rgba(24,32,23,0.37);
            cursor: pointer;
        }
        .chatbox {
            height: 80vh !important;
            overflow-y: scroll;
        }
        .message-box {
            height: 70vh !important;
            overflow-y: scroll;display:flex; flex-direction:column-reverse;
        }
        .single-message {
            background: #f1f0f0;
            border-radius: 12px;
            padding: 10px;
            margin-bottom: 10px;
            width: fit-content;
        }
        .received {
            margin-right: auto !important;
        }
        .sent {
            margin-left: auto !important;
            background :#3490dc;
            color: white!important;
        }
        .sent small {
            color: white !important;
        }
        .link:hover {
            list-style: none !important;
            text-decoration: none;
        }
        .online-icon {
            font-size: 11px !important;
        }

    </style>
    <script>
        document.addEventListener("livewire:load", function () {
            Livewire.on('scroll-bottom', function () {
                var chatWindow = document.getElementById("chatBody");
                chatWindow.scrollTop = chatWindow.scrollHeight;
            });
        });
    </script>
</div>
