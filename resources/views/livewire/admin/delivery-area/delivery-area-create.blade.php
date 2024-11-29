<div>
    <section class="section">
        <div class="section-header">
            <h1>Delivery Area</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Create Delivery Area</h4>

            </div>
            <div class="card-body">
                <form wire:submit="save">
                    @csrf

                    <div class="form-group">
                        <label>Area Name</label>
                        <input wire:model="area_name" type="text" name="area_name" class="form-control">
                        @error('area_name') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Minimum Delivery Time </label>
                                <input wire:model="min_delivery_time" type="text" name="min_delivery_time" class="form-control">
                                @error('min_delivery_time') <span class="error">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Maximum Delivery Time</label>
                                <input wire:model="max_delivery_time" type="text" name="max_delivery_time" class="form-control">
                                @error('max_delivery_time') <span class="error">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Delivery Fee</label>
                                <input wire:model="delivery_fee" type="text" name="delivery_fee" class="form-control">
                                @error('delivery_fee') <span class="error">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Status</label>
                                <select wire:model="status" name="status" class="form-control">
                                    <option selected="">Choose...</option>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                                @error('status') <span class="error">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Create</button>
                </form>
            </div>
        </div>
    </section>
</div>
