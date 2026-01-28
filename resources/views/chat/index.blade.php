@php
    $layout = 'layouts.creditorNItems'; 
    
    if(Auth::check() && Auth::user()->role === 'debtor') {
        $layout = 'layouts.debtor'; 
    } elseif(Auth::check() && Auth::user()->role === 'admin') {
        $layout = 'layouts.admin';
    }
@endphp

@extends($layout)

@section('title', __('strings.inbox') . ' | PayAware')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/chatStyle.css') }}">
@endpush

@section('content')
<main class="pt-24 pb-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto h-[calc(100vh)]">
    
    <div class="flex h-full bg-white rounded-[2rem] shadow-xl border border-slate-100 overflow-hidden relative">
        
        <div class="w-full md:w-1/3 lg:w-1/4 border-r border-slate-100 flex flex-col bg-slate-50/50 {{ isset($activeUser) ? 'hidden md:flex' : 'flex' }}">
            
            <div class="p-5 border-b border-slate-100 bg-white">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-extrabold text-slate-800">{{ __('strings.inbox') }}</h2>
                    <span class="bg-teal-100 text-teal-600 text-[10px] font-bold px-2 py-1 rounded-full">{{ $conversations->count() }}</span>
                </div>
                <div class="relative group">
                    <input type="text" placeholder="{{ __('strings.search_messages') }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl py-3 pl-10 pr-4 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition group-hover:bg-white">
                    <i data-lucide="search" class="absolute left-3 rtl:left-auto rtl:right-3 top-3.5 w-4 h-4 text-slate-400 group-hover:text-teal-500 transition"></i>
                </div>
            </div>
            
            <div class="flex-1 overflow-y-auto chat-scroll p-3 space-y-2">
                @forelse($conversations as $user)
                    <a href="{{ route('chat.show', $user->id) }}" class="flex items-center gap-3 p-3 rounded-2xl transition border border-transparent {{ (isset($activeUser) && $activeUser->id == $user->id) ? 'bg-white shadow-md border-slate-100 ring-1 ring-slate-100' : 'hover:bg-white hover:shadow-sm hover:border-slate-100' }}">
                        <div class="relative flex-shrink-0">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random&color=fff" class="w-12 h-12 rounded-full object-cover border-2 border-white shadow-sm">
                            <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-white rounded-full"></span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex justify-between items-baseline mb-0.5">
                                <h4 class="font-bold text-slate-800 text-sm truncate">{{ $user->name }}</h4>
                            </div>
                            <p class="text-xs text-slate-500 truncate flex items-center gap-1">
                                <i data-lucide="message-circle" class="w-3 h-3 text-slate-400"></i>
                                <span>{{ __('strings.click_to_chat') ?? 'Click to chat' }}</span>
                            </p>
                        </div>
                    </a>
                @empty
                    <div class="text-center py-10 opacity-60">
                        <div class="bg-slate-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i data-lucide="message-square-off" class="w-8 h-8 text-slate-400"></i>
                        </div>
                        <p class="text-sm text-slate-500">{{ __('strings.no_data') }}</p>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="flex-1 flex flex-col bg-[#FDFDFD] relative {{ !isset($activeUser) ? 'hidden md:flex' : 'flex' }}">
            
            @if(isset($activeUser))
                
                {{-- شات هيدر --}}
                <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-white shadow-sm z-20">
                    <div class="flex items-center gap-4">
                        <a href="{{ route('chat.index') }}" class="md:hidden p-2 -ml-2 rounded-full hover:bg-slate-50 text-slate-500">
                            <i data-lucide="arrow-left" class="w-5 h-5 rtl:rotate-180"></i>
                        </a>

                        <img src="https://ui-avatars.com/api/?name={{ urlencode($activeUser->name) }}&background=random&color=fff" class="w-10 h-10 rounded-full border border-slate-100 shadow-sm">
                        <div>
                            <h3 class="font-bold text-slate-800 text-sm md:text-base">{{ $activeUser->name }}</h3>
                            <div class="flex items-center gap-1.5">
                                <span class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></span>
                                <span class="text-xs text-slate-500 font-medium">{{ __('strings.active_now') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex-1 overflow-y-auto p-4 md:p-6 space-y-6 chat-scroll bg-slate-50/30" id="messages-container">
                    
                    @forelse($messages as $msg)
                        @php
                            $isMe = $msg->sender_id == Auth::id();
                        @endphp

                        @if($isMe)
                            <div class="flex items-end gap-3 flex-row-reverse group">
                                <div class="w-8 h-8 rounded-full bg-teal-100 flex items-center justify-center text-teal-600 font-bold text-xs mb-1 border-2 border-white shadow-sm flex-shrink-0">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                                <div class="flex flex-col gap-1 max-w-[75%] md:max-w-[60%] items-end">
                                    <div class="bg-gradient-to-br from-teal-500 to-teal-600 text-white px-4 py-3 rounded-2xl rounded-br-none shadow-md shadow-teal-100 text-sm leading-relaxed text-right dir-rtl">
                                        
                                        {{-- لعرض الصورة --}}
                                        @if($msg->attachment_type == 'image')
                                            <a href="{{ asset('storage/' . $msg->attachment_path) }}" target="_blank" class="block mb-2">
                                                <img src="{{ asset('storage/' . $msg->attachment_path) }}" class="max-w-full h-auto rounded-lg border border-teal-400/50 max-h-60 object-cover">
                                            </a>
                                        @elseif($msg->attachment_type == 'document')
                                            <a href="{{ asset('storage/' . $msg->attachment_path) }}" target="_blank" class="flex items-center gap-3 p-2 bg-white/20 border border-white/30 rounded-xl mb-2 hover:bg-white/30 transition text-white">
                                                <i data-lucide="file-text" class="w-5 h-5"></i>
                                                <span class="text-xs underline">Attached File</span>
                                            </a>
                                        @endif

                                        {{-- لعرض النص --}}
                                        @if($msg->message)
                                            <p>{{ $msg->message }}</p>
                                        @endif
                                    </div>
                                    <div class="flex items-center gap-1 mr-1">
                                        <span class="text-[10px] text-slate-400">{{ $msg->created_at->format('h:i A') }}</span>
                                        <i data-lucide="check-check" class="w-3 h-3 {{ $msg->is_read ? 'text-teal-500' : 'text-slate-300' }}"></i>
                                    </div>
                                </div>
                            </div>
                        @else
                            {{-- رسالة الطرف الآخر --}}
                            <div class="flex items-end gap-3 group">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($activeUser->name) }}&background=random" class="w-8 h-8 rounded-full mb-1 shadow-sm border border-white flex-shrink-0">
                                <div class="flex flex-col gap-1 max-w-[75%] md:max-w-[60%]">
                                    <div class="bg-white border border-slate-100 px-4 py-3 rounded-2xl rounded-bl-none shadow-sm text-slate-600 text-sm leading-relaxed text-right dir-rtl">
                                        
                                        @if($msg->attachment_type == 'image')
                                            <a href="{{ asset('storage/' . $msg->attachment_path) }}" target="_blank" class="block mb-2">
                                                <img src="{{ asset('storage/' . $msg->attachment_path) }}" class="max-w-full h-auto rounded-lg border border-slate-100 max-h-60 object-cover">
                                            </a>
                                        @elseif($msg->attachment_type == 'document')
                                            <a href="{{ asset('storage/' . $msg->attachment_path) }}" target="_blank" class="flex items-center gap-3 p-2 bg-slate-50 border border-slate-200 rounded-xl mb-2 hover:bg-slate-100 transition text-slate-700">
                                                <i data-lucide="file-text" class="w-5 h-5 text-red-500"></i>
                                                <span class="text-xs underline">Download File</span>
                                            </a>
                                        @endif

                                        @if($msg->message)
                                            <p>{{ $msg->message }}</p>
                                        @endif
                                    </div>
                                    <span class="text-[10px] text-slate-400 ml-1">{{ $msg->created_at->format('h:i A') }}</span>
                                </div>
                            </div>
                        @endif
                    @empty
                        <div class="flex flex-col items-center justify-center h-full opacity-50 space-y-4">
                            <div class="bg-slate-100 p-4 rounded-full">
                                <i data-lucide="message-circle" class="w-8 h-8 text-slate-400"></i>
                            </div>
                            <p class="text-sm text-slate-400 font-medium">{{ __('strings.start_chat_desc') }}</p>
                        </div>
                    @endforelse
                </div>

                <div class="p-4 bg-white border-t border-slate-100 z-20">
                    
                    <div id="file-preview" class="hidden mb-2 px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl justify-between items-center flex">
                        <span class="text-xs text-slate-600 font-medium truncate" id="file-name"></span>
                        <button type="button" id="clear-file-btn" class="text-red-500 hover:text-red-700 p-1">
                            <i data-lucide="x" class="w-4 h-4"></i>
                        </button>
                    </div>

                    <form action="{{ route('chat.store') }}" method="POST" enctype="multipart/form-data" class="flex items-end gap-2 bg-slate-50 p-2 rounded-[1.5rem] border border-slate-200 focus-within:border-teal-400 focus-within:ring-4 focus-within:ring-teal-500/10 transition-all duration-300">
                        @csrf
                        <input type="hidden" name="receiver_id" value="{{ $activeUser->id }}">
                        
                        <button type="button" id="trigger-upload-btn" class="p-3 text-slate-400 hover:text-teal-600 hover:bg-white rounded-full transition flex-shrink-0 cursor-pointer">
                            <i data-lucide="paperclip" class="w-5 h-5"></i>
                        </button>
                        
                        <input type="file" name="attachment" id="attachment_input" class="hidden">

                        <textarea name="message" rows="1" placeholder="{{ __('strings.type_message') }}" class="flex-1 bg-transparent border-none focus:ring-0 text-sm text-slate-700 placeholder-slate-400 py-3 resize-none max-h-32 custom-scroll text-right" oninput="this.style.height = ''; this.style.height = this.scrollHeight + 'px'"></textarea>
                        
                        <button type="submit" class="p-3 bg-teal-600 hover:bg-teal-700 text-white rounded-full shadow-lg shadow-teal-200 transition transform hover:scale-105 active:scale-95 flex-shrink-0">
                            <i data-lucide="send" class="w-5 h-5 rtl:rotate-180"></i>
                        </button>
                    </form>
                </div>

            @else
                
                <div class="flex-1 flex flex-col items-center justify-center text-center p-8">
                    <div class="relative mb-6">
                        <div class="absolute inset-0 bg-teal-100 blur-2xl opacity-50 rounded-full"></div>
                        <div class="relative bg-white p-6 rounded-[2rem] shadow-xl shadow-slate-200 border border-slate-50">
                            <i data-lucide="message-circle" class="w-12 h-12 text-teal-500"></i>
                        </div>
                    </div>
                    <h3 class="text-2xl font-black text-slate-800 mb-2">{{ __('strings.welcome_back', ['name' => Auth::user()->name]) }}</h3>
                    <p class="text-slate-400 max-w-xs mx-auto leading-relaxed">{{ __('strings.start_chat_desc') }}</p>
                </div>

            @endif
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script src="{{ asset('js/chatLog.js') }}"></script>
@endpush