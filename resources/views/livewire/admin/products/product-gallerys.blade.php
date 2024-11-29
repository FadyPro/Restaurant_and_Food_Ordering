<div>
    <section class="section">
        <div class="section-header">
            <h1>Products</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Product Gallery ({{ $Product->name }})</h4>

            </div>
            <div class="card-body">
                <form wire:submit.prevent="save">
                    @csrf
                    <div class="form-group">
                        <label for="input5" class="form-label">Image Gallery</label>
                        <input type="file" wire:model="image" class="form-control" multiple accept="image/jpeg,image/jpg,image/png,image/gif">
                        @error('image.*') <span class="error">{{ $message }}</span> @enderror
                        <br>
                        @if ($image)
                            @foreach($image as $images)
                                <img src="{{ $images->temporaryUrl() }}" class="p-1" width="70" height="70">
                            @endforeach
                        @endif
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Product Gallery Index</h4>
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
            </div>
            <div class="card-body">
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
                            <th>Image</th>
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
                                <td>
                                   <a href="{{url('/uploads/products/'.$models->image)}}"> <img src="{{(!empty($models->image))? url('/uploads/products/'.$models->image) : url('/uploads/no-image.png')}}"  width="60" height="60"></a>
                                </td>
                                <td>
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
    </section>
</div>
