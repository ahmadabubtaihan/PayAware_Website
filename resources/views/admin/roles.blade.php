@extends('layouts.admin')

@section('title', __('strings.roles_permissions') ?? 'الأدوار والصلاحيات')

@section('content')
<div class="flex-1 flex flex-col h-full overflow-hidden">
    
    {{-- عرض رسائل النجاح --}}
    @if(session('success'))
        <div class="mb-4 bg-emerald-50 text-emerald-600 px-4 py-3 rounded-xl border border-emerald-100 flex items-center gap-2">
            <i data-lucide="check-circle" class="w-5 h-5"></i>
            {{ session('success') }}
        </div>
    @endif

    {{-- عرض الأخطاء --}}
    @if($errors->any())
        <div class="mb-4 bg-red-50 text-red-600 px-4 py-3 rounded-xl border border-red-100">
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="mb-6 flex justify-between items-end flex-shrink-0">
        <div>
            <h1 class="text-3xl font-bold text-slate-800">{{ __('strings.roles_permissions') ?? 'الأدوار والصلاحيات' }}</h1>
            <p class="text-slate-500 mt-1">{{ __('strings.roles_desc') ?? 'إدارة صلاحيات الوصول لكل دور في النظام' }}</p>
        </div>
        <button onclick="document.getElementById('addRoleModal').classList.remove('hidden')" class="flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2.5 rounded-xl text-sm font-bold shadow-lg shadow-indigo-200 transition transform active:scale-95">
            <i data-lucide="plus" class="w-4 h-4"></i> {{ __('strings.add_role') ?? 'إضافة دور جديد' }}
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8 flex-shrink-0">
        @foreach($roles as $role)
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 group hover:border-indigo-200 transition">
            <div class="flex justify-between items-start mb-2">
                <h3 class="font-bold text-slate-800">{{ $role->name }}</h3>
                @if($role->slug === 'admin')
                    <i data-lucide="lock" class="w-4 h-4 text-orange-500" title="System Role"></i>
                @endif
            </div>
            <p class="text-[10px] bg-slate-100 text-slate-500 px-2 py-1 rounded w-fit mb-3 font-mono">{{ $role->slug }}</p>
            <p class="text-xs text-slate-400">{{ $role->permissions->count() }} {{ __('strings.active_permissions') ?? 'صلاحية مفعلة' }}</p>
        </div>
        @endforeach
    </div>

    <form action="{{ route('admin.roles.update') }}" method="POST" class="bg-white rounded-[2rem] shadow-sm border border-slate-100 flex-1 overflow-hidden flex flex-col min-h-0">
        @csrf
        
        <div class="p-6 border-b border-slate-100 flex-shrink-0 bg-white">
            <h3 class="font-bold text-slate-800">{{ __('strings.permissions_matrix') ?? 'مصفوفة التحكم' }}</h3>
        </div>
        
        <div class="overflow-auto custom-scroll flex-1 relative">
            <table class="w-full text-left rtl:text-right border-collapse">
                <thead class="bg-slate-50/90 sticky top-0 z-10 backdrop-blur-sm shadow-sm">
                    <tr>
                        <th class="py-4 pl-8 rtl:pr-8 font-bold w-1/3 text-xs text-slate-500 uppercase">
                            {{ __('strings.permission') ?? 'الصلاحية' }}
                        </th>
                        @foreach($roles as $role)
                        <th class="py-4 font-bold text-center min-w-[100px] text-xs text-slate-500 uppercase">{{ $role->name }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="text-sm text-slate-600 divide-y divide-slate-50">
                    
                    @foreach($permissionsGroups as $groupName => $permissions)
                        <tr class="bg-slate-50">
                            <td colspan="{{ count($roles) + 1 }}" class="py-2 px-8 font-bold text-xs text-indigo-600 uppercase tracking-wider">
                                {{ __('permissions.' . $groupName) ?? $groupName }}
                            </td>
                        </tr>

                        @foreach($permissions as $perm)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="py-3 pl-8 rtl:pr-8 font-medium text-slate-700">
                                {{ __('permissions.' . $perm->slug) ?? $perm->name }}
                                <div class="text-[10px] text-slate-400 font-mono">{{ $perm->slug }}</div>
                            </td>
                            
                            @foreach($roles as $role)
                            <td class="py-3 text-center">
                                {{-- Checkbox --}}
                                <input type="checkbox" 
                                       name="matrix[{{ $role->id }}][{{ $perm->id }}]" 
                                       class="accent-indigo-600 w-5 h-5 cursor-pointer rounded transition transform hover:scale-110"
                                       {{ $role->permissions->contains($perm->id) ? 'checked' : '' }}
                                       {{ $role->slug === 'admin' ? 'disabled checked' : '' }}
                                >
                            </td>
                            @endforeach
                        </tr>
                        @endforeach
                    @endforeach

                </tbody>
            </table>
        </div>
        
        <div class="p-4 border-t border-slate-100 flex justify-end gap-3 bg-white flex-shrink-0 rounded-b-[2rem]">
            <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-xl text-sm font-bold hover:bg-indigo-700 shadow-lg shadow-indigo-200 transition">
                {{ __('strings.save_changes') ?? 'حفظ التغييرات' }}
            </button>
        </div>
    </form>
</div>

{{-- إضافة دور جديد --}}
<div id="addRoleModal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm transition-opacity"></div>
    
    <div class="flex min-h-full items-center justify-center p-4">
        <div class="relative transform overflow-hidden rounded-2xl bg-white text-left rtl:text-right shadow-xl transition-all sm:w-full sm:max-w-md p-6">
            
            <div class="flex justify-between items-center mb-5">
                <h3 class="text-lg font-bold text-slate-900">{{ __('strings.add_new_role') ?? 'إضافة دور جديد' }}</h3>
                <button type="button" onclick="document.getElementById('addRoleModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 transition">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <form action="{{ route('admin.roles.store') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">{{ __('strings.role_name') ?? 'الاسم الظاهر (Display Name)' }}</label>
                        <input type="text" name="name" required placeholder="مثال: مدير الدعم الفني" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">{{ __('strings.role_slug') ?? 'المعرف البرمجي (Slug)' }}</label>
                        <input type="text" name="slug" required placeholder="example: support_manager" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-indigo-500/20">
                        <p class="text-[10px] text-slate-400 mt-1">يجب أن يكون بالإنجليزية وبدون مسافات.</p>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">{{ __('strings.description') ?? 'الوصف' }}</label>
                        <textarea name="description" rows="2" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20"></textarea>
                    </div>
                </div>
                <div class="mt-6 flex justify-end gap-2">
                    <button type="button" onclick="document.getElementById('addRoleModal').classList.add('hidden')" class="px-4 py-2 bg-slate-100 text-slate-600 rounded-xl text-sm font-bold hover:bg-slate-200 transition">
                        {{ __('strings.cancel') ?? 'إلغاء' }}
                    </button>
                    <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-xl text-sm font-bold hover:bg-indigo-700 shadow-lg shadow-indigo-200 transition">
                        {{ __('strings.save') ?? 'حفظ' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection