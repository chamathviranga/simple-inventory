@extends('layouts.layout')
@section('stocks', 'active')
@section('title', 'Items')
@section('content')

    <!-- Modal: create update -->
    <div class="modal fade" id="addNewStock" tabindex="-1" role="dialog" aria-labelledby="addNewStockLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="addNewStockLabel">Manage Stock</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="add-new-stock" method="POST" action="{{ route('stock.store') }}">
                        @csrf
                        <input type="hidden" name="_method" id="_method-create-update" value="POST">
                        <div class="form-group">
                            <label for="name">Item</label>

                            <input list="items" name="item_id" id="item" class="form-control @error('item_id') is-invalid @enderror" oninput="getItems(this)" value="{{ old('item_id') }}">

                            <datalist id="items">
                            </datalist>

                            @error('item_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">Quantity</label>
                            <input type="number" name="qty" id="qty"
                                class="form-control @error('qty') is-invalid @enderror text-right" placeholder="0.00" value="{{ old('qty') }}">

                            @error('qty')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="$('#add-new-stock').submit()">Save
                        changes</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        @include('layouts.message')

        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Stock</h1>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            {{-- <li class="breadcrumb-item active">Dashboard</li> --}}
                        </ol>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">My Stock</h3>

                                <div class="card-tools">
                                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addNewStock"><i
                                            class="fas fa-plus"></i> Add To Stock</button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Item</th>
                                            <th class="text-right">Stock</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @forelse ($stockList as $index => $stock)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $stock->name }}</td>
                                                <td class="text-right">{{ $stock->qty }}</td>
                                                <td class="text-center">
                                                <button class="btn btn-sm btn-dark" data-toggle="modal"
                                                    data-target="#addNewStock"
                                                    onclick="getSelectedItemStock('{{ route('stock.edit', ['stock' => $stock->id]) }}')">
                                                    <i class="fa fa-file text-primary"></i>
                                                    <span class="">Change</span>
                                                </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center">
                                                    <span class="text-danger">no stocks to display</span>
                                                </td>
                                            </tr>
                                        @endforelse

                                    </tbody>
                                </table>

                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>

                @if (!empty($categoryList))
                    <div class="row mt-2 ml-1">
                        {{ $categoryList->links() }}
                    </div>
                @endif
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

@endsection

@push('script')
    <script type="text/javascript">
        @if (!empty($errors->first()))
            $('#addNewStock').modal({
                show: true
            });
        @endif

        //Change form mode : POST / PUT
        const changeSubmitMethod = (id = null, reqMethod = 'update') => {

            if (reqMethod === 'update' && id === null) return false;

            let requestType = 'POST';
            let requestAPI = '{{ route('stock.store') }}';

            if (reqMethod == 'update') {
                requestType = 'PUT';
                requestAPI = '{{ route('stock.update', ['stock' => '_stock_']) }}';
            }

            document.getElementById('_method-create-update').value = requestType;
            document.getElementById('add-new-stock').setAttribute('action', requestAPI.replace('_stock_', id));
        }


        //Get category data: callback
        const setStockValuesToEdit = (responseObj) => {
            if (responseObj != null) {
                document.getElementById('item').value = responseObj.item.name;
                document.getElementById('qty').value = responseObj.qty;
                changeSubmitMethod(id = responseObj.id, reqMethod = 'update');
            }
        }

        //Get category data
        const getSelectedItemStock = async (requestAPI) => {
            await fetch(requestAPI, {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                })
                .then(response => response.json())
                .then(responseJson => setStockValuesToEdit(responseJson));
        }

        //Reset form to : create new
        $('#addNewStock').on('hidden.bs.modal', function() {
            changeSubmitMethod(id = null, reqMethod = 'create')
        });

        //Render item list for drop down
        const renderItemList = (itemList) => {
            let rootElement = document.getElementById('items');
            let html = '';
            if(itemList.length > 0) {
                itemList.forEach((item,index) => {
                    html += `<option value='${item.id}: ${item.name}'>`
                });
            }
            rootElement.innerHTML = html;
        }

        //Get searched item
        const getItems = async (ele) => {
            if(ele.value != 'undefined' && ele.value != "" && ele.value != '' && ele.value != null) {
                if(ele.value.length >= 3) {

                    await fetch('{{ route('stock-enter-search-item') }}', {
                        'headers': {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        'method':'POST',
                        'body': JSON.stringify({
                                'search' : `${ele.value}`
                            }),
                        }).then(response => response.json())
                    .then(responseJson => renderItemList(responseJson));
                }
            }
        }



    </script>
@endpush
