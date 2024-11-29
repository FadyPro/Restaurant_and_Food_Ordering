<div>
    <section class="section">
        <div class="section-header">
            <h1>Daily Offer</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Create Daily Offer</h4>

            </div>
            <div class="card-body">
                <form wire:submit.prevent="save">
                    @csrf
                    <div class="col-md-6">
                        <div class="form-group" wire:ignore>
                            <label>Product</label>
                            <select wire:model="product_id" name="product_id" class="form-control select2" id="product_id" >
                                <option value="">select</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                            @error('product_id') <span class="error">{{ $message }}</span> @enderror
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


                    <button type="submit" class="btn btn-primary">Create</button>
                </form>
            </div>
        </div>
    </section>
</div>
@script()
<script>
    // select2
    $(document).ready(function() {
        $('#product_id').select2();
        $('#product_id').on('change',function (){
            let data = $(this).val()
            console.log(data)
            $wire.set('product_id',data)
        });
    });
</script>
@endscript
