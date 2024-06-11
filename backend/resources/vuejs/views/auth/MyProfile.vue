<template>
  <AdminLte>
    <template #breadcrumb_title>
      Mon profil
    </template>
    <template #breadcrumb_pages>
      <li class="breadcrumb-item active">
        Mon compte > profil
      </li>
    </template>
    <template #content>
      <div class="d-flex justify-content-center row">
        <div class="col-md-3">
          <!-- Profile Image -->
          <div class="card card-primary card-outline">
            <div class="card-body box-profile">
              <div class="text-center">
                <img :src="'/'" alt="User profile picture" class="profile-user-img img-fluid img-circle">
              </div>

              <h3 class="profile-username text-center">juste</h3>

              <a class="btn btn-secondary btn-block mt-1" href="#" @click.prevent="deletePhoto()"><b>Retirer la
                photo</b></a>
              <a class="btn btn-success btn-block mt-1" href="#" @click.prevent="selectPhoto()"><b>Changer de photo</b></a>
              <form v-on:submit.prevent="change_photo()">
                <input id="photo" class="invisible" type="file" @change="OnchangePhoto">
              </form>

            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->

        </div>

        <!-- /.col -->
        <div class="col-md-6">
          <div class="card">
            <div class="card-header p-2">
              <h5 class="card-title">Mot de passe </h5>
            </div><!-- /.card-header -->
            <div class="card-body">
              <form class="form-horizontal" v-on:submit.prevent="update_password()">
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Ancien mot de passe</label>
                  <div class="col-sm-8">
                    <input v-model="current_password" class="form-control" required type="password">
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Nouveau mot de passe</label>
                  <div class="col-sm-8">
                    <input v-model="new_password" class="form-control" required type="password">
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Confirmation </label>
                  <div class="col-sm-8">
                    <input v-model="password_confirmation" class="form-control" required type="password">
                  </div>
                </div>

                <div class="form-group row">
                  <div class="float-right">
                    <button class="btn btn-success" type="submit">Mettre à jour</button>
                  </div>
                </div>
              </form>
            </div><!-- /.card-body -->
          </div>
          <!-- /.card -->
          <div class="card">
            <div class="card-header p-2">
              <h5 class="card-title">Mes informations</h5>
            </div><!-- /.card-header -->
            <div class="card-body">
              <div id="settings" class="active tab-pane">
                <form class="form-horizontal" method="post" v-on:submit.prevent="update()">
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Nom d'utilisateur</label>
                    <div class="col-sm-8">
                      <input v-model="name" class="form-control" required type="text">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Email</label>
                    <div class="col-sm-8">
                      <input v-model="email" class="form-control" readonly type="email">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Telephone</label>
                    <div class="col-sm-8">
                      <input v-model="phone_number" class="form-control" placeholder="exp: +241 077207720" type="text">
                    </div>
                  </div>

                  <div class="form-group row">
                    <div class="float-right">
                      <button class="btn btn-success" type="submit">Mettre à jour</button>
                    </div>
                  </div>
                </form>
              </div>
            </div><!-- /.card-body -->
          </div>
        </div>
        <!-- /.col -->
      </div>
    </template>
  </AdminLte>

</template>
<script>
import AdminLte from '@/components/AdminLte'

export default {
  components: {AdminLte},
  data() {
    return {
      photo: '',
      reset_photo: '',
      name: '',
      email: '',
      phone_number: '',
      successMsg: '',
      errorMsg: '',
      current_password: '',
      new_password: '',
      password_confirmation: ''
    }
  },
  methods: {
    selectPhoto() {
      document.getElementById('photo').click()
    },
    OnchangePhoto(e) {
      this.$store.commit('setLoading', true)
      const config = {
        headers: {'Content-Type': 'multipart/form-data'}
      }
      const data = new FormData()
      data.append('photo', e.target.files[0])

      this.axios.post('/mon-compte/photo/' + this.$store.state._auth.id, data, config).then(response => (
          console.log(response.data)
      )).catch(error => {
        console.log(error)
      })
    },
    deletePhoto() {
      this.$store.commit('setLoading', true)
      const data = new FormData()
      data.append('reset_photo', '1')

      this.axios.post('/mon-compte/photo/' + this.$store.state._auth.id, data).then(response => (
          console.log(response.data)
      )).catch(error => {
        console.log(error)
      })
    },
    update() {
      this.$store.commit('setLoading', true)
      const data = new FormData()
      data.append('name', this.name)
      data.append('phone_number', this.phone_number)

      this.axios.post('/mon-compte/' + this.$store.state._auth.id, data).then(response => (
          console.log(response.data)
      )).catch(error => {
        console.log(error)
      })
    },
    update_password() {
      this.$store.commit('setLoading', true)
      const data = new FormData()
      data.append('current_password', this.current_password)
      data.append('new_password', this.new_password)
      data.append('password_confirmation', this.password_confirmation)

      this.axios.post('/mon-compte/mot-de-passe/' + this.$store.state._auth.id, data).then(response => (
          console.log(response.data)
      )).catch(error => {
        console.log(error)
      })
    }

  }
}
</script>
