<div>
    <section class="section">

        <div class="section-header">
            <h1>Reservation</h1>
        </div>
        <div class="section-body">
            <div class="card card-primary">
                <div class="card-header">
                    <h4 style="width: 150px">Reservation List</h4>
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

                    <div class="card-header-form" style="padding-left: 65%;">
                        <form>
                            <div class="input-group">
                                <input wire:model.live="search" type="text" class="form-control" placeholder="Search">
                                <div class="input-group-btn">
                                    <button wire:click="Search" class="btn btn-primary"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-header-action" style="padding-left: 20px;" >

                    </div>

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
                                <th>Reservation No</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Persons</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                            @foreach($model as $key=>$models)
                                <tr>
                                    <td>
                                        <div>
                                            <input type="checkbox" value="{{$models->id}}" wire:model.live="checked" class="custom-checkbox custom-control">
                                        </div>
                                    </td>
                                    <td>{{$models->reservation_id}}</td>
                                    <td>{{$models->name}}</td>
                                    <td>{{$models->phone}}</td>
                                    <td>{{$models->date}}</td>
                                    <td>{{$models->time}}</td>
                                    <td>{{$models->persons}}</td>
                                    <td>
                                        @if($models->status === 'pending')
                                            <span class="badge badge-warning">Pending</span>
                                        @elseif($models->status === 'approved')
                                            <span class="badge badge-primary">Approved</span>
                                        @elseif($models->status === 'complete')
                                            <span class="badge badge-success">Complete</span>
                                        @elseif($models->status === 'cancel')
                                            <span class="badge badge-danger">Cancel</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="javascript:;" wire:click.prevent="editStatus({{$models->id}})" class="btn btn-primary"><i class='fas fa-edit'></i></a>
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
                <div>
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
                                                <form wire:submit.prevent="updateStatus">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label for="">Status</label>
                                                        <select wire:model="status" name="status}" class="form-control">
                                                            <option disabled selected="">Choose...</option>
                                                            <option value="pending">Pending</option>
                                                            <option value="approved">Approved</option>
                                                            <option value="complete">Complete</option>
                                                            <option value="cancel">Cancel</option>
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
                    <!-- Modal END -->
                    <style>
                        .modal-dialog {
                            max-width: 600px;
                        }
                    </style>
                </div>
            </div>
        </div>
    </section>
</div>
