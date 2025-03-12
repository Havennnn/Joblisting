<form wire:submit="login">
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" wire:model.live="form.email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
        @error('form.email') <span class="text-red-500">{{ $message }}</span> @enderror
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" wire:model.live="form.password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
        @error('form.password') <span class="text-red-500">{{ $message }}</span> @enderror
    </div>

    <div class="d-flex justify-content-between align-items-center">
        <a href="#" class="text-decoration-none">Forgot Password?</a>
        <button type="submit" class="btn btn-primary">Log In</button>
    </div>
</form>
