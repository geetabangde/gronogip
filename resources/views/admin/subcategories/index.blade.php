@extends('admin.layouts.app')

@section('content')
<div class="page-content">
    <div class="container-fluid">

        <!-- Page Title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Product Management</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Product</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Subcategory Button -->
        <div class="d-flex justify-content-end mb-3">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSubcategoryModal">
                Add Product
            </button>
        </div>

        <!-- Subcategory Table -->
        <div class="card">
            <div class="card-body">
                <table id="datatable" class="table table-bordered text-center">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($subcategories as $subcategory)
                        <tr>
                            <td><img src="{{ asset('storage/' . $subcategory->image) }}" class="img-thumbnail" width="50"></td>
                            <td>{{ $subcategory->name }}</td>
                            <td>{{ $subcategory->category->name }}</td>
                            <td>
                                <button class="btn btn-warning btn-sm editBtn" data-id="{{ $subcategory->id }}" data-name="{{ $subcategory->name }}" data-category-id="{{ $subcategory->category_id }}">Edit</button>
                                <button class="btn btn-danger btn-sm deleteBtn" data-id="{{ $subcategory->id }}">Delete</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Add Subcategory Modal -->
        <div class="modal fade" id="addSubcategoryModal" tabindex="-1" aria-labelledby="addSubcategoryLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addSubcategoryLabel">Add Product</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addSubcategoryForm">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Product Name</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Category</label>
                                <select class="form-control" name="category_id" required>
                                    @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Product Image</label>
                                <input type="file" class="form-control" name="image">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Add Product</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Subcategory Modal -->
        <div class="modal fade" id="editSubcategoryModal" tabindex="-1" aria-labelledby="editSubcategoryLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editSubcategoryLabel">Edit Product</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editSubcategoryForm">
                            @csrf
                            <input type="hidden" id="editSubcategoryId">
                            <div class="mb-3">
                                <label class="form-label">Product Name</label>
                                <input type="text" class="form-control" id="editSubcategoryName" name="name" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Category</label>
                                <select class="form-control" id="editCategoryId" name="category_id">
                                    @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Product Image</label>
                                <input type="file" class="form-control" id="editSubcategoryImage" name="image" accept="image/*">
                                <img id="previewImage" src="" alt="Preview Image" class="mt-2" style="max-width: 100px; display: none;">
                            </div>


                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Update Product</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Subcategory Modal -->
        <div class="modal fade" id="deleteSubcategoryModal" tabindex="-1" aria-labelledby="deleteSubcategoryLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Delete Product</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this Product?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

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
    let deleteId = null;

    // Add Subcategory
    $("#addSubcategoryForm").submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: "{{ route('admin.subcategories.store') }}",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function () {
                location.reload();
            }
        });
    });

    // Edit Subcategory
    $(".editBtn").click(function () {
        let id = $(this).data("id");
        let name = $(this).data("name");
        let categoryId = $(this).data("category-id");

        $("#editSubcategoryId").val(id);
        $("#editSubcategoryName").val(name);
        $("#editCategoryId").val(categoryId);
        $("#editSubcategoryModal").modal("show");
    });

    $("#editSubcategoryForm").submit(function (e) {
        e.preventDefault();
        let id = $("#editSubcategoryId").val();
        $.ajax({
            url: "/admin/subcategories/update/" + id,
            type: "POST",
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function () {
                location.reload();
            }
        });
    });

    // Delete Subcategory
    $(".deleteBtn").click(function () {
        deleteId = $(this).data("id");
        $("#deleteSubcategoryModal").modal("show");
    });

    $("#confirmDelete").click(function () {
        $.ajax({
            url: "/admin/subcategories/delete/" + deleteId,
            type: "DELETE",
            data: { _token: "{{ csrf_token() }}" },
            success: function () {
                location.reload();
            }
        });
    });
});
</script>

@endsection
