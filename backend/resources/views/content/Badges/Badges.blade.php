@extends('layouts/contentLayoutMaster')

@section('title', 'Badges')

@section('content')
    <!-- Page layout -->
    <div id="app"></div>
    <!--/ Page layout -->

    @vite("resources/views/content/Badges/main.js")

    <script>

        class Server {
            url = false;
            data = [];
            _on = {}
            _one = {}

            constructor(url) {

            }

            // Fonction qui me permet de mettre a jour lurl
            setUrl(newUrl) {
                this.url = newUrl
            }

            getUrl(newUrl) {
                this.url = newUrl
            }

            on(name, callBack) {
                let data = [];
                if (Array.isArray(this._on[name])) {
                    data = this._on[name];
                }
                data.push(callBack)
                let identifiant = data.length - 1
                this._on[name] = data
                return identifiant

            }

            one(name, callBack) {


            }

            deleteOn(name, identifiant) {
                let data = [];
                if (Array.isArray(this._on[name])) {
                    data = this._on[name];
                }
                this._on[name] = data.filter((value, index) => index != identifiant)
            }

            setData(newValue) {

            }

            SearchGlobal(query, columns, type) {

            }

            load(load) {

            }

        }
    </script>
@endsection
