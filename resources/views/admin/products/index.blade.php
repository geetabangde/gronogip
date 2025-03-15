@extends('admin.layouts.app')

@section('content')
<div class="page-content">
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0 font-size-18">Products for Sale </h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                                        <li class="breadcrumb-item active">Products for Sale</li>
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
                                    data-bs-target="#addProductModal">Add Product</button>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <table id="datatable" class="table table-bordered text-center">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Image</th>
                                                <th>Product Name</th>
                                                <!-- <th>Category</th> -->
                                                <th>Price (₹)</th>
                                                <th>Description</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody id="productBody">
                                                @foreach($products as $product)
                                                    <tr>
                                                        <td>{{ $product->id }}</td>
                                                        <td><img src="{{ asset('storage/'.$product->image) }}" alt="Product Image" class="img-thumbnail" width="50"></td>
                                                        <td>{{ $product->product_name }}</td>
                                                        <!-- <td>{{ $product->category ? $product->category->name : 'No Category' }}</td> -->
                                                        <td>{{ $product->price }}/kg</td>
                                                        <td>{{ $product->description }}</td>
                                                        <td>
                                                        <!-- data-category-id="{{ $product->category_id }}" -->
                                                            <button class="btn btn-warning btn-sm editBtn" data-id="{{ $product->id }}" 
                                                                    data-name="{{ $product->product_name }}" 
                                                                     
                                                                    data-price="{{ $product->price }}" 
                                                                    data-description="{{ $product->description }}" 
                                                                    data-image="{{ asset('storage/'.$product->image) }}">
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
                                        <h5 class="modal-title" id="addProductLabel">Add Product</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="text" class="form-control mb-2" id="productName" placeholder="Enter product name">
                                        <!-- <select class="form-control mb-2" id="categorySelect">
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select> -->
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
                                            <h5 class="modal-title" id="editProductLabel">Edit Product</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" id="editProductId">
                                            <input type="text" class="form-control mb-2" id="editProductName" placeholder="Enter product name">
                                            <!-- <select class="form-control mb-2" id="editCategorySelect">
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select> -->
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
document.getElementById('editSubcategoryImage').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('previewImage');
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
});
</script>
<script>
$(document).ready(function () {
    let deleteProductId = null;
    
    // ✅ Add Product (AJAX)
    $("#saveProduct").click(function () {
        let formData = new FormData();
        formData.append('product_name', $("#productName").val());
        formData.append('category_id', $("#categorySelect").val());
        formData.append('price', $("#productPrice").val());
        formData.append('description', $("#productDescription").val());
        formData.append('image', $("#productImage")[0].files[0]);

        $.ajax({
            url: "{{ route('admin.products.store') }}",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" },
            success: function (response) {
                alert("Product Added Successfully!");
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
    let row = $(this).closest("tr");
    let id = $(this).data("id");
    let product_name = $(this).data("product_name");
    let categoryId = $(this).data("category-id"); // ✅ Correct category data
    let price = $(this).data("price"); // ✅ Directly from button dataset
    let description = $(this).data("description");

    $("#editProductId").val(id);
    $("#editProductName").val(product_name);
    $("#editCategorySelect").val(categoryId); // ✅ Set category correctly
    $("#editProductPrice").val(price);
    $("#editProductDescription").val(description);
    $("#editProductModal").modal("show");
});


    // ✅ Update Product (AJAX)
    $("#updateProduct").click(function () {
        let id = $("#editProductId").val();
        let formData = new FormData();
        formData.append('product_name', $("#editProductName").val());
        formData.append('category_id', $("#editCategorySelect").val());
        formData.append('price', $("#editProductPrice").val());
        formData.append('description', $("#editProductDescription").val());
        if ($("#editProductImage")[0].files[0]) {
            formData.append('image', $("#editProductImage")[0].files[0]);
        }

        $.ajax({
            url: "{{ route('admin.products.update', '') }}/" + id, // ✅ Correct Laravel route
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" },
            success: function (response) {
                alert("Product Updated Successfully!");
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
                url: "/admin/products/delete/" + deleteProductId,
                type: "DELETE",
                headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" },
                success: function (response) {
                    alert("Product Deleted Successfully!");
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
