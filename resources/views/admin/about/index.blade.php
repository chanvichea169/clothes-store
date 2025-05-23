@extends('admin.layouts.master')
@section('title', 'About')
@section('content')
<style>
    .swal2-confirm.btn-lg,
    .swal2-cancel.btn-lg {
        font-size: 14px;
        padding: 10px 20px;
        border-radius: 5px;
    }
    td, tr{
        font-size: 14px;
    }
</style>
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Slider</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li>
                    <a href="{{ route('admin.index') }}">
                        <div class="text-tiny">Dashboard</div>
                    </a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <div class="text-tiny">About</div>
                </li>
            </ul>
        </div>
        <div class="wg-box">
            <div class="flex items-center justify-between gap10 flex-wrap">
                <div class="wg-filter flex-grow">
                    <form class="form-search">
                        <fieldset class="name">
                            <input type="text" placeholder="Search here..." class="" name="name"
                                tabindex="2" value="" aria-required="true" required="">
                        </fieldset>
                        <div class="button-submit">
                            <button class="" type="submit"><i class="icon-search"></i></button>
                        </div>
                    </form>
                </div>
                <a class="tf-button style-1 w208" href="{{ route('admin.about.create') }}">
                    <i class="icon-plus"></i>Add new
                </a>
            </div>
            @if(Session::has('success'))
                <div class="alert" style="font-size: 18px; color:rgb(242, 242, 242); background-color: rgb(7, 179, 70);">
                    {{ Session::get('success') }}
                </div>
            @endif
            @if(Session::has('message'))
                <div class="alert" style="font-size: 18px; color:rgb(242, 242, 242); background-color: rgb(210, 45, 58);">
                    {{ Session::get('message') }}
                </div>
            @endif

            @if($abouts->isEmpty())
                <div class="alert alert-info">
                    No about entries found. Create your first one!
                </div>
            @else
                <div class="wg-table table-all-user">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Mission</th>
                                    <th>Vision</th>
                                    <th>Company Info</th>
                                    <th>Image</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($abouts as $key => $about)
                                <tr>
                                    <td>{{ $abouts->firstItem() + $key }}</td>
                                    <td>{{ Str::limit($about->title, 30) }}</td>
                                    <td>{{ Str::limit($about->description, 50) }}</td>
                                    <td>{{ $about->mission ? Str::limit($about->mission, 50) : 'N/A' }}</td>
                                    <td>{{ $about->vision ? Str::limit($about->vision, 50) : 'N/A' }}</td>
                                    <td>{{ $about->company_infor ? Str::limit($about->company_infor, 50) : 'N/A' }}</td>
                                    <td>
                                        @if($about->image && file_exists(public_path('uploads/abouts/'.$about->image)))
                                            <img src="{{ asset('uploads/abouts/'.$about->image) }}" alt="About Image" width="50" class="img-thumbnail">
                                        @else
                                            <div class="no-image-placeholder" style="width:50px; height:50px; background:#eee; display:flex; align-items:center; justify-content:center;">
                                                <i class="icon-image" style="font-size:20px; color:#999;"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="action-buttons">
                                        <div class="list-icon-function">
                                            <a href="{{ route('admin.about.edit', $about->id) }}">
                                                <div class="item edit">
                                                    <i class="fa-regular fa-pen-to-square"></i>
                                                </div>
                                            </a>
                                            <form action="{{ route('admin.about.destroy', $about->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <div class="item text-danger delete">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </div>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mt-4">
                    {{ $abouts->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        $('.delete').on('click', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Are you sure?',
                text: 'You want to delete this record?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Delete',
                cancelButtonText: 'Cancel',
                customClass: {
                    confirmButton: 'btn-lg',
                    cancelButton: 'btn-lg'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $(this).closest('form').submit();
                }
            });
        });
    });
</script>
@endpush
@endsection
