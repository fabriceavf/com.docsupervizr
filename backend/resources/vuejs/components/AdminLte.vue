<template>
  <div class="wrapper">
    <TempNavBar/>
    <TempSideBar/>
    <div class="content-wrapper">
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">
                <slot name="breadcrumb_title"></slot>
              </h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                  <router-link to="/">Tableau de bord</router-link>
                </li>
                <slot name="breadcrumb_pages"></slot>
              </ol>
            </div>
          </div>
        </div>
      </div>
      <div class="content">
        <div class="container-fluid">
          <slot name="content"></slot>
        </div>
      </div>
    </div>
    <TempRightBar/>
    <TempFooter/>
  </div>
</template>

<script>
import 'admin-lte/dist/css/adminlte.min.css'
import '@fortawesome/fontawesome-free/css/fontawesome.css'
import '@fortawesome/fontawesome-free/css/regular.css'
import '@fortawesome/fontawesome-free/css/brands.css'
import '@fortawesome/fontawesome-free/css/solid.css'
import '@fortawesome/fontawesome-free/js/all'
import 'jquery/dist/jquery'
import 'bootstrap/dist/js/bootstrap.bundle'
import 'admin-lte/dist/js/adminlte'
import TempNavBar from './layouts/NavBar'
import TempSideBar from './layouts/SideBar'
import TempRightBar from './layouts/RightBar'
import TempFooter from './layouts/Footer'

export default {
  name: 'AdminLte',
  components: { TempNavBar, TempSideBar, TempRightBar, TempFooter }
}
</script>
