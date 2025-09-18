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
                              <h4>📒 Add Manufacturers</h4>
                           
                           </div>
                           <a href="{{ route('admin.manufacturers.list') }}"  class="btn btn-primary"
                              style="background-color: #ca2639; color: white; border: none;">
                           ⬅ Back
                           </a>
                        </div>
                        <form action="{{ route('admin.manufacturers.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                            <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" name="password" id="password" class="form-control" required>
                                </div>
                                <!-- address -->
                                 <div class="mb-3">
                                    <label for="address" class="form-label">Address</label>
                                    <input type="text" name="address" id="address" class="form-control" value="{{ old('address') }}">
                                </div>
                                
                              </div>
                              <div class="text-end">
                                 <button type="submit" class="btn btn-primary">Create Manufacturer</button>
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