<div>
    <section class="section">
        <div class="section-header">
            <h1>Admin Management</h1>
        </div>
        <div class="section-body">
            <div class="card card-primary">
                <div class="card-header">
                    <h4 style="width: 150px">Users List</h4>
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
                    </div>

                    <div class="card-header-form" style="padding-left: 55%;">
                        <form>
                            <div class="input-group">
                                <input wire:model.live="search" type="text" class="form-control" placeholder="Search">
                                <div class="input-group-btn">
                                    <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-header-action" style="padding-left: 20px;" >
                        <a href="{{route('admin.admin-management.create')}}" class="btn btn-primary" style="padding-left: 20px; text-align: right; float: right;">
                            New Item
                        </a>
                    </div>

                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <tbody>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Created_at</th>
                                <th>Actions</th>
                                <th></th>
                            </tr>
                            @foreach($model as $key=>$models)
                                <tr>
                                    <td>{{$models->name}} </td>
                                    <td>{{$models->email}} </td>
                                    <td>{{$models->role}}</td>
                                    <td>{{date('d M Y', strtotime($models->created_at))}}</td>
                                    <td>
                                        @if($models->id != 1)
                                            <a href="/admin/admin-management/{{$models->id}}/edit"  class="btn btn-primary"><i class='fas fa-edit'></i></a>
                                            <a href="javascript:;" wire:click.prevent="deleteOne({{$models->id}})" class="btn btn-danger delete-item ml-2"><i class='fas fa-trash'></i></a>
                                            {{--                                        <a href="javascript:void(0)" wire:click.prevent="deleteConfirmation({{$models->id}})" class="ms-3"><i class='bx bxs-trash'></i></a>--}}
                                        @endif
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
