@extends('admin.layouts.master')
@section('title', '- Products')
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
            <h3>All Products</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li>
                    <a href="{{ route('admin.index') }}" class="color-dark">
                        <div class="text-tiny">Dashboard</div>
                    </a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <div class="text-tiny">All Products</div>
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
                <a class="tf-button style-1 w208" href="{{ route('admin.add.product') }}"><i
                        class="icon-plus"></i>Add new</a>
            </div>
            <div class="table-responsive">
                @if(Session::has('success'))
                    <p class="alert" style="font-size:18px; color:rgb(255, 255, 255); background: rgb(1, 181, 82)">{{ Session::get('success') }}</p>
                @endif
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>SalePrice</th>
                            <th>SKU</th>
                            <th>Category</th>
                            <th>Brand</th>
                            <th>Featured</th>
                            <th>Stock</th>
                            <th>Quantity</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $key => $product)
                        @csrf
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td class="pname">
                                <div class="image">
                                    <img src="{{ asset('uploads/products/' . $product->image) }}" alt="{{ $product->name }}" class="image">
                                </div>
                                <div class="name">
                                    <a href="#" class="body-title-2">{{ $product->name }}</a>
                                </div>
                            </td>
                            <td>{{ $product->price }}</td>
                            <td>{{ $product->cost }}</td>
                            <td>{{ $product->SKU }}</td>
                            <td>{{ $product->category_id }}</td>
                            <td>{{ $product->brand_id }}</td>
                            <td>{{ $product->featured }}</td>
                            <td>{{ $product->stock_status }}</td>
                            <td>{{ $product->quantity }}</td>
                            <th>
                                <div class="list-icon-function">
                                    <a href="{{ route('admin.edit.product', ['slug'=>$product->slug]) }}">
                                        <div class="item edit">
                                            <i class="fa-regular fa-pen-to-square"></i>
                                        </div>
                                    </a>
                                    <form action="{{ route('admin.delete.product', ['slug'=>$product->slug]) }}" method="POST">
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
                {{ $products->links('pagination::bootstrap-5') }}
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
