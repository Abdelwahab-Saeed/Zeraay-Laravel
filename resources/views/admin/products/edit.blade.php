@extends('admin.layouts.app')

@section('title', 'تعديل المنتج')

@section('content')
<div class="max-w-5xl mx-auto animate-fade-in">
    <div class="mb-8">
        <a href="{{ route('admin.products.index') }}" class="text-slate-500 hover:text-primary-start transition-colors mb-4 inline-flex items-center text-sm font-medium">
            <i class="fas fa-arrow-right ml-2 text-xs"></i> العودة للمنتجات
        </a>
        <h2 class="text-3xl font-bold text-slate-800">تعديل المنتج: {{ $product->name }}</h2>
        <p class="text-slate-500 mt-1">قم بتعديل البيانات المطلوبة للمنتج أدناه.</p>
    </div>

    <form action="{{ route('admin.products.update', $product) }}" method="POST" novalidate enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Basic Info Card -->
                <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8">
                    <h3 class="text-lg font-bold text-slate-800 mb-6 flex items-center">
                        <i class="fas fa-info-circle ml-3 text-primary-start"></i> المعلومات الأساسية
                    </h3>
                    
                    <div class="space-y-6">
                        <div>
                            <label for="name" class="block text-sm font-bold text-slate-700 mb-2">اسم المنتج <span class="text-rose-500">*</span></label>
                            <input type="text" 
                                   class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-primary-start focus:ring-4 focus:ring-primary-start/10 transition-all-300 outline-none @error('name') border-rose-500 ring-rose-500/10 @enderror" 
                                   id="name" name="name" value="{{ old('name', $product->name) }}">
                            @error('name')
                                <p class="mt-1 text-xs text-rose-500 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-bold text-slate-700 mb-2">الوصف <span class="text-rose-500">*</span></label>
                            <textarea class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-primary-start focus:ring-4 focus:ring-primary-start/10 transition-all-300 outline-none @error('description') border-rose-500 ring-rose-500/10 @enderror" 
                                      id="description" name="description" rows="6">{{ old('description', $product->description) }}</textarea>
                            @error('description')
                                <p class="mt-1 text-xs text-rose-500 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Pricing & Stock Card -->
                <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8">
                    <h3 class="text-lg font-bold text-slate-800 mb-6 flex items-center">
                        <i class="fas fa-tags ml-3 text-emerald-500"></i> التسعير والمخزون
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label for="price" class="block text-sm font-bold text-slate-700 mb-2">السعر <span class="text-rose-500">*</span></label>
                            <div class="relative">
                                <input type="number" step="0.01" 
                                       class="w-full pl-12 pr-4 py-3 rounded-xl border border-slate-200 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition-all-300 outline-none @error('price') border-rose-500 ring-rose-500/10 @enderror" 
                                       id="price" name="price" value="{{ old('price', $product->price) }}">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold text-xs uppercase">ج.م</span>
                            </div>
                            @error('price')
                                <p class="mt-1 text-xs text-rose-500 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="discount_price" class="block text-sm font-bold text-slate-700 mb-2">سعر الخصم</label>
                            <div class="relative">
                                <input type="number" step="0.01" 
                                       class="w-full pl-12 pr-4 py-3 rounded-xl border border-slate-200 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition-all-300 outline-none @error('discount_price') border-rose-500 ring-rose-500/10 @enderror" 
                                       id="discount_price" name="discount_price" value="{{ old('discount_price', $product->discount_price) }}">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold text-xs uppercase">ج.م</span>
                            </div>
                            @error('discount_price')
                                <p class="mt-1 text-xs text-rose-500 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="stock" class="block text-sm font-bold text-slate-700 mb-2">الكمية <span class="text-rose-500">*</span></label>
                            <input type="number" 
                                   class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition-all-300 outline-none @error('stock') border-rose-500 ring-rose-500/10 @enderror" 
                                   id="stock" name="stock" value="{{ old('stock', $product->stock) }}">
                            @error('stock')
                                <p class="mt-1 text-xs text-rose-500 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar Info -->
            <div class="space-y-8">
                <!-- Status & Category Card -->
                <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8">
                    <h3 class="text-lg font-bold text-slate-800 mb-6">التنظيم</h3>
                    
                    <div class="space-y-6">
                        <div>
                            <label for="category_id" class="block text-sm font-bold text-slate-700 mb-2">الفئة <span class="text-rose-500">*</span></label>
                            <select class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-primary-start focus:ring-4 focus:ring-primary-start/10 transition-all-300 outline-none @error('category_id') border-rose-500 ring-rose-500/10 @enderror bg-white cursor-pointer appearance-none" 
                                    id="category_id" name="category_id">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="mt-1 text-xs text-rose-500 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="company_id" class="block text-sm font-bold text-slate-700 mb-2">الشركة <span class="text-rose-500">*</span></label>
                            <select class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-primary-start focus:ring-4 focus:ring-primary-start/10 transition-all-300 outline-none @error('company_id') border-rose-500 ring-rose-500/10 @enderror bg-white cursor-pointer appearance-none" 
                                    id="company_id" name="company_id">
                                <option value="">اختر الشركة</option>
                                @foreach($companies as $company)
                                    <option value="{{ $company->id }}" {{ old('company_id', $product->company_id) == $company->id ? 'selected' : '' }}>
                                        {{ $company->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('company_id')
                                <p class="mt-1 text-xs text-rose-500 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center">
                            <label class="relative inline-flex items-center cursor-pointer group">
                                <input type="checkbox" id="status" name="status" value="1" class="sr-only peer" {{ old('status', $product->status) ? 'checked' : '' }}>
                                <div class="w-12 h-6 bg-slate-200 peer-focus:ring-4 peer-focus:ring-emerald-500/20 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:right-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500"></div>
                                <span class="mr-3 text-sm font-bold text-slate-700">نشط</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Media Card -->
                <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8">
                    <h3 class="text-lg font-bold text-slate-800 mb-6">الوسائط</h3>
                    <div class="space-y-6">
                        @if($product->image)
                            <div class="relative group">
                                <div class="w-full aspect-square rounded-2xl overflow-hidden shadow-lg ring-4 ring-slate-50 group-hover:ring-primary-start transition-all">
                                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                </div>
                                <div class="absolute -top-2 -right-2 bg-emerald-500 text-white p-1 rounded-full shadow-lg border-2 border-white">
                                    <i class="fas fa-check text-[10px]"></i>
                                </div>
                                <p class="text-[10px] text-center text-slate-400 mt-2 font-bold uppercase tracking-wider">الصورة الحالية</p>
                            </div>
                        @endif

                        <div class="relative group">
                            <input type="file" 
                                   class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" 
                                   id="image" name="image" accept="image/*"
                                   onchange="document.getElementById('fileName').textContent = this.files[0].name">
                            <div class="w-full px-4 py-8 rounded-2xl border-2 border-dashed border-slate-200 group-hover:border-primary-start/30 transition-all-300 bg-slate-50/50 text-center">
                                <i class="fas fa-cloud-upload-alt text-2xl text-slate-300 group-hover:text-primary-start transition-all-300 mb-2"></i>
                                <p class="text-xs text-slate-500 font-medium" id="fileName">تغيير الصورة الرئيسية</p>
                            </div>
                        </div>
                        @error('image')
                            <p class="mt-1 text-xs text-rose-500 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Action Card -->
                <div class="bg-slate-900 rounded-3xl shadow-lg p-8 text-white">
                    <p class="text-sm text-slate-400 mb-6 text-center leading-relaxed">تأكد من مراجعة كافة البيانات قبل عملية تحديث المنتج.</p>
                    <div class="space-y-4">
                        <button type="submit" class="w-full py-4 bg-primary-start hover:bg-primary-end text-white font-bold rounded-2xl shadow-lg hover:shadow-primary-start/30 transition-all-300 flex justify-center items-center">
                            <i class="fas fa-save ml-2"></i> تحديث المنتج
                        </button>
                        <a href="{{ route('admin.products.index') }}" class="w-full py-4 bg-white/10 hover:bg-white/20 text-white font-bold rounded-2xl transition-all-300 text-center block">
                            إلغاء
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
