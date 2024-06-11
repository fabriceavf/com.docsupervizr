<template>
  <div class="login-box">
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <a class="h1" href=""><b>Supervizr</b></a>
      </div>
      <div class="card-body">
        <p class="login-box-msg">Réinitialiser le mot de passe</p>
        <form action="" method="POST">
          <div class="input-group mb-3">
            <input id="email" autocomplete="email" autofocus class="form-control" name="email" required type="email"
                   value="">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input id="password" autocomplete="new-password" class="form-control" name="password"
                   placeholder="mot de passe"
                   required type="password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input id="password-confirm" autocomplete="new-password" class="form-control" name="password_confirmation"
                   placeholder="confirmer mot de passe" required type="password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <button class="btn btn-primary btn-block" type="submit">Changer le mot de passe</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
export default {}
</script>
