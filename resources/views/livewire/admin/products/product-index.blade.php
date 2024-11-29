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
                                    <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-header-action" style="padding-left: 20px;" >
                        <a href="{{route('admin.product.create')}}" class="btn btn-primary" style="padding-left: 20px; text-align: right; float: right;">
                            New Item
                        </a>
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
                                <th>Name</th>
                                <th>Price</th>
                                <th>Offer Price</th>
                                <th>Status</th>
                                <th>show at home</th>
                                <th>Category</th>
                                <th>Actions</th>
                                <th></th>
                            </tr>
                            @foreach($model as $key=>$models)
                                <tr>
                                    <td>
                                        <div>
                                            <input type="checkbox" value="{{$models->id}}" wire:model.live="checked" class="custom-checkbox custom-control">
                                        </div>
                                    </td>
                                    <td>{{$models->name}}</td>
                                    <td>{{$models->price}}</td>
                                    <td>{{$models->offer_price}}</td>
                                    <td>
                                        @if($models->status === 1)
                                            <span class="badge badge-primary">Active</span>
                                        @else
                                            <span class="badge badge-danger">InActive</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($models->show_at_home === 1)
                                            <span class="badge badge-primary">Active</span>
                                        @else
                                            <span class="badge badge-danger">InActive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <img src="{{(!empty($models->thumb_image))? url('/uploads/products/'.$models->thumb_image) : url('/uploads/no-image.png')}}"  width="60" height="60">
                                    </td>
                                    <td>{{$models->category->name}}</td>
                                    <td>
                                        <div class="btn-group dropleft" style="padding-right: 8px">
                                            <button type="button" class="btn btn-dark dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-cog"></i></button>
                                            <div class="dropdown-menu dropleft" x-placement="left-start" style="position: absolute; transform: translate3d(-2px, 0px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                <a class="dropdown-item" href="/admin/product/ImageGallery/{{$models->id}}">Product Gallery</a>
                                                <a class="dropdown-item" href="/admin/product/variants/{{$models->id}}">Product Variants</a>
                                            </div>
                                        </div>
                                        <a href="#" class="btn btn-warning mr-2"><i class='fas fa-eye'></i></a>
                                        <a href="/admin/product/{{$models->id}}/edit"  class="btn btn-primary"><i class='fas fa-edit'></i></a>
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
