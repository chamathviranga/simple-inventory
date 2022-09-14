@extends('layouts.layout')
@section('dashboard','active')
@section('title','Dashboard')
@section('content')

<div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Dashboard</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                {{-- <li class="breadcrumb-item active">Dashboard</li> --}}
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        
            <section class="content">
                <div class="container-fluid">

                    <div class="row">
                        
                        {{-- <info-box 
                        :count=150
                        info-label="Items"
                        button-name="More info"
                        bg-color="bg-info"
                        card-icon="fa fa-shopping-bag"
                        > </info-box>

                        <info-box 
                        :count=53
                        info-label="Categories"
                        button-name="More info"
                        bg-color="bg-success"
                        card-icon="fa fa-bar-chart"
                        > </info-box>

                        <info-box 
                        :count=44
                        info-label="Stock"
                        button-name="More info"
                        bg-color="bg-warning"
                        card-icon="fa fa-user-plus"
                        > </info-box>

                        <info-box 
                        :count=65
                        info-label="Unvailable Items"
                        button-name="More info"
                        bg-color="bg-danger"
                        card-icon="fa fa-pie-chart"
                        > </info-box> --}}

                        <info-box 
                        :count=44
                        info-label="Stock"
                        button-name="More info"
                        bg-color="bg-warning"
                        card-icon="fa fa-user-plus"
                        > </info-box>
                     
                    </div>
                </div>
            </section>
        </div>

@endsection

@push('script')
   
   <script>

   </script>

@endpush