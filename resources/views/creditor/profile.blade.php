@extends('layouts.creditorNItems')

@section('title', ($company->name ?? $user->name) . ' | PayAware')

@section('content')
    
    {{-- ======================== --}}
    {{-- لصورة الغلاف  --}}
    {{-- ======================== --}}
    <div class="h-64 md:h-80 bg-slate-900 relative group mt-20">
        <img src="{{ isset($company->cover_photo) ? asset('storage/' . $company->cover_photo) : 'https://images.unsplash.com/photo-1497215728101-856f4ea42174?auto=format&fit=crop&w=1600&q=80' }}" 
             alt="Cover" 
             class="w-full h-full object-cover opacity-60 group-hover:opacity-70 transition duration-500">
        
        <button class="absolute bottom-4 right-4 rtl:right-auto rtl:left-4 bg-white/20 backdrop-blur-md hover:bg-white/30 text-white px-4 py-2 rounded-xl text-sm font-bold transition flex items-center gap-2">
            <i data-lucide="camera" class="w-4 h-4"></i> {{ __('strings.change_cover') }}
        </button>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative -mt-20 pb-12">
        
        {{-- ======================== --}}
        {{-- بطاقة المعلومات --}}
        {{-- ======================== --}}
        <div class="bg-white rounded-[2rem] shadow-lg border border-slate-100 p-6 md:p-8 flex flex-col md:flex-row items-center md:items-end gap-6 relative z-10">
            <div class="relative group">
                <div class="w-32 h-32 md:w-40 md:h-40 rounded-[2rem] border-4 border-white shadow-xl overflow-hidden bg-indigo-50 p-2">
                    <img src="{{ isset($company->logo) ? asset('storage/' . $company->logo) : 'https://api.dicebear.com/7.x/identicon/svg?seed=' . ($company->name ?? $user->name) }}" 
                         alt="Logo" 
                         class="w-full h-full object-cover rounded-xl">
                </div>
                <button class="absolute bottom-2 right-2 rtl:right-auto rtl:left-2 bg-slate-900 text-white p-2 rounded-full hover:bg-teal-500 transition shadow-lg">
                    <i data-lucide="camera" class="w-4 h-4"></i>
                </button>
            </div>
            
            <div class="flex-1 text-center md:text-left rtl:md:text-right mb-2">
                <div class="flex items-center justify-center md:justify-start rtl:md:justify-start gap-2">
                    <h1 class="text-3xl font-extrabold text-slate-800">{{ $company->name ?? $user->name }}</h1>
                    <i data-lucide="badge-check" class="w-6 h-6 text-teal-500 fill-teal-100"></i>
                </div>
                <p class="text-slate-500 font-medium mt-1">{{ $company->industry ?? __('strings.industry_placeholder') }}</p>
                
                <div class="flex items-center justify-center md:justify-start rtl:md:justify-start gap-4 mt-3 text-sm text-slate-400">
                    @if(isset($company->address))
                        <span class="flex items-center gap-1"><i data-lucide="map-pin" class="w-4 h-4"></i> {{ $company->address }}</span>
                    @endif
                    @if(isset($company->website))
                        <span class="flex items-center gap-1"><i data-lucide="link" class="w-4 h-4"></i> <a href="{{ $company->website }}" target="_blank" class="hover:text-teal-600">Website</a></span>
                    @endif
                </div>
            </div>

            <div class="flex gap-3">
                <a href="{{ route('creditor.settings.index') }}" class="bg-white border border-slate-200 hover:bg-slate-50 text-slate-600 font-bold py-2.5 px-4 rounded-xl transition flex items-center gap-2">
                    <i data-lucide="settings" class="w-4 h-4"></i> {{ __('strings.edit_profile') }}
                </a>
            </div>
        </div>

        {{-- تخطيط الصفحة  --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mt-8">
            
            {{-- ======================== --}}
            {{-- الشريط الجانبي (About) --}}
            {{-- ======================== --}}
            <div class="space-y-6">
                <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100">
                    <h3 class="text-lg font-bold text-slate-800 mb-4">{{ __('strings.about_us') }}</h3>
                    <p class="text-slate-500 text-sm leading-relaxed mb-6">
                        {{ $company->description ?? __('strings.no_description') }}
                    </p>
                    <div class="space-y-4">
                        <div class="flex items-start gap-3">
                            <div class="p-2 bg-indigo-50 text-indigo-600 rounded-lg"><i data-lucide="map" class="w-5 h-5"></i></div>
                            <div>
                                <p class="text-sm font-bold text-slate-700">{{ __('strings.location') }}</p>
                                <p class="text-xs text-slate-500">{{ $company->address ?? __('strings.no_address') }}</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="p-2 bg-teal-50 text-teal-600 rounded-lg"><i data-lucide="phone" class="w-5 h-5"></i></div>
                            <div>
                                <p class="text-sm font-bold text-slate-700">{{ __('strings.contact') }}</p>
                                <p class="text-xs text-slate-500" dir="ltr">{{ $company->phone ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- التقييمات --}}
                <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-bold text-slate-800">{{ __('strings.ratings') }}</h3>
                        <div class="flex items-center gap-1 text-yellow-500 font-bold">
                            <i data-lucide="star" class="w-5 h-5 fill-current"></i> {{ $company->rating ?? '5.0' }}
                        </div>
                    </div>
                    <div class="text-center text-slate-400 text-sm py-2">
                        No reviews yet.
                    </div>
                </div>
            </div>

            {{-- ======================== --}}
            {{--  المحتوى الرئيسي (Feed) --}}
            {{-- ======================== --}}
            <div class="lg:col-span-2 space-y-6">
                
                {{-- رسائل النظام --}}
                @if(session('success'))
                    <div class="bg-green-50 text-green-600 p-4 rounded-xl border border-green-100 text-sm font-bold">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="bg-red-50 text-red-600 p-4 rounded-xl border border-red-100 text-sm font-bold">
                        {{ session('error') }}
                    </div>
                @endif
                @if ($errors->any())
                    <div class="bg-red-50 text-red-600 p-4 rounded-xl border border-red-100 text-sm font-bold">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- ======================== --}}
                {{-- نموذج النشر  --}}
                {{-- ======================== --}}
                <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100">
                    @csrf
                    
                    <div class="flex gap-4 mb-4">
                        <div class="w-10 h-10 rounded-full bg-indigo-50 p-1 overflow-hidden shrink-0">
                            <img src="{{ isset($company->logo) ? asset('storage/' . $company->logo) : 'https://api.dicebear.com/7.x/identicon/svg?seed=' . ($company->name ?? $user->name) }}" class="w-full h-full object-cover">
                        </div>
                        
                        <div class="w-full">
                            <input type="text" name="content" required placeholder="{{ __('strings.share_updates_placeholder') }}" class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500/20 transition">
                            
                            <div id="file-preview" class="hidden mt-2 text-xs text-teal-600 font-bold flex items-center gap-2">
                                <i data-lucide="image" class="w-3 h-3"></i> <span id="file-name"></span>
                                <button type="button" onclick="clearImage()" class="text-red-500 hover:text-red-700 ml-2 font-bold">✕</button>
                            </div>
                        </div>
                    </div>

                    {{-- الحقول المخفية --}}
                    <input type="file" name="image" id="post-image-input" class="hidden" accept="image/*">
                    <input type="checkbox" name="is_offer" id="post-offer-input" class="hidden" value="1">

                    <div class="flex justify-between items-center pt-3 border-t border-slate-50">
                        <div class="flex gap-4">
                            <button type="button" onclick="document.getElementById('post-image-input').click()" class="flex items-center gap-2 text-slate-500 hover:text-teal-600 text-xs font-bold transition">
                                <i data-lucide="image" class="w-4 h-4"></i> {{ __('strings.photo_video') }}
                            </button>
                            <button type="button" id="offer-btn" onclick="toggleOffer()" class="flex items-center gap-2 text-slate-500 hover:text-teal-600 text-xs font-bold transition">
                                <i data-lucide="tag" class="w-4 h-4"></i> {{ __('strings.offer') }}
                            </button>
                        </div>
                        <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white font-bold py-2 px-6 rounded-lg text-xs transition shadow-md shadow-teal-200">
                            {{ __('strings.publish') }}
                        </button>
                    </div>
                </form>

                {{-- ======================== --}}
                {{-- قائمة المنشورات  --}}
                {{-- ======================== --}}
                @forelse($company->posts as $post)
                    <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 relative group">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-12 h-12 rounded-xl bg-indigo-50 p-1 border border-slate-100">
                                @if($post->company)
                                    <img src="{{ $post->company->logo ? asset('storage/' . $post->company->logo) : 'https://api.dicebear.com/7.x/identicon/svg?seed=' . $post->company->name }}" class="w-full h-full rounded-lg object-cover">
                                @else
                                    <img src="{{ 'https://api.dicebear.com/7.x/avataaars/svg?seed=' . $post->user->name }}" class="w-full h-full rounded-lg object-cover">
                                @endif
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-900">
                                    {{ $post->company->name ?? $post->user->name }}
                                </h4>
                                <p class="text-xs text-slate-400">{{ $post->created_at->diffForHumans() }}</p>
                            </div>
                            <button class="ml-auto rtl:ml-0 rtl:mr-auto text-slate-300 hover:text-slate-600"><i data-lucide="more-horizontal"></i></button>
                        </div>
                        
                        <p class="text-slate-600 text-sm mb-4 leading-relaxed whitespace-pre-line">{{ $post->content }}</p>
                        
                        @if($post->image)
                        <div class="rounded-2xl overflow-hidden h-72 bg-slate-900 relative mb-4">
                            <img src="{{ asset('storage/' . $post->image) }}" class="w-full h-full object-cover">
                            @if($post->is_offer)
                                <div class="absolute top-4 right-4 rtl:right-auto rtl:left-4 bg-red-500 text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-lg">
                                    {{ __('strings.offer') }}
                                </div>
                            @endif
                        </div>
                        @elseif($post->is_offer)
                             <span class="inline-block bg-red-100 text-red-600 text-xs font-bold px-3 py-1 rounded-full mb-4">🔥 {{ __('strings.offer') }}</span>
                        @endif

                        <div class="flex items-center gap-6 pt-4 border-t border-slate-50">
                            <button class="flex items-center gap-2 text-slate-500 hover:text-red-500 transition font-bold text-xs">
                                <i data-lucide="heart" class="w-4 h-4"></i> {{ $post->likes_count ?? 0 }}
                            </button>
                            <button class="flex items-center gap-2 text-slate-500 hover:text-teal-600 font-bold text-xs">
                                <i data-lucide="message-circle" class="w-4 h-4"></i> {{ __('strings.comments_count', ['count' => $post->comments_count ?? 0]) }}
                            </button>
                            <button class="flex items-center gap-2 text-slate-500 hover:text-teal-600 font-bold text-xs">
                                <i data-lucide="share-2" class="w-4 h-4"></i> {{ __('strings.share') }}
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-10 bg-white rounded-[2rem] border border-slate-100">
                        <div class="bg-slate-50 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i data-lucide="pen-tool" class="w-8 h-8 text-slate-400"></i>
                        </div>
                        <h3 class="text-slate-800 font-bold">No posts yet</h3>
                        <p class="text-slate-500 text-sm mt-1">Start by sharing your first update!</p>
                    </div>
                @endforelse

            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="{{ asset('js/creditorLog.js') }}"></script>
@endpush