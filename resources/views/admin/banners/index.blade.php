@extends('admin.layouts.app')

@section('content')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0 font-size-18">Banner </h4>
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                                        <li class="breadcrumb-item active">Banner</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

        <!-- Add Subcategory Button -->
        <div class="d-flex justify-content-end mb-3">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSubcategoryModal">
               Add Banner
            </button>
        </div>

        <!-- Subcategory Table -->
        <div class="card">
            <div class="card-body">
                <table id="datatable" class="table table-bordered text-center">
                    <thead>
                    <tr>
                        <th>Banner Image</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody id="bannerTable">
                        @foreach($banners as $banner)
                        <tr id="bannerRow_{{ $banner->id }}">
                            <td>
                                <img src="{{ asset('storage/'.$banner->image) }}" alt="Banner" width="100">
                            </td>
                            <td>
                                <button class="btn btn-warning btn-sm editBtn" data-id="{{ $banner->id }}" data-image="{{ asset('storage/'.$banner->image) }}">Edit</button>
                                <button class="btn btn-danger btn-sm deleteBtn" data-id="{{ $banner->id }}">Delete</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

         <!-- Add Banner Modal -->
        <div class="modal fade" id="addSubcategoryModal" tabindex="-1" aria-labelledby="addSubcategoryLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addSubcategoryLabel">Upload Banner</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <form id="addBannerForm">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Image</label>
                                <input type="file" class="form-control" name="image" required>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Add Banner</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Subcategory Modal -->
        <div class="modal fade" id="editBannerModal" tabindex="-1" aria-labelledby="editSubcategoryLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editSubcategoryLabel">Edit banner</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <form id="editBannerForm">
                            @csrf
                            <input type="hidden" id="editBannerId">
                            <div class="mb-3">
                                <label class="form-label">Banner Image</label>
                                <input type="file" class="form-control" id="editBannerImage" name="image">
                                <img id="previewImage" src="" class="mt-2" style="max-width: 100px; display: none;">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Update Banner</button>
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
                        <h5 class="modal-title">Delete Banner</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this banner?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger" id="confirmBannen">Delete</button>
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
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
$(document).ready(function () {
    // Add Banner
    $("#addBannerForm").submit(function (e) {
        e.preventDefault();
        let formData = new FormData(this);
        $.ajax({
            url: "{{ route('admin.banners.store') }}",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function () {
                location.reload();
            }
        });
    });

    // Edit Banner
    $(".editBtn").click(function () {
        let id = $(this).data("id");
        let image = $(this).data("image");
        
        $("#editBannerId").val(id);
        $("#previewImage").attr("src", image).show();
        $("#editBannerModal").modal("show");
    });

    $("#editBannerForm").submit(function (e) {
        e.preventDefault();
        let id = $("#editBannerId").val();
        let formData = new FormData(this);
        $.ajax({
            url: "/admin/banners/update/" + id,
            type: "POST",
            data: formData,
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

    $("#confirmBannen").click(function () {
        $.ajax({
            url: "/admin/banners/delete/" + deleteId,
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
