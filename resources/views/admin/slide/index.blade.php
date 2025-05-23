@extends('admin.layouts.master')
@section('title', '- Sliders')
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
                    <div class="text-tiny">Sliders</div>
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
                <a class="tf-button style-1 w208" href="{{ route('admin.slide.create') }}">
                    <i class="icon-plus"></i>Add new
                </a>
            </div>
            <div class="wg-table table-all-user">
                @if(Session::has('success'))
                    <div class="alert alert-success" style="font-size: 18px; color:green;">{{ Session::get('success') }}</div>
                 @endif
                <table class="table table-striped table-bordered table-responsive">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Tagline</th>
                            <th>Title</th>
                            <th>Subtitle</th>
                            <th>Link</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($slides as $key => $slide)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td class="pname">
                                <div class="image">
                                    <img src="{{ asset('uploads/slides') }}/{{ $slide->image }}" alt="" class="image">
                                </div>
                            </td>
                            <td>{{ $slide->tagline }}</td>
                            <td>{{ $slide->title }}</td>
                            <td>{{ $slide->subtitle }}</td>
                            <td>{{ $slide->link }}</td>
                            <th>
                                <div class="list-icon-function">
                                    <a href="{{ route('admin.slide.edit', $slide->id) }}">
                                        <div class="item edit">
                                            <i class="fa-regular fa-pen-to-square"></i>
                                        </div>
                                    </a>
                                    <form action="{{ route('admin.slide.delete', $slide->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <div class="item text-danger delete">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </div>
                                    </form>
                                </div>
                            </th>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="divider"></div>
            <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                {{ $slides->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection

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
