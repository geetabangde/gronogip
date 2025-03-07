@extends('admin.layouts.app')
@section('title', 'Order')
@section('content')
<div class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0 font-size-18">Order</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                                        <li class="breadcrumb-item active">Order</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <table id="datatable" class="table table-bordered text-center">
                                        <thead>
                                            <tr>
                                                <th>Order ID</th>
                                                <th>Customer Name</th>
                                                <th>Total Price (Incl. GST)</th>
                                                <th>Total Quantity</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>ORD001</td>
                                                <td>Rahul Sharma</td>
                                                <td>₹12,000</td>
                                                <td>50 Kg</td>
                                                <td><button class="btn btn-info btn-sm viewOrder" data-order="1">View</button></td>
                                            </tr>
                                            <tr>
                                                <td>ORD002</td>
                                                <td>Ankit Verma</td>
                                                <td>₹25,500</td>
                                                <td>120 Kg</td>
                                                <td><button class="btn btn-info btn-sm viewOrder" data-order="2">View</button></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    
                     
                    </div> <!-- end row -->

                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
<!-- Order Details Modal -->
<div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderModalLabel">Order Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="orderDetails">
                <!-- Order details will be loaded here -->
            </div>
        </div>
    </div>
</div>

           
        </div>

        <script>
        document.addEventListener("DOMContentLoaded", function () {
            const orders = {
                1: {
                    customer: "Rahul Sharma",
                    email: "rahul.sharma@gmail.com",
                    mobile: "+91 9876543210",
                    address: "Sector 15, Noida",
                    city: "Noida, UP",
                    items: [
                        { product: "Wheat", quantity: "20 Kg", price: "₹4,000", gst: "₹200", total: "₹4,200" },
                        { product: "Rice", quantity: "30 Kg", price: "₹7,500", gst: "₹300", total: "₹7,800" }
                    ],
                    totalPrice: "₹12,000",
                    totalQuantity: "50 Kg"
                },
                2: {
                    customer: "Ankit Verma",
                    email: "ankit.verma@gmail.com",
                    mobile: "+91 9876543222",
                    address: "MG Road, Indore",
                    city: "Indore, MP",
                    items: [
                        { product: "Sugar", quantity: "50 Kg", price: "₹20,000", gst: "₹500", total: "₹20,500" },
                        { product: "Dal", quantity: "70 Kg", price: "₹5,000", gst: "₹500", total: "₹5,500" }
                    ],
                    totalPrice: "₹25,500",
                    totalQuantity: "120 Kg"
                }
            };
    
            document.querySelectorAll(".viewOrder").forEach(button => {
                button.addEventListener("click", function () {
                    const orderId = this.getAttribute("data-order");
                    const order = orders[orderId];
    
                    let orderDetailsHtml = `<p><strong>Customer:</strong> ${order.customer}</p>`;
                    orderDetailsHtml += `<p><strong>Email:</strong> ${order.email}</p>`;
                    orderDetailsHtml += `<p><strong>Mobile:</strong> ${order.mobile}</p>`;
                    orderDetailsHtml += `<p><strong>Address:</strong> ${order.address}, ${order.city}</p>`;
                    
                    orderDetailsHtml += `<table class="table table-bordered mt-3"><thead><tr><th>Product</th><th>Quantity</th><th>Price</th><th>GST</th><th>Total</th></tr></thead><tbody>`;
    
                    order.items.forEach(item => {
                        orderDetailsHtml += `<tr>
                            <td>${item.product}</td>
                            <td>${item.quantity}</td>
                            <td>${item.price}</td>
                            <td>${item.gst}</td>
                            <td>${item.total}</td>
                        </tr>`;
                    });
    
                    orderDetailsHtml += `</tbody></table>`;
                    orderDetailsHtml += `<p><strong>Total Quantity:</strong> ${order.totalQuantity}</p>`;
                    orderDetailsHtml += `<p><strong>Total Price (Incl. GST):</strong> ${order.totalPrice}</p>`;
    
                    document.getElementById("orderDetails").innerHTML = orderDetailsHtml;
                    new bootstrap.Modal(document.getElementById("orderModal")).show();
                });
            });
        });
    </script>
@endsection