<div>
    <section class="section">
        <div class="section-header">
            <h1>Coupon</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Create Coupon</h4>

            </div>
            <div class="card-body">
                <form wire:submit.prevent="save">
                    @csrf

                    <div class="form-group">
                        <label>Name</label>
                        <input wire:model="name" type="text" name="name" class="form-control" value="{{ old('name') }}">
                        @error('name') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label>Coupon Code</label>
                        <input wire:model="code" type="text" name="code" class="form-control" value="{{ old('code') }}">
                        @error('quantity') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label>Coupon Quantity</label>
                        <input wire:model="quantity" type="text" name="quantity" class="form-control" value="{{ old('quantity') }}">
                        @error('quantity') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label>Minumum Purchase Price</label>
                        <input wire:model="min_purchase_amount" type="text" name="min_purchase_amount" class="form-control" value="{{ old('min_purchase_amount') }}">
                        @error('min_purchase_amount') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label>Expire Date</label>
                        <input wire:model="expire_date" type="date" name="expire_date" class="form-control" value="{{ old('date') }}">
                        @error('expire_date') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label>Discount Type</label>
                        <select wire:model="discount_type" name="discount_type" class="form-control" id="">
                            <option selected="">Choose...</option>
                            <option value="percent">Percent ( % )</option>
                            <option value="amount">Amount ({{ config('settings.site_currency_icon') }})</option>
                        </select>
                        @error('discount_type') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label>Discount Amount</label>
                        <input wire:model="discount" type="text" name="discount" class="form-control" value="{{ old('discount') }}">
                        @error('discount') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select wire:model="status" name="status" class="form-control" id="">
                            <option selected="">Choose...</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                        @error('status') <span class="error">{{ $message }}</span> @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Create</button>
                </form>
            </div>
        </div>
    </section>
</div>
