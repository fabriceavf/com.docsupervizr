<template>
  <section class="content-header">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>
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
  </section>
</template>
