<div>
    <section class="section">
        <div class="section-header">
            <h1>Products Variants ({{ $product->name }})</h1>
        </div>

        <div>
            <a href="{{ route('admin.product.index') }}" class="btn btn-primary my-3">Go Back</a>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h4>Create Product Size</h4>

                    </div>
                    <div class="card-body">
                        <form wire:submit.prevent="SaveSize">
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Name</label>
                                        <input wire:model="sname" type="text" name="sname" id="" class="form-control">
                                        @error('sname') <span class="error">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Price</label>
                                        <input wire:model="sprice" type="text" name="sprice" id="" class="form-control">
                                        @error('sprice') <span class="error">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Create</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card card-primary">

                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>No.</th>
                                <th>Name</th>
                                <th>price</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($sizes as $size)
                                <tr>
                                    <td>{{ ++$loop->index }}</td>
                                    <td>{{ $size->name }}</td>
                                    <td>{{ currencyPosition($size->price) }}</td>
                                    <td>
                                        <a href="javascript:;" wire:click.prevent="destroyProductSize({{$size->id}})" class="btn btn-danger delete-item mx-2"><i class='fas fa-trash'></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            @if (count($sizes) === 0)
                                <tr>
                                    <td colspan='3' class="text-center">No data found!</td>

                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h4>Create Product Options</h4>

                    </div>
                    <div class="card-body">
                        <form wire:submit.prevent="SaveOption">
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Name</label>
                                        <input wire:model="oname" type="text" name="oname" id="" class="form-control">
                                        @error('oname') <span class="error">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Price</label>
                                        <input wire:model="oprice" type="text" name="oprice" id="" class="form-control">
                                        @error('oprice') <span class="error">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Create</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card card-primary">

                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>No.</th>
                                <th>Name</th>
                                <th>price</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($options as $option)
                                <tr>
                                    <td>{{ ++$loop->index }}</td>
                                    <td>{{ $option->name }}</td>
                                    <td>{{ currencyPosition($option->price) }}</td>
                                    <td>
                                        <a href="javascript:;" wire:click.prevent="destroyProductSize({{$option->id}})" class="btn btn-danger delete-item mx-2"><i class='fas fa-trash'></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            @if (count($options) === 0)
                                <tr>
                                    <td colspan='3' class="text-center">No data found!</td>

                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </section>
</div>
