@extends('layouts.debtor')

@section('title', __('strings.user_profile'))

@section('content')
<main class="pt-20 pb-12">
        
    <div class="h-64 md:h-80 bg-gradient-to-r from-teal-500 to-indigo-600 relative group overflow-hidden">
        <img src="{{ $user->cover_image ? asset('storage/'.$user->cover_image) : 'https://images.unsplash.com/photo-1579546929518-9e396f3cc809?auto=format&fit=crop&w=1600&q=80' }}" alt="Cover" class="w-full h-full object-cover opacity-80 group-hover:scale-105 transition duration-700">
        
        {{-- زر تعديل صورة الغلاف  --}}
        <button onclick="document.getElementById('cover-input').click()" class="absolute bottom-4 right-4 rtl:right-auto rtl:left-4 bg-white/20 backdrop-blur-md hover:bg-white/30 text-white px-4 py-2 rounded-xl text-sm font-bold transition flex items-center gap-2 shadow-lg">
            <i data-lucide="camera" class="w-4 h-4"></i> {{ __('strings.edit_cover') ?? 'Edit Cover' }}
        </button>

        <form id="cover-form" action="{{ route('debtor.profile.update_avatar') }}" method="POST" enctype="multipart/form-data" class="hidden">
            @csrf
            <input type="file" name="cover_image" id="cover-input" accept="image/*" onchange="document.getElementById('cover-form').submit()">
        </form>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative -mt-20">
        
        {{-- رسالة الفشل او النجاح --}}
        @if (session('success'))
            <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl relative flex items-center gap-2 shadow-sm animate-fade-in-up" role="alert">
                <i data-lucide="check-circle" class="w-5 h-5"></i>
                <span class="block sm:inline font-bold">{{ session('success') }}</span>
            </div>
        @endif

        @error('avatar')
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl relative flex items-center gap-2 shadow-sm" role="alert">
                <i data-lucide="alert-circle" class="w-5 h-5"></i>
                <span class="block sm:inline font-bold">{{ $message }}</span>
            </div>
        @enderror

        <div class="bg-white rounded-[2rem] shadow-lg border border-slate-100 p-6 md:p-8 flex flex-col md:flex-row items-center md:items-end gap-6 relative z-10">
            
            {{-- رفع صورة البرفايل  --}}
            <div class="relative group">
                <div class="w-32 h-32 md:w-40 md:h-40 rounded-full border-4 border-white shadow-xl overflow-hidden bg-slate-100 relative">
                    <img src="{{ $user->avatar ? asset('storage/'.$user->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=random&size=256' }}" alt="Profile" class="w-full h-full object-cover">
                    
                    {{-- سبينر لودينج  --}}
                    <div id="avatar-loading" class="absolute inset-0 bg-black/50 hidden items-center justify-center transition-all">
                        <div class="w-8 h-8 border-4 border-white border-t-transparent rounded-full animate-spin"></div>
                    </div>
                </div>

                <form id="avatar-form" action="{{ route('debtor.profile.update_avatar') }}" method="POST" enctype="multipart/form-data" class="hidden">
                    @csrf
                    <input type="file" name="avatar" id="avatar-input" accept="image/*" onchange="document.getElementById('avatar-form').submit(); document.getElementById('avatar-loading').classList.remove('hidden'); document.getElementById('avatar-loading').classList.add('flex');">
                </form>

                <button onclick="document.getElementById('avatar-input').click()" class="absolute bottom-2 right-2 rtl:right-auto rtl:left-2 bg-slate-900 text-white p-2 rounded-full hover:bg-teal-500 transition shadow-lg cursor-pointer z-20" title="{{ __('strings.change_photo') }}">
                    <i data-lucide="camera" class="w-4 h-4"></i>
                </button>
            </div>
            
            <div class="flex-1 text-center md:text-left rtl:md:text-right mb-2">
                <h1 class="text-3xl font-extrabold text-slate-800 flex items-center justify-center md:justify-start gap-2">
                    {{ $user->name }}
                    @if(($user->credit_score ?? 0) >= 80)
                        <i data-lucide="badge-check" class="w-6 h-6 text-teal-500" title="{{ __('strings.verified_payer') }}"></i>
                    @endif
                </h1>
                <p class="text-slate-500 font-medium mt-1">{{ $user->job_title ?? __('strings.default_job_title') }}</p>
                
                <div class="flex items-center justify-center md:justify-start gap-4 mt-3 text-sm text-slate-400">
                    <span class="flex items-center gap-1">
                        <i data-lucide="map-pin" class="w-4 h-4"></i> {{ $user->address ?? __('strings.not_specified') }}
                    </span>
                    <span class="flex items-center gap-1">
                        <i data-lucide="calendar" class="w-4 h-4"></i> 
                        {{ __('strings.joined_date', ['date' => $user->created_at->format('F Y')]) }}
                    </span>
                </div>
            </div>

            <div class="flex gap-3">
                {{-- زر تحرير البروفايل --}}
                <button onclick="openEditProfileModal()" class="bg-white border border-slate-200 hover:bg-slate-50 text-slate-600 font-bold py-2.5 px-4 rounded-xl transition flex items-center gap-2">
                    <i data-lucide="edit-3" class="w-5 h-5"></i> {{ __('strings.edit_profile') }}
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mt-8">
            
            <div class="space-y-6">
                <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100">
                    <h3 class="text-lg font-bold text-slate-800 mb-4">{{ __('strings.about') }}</h3>
                    <p class="text-slate-500 text-sm leading-relaxed mb-6">
                        {{ $user->bio ?? __('strings.default_bio_text') ?? 'No bio added yet.' }}
                    </p>
                    <ul class="space-y-4">
                        <li class="flex items-center gap-3 text-sm text-slate-600">
                            <i data-lucide="briefcase" class="w-5 h-5 text-slate-400"></i> {{ __('strings.works_at') }} 
                            <span class="font-bold text-slate-800">{{ $user->work_place ?? __('strings.not_specified') }}</span>
                        </li>
                        <li class="flex items-center gap-3 text-sm text-slate-600">
                            <i data-lucide="graduation-cap" class="w-5 h-5 text-slate-400"></i> {{ __('strings.studied_at') }} 
                            <span class="font-bold text-slate-800">{{ $user->study_place ?? __('strings.not_specified') }}</span>
                        </li>
                        <li class="flex items-center gap-3 text-sm text-slate-600">
                            <i data-lucide="home" class="w-5 h-5 text-slate-400"></i> {{ __('strings.lives_in') }} 
                            <span class="font-bold text-slate-800">{{ $user->address ?? __('strings.not_specified') }}</span>
                        </li>
                    </ul>

                    <div class="mt-8 pt-6 border-t border-slate-50">
                        <h4 class="text-xs font-bold text-slate-400 uppercase mb-4 tracking-wider">{{ __('strings.achievements') }}</h4>
                        <div class="flex flex-wrap gap-3">
                            <div class="flex items-center gap-2 bg-green-50 text-green-700 px-3 py-1.5 rounded-lg text-xs font-bold border border-green-100 shadow-sm cursor-help" title="No recent violations">
                                <i data-lucide="shield-check" class="w-4 h-4"></i> {{ __('strings.good_behavior') ?? 'Good Standing' }}
                            </div>
                            
                            @if(($user->credit_score ?? 0) >= 90)
                            <div class="flex items-center gap-2 bg-indigo-50 text-indigo-700 px-3 py-1.5 rounded-lg text-xs font-bold border border-indigo-100 shadow-sm cursor-help" title="Credit Score 90+">
                                <i data-lucide="star" class="w-4 h-4"></i> {{ __('strings.top_payer') }}
                            </div>
                            @endif

                            @if($user->credit_score >= 80)
                            <div class="flex items-center gap-2 bg-orange-50 text-orange-700 px-3 py-1.5 rounded-lg text-xs font-bold border border-orange-100 shadow-sm cursor-help">
                                <i data-lucide="zap" class="w-4 h-4"></i> {{ __('strings.early_payer') ?? 'Reliable' }}
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- لصورة البروفايل  --}}
                <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-bold text-slate-800">{{ __('strings.photos') }}</h3>
                        <a href="#" class="text-teal-600 text-xs font-bold hover:underline">{{ __('strings.see_all') }}</a>
                    </div>
                    <div class="grid grid-cols-3 gap-2">
                        <div class="aspect-square rounded-xl bg-slate-100 overflow-hidden"><img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=200&q=80" class="w-full h-full object-cover hover:scale-110 transition"></div>
                        <div class="aspect-square rounded-xl bg-slate-100 overflow-hidden"><img src="https://images.unsplash.com/photo-1517048676732-d65bc937f952?auto=format&fit=crop&w=200&q=80" class="w-full h-full object-cover hover:scale-110 transition"></div>
                        <div class="aspect-square rounded-xl bg-slate-100 overflow-hidden"><img src="https://images.unsplash.com/photo-1531403009284-440f080d1e12?auto=format&fit=crop&w=200&q=80" class="w-full h-full object-cover hover:scale-110 transition"></div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-2 space-y-6">
                
                {{-- لنشر بوست --}}
                <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100">
                    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="flex gap-4 mb-4">
                            <img src="{{ $user->avatar ? asset('storage/'.$user->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=random' }}" class="w-10 h-10 rounded-full bg-slate-100 object-cover">
                            <input type="text" name="content" placeholder="{{ __('strings.whats_on_mind', ['name' => explode(' ', $user->name)[0]]) }}" class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500/20 transition" required>
                        </div>
                        <div class="flex justify-between items-center pt-3 border-t border-slate-50">
                            <div class="flex gap-4">
                                <input type="file" name="image" id="post-image" class="hidden" accept="image/*">
                                <button type="button" onclick="document.getElementById('post-image').click()" class="flex items-center gap-2 text-slate-500 hover:text-teal-600 text-xs font-bold transition">
                                    <i data-lucide="image" class="w-4 h-4"></i> {{ __('strings.photo_video') }}
                                </button>
                                <button type="button" class="flex items-center gap-2 text-slate-500 hover:text-teal-600 text-xs font-bold transition">
                                    <i data-lucide="smile" class="w-4 h-4"></i> {{ __('strings.feeling') }}
                                </button>
                            </div>
                            <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white font-bold py-2 px-6 rounded-lg text-xs transition shadow-md shadow-teal-200">
                                {{ __('strings.post_btn') }}
                            </button>
                        </div>
                    </form>
                </div>

                {{-- لعرض البوستات --}}
                @forelse($user->posts as $post)
                    <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 hover:shadow-md transition duration-300">
                        <div class="flex items-center gap-4 mb-4">
                            <img src="{{ $user->avatar ? asset('storage/'.$user->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=random' }}" class="w-10 h-10 rounded-full bg-slate-100 object-cover">
                            <div>
                                <h4 class="font-bold text-slate-800">{{ $user->name }}</h4>
                                <p class="text-xs text-slate-400">{{ $post->created_at->diffForHumans() }}</p>
                            </div>
                            <button class="ml-auto text-slate-300 hover:text-slate-600"><i data-lucide="more-horizontal"></i></button>
                        </div>
                        
                        <p class="text-slate-600 text-sm mb-4 leading-relaxed whitespace-pre-line dir-auto">
                            {{ $post->content }}
                        </p>

                        @if($post->image)
                            <div class="rounded-2xl overflow-hidden mb-4 border border-slate-100">
                                <img src="{{ asset('storage/' . $post->image) }}" class="w-full h-auto object-cover max-h-96">
                            </div>
                        @endif

                        <div class="flex items-center gap-6 pt-4 border-t border-slate-50">
                            {{-- زر اللايك --}}
                            <form action="{{ route('posts.like', $post->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="flex items-center gap-2 text-xs font-bold px-3 py-1 rounded-full transition {{ $post->isLikedByAuthUser() ? 'bg-red-50 text-red-500' : 'text-slate-500 hover:text-red-500' }}">
                                    <i data-lucide="heart" class="w-4 h-4 {{ $post->isLikedByAuthUser() ? 'fill-current' : '' }}"></i> 
                                    <span>{{ $post->likes_count }}</span>
                                </button>
                            </form>
                            
                            {{-- الكومنت --}}
                            <button class="flex items-center gap-2 text-slate-500 hover:text-teal-600 font-bold text-xs">
                                <i data-lucide="message-circle" class="w-4 h-4"></i> 
                                <span>{{ $post->comments->count() }} {{ __('strings.comment') }}</span>
                            </button>
                            
                            {{-- مشاركة --}}
                            <button class="flex items-center gap-2 text-slate-500 hover:text-teal-600 font-bold text-xs">
                                <i data-lucide="share-2" class="w-4 h-4"></i> Share
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-10 bg-white rounded-[2rem] border border-dashed border-slate-200">
                        <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i data-lucide="pen-tool" class="w-8 h-8 text-slate-300"></i>
                        </div>
                        <p class="text-slate-400 text-sm font-bold">{{ __('strings.no_posts_yet') ?? 'You haven\'t posted anything yet.' }}</p>
                    </div>
                @endforelse

            </div>
        </div>
    </div>
