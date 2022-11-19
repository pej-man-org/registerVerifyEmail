<div>
    <div class="login-box" style="display : @unless($emailSent) block @else none @endunless">
        <h2>Register</h2>
        <h2 wire:loading>Please Wait</h2>
        <form>
            <div class="user-box">
                <input type="text" wire:model.debounce.500ms="email">
                <label>
                    @error('email')
                        {{ $message }}
                    @else
                        Email adress
                    @enderror
                </label>
            </div>
            <div class="user-box">
                <input type="password" wire:model.debounce.500ms="password">
                <label>
                    @error('password')
                        {{ $message }}
                    @else
                        Password
                    @enderror
                </label>
            </div>
            <a href="#" wire:click="login">
                <span></span>
                <span></span>
                <span></span>
                <span></span>
                Log in
            </a>
            <a href="#" wire:click="register">
                <span></span>
                <span></span>
                <span></span>
                <span></span>
                Create
            </a>
        </form>
    </div>
    <div class="login-box" style="display : @if ($emailSent) block @else none @endif">
        <h2>Enter Verification Code</h2>
        <form>
            <div class="user-box">
                <input type="text" wire:model="code">
                <label>
                    @error('code')
                        {{ $message }}
                    @else
                        Verification Code
                    @enderror
                </label>
            </div>
            <a href="#" wire:click="submit">
                <span></span>
                <span></span>
                <span></span>
                <span></span>
                Submit
            </a>
        </form>
    </div>
</div>
