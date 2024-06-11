<template>

  <div class="col-sm-12">
    <div class="login-box">
      <div class="card card-outline card-primary">
        <div class="card-header text-center">
          <b>Supervizr</b>
        </div>
        <div class="card-body">
          <p class="login-box-msg">Content de vous revoir, connectez-vous</p>

          <div v-if="errors" class="alert alert-danger" role="alert">
            {{ errors }}
          </div>
          <b-overlay :show="isLoading">
            <validation-observer
                ref="loginForm"
                #default="{invalid}"
            >
              <b-form
                  class="auth-login-form mt-2"
                  @submit.prevent="login"
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
                      vid="email"
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
                    <b-link :to="{name:'auth-forgot-password'}">
                      <small>Forgot Password?</small>
                    </b-link>
                  </div>
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
                          id="login-password"
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

                <!-- submit buttons -->
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
          </b-overlay>

          <p class="mt-2 text-center">
            <a href="/mot-de-passe-oublie">
              Mot de passe oublié ?
            </a>
          </p>
        </div>
      </div>
    </div>

  </div>


</template>

<script>
import {ValidationObserver, ValidationProvider} from 'vee-validate'
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
import {getHomeRouteForLoggedInUser} from '@/auth/utils'
import ToastificationContent from "@core/components/toastification/ToastificationContent.vue";


export default {
  name: 'LoginView',

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
  data() {
    return {
      isLoading: false,
      errors: '',
      form: {
        email: '',
        password: ''
      }
    }
  },
  methods: {
    login() {
      this.$refs.loginForm.validate().then(success => {
        if (success) {
          useJwt.login({
            email: this.userEmail,
            password: this.password,
          })
              .then(response => {
                const {userData} = response.data
                useJwt.setToken(response.data.accessToken)
                useJwt.setRefreshToken(response.data.refreshToken)
                localStorage.setItem('userData', JSON.stringify(userData))
                this.$ability.update(userData.ability)

                // ? This is just for demo purpose as well.
                // ? Because we are showing eCommerce app's cart items count in navbar
                this.$store.commit('app-ecommerce/UPDATE_CART_ITEMS_COUNT', userData.extras.eCommerceCartItemsCount)

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
                this.$refs.loginForm.setErrors(error.response.data.error)
              })
        }
      })
    },
  }
}
</script>
<style>
#app {
  height: 100% !important;
  display: flex;
  align-items: center;
  justify-content: center;
}

th {
  text-align: center;
}
</style>
