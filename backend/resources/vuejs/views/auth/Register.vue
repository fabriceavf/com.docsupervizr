<template>
  <div class="auth-wrapper auth-v2">
    <b-row class="auth-inner m-0">

      <!-- Brand logo-->
      <b-link class="brand-logo">
        <vuexy-logo/>

        <h2 class="brand-text text-primary ml-1">
          Vuexy
        </h2>
      </b-link>
      <!-- /Brand logo-->

      <!-- Left Text-->
      <b-col
          class="d-none d-lg-flex align-items-center p-5"
          lg="8"
      >
        <div class="w-100 d-lg-flex align-items-center justify-content-center px-5">
          <b-img
              :src="imgUrl"
              alt="Register V2"
              fluid
          />
        </div>
      </b-col>
      <!-- /Left Text-->

      <!-- Register-->
      <b-col
          class="d-flex align-items-center auth-bg px-2 p-lg-5"
          lg="4"
      >
        <b-col
            class="px-xl-2 mx-auto"
            lg="12"
            md="6"
            sm="8"
        >
          <b-card-title class="mb-1">
            Adventure starts here 🚀
          </b-card-title>
          <b-card-text class="mb-2">
            Make your app management easy and fun!
          </b-card-text>

          <!-- form -->
          <validation-observer
              ref="registerForm"
              #default="{invalid}"
          >
            <b-form
                class="auth-register-form mt-2"
                @submit.prevent="register"
            >
              <!-- username -->
              <b-form-group
                  label="Username"
                  label-for="register-username"
              >
                <validation-provider
                    #default="{ errors }"
                    name="Username"
                    rules="required"
                    vid="username"
                >
                  <b-form-input
                      id="register-username"
                      v-model="username"
                      :state="errors.length > 0 ? false:null"
                      name="register-username"
                      placeholder="johndoe"
                  />
                  <small class="text-danger">{{ errors[0] }}</small>
                </validation-provider>
              </b-form-group>

              <!-- email -->
              <b-form-group
                  label="Email"
                  label-for="register-email"
              >
                <validation-provider
                    #default="{ errors }"
                    name="Email"
                    rules="required|email"
                    vid="email"
                >
                  <b-form-input
                      id="register-email"
                      v-model="userEmail"
                      :state="errors.length > 0 ? false:null"
                      name="register-email"
                      placeholder="john@example.com"
                  />
                  <small class="text-danger">{{ errors[0] }}</small>
                </validation-provider>
              </b-form-group>

              <!-- password -->
              <b-form-group
                  label="Password"
                  label-for="register-password"
              >
                <validation-provider
                    #default="{ errors }"
                    name="Password"
                    rules="required"
                    vid="password"
                >
                  <b-input-group
                      :class="errors.length > 0 ? 'is-invalid':null"
                      class="input-group-merge"
                  >
                    <b-form-input
                        id="register-password"
                        v-model="password"
                        :state="errors.length > 0 ? false:null"
                        :type="passwordFieldType"
                        class="form-control-merge"
                        name="register-password"
                        placeholder="············"
                    />
                    <b-input-group-append is-text>
                      <feather-icon
                          :icon="passwordToggleIcon"
                          class="cursor-pointer"
                          @click="togglePasswordVisibility"
                      />
                    </b-input-group-append>
                  </b-input-group>
                  <small class="text-danger">{{ errors[0] }}</small>
                </validation-provider>
              </b-form-group>

              <b-form-group>
                <b-form-checkbox
                    id="register-privacy-policy"
                    v-model="status"
                    name="checkbox-1"
                >
                  I agree to
                  <b-link>privacy policy & terms</b-link>
                </b-form-checkbox>
              </b-form-group>

              <b-button
                  :disabled="invalid"
                  block
                  type="submit"
                  variant="primary"
              >
                Sign up
              </b-button>
            </b-form>
          </validation-observer>

          <p class="text-center mt-2">
            <span>Already have an account?</span>
            <b-link :to="{name:'auth-login'}">
              <span>&nbsp;Sign in instead</span>
            </b-link>
          </p>

          <!-- divider -->
          <div class="divider my-2">
            <div class="divider-text">
              or
            </div>
          </div>

          <div class="auth-footer-btn d-flex justify-content-center">
            <b-button
                href="javascript:void(0)"
                variant="facebook"
            >
              <feather-icon icon="FacebookIcon"/>
            </b-button>
            <b-button
                href="javascript:void(0)"
                variant="twitter"
            >
              <feather-icon icon="TwitterIcon"/>
            </b-button>
            <b-button
                href="javascript:void(0)"
                variant="google"
            >
              <feather-icon icon="MailIcon"/>
            </b-button>
            <b-button
                href="javascript:void(0)"
                variant="github"
            >
              <feather-icon icon="GithubIcon"/>
            </b-button>
          </div>
        </b-col>
      </b-col>
      <!-- /Register-->
    </b-row>
  </div>
</template>

<script>
/* eslint-disable global-require */
import {ValidationObserver, ValidationProvider} from 'vee-validate'
import VuexyLogo from '@core/layouts/components/Logo.vue'
import {
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
} from 'bootstrap-vue'
import {email, required} from '@validations'
import {togglePasswordVisibility} from '@core/mixins/ui/forms'
import store from '@/store/index'
import useJwt from '@/auth/jwt/useJwt'

export default {
  components: {
    VuexyLogo,
    BRow,
    BImg,
    BCol,
    BLink,
    BButton,
    BForm,
    BCardText,
    BCardTitle,
    BFormCheckbox,
    BFormGroup,
    BFormInput,
    BInputGroup,
    BInputGroupAppend,
    // validations
    ValidationProvider,
    ValidationObserver,
  },
  mixins: [togglePasswordVisibility],
  data() {
    return {
      status: '',
      username: '',
      userEmail: '',
      password: '',
      sideImg: require('@/assets/images/pages/register-v2.svg'),
      // validation
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
        this.sideImg = require('@/assets/images/pages/register-v2-dark.svg')
        return this.sideImg
      }
      return this.sideImg
    },
  },
  methods: {
    register() {
      this.$refs.registerForm.validate().then(success => {
        if (success) {
          useJwt.register({
            username: this.username,
            email: this.userEmail,
            password: this.password,
          })
              .then(response => {
                useJwt.setToken(response.data.accessToken)
                useJwt.setRefreshToken(response.data.refreshToken)
                localStorage.setItem('userData', JSON.stringify(response.data.userData))
                this.$ability.update(response.data.userData.ability)
                this.routeDatar.push('/')
              })
              .catch(error => {
                this.$refs.registerForm.setErrors(error.response.data.error)
              })
        }
      })
    },
  },
}
/* eslint-disable global-require */
</script>

<style lang="scss">
@import '@core/scss/vue/pages/page-auth.scss';
</style>
