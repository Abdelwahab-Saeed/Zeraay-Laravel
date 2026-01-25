@extends('admin.layouts.app')

@section('title', 'لوحة التحكم')

@section('content')
<div class="row">
    <div class="col-12">
        <h2 class="mb-4">مرحباً بك، {{ Auth::user()->name }}</h2>
    </div>
</div>

<div class="row g-4">
    <!-- Categories Card -->
    <div class="col-md-4">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">الفئات</h6>
                        <h2 class="mb-0">{{ \App\Models\Category::count() }}</h2>
                    </div>
                    <div>
                        <i class="fas fa-folder fa-3x opacity-50"></i>
                    </div>
                </div>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-light btn-sm mt-3">
                    عرض الكل <i class="fas fa-arrow-left ms-2"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Products Card -->
    <div class="col-md-4">
        <div class="card text-white bg-success">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">المنتجات</h6>
                        <h2 class="mb-0">{{ \App\Models\Product::count() }}</h2>
                    </div>
                    <div>
                        <i class="fas fa-box fa-3x opacity-50"></i>
                    </div>
                </div>
                <a href="{{ route('admin.products.index') }}" class="btn btn-light btn-sm mt-3">
                    عرض الكل <i class="fas fa-arrow-left ms-2"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Users Card -->
    <div class="col-md-4">
        <div class="card text-white bg-info">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">المستخدمون</h6>
                        <h2 class="mb-0">{{ \App\Models\User::count() }}</h2>
                    </div>
                    <div>
                        <i class="fas fa-users fa-3x opacity-50"></i>
                    </div>
                </div>
                <a href="{{ route('admin.users.index') }}" class="btn btn-light btn-sm mt-3">
                    عرض الكل <i class="fas fa-arrow-left ms-2"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">آخر المنتجات</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>الاسم</th>
                                <th>الفئة</th>
                                <th>السعر</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse(\App\Models\Product::with('category')->latest()->take(5)->get() as $product)
                                <tr>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->category->name }}</td>
                                    <td>{{ number_format((float)$product->price, 2) }} ج.م</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">لا توجد منتجات</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">آخر المستخدمين</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>الاسم</th>
                                <th>البريد الإلكتروني</th>
                                <th>الدور</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse(\App\Models\User::latest()->take(5)->get() as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if($user->role === 'admin')
                                            <span class="badge bg-danger">مدير</span>
                                        @else
                                            <span class="badge bg-secondary">مستخدم</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">لا يوجد مستخدمين</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
