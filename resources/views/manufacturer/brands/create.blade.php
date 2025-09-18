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
                              <h4>📒 Add Brand</h4>
                              <p>Enter details for the new brand below.</p>
                           </div>
                           <a href="{{ route('admin.brand.index') }}"  class="btn btn-primary"
                              style="background-color: #ca2639; color: white; border: none;">
                           ⬅ Back
                           </a>
                        </div>
                        <form action="{{ route('admin.brand.store') }}" method="POST" enctype="multipart/form-data">
                           @csrf
                           <div class="card-body">
                                <div class="row">
                                 <div class="col-md-4">
                                    <div class="mb-3">
                                       <label class="form-label">Name</label>
                                       <input type="text" name="name" class="form-control" placeholder="Enter a Brand name" required>
                                    </div>
                                 </div>
                                 <!-- Image -->
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Brand Image</label>
                                        <input type="file" name="image" class="form-control">
                                    </div>
                                </div>
                                 <!-- description -->
                                 <div class="col-md-4">
                                    <div class="mb-3">
                                       <label class="form-label">Description</label>
                                       <textarea name="description" class="form-control" placeholder="Enter a brief description"></textarea>
                                    </div>
                                 </div>
                                 

                                </div>
                              <div class="text-end">
                                 <button type="submit" class="btn btn-primary">Save Brand</button>
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