@extends('admin.layouts.master')
@section('title', '- Coupons')
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
            <h3>Coupons Information</h3>
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
                    <div class="text-tiny">Coupons</div>
                </li>
            </ul>
        </div>

        <div class="wg-box">
            <div class="flex items-center justify-between gap10 flex-wrap">
                <div class="wg-filter flex-grow">
                    <form class="form-search">
                        <fieldset class="name">
                            <input type="text" placeholder="Search here..." name="name" value="" required>
                        </fieldset>
                        <div class="button-submit">
                            <button type="submit"><i class="icon-search"></i></button>
                        </div>
                    </form>
                </div>
                <a class="tf-button style-1 w208" href="{{ route('admin.coupon.add-coupon') }}">
                    <i class="icon-plus"></i>Add new
                </a>
            </div>

            <div class="wg-table table-all-user">
                <div class="table-responsive">
                    @if(Session::has('success'))
                        <p class="alert" style="font-size: 18px; background:rgb(2, 159, 67); color: white;">{{ Session::get('success') }}</p>
                    @endif
                    @if(Session::has('message'))
                        <p class="alert alert-danger" style="font-size: 18px; background:rgba(242, 1, 69, 0.926); color: white">{{ Session::get('message') }}</p>
                    @endif
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Code</th>
                                <th>Type</th>
                                <th>Value</th>
                                <th>Cart Value</th>
                                <th>Expiry Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($coupons as $key => $coupon)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $coupon->code }}</td>
                                <td>{{ $coupon->type }}</td>
                                <td>{{ $coupon->value }}</td>
                                <td>{{ $coupon->cart_value }}</td>
                                <td>{{ $coupon->expiry_date }}</td>
                                <td>
                                    <div class="list-icon-function">
                                        <a href="{{ route('admin.coupon.edit', ['id' => $coupon->id]) }}">
                                            <div class="item edit">
                                                <i class="fa-regular fa-pen-to-square"></i>
                                            </div>
                                        </a>
                                        <form action="{{ route('admin.coupon.delete', $coupon->id) }}" method="POST">
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

            <div class="divider"></div>
            <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                {{ $coupons->links('pagination::bootstrap-5') }}
            </div>
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
