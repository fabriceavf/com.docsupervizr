@php

    $__internalId__=request()->get('__internalId__');


@endphp


@extends('layouts/contentLayoutMaster')
@section('vendor-style')
    <!-- vendor css files -->

    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap4.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap4.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/file-uploaders/dropzone.min.css')) }}">
@endsection
@section('page-style')
    <link href="{{asset(mix('css/personnal/editor/editor_beau_formulaire.css'))}}" rel="stylesheet" type="text/css">
    <link href="{{asset(mix('css/personnal/admin/admin.css'))}}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-file-uploader.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/tables/datatables.searchHighLight.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/tables/select.datatables.css')) }}">


    @livewireStyles


    <style>

        #Branches_{{$__internalId__}} thead {
            display: none !important;
        }

        #Branches_{{$__internalId__}}_parents .dt-buttons {
            margin: 0 auto;
            width: 90%;
            display: block;
            justify-content: center;
            text-align: center;
        }


        #Branches_{{$__internalId__}}_parents .DTE_Body {
            border: 1px solid #cacaca !important;
            width: 90%;
            margin: 0 auto;
            padding: 20px !important;
        }


        #Branches_{{$__internalId__}}_parents tbody {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
            width: 95%;
            margin: 0 auto;
        }

        #Branches_{{$__internalId__}}_parents tbody tr {


        }

        #Branches_{{$__internalId__}}_parents tbody tr td {
            display: flex;
            padding: 0px !important;
        }

        #Branches_{{$__internalId__}}_parents tbody .branches_elements {

            order: 0;
            border-radius: 5px;
            border: 1px solid #d9d2d2;
            width: 100%;
            padding: 10px;

        }

        #Branches_{{$__internalId__}}_parents tbody .branches_elements.base {
            background: #cdb4db;
            color: #fff;
        }

        #Branches_{{$__internalId__}}_parents tbody .branches_elements.questions {
            background: red;
            color: #fff;
        }

        #Branches_{{$__internalId__}}_parents .parents {
            flex: 1 0 100%;
            cursor: pointer;
            padding: 5px


        }

        #Branches_{{$__internalId__}}_parents .parents .all_buttons {
            display: none;


        }


    </style>

@endsection

@section('title',"branches")
@section('content')

    {{--    <div class="container">--}}
    {{--        <div class="row">--}}
    {{--            <div class="col-sm-6"><livewire:diagnosticsarbres family="1540"  type="Admin" /></div>--}}
    {{--            <div class="col-sm-6"> <livewire:diagnosticsarbres family="1540" /></div>--}}
    {{--        </div>--}}
    {{--    </div>--}}

    {{--    <div class="container">--}}

    {{--        <div class="row">--}}
    {{--            <div class="col-sm-12">--}}
    {{--                <livewire:pages--}}
    {{--                    base="branches"--}}
    {{--                                _parent_key="__key__adn"--}}
    {{--                                _parent_val="adn"--}}
    {{--                />--}}
    {{--            </div>--}}

    {{--        </div>--}}
    {{--        <div class="row">--}}
    {{--            <div class="col-sm-6"><livewire:diagnosticsarbres family="1540"  type="Admin"  personalId="10"/></div>--}}
    {{--            <div class="col-sm-6"> <livewire:diagnosticsarbres family="1540" /></div>--}}
    {{--        </div>--}}
    {{--    </div>--}}
    {{--    <div class="container">--}}
    {{--        <div class="row">--}}
    {{--            <div class="col-sm-12"><livewire:routagesarbres family="154012"  type="Admin"  personalId="10"/></div>--}}
    {{--            <div class="col-sm-6"> <livewire:routagesarbres family="154012" /></div>--}}
    {{--        </div>--}}

    {{--    </div>--}}



    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <arbres-diags id="teste"
                              urlCreate="{{ URL::signedRoute('Base_Branches_web_create') }}"
                              urlUpdate="{{route('Base_Branches_web_index')}}/_id_/update"
                              urlRemove="{{route('Base_Branches_web_index')}}/_id_/delete"
                              urlDataBase="{{route('Base_Branches_web_index_data')}}"
                              family="1000"
                              type="Admin"

                />
            </div>
            <div class="col-sm-6">
                <arbres-diags
                        urlCreate="{{ URL::signedRoute('Base_Branches_web_create') }}"
                        urlUpdate="{{route('Base_Branches_web_index')}}/_id_/update"
                        urlRemove="{{route('Base_Branches_web_index')}}/_id_/delete"
                        urlDataBase="{{route('Base_Branches_web_index_data')}}"

                        family="1000"

                />
            </div>
        </div>

    </div>



    <div class="btn btn-primary" id="btt">Changer</div>

@endsection
@section('vendor-script')

    <script>

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name=\'csrf-token\']').attr('content')
            }
        });


    </script>
    <!-- vendor files -->
    <script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.bootstrap4.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap4.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.select.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/buttons.bootstrap4.min.js')) }}"></script>

    <script src="{{asset('vendors/js/tables/datatable/dataTables.editor.min.js')}}"></script>
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/dropzone.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/ckeditor/ckeditor.complet.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/jquery/jquery.hightlight.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/search.hightlight.min.js')) }}"></script>


    <script src="{{ asset(mix('vendors/js/tables/datatable/RowReorder/dataTables.rowReorder.min.js')) }}"></script>

@endsection
@section('page-script')
    @livewireScripts

    <script src="{{ asset(mix('js/personnal/editor/editor_personnal_field.js')) }}"></script>
    <script src="{{ asset('js/personnal/customElement.js') }}"></script>
    {{--    <script src="{{ asset(mix('vendors/js/vuejs/vue2.js')) }}"></script>--}}
    <script src="https://cdn.jsdelivr.net/npm/vue@2.7.13/dist/vue.js"></script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct"
            crossorigin="anonymous"></script>


    <script>
        let i = 0
        $('#btt').on('click', function () {
            alert('on veut changer la valeur de lelement')
            $('#teste').attr('family', 1000 + i)
            i = i + 1
        })
    </script>














    <script>
        $('.tab-content').append($('.tab-extra'))
    </script>

@endsection
