@extends('admin.layouts.app')

@section('title', 'إضافة منتج جديد')

@section('content')
<div class="max-w-5xl mx-auto animate-fade-in">
    <div class="mb-8">
        <a href="{{ route('admin.products.index') }}" class="text-slate-500 hover:text-primary-start transition-colors mb-4 inline-flex items-center text-sm font-medium">
            <i class="fas fa-arrow-right ml-2 text-xs"></i> العودة للمنتجات
        </a>
        <h2 class="text-3xl font-bold text-slate-800">إضافة منتج جديد</h2>
        <p class="text-slate-500 mt-1">قم بتعبئة البيانات أدناه لإضافة منتج جديد لمتجرك.</p>
    </div>

    <form action="{{ route('admin.products.store') }}" method="POST" novalidate enctype="multipart/form-data"
          x-data="{ 
            features: @js(old('features', [])) ? @js(old('features', [])).map(f => ({name: f})) : [],
            specifications: @js(old('specifications', [])) ? @js(old('specifications', [])).map(s => ({name: s})) : [],
            addFeature() { this.features.push({name: ''}) },
            removeFeature(index) { this.features.splice(index, 1) },
            addSpecification() { this.specifications.push({name: ''}) },
            removeSpecification(index) { this.specifications.splice(index, 1) }
          }">
        @csrf

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
                                   id="name" name="name" value="{{ old('name') }}" placeholder="أدخل اسم المنتج">
                            @error('name')
                                <p class="mt-1 text-xs text-rose-500 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-bold text-slate-700 mb-2">الوصف <span class="text-rose-500">*</span></label>
                            <textarea class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-primary-start focus:ring-4 focus:ring-primary-start/10 transition-all-300 outline-none @error('description') border-rose-500 ring-rose-500/10 @enderror" 
                                      id="description" name="description" rows="6" placeholder="اكتب وصفاً تفصيلياً للمنتج...">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-xs text-rose-500 font-medium">{{ $message }}</p>
                            @enderror
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
                                       id="price" name="price" value="{{ old('price') }}" placeholder="0.00">
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
                                       id="discount_price" name="discount_price" value="{{ old('discount_price') }}" placeholder="0.00">
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
                                   id="stock" name="stock" value="{{ old('stock', 0) }}">
                            @error('stock')
                                <p class="mt-1 text-xs text-rose-500 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Features Card -->
                <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8">
                    <h3 class="text-lg font-bold text-slate-800 mb-6 flex items-center justify-between">
                        <span class="flex items-center">
                            <i class="fas fa-list-ul ml-3 text-blue-500"></i> مميزات المنتج
                        </span>
                        <button type="button" @click="addFeature()" class="text-sm bg-blue-50 text-blue-600 px-4 py-2 rounded-xl hover:bg-blue-100 transition-colors">
                            <i class="fas fa-plus ml-1"></i> إضافة ميزة
                        </button>
                    </h3>

                    <div id="features-container" class="space-y-4">
                        <template x-for="(feature, index) in features" :key="index">
                            <div class="flex flex-col gap-1">
                                <div class="flex gap-4 items-start animate-fade-in">
                                    <div class="flex-grow">
                                        <input type="text" :name="'features[' + index + ']'" x-model="feature.name"
                                               class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all-300 outline-none" 
                                               placeholder="أدخل ميزة المنتج">
                                    </div>
                                    <button type="button" @click="removeFeature(index)" class="p-3 text-rose-500 hover:bg-rose-50 rounded-xl transition-colors">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                                @error('features.*')
                                    <p class="text-xs text-rose-500 font-medium px-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </template>
                        @error('features')
                            <p class="text-xs text-rose-500 font-medium px-1">{{ $message }}</p>
                        @enderror
                        <div x-show="features.length === 0" class="text-center py-6 bg-slate-50 rounded-2xl border-2 border-dashed border-slate-100">
                            <p class="text-slate-400 text-sm">لم يتم إضافة أي مميزات بعد.</p>
                        </div>
                    </div>
                </div>

                <!-- Specifications Card -->
                <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8">
                    <h3 class="text-lg font-bold text-slate-800 mb-6 flex items-center justify-between">
                        <span class="flex items-center">
                            <i class="fas fa-cog ml-3 text-amber-500"></i> ميزات المواصفات
                        </span>
                        <button type="button" @click="addSpecification()" class="text-sm bg-amber-50 text-amber-600 px-4 py-2 rounded-xl hover:bg-amber-100 transition-colors">
                            <i class="fas fa-plus ml-1"></i> إضافة مواصفة
                        </button>
                    </h3>

                    <div id="specifications-container" class="space-y-4">
                        <template x-for="(spec, index) in specifications" :key="index">
                            <div class="flex flex-col gap-1">
                                <div class="flex gap-4 items-start animate-fade-in">
                                    <div class="flex-grow">
                                        <input type="text" :name="'specifications[' + index + ']'" x-model="spec.name"
                                               class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-amber-500 focus:ring-4 focus:ring-amber-500/10 transition-all-300 outline-none" 
                                               placeholder="أدخل مواصفة المنتج">
                                    </div>
                                    <button type="button" @click="removeSpecification(index)" class="p-3 text-rose-500 hover:bg-rose-50 rounded-xl transition-colors">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                                @error('specifications.*')
                                    <p class="text-xs text-rose-500 font-medium px-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </template>
                        @error('specifications')
                            <p class="text-xs text-rose-500 font-medium px-1">{{ $message }}</p>
                        @enderror
                        <div x-show="specifications.length === 0" class="text-center py-6 bg-slate-50 rounded-2xl border-2 border-dashed border-slate-100">
                            <p class="text-slate-400 text-sm">لم يتم إضافة أي مواصفات بعد.</p>
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
                                <option value="">اختر الفئة</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                                    <option value="{{ $company->id }}" {{ old('company_id') == $company->id ? 'selected' : '' }}>
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
                                <input type="checkbox" id="status" name="status" value="1" class="sr-only peer" {{ old('status', true) ? 'checked' : '' }}>
                                <div class="w-12 h-6 bg-slate-200 peer-focus:ring-4 peer-focus:ring-emerald-500/20 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:right-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500"></div>
                                <span class="mr-3 text-sm font-bold text-slate-700">نشط</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Media Card -->
                <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8">
                    <h3 class="text-lg font-bold text-slate-800 mb-6">الوسائط</h3>
                    <div>
                        <label for="image" class="block text-sm font-bold text-slate-700 mb-2 text-center">الصورة الرئيسية</label>
                        <div class="relative group">
                            <input type="file" 
                                   class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" 
                                   id="image" name="image" accept="image/*"
                                   onchange="document.getElementById('fileName').textContent = this.files[0].name">
                            <div class="w-full px-4 py-10 rounded-2xl border-2 border-dashed border-slate-200 group-hover:border-primary-start/30 transition-all-300 bg-slate-50/50 text-center">
                                <i class="fas fa-image text-4xl text-slate-300 group-hover:text-primary-start transition-all-300 mb-2"></i>
                                <p class="text-xs text-slate-500 font-medium leading-relaxed" id="fileName">اضغط للرفع أو اسحب الصورة هنا</p>
                            </div>
                        </div>
                        @error('image')
                            <p class="mt-1 text-xs text-rose-500 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Action Card -->
                <div class="bg-slate-900 rounded-3xl shadow-lg p-8 text-white">
                    <p class="text-sm text-slate-400 mb-6 text-center leading-relaxed">تأكد من مراجعة كافة البيانات قبل عملية الحفظ النهائي.</p>
                    <div class="space-y-4">
                        <button type="submit" class="w-full py-4 bg-primary-start hover:bg-primary-end text-white font-bold rounded-2xl shadow-lg hover:shadow-primary-start/30 transition-all-300 flex justify-center items-center">
                            <i class="fas fa-save ml-2"></i> حفظ المنتج
                        </button>
                        <a href="{{ route('admin.products.index') }}" class="w-full py-4 bg-white/10 hover:bg-white/20 text-white font-bold rounded-2xl transition-all-300 text-center block">
                            إلغاء التغييرات
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
