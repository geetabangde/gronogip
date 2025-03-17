@extends('admin.layouts.app')

@section('content')
<div class="page-content">
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0 font-size-18">Products Redeem </h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                                        <li class="breadcrumb-item active">Products Redeem</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex justify-content-end mb-3">
                                <button class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#addProductModal">Add Products Redeem</button>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <table id="datatable" class="table table-bordered text-center">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Image</th>
                                                <th>Products Redeem Name</th>
                                                <!-- <th>Category</th> -->
                                                <th> Products Redeem Coins (₹)</th>
                                                <th>Products Redeem  Description</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody id="productBody">
                                                @foreach($products as $product)
                                                    <tr>
                                                        <td>{{ $product->id }}</td>
                                                        <td><img src="{{ asset('storage/'.$product->redeem_product_image) }}" alt="Product Image" class="img-thumbnail" width="50"></td>
                                                        <td>{{ $product->redeem_product_name }}</td>
                                                        
                                                        <td>{{ $product->redeem_product_coins }}/kg</td>
                                                        <td>{{ $product->redeem_product_description }}</td>
                                                        <td>
                                                        <!-- data-category-id="{{ $product->category_id }}" -->
                                                        <button class="btn btn-warning btn-sm editBtn"
                                                            data-id="{{ $product->id }}"
                                                            data-redeem_product_name="{{ $product->redeem_product_name }}"
                                                            data-category-id="{{ $product->category_id }}"
                                                            data-redeem_product_coins="{{ $product->redeem_product_coins }}"
                                                            data-redeem_product_description="{{ $product->redeem_product_description }}">
                                                            Edit
                                                        </button>

                                                            <button class="btn btn-danger btn-sm deleteBtn" data-id="{{ $product->id }}">Delete</button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Add Product Modal -->
                    <!-- Add Product Modal -->
                        <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="addProductLabel">Add Redeem Product</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="text" class="form-control mb-2" id="productName" placeholder="Enter product name">
                                        
                                        <input type="number" class="form-control mb-2" id="productPrice" placeholder="Enter price per kg">
                                        <textarea class="form-control mb-2" id="productDescription" placeholder="Enter product description"></textarea>
                                        <input type="file" class="form-control" id="productImage">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-success" id="saveProduct">Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Edit Product Modal -->
                            <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editProductLabel">Edit Redeem Product</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" id="editProductId">
                                            <input type="text" class="form-control mb-2" id="editProductName" placeholder="Enter product name">
                                            
                                            <input type="number" class="form-control mb-2" id="editProductPrice" placeholder="Enter price per kg">
                                            <textarea class="form-control mb-2" id="editProductDescription" placeholder="Enter product description"></textarea>
                                            <input type="file" class="form-control" id="editProductImage">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-success" id="updateProduct">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
$(document).ready(function () {
    let deleteProductId = null;
    
    // ✅ Add Product (AJAX)
    $("#saveProduct").click(function () {
        let formData = new FormData();
        formData.append('redeem_product_name', $("#productName").val());
        formData.append('category_id', $("#categorySelect").val());
        formData.append('redeem_product_coins', $("#productPrice").val());
        formData.append('redeem_product_description', $("#productDescription").val());
        formData.append('redeem_product_image', $("#productImage")[0].files[0]);

        $.ajax({
            url: "{{ route('admin.redeem.store') }}",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" },
            success: function (response) {
                alert("Redeem Product Added Successfully!");
                location.reload();
            },
            error: function (xhr) {
                alert("Error: " + xhr.responseJSON.message);
            }
        });
    });

    // ✅ Edit Product - Show Data in Modal
   // ✅ Edit Product - Show Data in Modal
   $(".editBtn").click(function () {
    let id = $(this).data("id");
    let redeem_product_name = $(this).data("redeem_product_name");
    let categoryId = $(this).data("category-id");
    let redeem_product_coins = $(this).data("redeem_product_coins");
    let redeem_product_description = $(this).data("redeem_product_description");

    console.log("Editing Product ID:", id); // Debugging के लिए

    $("#editProductId").val(id);
    $("#editProductName").val(redeem_product_name);
    $("#editCategorySelect").val(categoryId);
    $("#editProductPrice").val(redeem_product_coins);
    $("#editProductDescription").val(redeem_product_description);

    $("#editProductModal").modal("show");
});



    // ✅ Update Product (AJAX)
    $("#updateProduct").click(function () {
        let id = $("#editProductId").val();
        let formData = new FormData();
        formData.append('redeem_product_name', $("#editProductName").val());
        formData.append('category_id', $("#editCategorySelect").val());
        formData.append('redeem_product_coins', $("#editProductPrice").val());
        formData.append('redeem_product_description', $("#editProductDescription").val());
        if ($("#editProductImage")[0].files[0]) {
            formData.append('redeem_product_image', $("#editProductImage")[0].files[0]);
        }

        $.ajax({
            url: "{{ route('admin.redeem.update', '') }}/" + id, // ✅ Correct Laravel route
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" },
            success: function (response) {
                alert("Redeem Product Updated Successfully!");
                location.reload();
            },
            error: function (xhr) {
                alert("Error: " + xhr.responseJSON.message);
            }
        });
    });

    // ✅ Delete Product (AJAX)
    $(".deleteBtn").click(function () {
        deleteProductId = $(this).closest("tr").find("td:eq(0)").text();
        if (confirm("Are you sure you want to delete this product?")) {
            $.ajax({
                url: "/admin/redeem/delete/" + deleteProductId,
                type: "DELETE",
                headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" },
                success: function (response) {
                    alert("Redeem Product Deleted Successfully!");
                    location.reload();
                },
                error: function (xhr) {
                    alert("Error: " + xhr.responseJSON.message);
                }
            });
        }
    });
});
</script>
@endsection
