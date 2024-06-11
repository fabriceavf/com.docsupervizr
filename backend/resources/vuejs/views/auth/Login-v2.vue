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
              alt="Login V2"
              fluid
          />
        </div>
      </b-col>
      <!-- /Left Text-->

      <!-- Login-->
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
          <b-card-title
              class="font-weight-bold mb-1"
              title-tag="h2"
          >
            Welcome to Vuexy! 👋
          </b-card-title>
          <b-card-text class="mb-2">
            Please sign-in to your account and start the adventure
          </b-card-text>

          <!-- form -->
          <validation-observer ref="loginValidation">
            <b-form
                class="auth-login-form mt-2"
                @submit.prevent
            >
              <!-- email -->
              <b-form-group
                  label="Email"
                  label-for="login-email"
              >
                <validation-provider
                    #default="{ errors }"
                    name="Email"
                    rules="required|email"
                >
                  <b-form-input
                      id="login-email"
                      v-model="userEmail"
                      :state="errors.length > 0 ? false:null"
                      name="login-email"
                      placeholder="john@example.com"
                  />
                  <small class="text-danger">{{ errors[0] }}</small>
                </validation-provider>
              </b-form-group>

              <!-- forgot password -->
              <b-form-group>
                <div class="d-flex justify-content-between">
                  <label for="login-password">Password</label>
                  <b-link :to="{name:'auth-forgot-password-v2'}">
                    <small>Forgot Password?</small>
                  </b-link>
                </div>
                <validation-provider
                    #default="{ errors }"
                    name="Password"
                    rules="required"
                >
                  <b-input-group
                      :class="errors.length > 0 ? 'is-invalid':null"
                      class="input-group-merge"
                  >
                    <b-form-input
                        id="login-password"
                        v-model="password"
                        :state="errors.length > 0 ? false:null"
                        :type="passwordFieldType"
                        class="form-control-merge"
                        name="login-password"
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

              <!-- checkbox -->
              <b-form-group>
                <b-form-checkbox
                    id="remember-me"
                    v-model="status"
                    name="checkbox-1"
                >
                  Remember Me
                </b-form-checkbox>
              </b-form-group>

              <!-- submit buttons -->
              <b-button
                  block
                  type="submit"
                  variant="primary"
                  @click="validationForm"
              >
                Sign in
              </b-button>
            </b-form>
          </validation-observer>

          <b-card-text class="text-center mt-2">
            <span>New on our platform? </span>
            <b-link :to="{name:'page-auth-register-v2'}">
              <span>&nbsp;Create an account</span>
            </b-link>
          </b-card-text>

          <!-- divider -->
          <div class="divider my-2">
            <div class="divider-text">
              or
            </div>
          </div>

          <!-- social buttons -->
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
      <!-- /Login-->
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
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'

export default {
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
    VuexyLogo,
    ValidationProvider,
    ValidationObserver,
  },
  mixins: [togglePasswordVisibility],
  data() {
    return {
      status: '',
      password: '',
      userEmail: '',
      sideImg: require('@/assets/images/pages/login-v2.svg'),
      // validation rulesimport store from '@/store/index'
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
    validationForm() {
      this.$refs.loginValidation.validate().then(success => {
        if (success) {
          this.$toast({
            component: ToastificationContent,
            props: {
              title: 'Form Submitted',
              icon: 'EditIcon',
              variant: 'success',
            },
          })
        }
      })
    },
  },
}
</script>

<style lang="scss">
@import '@core/scss/vue/pages/page-auth.scss';
</style>
