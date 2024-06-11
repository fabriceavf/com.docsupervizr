<template>
  <div class="login-box">
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <a class="h1" href="/"><b>Supervizr</b></a>
      </div>
      <div class="card-body">
        <p class="login-box-msg">Veuillez confirmer votre mot de passe avant de continuer</p>
        <form action="" method="POST">
          <div class="input-group mb-3">
            <input id="password" autocomplete="current-password" class="form-control" name="password" required
                   type="password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <button class="btn btn-primary btn-block" type="submit">Confirmer le mot de passe</button>
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
