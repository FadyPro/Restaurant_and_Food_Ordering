<div>
    <section class="section">
        <div class="section-header">
            <h1>Products</h1>
        </div>
        <div class="section-body">
            <div class="card card-primary">
                <div class="card-header">
                    <h4 style="width: 150px">Products List</h4>
                    <div>
                        <div class="d-flex align-items-center ml-20" style="width: 150px">
                            <label for="paginate" class="text-nowrap mr-2 mb-0">Per Page</label>
                            <select wire:model.live="paginate" name="paginate" id="paginate" class="form-control form-control-sm">
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="30">30</option>
                            </select>
                        </div>
                    </div>
                    <div style="margin-left: 10px;" class=" pr-20">
                        @if ($checked)
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                With Checked ({{ count($checked) }})
                            </button>
                            <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 28px, 0px); top: 0px; left: 0px; will-change: transform;">
                                <a href="#" class="dropdown-item" type="button"
                                   onclick="confirm('Are you sure you want to delete these Records?') || event.stopImmediatePropagation()"
                                   wire:click="deleteRecords()">
                                    Delete
                                </a>
                            </div>
                        @endif
                    </div>

                    <div class="card-header-form" style="padding-left: 55%;">
                        <form>
                            <div class="input-group">
                                <input wire:model.live="search" type="text" class="form-control" placeholder="Search">
                                <div class="input-group-btn">
                                    <button wire:click="Search" class="btn btn-primary"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
{{--                    <div class="card-header-action" style="padding-left: 20px;" >--}}
{{--                        <a href="{{route('admin.product.create')}}" class="btn btn-primary" style="padding-left: 20px; text-align: right; float: right;">--}}
{{--                            New Item--}}
{{--                        </a>--}}
{{--                    </div>--}}

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
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <tbody>
                            <tr>
                                <th>
                                    <div class="custom-checkbox custom-control">
                                        <input wire:model.live="selectAll" type="checkbox" data-checkboxes="mygroup" data-checkbox-role="dad" class="custom-control-input" id="checkbox-all">
                                        <label for="checkbox-all" class="custom-control-label">&nbsp;</label>
                                    </div>
                                </th>
                                <th wire:click="setSortBy('user_name')" style="cursor: pointer">
                                    <a> User Name
                                        @if( $sortBy !== 'user_name')
                                            <i class="fas fa-solid fa-arrow-up"></i>
                                        @elseif( $sortBy === 'user_name' && $sortDirection === 'asc')
                                            <i class="fas fa-solid fa-arrow-down"></i>
                                        @else
                                            <i class="fas fa-solid fa-arrow-up"></i>
                                        @endif
                                    </a>
                                </th>
                                <th wire:click="setSortBy('user_phone')" style="cursor: pointer">
                                    <a> User Phone
                                        @if( $sortBy !== 'user_phone')
                                            <i class="fas fa-solid fa-arrow-up"></i>
                                        @elseif( $sortBy === 'user_phone' && $sortDirection === 'asc')
                                            <i class="fas fa-solid fa-arrow-down"></i>
                                        @else
                                            <i class="fas fa-solid fa-arrow-up"></i>
                                        @endif
                                    </a>
                                </th>
                                <th>Order NO</th>
                                <th>Grand Total</th>
                                <th wire:click="setSortBy('order_status')" style="cursor: pointer">
                                    <a> Order Status
                                        @if( $sortBy !== 'order_status')
                                            <i class="fas fa-solid fa-arrow-up"></i>
                                        @elseif( $sortBy === 'order_status' && $sortDirection === 'asc')
                                            <i class="fas fa-solid fa-arrow-down"></i>
                                        @else
                                            <i class="fas fa-solid fa-arrow-up"></i>
                                        @endif
                                    </a>
                                </th>
                                <th wire:click="setSortBy('payment_status')" style="cursor: pointer">
                                    <a> Payment Status
                                        @if( $sortBy !== 'payment_status')
                                            <i class="fas fa-solid fa-arrow-up"></i>
                                        @elseif( $sortBy === 'payment_status' && $sortDirection === 'asc')
                                            <i class="fas fa-solid fa-arrow-down"></i>
                                        @else
                                            <i class="fas fa-solid fa-arrow-up"></i>
                                        @endif
                                    </a>
                                </th>
                                <th wire:click="setSortBy('created_at')" style="cursor: pointer">
                                    <a> Date
                                        @if( $sortBy !== 'created_at')
                                            <i class="fas fa-solid fa-arrow-up"></i>
                                        @elseif( $sortBy === 'created_at' && $sortDirection === 'asc')
                                            <i class="fas fa-solid fa-arrow-down"></i>
                                        @else
                                            <i class="fas fa-solid fa-arrow-up"></i>
                                        @endif
                                    </a>
                                </th>
                                <th>Actions</th>
                            </tr>
                            @foreach($model as $key=>$models)
                                <tr>
                                    <td>
                                        <div>
                                            <input type="checkbox" value="{{$models->id}}" wire:model.live="checked" class="custom-checkbox custom-control">
                                        </div>
                                    </td>
                                    <td>{{$models->user?->name}}</td>
                                    <td>{{$models->user?->phone}}</td>
                                    <td>{{$models->invoice_id}}</td>
                                    <td>{{$models->grand_total}}</td>
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
                                        {{--                                        <a href="javascript:void(0)" wire:click.prevent="deleteConfirmation({{$models->id}})" class="ms-3"><i class='bx bxs-trash'></i></a>--}}
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
        </div>
    </section>
</div>
