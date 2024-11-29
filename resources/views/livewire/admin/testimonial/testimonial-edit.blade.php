<div>
    <section class="section">
        <div class="section-header">
            <h1>Testimonials</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Update Testimonial</h4>

            </div>
            <div class="card-body">
                <form wire:submit="save">
                    @csrf
                    <div class="form-group">
                        <label>Image</label>
                        <div>
                            <div wire:loading wire:target="image" style="color: red">Uploading...</div>
                            <input wire:model="image" name="image" type="file" class="form-control" />
                            @error('image') <span class="error">{{ $message }}</span> @enderror
                        </div>
                        @if ($image)
                            <img src="{{ $image->temporaryUrl() }}" class="p-1 bg-primary" width="100" height="100">
                        @else
                            <img src="{{(!empty($testimonial->image))? url('/uploads/testimonial/'.$testimonial->image) : url('/uploads/no-image.png')}}" style="width: 80px; height: 80px">
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="">Name</label>
                        <input wire:model="name" type="text" class="form-control" name="name">
                        @error('name') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="">Title</label>
                        <input wire:model="title" type="text" class="form-control" name="title">
                        @error('title') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label>Rating</label>
                        <select wire:model="rating" name="rating" class="form-control" id="">
                            <option selected="">Choose...</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                        @error('rating') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="">Review</label>
                        <textarea wire:model="review" name="review" id="" class="form-control"></textarea>
                        @error('review') <span class="error">{{ $message }}</span> @enderror
                    </div>


                    <div class="form-group">
                        <label>Show at Home</label>
                        <select wire:model="show_at_home" name="show_at_home" class="form-control" id="">
                            <option selected="">Choose...</option>
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                        @error('show_at_home') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select wire:model="status" class="form-control">
                            <option selected="">Choose...</option>
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                        @error('status') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </section>
</div>
