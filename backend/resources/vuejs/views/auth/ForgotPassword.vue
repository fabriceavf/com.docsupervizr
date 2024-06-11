<template>
  <div class="login-box">
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <a href=""><b>Mot de passe oublié</b></a>
      </div>
      <div class="card-body">
        <p class="login-box-msg">
          Vous avez oublié votre mot de passe ? Ici, vous pouvez facilement récupérer un nouveau mot de passe.
        </p>
        <form action="" method="POST">
          <div class="input-group mb-3">
            <input id="email" autocomplete="email" autofocus class="form-control" name="email"
                   placeholder="Votre adresse email"
                   required type="email" value="">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <button class="btn btn-primary btn-block" type="submit">Envoyer le lien de réinitialisation du mot de
                passe
              </button>
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
