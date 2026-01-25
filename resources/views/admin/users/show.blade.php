@extends('admin.layouts.app')

@section('title', 'تفاصيل المستخدم')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4>تفاصيل المستخدم</h4>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-right me-2"></i> رجوع
                </a>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th style="width: 200px;">الاسم</th>
                            <td>{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <th>البريد الإلكتروني</th>
                            <td>{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <th>الهاتف</th>
                            <td>{{ $user->phone ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>المدينة</th>
                            <td>{{ $user->city ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>المحافظة</th>
                            <td>{{ $user->state ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>العنوان</th>
                            <td>{{ $user->address ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>كود المهندس</th>
                            <td>{{ $user->engineer_code ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>تاريخ التسجيل</th>
                            <td>{{ $user->created_at->format('Y-m-d H:i') }}</td>
                        </tr>
                        <tr>
                            <th>آخر تحديث</th>
                            <td>{{ $user->updated_at->format('Y-m-d H:i') }}</td>
                        </tr>
                    </tbody>
                </table>

                <div class="mt-3">
                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-2"></i> تعديل
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
