<div>
    <section class="section">
        <div class="section-header">
            <h1>Profile</h1>
        </div>

        <div class="section-body">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>Update User Settings</h4>

                </div>
                <div class="card-body">
                    <form wire:submit.prevent="save">
                        @csrf
                        <div class="form-group col-md-4">
                            <div>
                                <label for="avatar" id="image-label">Choose File</label>
                                <div wire:loading wire:target="avatar">Uploading...</div>
                                <input wire:model="avatar" name="avatar" type="file" class="form-control" />
                                @error('avatar') <span class="error">{{ $message }}</span> @enderror
                            </div>
                            @if ($avatar)
                                <img src="{{ $avatar->temporaryUrl() }}" class="p-1 bg-primary" width="100" height="100">
                            @else
                                <img src="{{(!empty(auth()->user()->avatar))? url('/uploads/avatars/'.auth()->user()->avatar) : url('/uploads/avatar.png')}}" style="width: 100px; height: 100px">
                            @endif
                        </div>
                        <div class="form-group col-md-6">
                            <label>Name</label>
                            <input wire:model="name" type="text" class="form-control" name="name">
                            @error('name') <span class="error">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label>Email</label>
                            <input wire:model="email" type="email" class="form-control" name="email">
                            @error('email') <span class="error">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group col-md-8">
                            <label>Address</label>
                            <input wire:model="address" type="text" class="form-control" name="address">
                            @error('address') <span class="error">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label>Phone</label>
                            <input wire:model="phone" type="text" class="form-control" name="phone">
                            @error('phone') <span class="error">{{ $message }}</span> @enderror
                        </div>
                        <button class="btn btn-primary" type="submit">Save</button>
                    </form>
                </div>
            </div>
            <div class="card card-primary">
                <div class="card-header">
                    <h4>Update Password</h4>

                </div>
                <div class="card-body">
                    <form wire:submit.prevent="updatePassword">
                        @csrf
                        <div class="form-group col-md-6">
                            <label>Current Password</label>
                            <input wire:model="current_password" type="password" class="form-control" name="current_password">
                            @error('current_password') <span class="error">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label>New Password</label>
                            <input wire:model="password" type="password" class="form-control" name="password">
                            @error('password') <span class="error">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label>Confirm Password</label>
                            <input wire:model="password_confirmation" type="password" class="form-control" name="password_confirmation">
                            @error('password_confirmation') <span class="error">{{ $message }}</span> @enderror
                        </div>

                        <button class="btn btn-primary" type="submit">Save</button>

                    </form>
                </div>
            </div>

        </div>
    </section>
</div>
