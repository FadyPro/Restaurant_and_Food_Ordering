<div>
    <section class="section">
        <div class="section-header">
            <h1>Counter</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Update Counter</h4>

            </div>
            <div class="card-body">
                <form wire:submit.prevent="save">
                    @csrf
                    <div class="form-group">
                        <label>Background</label>
                        <div>
                            <div wire:loading wire:target="background" style="color: red">Uploading...</div>
                            <input wire:model="background" name="background" type="file" class="form-control" />
                            @error('background') <span class="error">{{ $message }}</span> @enderror
                        </div>
                        @if ($background)
                            <img src="{{ $background->temporaryUrl() }}" class="p-1 bg-primary" width="100" height="100">
                        @else
                            <img src="{{(!empty($counter->background))? url('/uploads/counter/'.$counter->background) : url('/uploads/no-image.png')}}" style="width: 80px; height: 80px">
                        @endif
                    </div>

                    <h6>Counter One</h6>
                    <hr>
                    <div class="form-group">
                        <label for="">Counter Icon One</label>
                        <input wire:model="counter_icon_one" type="text" class="form-control" name="counter_icon_one">
                        @error('counter_icon_one') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="">Counter count One</label>
                        <input wire:model="counter_count_one" type="text" class="form-control" name="counter_count_one">
                        @error('counter_count_one') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="">Counter count Name</label>
                        <input wire:model="counter_name_one" type="text" class="form-control" name="counter_name_one">
                        @error('counter_name_one') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <h6>Counter Two</h6>
                    <hr>
                    <div class="form-group">
                        <label for="">Counter Icon Two</label>
                        <input wire:model="counter_icon_two" type="text" class="form-control" name="counter_icon_two">
                        @error('counter_icon_two') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="">Counter count Two</label>
                        <input wire:model="counter_count_two" type="text" class="form-control" name="counter_count_two">
                        @error('counter_count_two') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="">Counter count Name Two</label>
                        <input wire:model="counter_name_two" type="text" class="form-control" name="counter_name_two">
                        @error('counter_name_two') <span class="error">{{ $message }}</span> @enderror
                    </div>


                    <h6>Counter Three</h6>
                    <hr>
                    <div class="form-group">
                        <label for="">Counter Icon Three</label>
                        <input wire:model="counter_icon_three" type="text" class="form-control" name="counter_icon_three">
                        @error('counter_icon_three') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="">Counter Count Three</label>
                        <input wire:model="counter_count_three" type="text" class="form-control" name="counter_count_three">
                        @error('counter_count_three') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="">Counter count Name Theree</label>
                        <input wire:model="counter_name_three" type="text" class="form-control" name="counter_name_three">
                        @error('counter_name_three') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <h6>Counter Four</h6>
                    <hr>
                    <div class="form-group">
                        <label for="">Counter Icon Four</label>
                        <input wire:model="counter_icon_four" type="text" class="form-control" name="counter_icon_four">
                        @error('counter_icon_four') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="">Counter Count Four</label>
                        <input wire:model="counter_count_four" type="text" class="form-control" name="counter_count_four">
                        @error('counter_count_four') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="">Counter count Name Four</label>
                        <input wire:model="counter_name_four" type="text" class="form-control" name="counter_name_four">
                        @error('counter_name_four') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </section>
</div>