</main>
@endsection

{{-- لتعديل البروفايل  --}}
@section('modals')
<div id="editProfileModal" class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-[2rem] w-full max-w-lg shadow-2xl transform scale-95 opacity-0 transition-all duration-300" id="editProfileContent">
        <form action="{{ route('debtor.profile.update') }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="p-6 border-b border-slate-100 flex justify-between items-center">
                <h3 class="text-lg font-bold text-slate-800">{{ __('strings.edit_profile') }}</h3>
                <button type="button" onclick="closeEditProfileModal()" class="text-slate-400 hover:text-red-500 transition"><i data-lucide="x" class="w-6 h-6"></i></button>
            </div>
            
            <div class="p-6 space-y-4 max-h-[70vh] overflow-y-auto custom-scroll">
                <div>
                    <label class="block text-xs font-bold text-slate-500 mb-1 uppercase">{{ __('strings.job_title') }}</label>
                    <input type="text" name="job_title" value="{{ $user->job_title }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-sm focus:outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 mb-1 uppercase">{{ __('strings.bio') }}</label>
                    <textarea name="bio" rows="3" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-sm focus:outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500">{{ $user->bio }}</textarea>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-1 uppercase">{{ __('strings.works_at') }}</label>
                        <input type="text" name="work_place" value="{{ $user->work_place }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-sm focus:outline-none focus:border-teal-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-1 uppercase">{{ __('strings.studied_at') }}</label>
                        <input type="text" name="study_place" value="{{ $user->study_place }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-sm focus:outline-none focus:border-teal-500">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 mb-1 uppercase">{{ __('strings.address') }}</label>
                    <input type="text" name="address" value="{{ $user->address }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-sm focus:outline-none focus:border-teal-500">
                </div>
            </div>

            <div class="p-6 border-t border-slate-100 flex justify-end gap-3 bg-slate-50/50 rounded-b-[2rem]">
                <button type="button" onclick="closeEditProfileModal()" class="px-5 py-2.5 rounded-xl text-sm font-bold text-slate-500 hover:bg-slate-100 transition">{{ __('strings.cancel') }}</button>
                <button type="submit" class="px-6 py-2.5 rounded-xl text-sm font-bold text-white bg-teal-600 hover:bg-teal-700 shadow-md shadow-teal-200 transition">{{ __('strings.save_changes') }}</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/debtorLog.js') }}"></script>
@endpush