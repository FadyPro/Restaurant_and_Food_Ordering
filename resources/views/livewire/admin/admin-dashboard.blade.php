<div>
    <section class="section">
        <div class="section-header">
            <h1>Dashboard</h1>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="fas fa-cart-plus"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Today's Orders</h4>
                        </div>
                        <div class="card-body">
                            {{ $todaysOrders }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Today's Earnings</h4>
                        </div>
                        <div class="card-body">
                            {{ currencyPosition($todaysEarnings) }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="fas fa-cart-plus"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>This Month Orders</h4>
                        </div>
                        <div class="card-body">
                            {{ $thisMonthsOrders }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>This Months Earnings</h4>
                        </div>
                        <div class="card-body">
                            {{ currencyPosition($thisMonthsEarnings) }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="fas fa-cart-plus"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>This Year Orders</h4>
                        </div>
                        <div class="card-body">
                            {{ $thisYearOrders }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>This Year Earnings</h4>
                        </div>
                        <div class="card-body">
                            {{ currencyPosition($thisYearEarnings) }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="fas fa-cart-plus"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Orders</h4>
                        </div>
                        <div class="card-body">
                            {{ $totalOrders }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Earnings</h4>
                        </div>
                        <div class="card-body">
                            {{ currencyPosition($totalEarnings) }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Users</h4>
                        </div>
                        <div class="card-body">
                            {{ $totalUsers }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Admins</h4>
                        </div>
                        <div class="card-body">
                            {{ $totalAdmins }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="fas fa-th"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Products</h4>
                        </div>
                        <div class="card-body">
                            {{ $totalProducts }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                        <i class="fas fa-rss"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Blogs</h4>
                        </div>
                        <div class="card-body">
                            {{ $totalBlogs }}
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </section>

    <section class="section">

        <div class="card card-primary">
            <div class="card-header">
                <h4>Today's Orders</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <tbody>
                        <tr>
                            <th>User Name</th>
                            <th>Order NO</th>
                            <th>Grand Total</th>
                            <th>Order Status</th>
                            <th>Payment Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                        @foreach($model as $key=>$models)
                            <tr>
                                <td>{{$models->user?->name}}</td>
                                <td>{{$models->invoice_id}}</td>
                                <td>{{$models->grand_total.' '.strtoupper($models->currency_name)}}</td>
                                <td>
                                    @if($models->order_status === 'delivered')
                                        <span class="badge badge-success">Delivered</span>
                                    @elseif($models->order_status === 'declined')
                                        <span class="badge badge-danger">Declined</span>
                                    @else
                                        <span class="badge badge-warning">{{$models->order_status}}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($models->payment_status == 'completed')
                                        <span class="badge badge-success">COMPLETED</span>
                                    @elseif($models->payment_status == 'pending')
                                        <span class="badge badge-warning">PENDING</span>
                                    @else
                                        <span class="badge badge-danger">{{$models->payment_status}}</span>
                                    @endif
                                </td>
                                <td>{{date('d-m-Y', strtotime($models->created_at))}}</td>
                                <td>
                                    <a href="/admin/orders/{{$models->id}}/show" class="btn btn-warning mr-2"><i class='fas fa-eye'></i></a>
                                    <a href="javascript:;" wire:click.prevent="editOrderStatus({{$models->id}})" class="btn btn-primary"><i class='fas fa-edit'></i></a>
                                    <a href="javascript:;" wire:click.prevent="deleteOne({{$models->id}})" class="btn btn-danger delete-item ml-2"><i class='fas fa-trash'></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @if (count($model) === 0)
                        <p> ... showing no Results found </p>
                    @endif
                    <div>
                        <br>
                        {{$model->onEachSide(2)->links()}}
                    </div>
                    <div>
                        Viewing {{ $model->firstItem() }} - {{ $model->lastItem() }} of {{ $model->total() }} entries
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal -->
    @if($isOpen)
        <div class="fp__address_modal">
            <div wire:ignore class="modal show"  tabindex="-1" aria-labelledby="address_modalLabel"
                 style="display: block;">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="address_modalLabel">Status
                            </h1>
                            <button wire:click="closeModal()" type="button" class="close" data-bs-dismiss="modal"
                                    aria-label="Close">x</button>
                        </div>
                        <div class="modal-body">
                            <div class="fp_dashboard_new_address d-block">
                                <form wire:submit.prevent="updateOrderStatus">
                                    @csrf
                                    <div class="form-group">
                                        <label for="">Payment Status</label>
                                        <select wire:model="payment_status" class="form-control" name="payment_status">
                                            <option value="pending">Pending</option>
                                            <option value="completed">Completed</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Order Status</label>
                                        <select wire:model="order_status" class="form-control" name="order_status">
                                            <option value="pending">Pending</option>
                                            <option value="in_process">In Process</option>
                                            <option value="delivered">Delivered</option>
                                            <option value="declined">Declined</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-info">Update</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif


</div>
