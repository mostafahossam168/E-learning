<div class="chat-container">
    <!-- الشريط الجانبي -->
    <div class="sidebar-chat">

        <!-- أعلى القائمة: البحث وزر الإضافة -->
        <div class="top-bar">
            <input type="search" class="search-input" wire:model.live="search" placeholder="🔍 ابحث عن مستخدم..." />
            @if (!$new_chat)
                <button class="add-chat" wire:click="$set('new_chat',true)">+</button>
            @else
                <button class="add-chat bg-danger fs-6" wire:click="$set('new_chat',false)">رجوع</button>
            @endif
        </div>
        @if (!$new_chat)
            <!-- فلاتر المحادثات -->
            <div class="chat-filters">
                <button class="filter-button {{ !$unread ? 'active' : '' }}" wire:click="$set('unread',false)">📁
                    الكل</button>
                <button class="filter-button {{ $unread ? 'active' : '' }}" wire:click="$set('unread',true)">📩 غير
                    مقروءة</button>
            </div>
            <!-- قائمة المحادثات -->
            <ul class="chat-list">
                @foreach ($conversations as $conversation)
                    <li class="chat-item {{ $conversationId == $conversation->id ? 'active' : null }}"
                        onclick="scrollChatToBottom()" wire:click="showConversation({{ $conversation->id }})">
                        <img src="{{ display_file($conversation->otherUser(auth()->id())->image) }}" class="avatar"
                            alt="User" />
                        <span class="chat-name">{{ $conversation->otherUser(auth()->id())->name }}</span>
                        @php
                            $count = $conversation
                                ->messages()
                                ->where('sender_id', '!=', auth()->id())
                                ->where('is_read', 0)
                                ->count();
                        @endphp
                        @if ($count)
                            <span class="unread-count">{{ $count }}</span>
                        @endif
                    </li>
                @endforeach
            </ul>
        @else
            <ul class="chat-list">
                @foreach ($usersWithoutConversation as $user)
                    <li class="chat-item " wire:click="AddNewChat({{ $user->id }})">
                        <img src="{{ display_file($user->image) }}" class="avatar" alt="User" />
                        <span class="chat-name">{{ $user->name }}</span>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

    @if ($show_conversation)
        @php
            if ($new_user) {
                $converstion_other = $new_user;
            } else {
                $converstion_other = App\Models\Conversation::find($conversationId)->otherUser(auth()->id());
            }
        @endphp
        <!-- نافذة الشات -->
        <main class="chat-window">
            <!-- رأس المحادثة -->
            <header class="chat-header">
                <img src="{{ display_file($converstion_other->image) }}" alt="User" class="chat-user-avatar" />
                <h3>{{ $converstion_other->name }}</h3>
            </header>
            <!-- رسائل الشات -->
            <div class="chat-messages">
                @foreach ($messages as $message)
                    @if ($message->sender_id == auth()->id())
                        <div class="message sent">
                            @if ($message->type->value == 'image')
                                <div class="content">
                                    <img src="{{ display_file($message->file_path) }}" class="chat-image"
                                        alt="صورة مرسلة">
                                </div>
                            @elseif($message->type->value == 'file')
                                <div class="content">
                                    <a href="{{ display_file($message->file_path) }}" class="chat-file" download>📄
                                        تحميل ملف </a>
                                </div>
                            @else
                                <div class="content">{{ $message->message }}</div>
                            @endif
                            <div class="timestamp"> {{ date('h:i a', strtotime($message->created_at)) }}</div>
                        </div>
                    @else
                        <div class="message received">
                            @if ($message->type->value == 'image')
                                <div class="content">
                                    <img src="{{ display_file($message->file_path) }}" class="chat-image"
                                        alt="صورة مرسلة">
                                </div>
                            @elseif($message->type->value == 'file')
                                <div class="content">
                                    <a href="{{ display_file($message->file_path) }}" class="chat-file" download>📄
                                        تحميل ملف </a>
                                </div>
                            @else
                                <div class="content">{{ $message->message }}</div>
                            @endif
                            <div class="timestamp"> {{ date('h:i a', strtotime($message->created_at)) }}</div>
                        </div>
                    @endif
                @endforeach

                {{-- <div class="message received">
                    <div class="content">
                        <img src="sample-image.jpg" class="chat-image" alt="صورة مرسلة">
                    </div>
                    <div class="timestamp">10:32 ص</div>
                </div>

                <div class="message sent">
                    <div class="content">
                        <a href="file.pdf" class="chat-file" download>📄 تحميل ملف PDF</a>
                    </div>
                    <div class="timestamp">10:34 ص</div>
                </div> --}}
            </div>
            <!-- إرسال رسالة -->
            <form class="chat-input" wire:submit.prevent="sendMessage({{ $converstion_other->id }})">
                <input type="file" id="fileInput" hidden wire:model="file" />
                <button type="button" onclick="document.getElementById('fileInput').click()">📎</button>
                <input type="text" placeholder="اكتب رسالتك..." wire:model="message" />
                <button type="submit">إرسال</button>
            </form>
        </main>
    @else
        <main style="height: 100%;width: 100%;display: flex;align-items: center;justify-content: center;">
            <p class="fs-3 text-danger">لا يوجد محادثه</p>
        </main>
    @endif



