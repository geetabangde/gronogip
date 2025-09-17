@extends('admin.layouts.app')
@section('content')
<div class="page-content">
   <div class="container-fluid">
      <!-- Add Ledger Form -->
      <div class="row ledger-add-form" >
         <div class="col-12">
            <div class="card">
               <!-- Add Ledger Form -->
               <div class="row ledger-add-form" >
                  <div class="col-12">
                     <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                           <div>
                              <h4>📒 Add Product</h4>
                              <p>Enter details for the new brand below.</p>
                           </div>
                           <a href="{{ route('admin.product.index') }}"  class="btn btn-primary"
                              style="background-color: #ca2639; color: white; border: none;">
                           ⬅ Back
                           </a>
                        </div>
                        <form action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <!-- Product Name -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Product Name</label>
                                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Enter product name" required>
                                    </div>
                                </div>

                                <!-- Brand Dropdown -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Brand</label>
                                        <select name="brand_id" class="form-control" required>
                                            <option value="">-- Select Brand --</option>
                                            @foreach($brands as $brand)
                                                <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                                                    {{ $brand->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Quantity -->
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Quantity</label>
                                        <input type="number" name="quantity" class="form-control" value="{{ old('quantity') }}" placeholder="Enter quantity" required>
                                    </div>
                                </div>

                                <!-- Price -->
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Price</label>
                                        <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price') }}" placeholder="Enter price" required>
                                    </div>
                                </div>

                                <!-- Image -->
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Image</label>
                                        <input type="file" name="image" class="form-control">
                                    </div>
                                </div>

                                <!-- Description -->
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Description</label>
                                        <textarea name="description" class="form-control" placeholder="Enter product description">{{ old('description') }}</textarea>
                                    </div>
                                </div>
                                <!-- status -->
                                 <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Status</label>
                                        <select name="status" class="form-control" required>
                                            <option value="">-- Select Status --</option>
                                            <option value="1" {{ old('status') == 1?'selected' : '' }}>Active</option>
                                            <option value="0" {{ old('status') == 0?'selected' : '' }}>Inactive</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">Save Product</button>
                            </div>
                        </div>
                    </form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection