@extends('admin.layouts.app')
@section('content')
<div class="page-content">
   <div class="container-fluid">
      <div class="row ledger-add-form">
         <div class="col-12">
            <div class="card">
               <div class="card-header d-flex justify-content-between align-items-center">
                  <div>
                     <h4>✏️ Edit Products</h4>
                     <p>Update the details for this brand.</p>
                  </div>
                  <a href="{{ route('admin.product.index') }}" class="btn btn-primary"
                     style="background-color: #ca2639; color: white; border: none;">
                     ⬅ Back
                  </a>
               </div>
                <form action="{{ route('admin.product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  @method('PUT')
                  <div class="card-body">
                     <div class="row">
                        <!-- Product Name -->
                        <div class="col-md-4">
                           <div class="mb-3">
                              <label class="form-label">Name</label>
                              <input type="text" name="name" class="form-control"
                                     value="{{ old('name', $product->name) }}" required>
                           </div>
                        </div>

                        <!-- Description -->
                        <div class="col-md-6">
                           <div class="mb-3">
                              <label class="form-label">Description</label>
                              <textarea name="description" class="form-control">{{ old('description', $product->description) }}</textarea>
                           </div>
                        </div>

                        <!-- Quantity -->
                        <div class="col-md-2">
                           <div class="mb-3">
                              <label class="form-label">Quantity</label>
                              <input type="number" name="quantity" class="form-control" 
                                     value="{{ old('quantity', $product->quantity) }}" required>
                           </div>
                        </div>

                        <!-- Price -->
                        <div class="col-md-2">
                           <div class="mb-3">
                              <label class="form-label">Price</label>
                              <input type="number" step="0.01" name="price" class="form-control"
                                     value="{{ old('price', $product->price) }}" required>
                           </div>
                        </div>

                        <!-- Brand Dropdown -->
                        <div class="col-md-4">
                           <div class="mb-3">
                              <label class="form-label">Brand</label>
                              <select name="brand_id" class="form-control" required>
                                 <option value="">Select Brand</option>
                                 @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}" 
                                        {{ $product->brand_id == $brand->id ? 'selected' : '' }}>
                                        {{ $brand->name }}
                                    </option>
                                 @endforeach
                              </select>
                           </div>
                        </div>

                        <!-- Image Upload -->
                        <div class="col-md-4">
                           <div class="mb-3">
                              <label class="form-label">Product Image</label>
                              <input type="file" name="image" class="form-control">
                              @if($product->image)
                                 <img src="{{ $product->image }}" alt="Product Image" style="width: 80px; margin-top: 5px;">
                              @endif
                           </div>
                        </div>
                        <!-- status -->
                         <div class="col-md-4">
                           <div class="mb-3">
                              <label class="form-label">Status</label>
                              <select name="status" class="form-control">
                                 <option value="1" {{ $product->status == 1?'selected' : '' }}>Active</option>
                                 <option value="0" {{ $product->status == 0?'selected' : '' }}>Inactive</option>
                              </select>
                           </div>
                        </div>
                     </div>
                     <div class="text-end">
                        <button type="submit" class="btn btn-primary">Update Product</button>
                     </div>
                    </div>
                </form>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