</div>
@section('css')
    <style>
        .chat-container {
            display: flex;
            height: 90vh;
        }

        /* الشريط الجانبي */
        .sidebar-chat {
            width: 350px;
            background-color: #2c3e50;
            color: #fff;
            padding: 10px;
            overflow-y: auto;
        }

        /* البحث + زر الإضافة */
        .top-bar {
            display: flex;
            gap: 10px;
            margin-bottom: 15px;
        }

        .search-input {
            flex: 1;
            padding: 8px;
            border-radius: 5px;
            border: none;
            font-size: 14px;
        }

        .add-chat {
            background-color: #1abc9c;
            color: #fff;
            border: none;
            padding: 8px 10px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 18px;
        }

        /* فلاتر */
        .chat-filters {
            display: flex;
            gap: 10px;
            margin-bottom: 15px;
        }

        .filter-button {
            flex: 1;
            background-color: #34495e;
            border: none;
            color: white;
            padding: 8px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
        }

        .filter-button.active {
            background-color: #1abc9c;
        }

        /* المحادثات */
        .chat-list {
            list-style: none;
            margin: 0;
            padding: 0;

        }

        .chat-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 8px;
            border-radius: 4px;
            position: relative;
            cursor: pointer;
            transition: background 0.2s;
            border-bottom: 1px solid white;
        }

        .chat-item:hover,
        .chat-item.active {
            background-color: #34495e;
        }

        .avatar {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            object-fit: cover;
            margin-left: 10px;
        }

        .chat-name {
            flex: 1;
            color: #fff;
            font-size: 15px;
        }

        .unread-count {
            background-color: red;
            color: #fff;
            font-size: 12px;
            padding: 3px 6px;
            border-radius: 50%;
            min-width: 18px;
            text-align: center;
        }

        /* نافذة الشات */
        .chat-window {
            flex: 1;
            display: flex;
            flex-direction: column;
            background-color: #fff;
        }

        /* رأس الشات */
        .chat-header {
            display: flex;
            align-items: center;
            gap: 10px;
            background-color: #2980b9;
            color: #fff;
            padding: 15px;
        }

        .chat-user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }

        /* الرسائل */
        .chat-messages {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
            background-color: #ecf0f1;
        }

        .message {
            margin-bottom: 15px;
            max-width: 70%;
            clear: both;
        }

        .message .content {
            padding: 10px 15px;
            border-radius: 15px;
            background-color: #bdc3c7;
            color: black;
            word-wrap: break-word;
        }

        .message.sent .content {
            background-color: #3498db;
            color: white;
        }

        .message.sent {
            float: right;
            text-align: right;
        }

        .message.received {
            float: left;
            text-align: left;
        }

        .timestamp {
            font-size: 12px;
            margin-top: 4px;
            color: #555;
            padding: 0 10px;
        }

        .chat-image {
            max-width: 100%;
            border-radius: 10px;
        }

        .chat-file {
            display: inline-block;
            background: #eee;
            padding: 8px 12px;
            border-radius: 10px;
            text-decoration: none;
            color: #333;
        }

        /* إدخال الرسائل */
        .chat-input {
            display: flex;
            padding: 15px;
            border-top: 1px solid #ccc;
            background-color: #fff;
        }

        .chat-input input[type="text"] {
            flex: 1;
            padding: 10px;
            font-size: 15px;
            border: 1px solid #ccc;
            border-radius: 20px;
            margin: 0 10px;
        }

        .chat-input button {
            background-color: #2980b9;
            color: white;
            border: none;
            padding: 10px 16px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 16px;
        }
    </style>
@endsection
@push('scripts')
    <script>
        function scrollChatToBottom() {
            const chatMessages = document.querySelector('.chat-messages');

            if (chatMessages) {
                setTimeout(() => { // اعطِ فرصة للرسائل انها تظهر اول
                    chatMessages.scrollTop = chatMessages.scrollHeight;
                }, 1000); // ممكن تزود الوقت لو الرسائل بتاخد وقت للظهور
            }
        }
    </script>
    >
@endpush
