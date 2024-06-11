<template>
  <b-col>
    <b-col>
      <b-card-title class="mb-1 font-weight-bold" title-tag="h2">
        Bienvenu sur supervizr
      </b-card-title>
      <b-card-text class="mb-2">
        Veuillez entrez vos identifiant pour vous connecter
      </b-card-text>

      <b-overlay :show="isLoading">
        <validation-observer ref="loginForm" >
          <b-form class="auth-login-form mt-2" @submit.prevent="login">
            <!-- email -->
            <b-form-group label="Email" label-for="login-email">
              <validation-provider #default="{ errors }" name="Email" rules="required|email" vid="email">
                <b-form-input id="login-email" v-model="userEmail" :state="errors.length > 0 ? false : null"
                  name="login-email" />
                <small class="text-danger">{{ errors[0] }}</small>
              </validation-provider>
            </b-form-group>

            <!-- forgot password -->
            <b-form-group>
              <div class="d-flex justify-content-between">
                <label for="login-password">Password</label>
                <b-link :to="{ name: 'auth-forgot-password' }">
                  <small>Forgot Password?</small>
                </b-link>
              </div>
              <validation-provider #default="{ errors }" name="Password" rules="required" vid="password">
                <b-input-group :class="errors.length > 0 ? 'is-invalid' : null" class="input-group-merge">
                  <b-form-input id="login-password" v-model="password" :state="errors.length > 0 ? false : null"
                    :type="passwordFieldType" class="form-control-merge" name="login-password" />
                  <b-input-group-append is-text>
                    <feather-icon :icon="passwordToggleIcon" class="cursor-pointer" @click="togglePasswordVisibility" />
                  </b-input-group-append>
                </b-input-group>
                <small class="text-danger">{{ errors[0] }}</small>
              </validation-provider>
            </b-form-group>

            <!-- checkbox -->
            <b-form-group>
              <b-form-checkbox id="remember-me" v-model="status" name="checkbox-1">
                Se souvenir de moi
              </b-form-checkbox>
            </b-form-group>

            <!-- submit buttons -->
            <b-button :disabled="invalid" block type="submit" variant="primary">
              Connection
            </b-button>
          </b-form>
        </validation-observer>

      </b-overlay>

    </b-col>
  </b-col>
</template>

<script>
/* eslint-disable global-require */
import $ from 'jquery'
import { ValidationObserver, ValidationProvider } from 'vee-validate'
import VuexyLogo from '@core/layouts/components/Logo.vue'
import {
  BAlert,
  BButton,
  BCardText,
  BCardTitle,
  BCol,
  BForm,
  BFormCheckbox,
  BFormGroup,
  BFormInput,
  BImg,
  BInputGroup,
  BInputGroupAppend,
  BLink,
  BRow,
  VBTooltip,
} from 'bootstrap-vue'
import useJwt from '@/auth/jwt/useJwt'
import { email, required } from '@validations'
import { togglePasswordVisibility } from '@core/mixins/ui/forms'
import store from '@/store/index'
import { getHomeRouteForLoggedInUser } from '@/auth/utils'

import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'

export default {
  directives: {
    'b-tooltip': VBTooltip,
  },
  components: {
    BRow,
    BCol,
    BLink,
    BFormGroup,
    BFormInput,
    BInputGroupAppend,
    BInputGroup,
    BFormCheckbox,
    BCardText,
    BCardTitle,
    BImg,
    BForm,
    BButton,
    BAlert,
    VuexyLogo,
    ValidationProvider,
    ValidationObserver,
  },
  mixins: [togglePasswordVisibility],
  data() {
    return {
      isLoading: false,
      status: '',
      password: '',
      userEmail: '',
      sideImg: require('@/assets/images/pages/login-v2.svg'),

      // validation rules
      required,
      email,
    }
  },
   computed: {$routeData:function(){let router = {meta:{}};try{router=window.routeData}catch (e) {};return router; },
        routeData:function () {
            let router={meta:{}}
            if(window.router){
                try{ router=window.router; }catch (e) { }
            }


            return router
        },
    passwordToggleIcon() {
      return this.passwordFieldType === 'password' ? 'EyeIcon' : 'EyeOffIcon'
    },
    imgUrl() {
      if (store.state.appConfig.layout.skin === 'dark') {
        // eslint-disable-next-line vue/no-side-effects-in-computed-properties
        this.sideImg = require('@/assets/images/pages/login-v2-dark.svg')
        return this.sideImg
      }
      return this.sideImg
    },
  },
  methods: {
    login() {
      this.$refs.loginForm.validate().then(success => {
        if (success) {
          this.isLoading = true
          useJwt.login({
            email: this.userEmail,
            password: this.password
          })
            .then(response => {

              const { userData } = response.data
              const today = new Date();
              const date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();
              const time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
              const connectData = date + ' ' + time;
              useJwt.setToken(response.data.accessToken)
              useJwt.setRefreshToken(response.data.refreshToken)
              this.$store.commit('general/setUserData')
              localStorage.setItem('userData', JSON.stringify(userData))
              localStorage.setItem('connectData', JSON.stringify(connectData))
              console.log('this=>', this)
              this.$ability.update(userData.ability)
              // console.log('voici luser',userData,response.data)

              // ? This is just for demo purpose. Don't think CASL is role based in this case, we used role in if condition just for ease
              this.routeDatar.replace(getHomeRouteForLoggedInUser(userData.role))
                .then(() => {
                  this.$toast({
                    component: ToastificationContent,
                    position: 'top-right',
                    props: {
                      title: `Welcome ${userData.fullName || userData.username}`,
                      icon: 'CoffeeIcon',
                      variant: 'success',
                      text: `You have successfully logged in as ${userData.role}. Now you can start to explore!`,
                    },
                  })
                })
            })
            .catch(error => {

              this.isLoading = false
              console.error('voici lerrur=>', error)
              this.$refs.loginForm.setErrors(error.response.data.error)
            })
        }
      })
    },
  },
  mounted() {
    $("#app").css({
      display: 'flex'
    })
  },
  destroyed() {
    $("#app").css({
      display: 'block'
    })
  }

}
</script>

<style lang="scss">
@import '@core/scss/vue/pages/page-auth.scss';
</style>
