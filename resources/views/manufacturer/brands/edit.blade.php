@extends('admin.layouts.app')
@section('content')
<div class="page-content">
   <div class="container-fluid">
      <div class="row ledger-add-form">
         <div class="col-12">
            <div class="card">
               <div class="card-header d-flex justify-content-between align-items-center">
                  <div>
                     <h4>✏️ Edit Brand</h4>
                     <p>Update the details for this brand.</p>
                  </div>
                  <a href="{{ route('admin.brand.index') }}" class="btn btn-primary"
                     style="background-color: #ca2639; color: white; border: none;">
                     ⬅ Back
                  </a>
               </div>

               <form action="{{ route('admin.brand.update', $brand->id) }}" method="POST">
                  @csrf
                  @method('PUT')
                  <div class="card-body">
                     <div class="row">
                        <div class="col-md-4">
                           <div class="mb-3">
                              <label class="form-label">Name</label>
                              <input type="text" name="name" class="form-control"
                                    value="{{ old('name', $brand->name) }}" required>
                           </div>
                        </div>

                        <div class="col-md-6">
                           <div class="mb-3">
                              <label class="form-label">Description</label>
                              <textarea name="description" class="form-control">{{ old('description', $brand->description) }}</textarea>
                           </div>
                        </div>
                     </div>

                     <div class="text-end">
                        <button type="submit" class="btn btn-primary">Update Brand</button>
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
