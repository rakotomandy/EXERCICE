<!--centered login form with shadow and attracted appearance -->
<div class="row">
    <div class="col-1 col-md-2 col-lg-4"></div>
    <div class="col-10 col-md-8 col-lg-4 px-5 mx-lg-0 shadow p-4 mb-5 bg-warning rounded" style="margin-top: 100px;">
        <form action="" id="login">
            <h1 class="text-center">Login</h1>
            <hr>
            <div class="form-group mb-3">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" id="email" placeholder="Enter email">
            </div>
            <div class="form-group mb-3">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control" id="password" placeholder="Enter password">
            </div>
            <button type="submit" class="btn btn-primary mb-3 w-100">Login</button>
            <span class="text-muted">Don't have an account? <a href="<?= URL . '/Signup' ?>">Sign up</a></span>
        </form>
    </div>
    <div class="col-1 col-md-2 col-lg-4"></div>
</div>