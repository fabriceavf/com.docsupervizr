<template>
  <div class="auth-wrapper auth-v1 px-2">
    <div class="auth-inner py-2">

      <!-- Login v1 -->
      <b-card class="mb-0">
        <b-link class="brand-logo">
          <vuexy-logo/>

          <h2 class="brand-text text-primary ml-1">
            Vuexy
          </h2>
        </b-link>

        <b-card-title class="mb-1">
          Welcome to Vuexy! 👋
        </b-card-title>
        <b-card-text class="mb-2">
          Please sign-in to your account and start the adventure
        </b-card-text>

        <!-- form -->
        <validation-observer
            ref="loginForm"
            #default="{invalid}"
        >
          <b-form
              class="auth-login-form mt-2"
              @submit.prevent
          >

            <!-- email -->
            <b-form-group
                label="Email"
                label-for="email"
            >
              <validation-provider
                  #default="{ errors }"
                  name="Email"
                  rules="required|email"
              >
                <b-form-input
                    id="email"
                    v-model="userEmail"
                    :state="errors.length > 0 ? false:null"
                    autofocus
                    name="login-email"
                    placeholder="john@example.com"
                />
                <small class="text-danger">{{ errors[0] }}</small>
              </validation-provider>
            </b-form-group>

            <!-- password -->
            <b-form-group>
              <div class="d-flex justify-content-between">
                <label for="password">Password</label>
                <b-link :to="{name:'auth-forgot-password-v1'}">
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
                      id="password"
                      v-model="password"
                      :state="errors.length > 0 ? false:null"
                      :type="passwordFieldType"
                      class="form-control-merge"
                      name="login-password"
                      placeholder="Password"
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

            <!-- submit button -->
            <b-button
                :disabled="invalid"
                block
                type="submit"
                variant="primary"
            >
              Sign in
            </b-button>
          </b-form>
        </validation-observer>

        <b-card-text class="text-center mt-2">
          <span>New on our platform? </span>
          <b-link :to="{name:'auth-register-v1'}">
            <span>Create an account</span>
          </b-link>
        </b-card-text>

        <div class="divider my-2">
          <div class="divider-text">
            or
          </div>
        </div>

        <!-- social button -->
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
      </b-card>
      <!-- /Login v1 -->
    </div>
  </div>
</template>

<script>
import {ValidationObserver, ValidationProvider} from 'vee-validate'
import {
  BButton,
  BCard,
  BCardText,
  BCardTitle,
  BForm,
  BFormCheckbox,
  BFormGroup,
  BFormInput,
  BInputGroup,
  BInputGroupAppend,
  BLink,
} from 'bootstrap-vue'
import VuexyLogo from '@core/layouts/components/Logo.vue'
import {email, required} from '@validations'
import {togglePasswordVisibility} from '@core/mixins/ui/forms'

export default {
  components: {
    // BSV
    BButton,
    BForm,
    BFormInput,
    BFormGroup,
    BCard,
    BCardTitle,
    BLink,
    VuexyLogo,
    BCardText,
    BInputGroup,
    BInputGroupAppend,
    BFormCheckbox,
    ValidationProvider,
    ValidationObserver,
  },
  mixins: [togglePasswordVisibility],
  data() {
    return {
      userEmail: '',
      password: '',
      status: '',
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
  },
}
</script>

<style lang="scss">
@import '@core/scss/vue/pages/page-auth.scss';
</style>
