@extends('layouts.layout')
@section('items','active')
@section('title', 'Items')
@section('content')

    <!-- Modal -->
    <div class="modal fade" id="addNewItem" tabindex="-1" role="dialog" aria-labelledby="addNewItemLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">


                <div class="modal-header">
                    <h5 class="modal-title" id="addNewItemLabel">Add new item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="add-new-item" method="POST" action="{{ route('item.add') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="_method" id="_method-create-update" value="POST">
                        <div class="form-group">
                            <label for="category">Category</label>
                            <select class="form-control @error('category_id') is-invalid @enderror" name="category_id"
                                id="category">
                                <option value="">Choose</option>
                                @if (!empty($categories))
                                    @foreach ($categories as $category)
                                        <option {{ old('category_id') == $category->id ? 'selected' : null }} value="{{ $category->id }}">{{ Str::ucfirst($category->name) }}</option>
                                    @endforeach
                                @endif
                            </select>

                            @error('category')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name"
                                class="form-control @error('name') is-invalid @enderror" placeholder="Keyboard"
                                value="{{ old('name') }}">

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" cols="5"
                                class="form-control @error('description') is-invalid @enderror"
                                placeholder="Lorem Ipsum is simply dummy text of the printing ...">{{ old('description') }}</textarea>

                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group text-center" style="display:none" id="display-current-image">
                            <img src="" style="max-width:200px;height:auto;" alt="current-image" id="current-image">
                        </div>

                        <div class="form-group">
                            <label for="image">Image</label>
                            <input type="file" name="image" id="image"
                                class="form-control @error('image') is-invalid @enderror" accept="image/*">

                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="$('#add-new-item').submit()">Save
                        changes</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal: delete confirmation-->
    <div class="modal fade" id="deleteItem" tabindex="-1" role="dialog" aria-labelledby="deleteItemLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger" id="deleteItemLabel">Confirmation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="item-delete" method="POST" action="">
                        @csrf
                        <input type="hidden" name="_method" id="_method-delete" value="DELETE">
                        <h6 class="text-danger">Do you really want to delete this item ?</h6>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" onclick="$('#item-delete').submit()">Confirm</button>
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
                        <h1 class="m-0">Items</h1>
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
                                <h3 class="card-title">My Inventory</h3>

                                {{-- <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 150px;">
                                  <input type="text" name="table_search" class="form-control float-right" placeholder="Search">
              
                                  <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                      <i class="fas fa-search"></i>
                                    </button>
                                  </div>
                                </div>
                              </div> --}}

                                <div class="card-tools">
                                    <button class="btn btn-primary btn-sm" data-toggle="modal"
                                        data-target="#addNewItem"><i class="fas fa-plus"></i> Add new item</button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Category</th>
                                            <th style="max-width: 200px;word-wrap: break-word">Desc</th>
                                            <th>Image</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @forelse ($itemList as $index => $item)
                                        
                                        <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->category->name }}</td>
                                                <td>{{ $item->description }}</td>
                                                <td>
                                                    <img style="width:100px;height:auto"
                                                        src="{{ asset('storage/images/items/' . $item->image) }}"
                                                        alt="" srcset="">
                                                </td>
                                                <td>{!! $item->is_active == 0
                                                    ? "<span class='badge badge-small badge-secondary'>deactivated</span>"
                                                    : "<span class='badge badge-small badge-success'>active</span>" !!}</td>
                                                <td class="text-center">

                                                    <button class="btn btn-sm btn-dark" data-toggle="modal"
                                                        data-target="#addNewItem"
                                                        onclick="getSelectedItem('{{ route('item.item',['item' => $item->id]) }}')">
                                                        <i class="fa fa-file text-primary"></i>
                                                        <span class="">Open</span>
                                                    </button>

                                                    <button class="btn btn-sm btn-dark" data-toggle="modal"
                                                        data-target="#deleteItem"
                                                        onclick="confirmItemDelete( {{ $item->id }} )">
                                                        <i class="fa fa-trash text-danger"></i>
                                                        <span class="">Remove</span>
                                                    </button>

                                                </td>
                                            </tr>
                                        @empty
                                            <tr class="text-center">
                                                <td colspan="7"><span class="text-danger">no items to display</span>
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

                @if (!empty($itemList))
                    <div class="row mt-2 ml-1">
                        {{ $itemList->links() }}
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
            $('#addNewItem').modal({
                show: true
            });
        @endif


        //Change form mode : POST / PUT
        const changeSubmitMethod = (id = null, reqMethod = 'update') => {

            if (reqMethod === 'update' && id === null) return false;

            let requestType = 'POST';
            let requestAPI = '{{ route('item.add') }}';

            if (reqMethod == 'update') {
                requestType = 'PUT';
                requestAPI = '{{ route('item.update', ['item' => '_item_']) }}';
            }

            document.getElementById('_method-create-update').value = requestType;
            document.getElementById('add-new-item').setAttribute('action', requestAPI.replace('_item_', id));
        }


        //Get category data: callback
        const setItemValuesToEdit = (responseObj) => {
            if (responseObj != null) {
                document.getElementById('category').selectedIndex = responseObj.category_id;
                document.getElementById('name').value = responseObj.name;
                document.getElementById('description').value = responseObj.description;

                if(responseObj.image != null) {
                    document.getElementById('display-current-image').style.display = 'block';
                    document.getElementById('current-image').src = '{{ asset('storage/images/items') }}/' + responseObj.image;
                }


                changeSubmitMethod(id = responseObj.id, reqMethod = 'update');
            }
        }

        //Get category data
        const getSelectedItem = async (requestAPI) => {
            await fetch(requestAPI, {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                })
                .then(response => response.json())
                .then(responseJson => setItemValuesToEdit(responseJson));
        }

        //Reset form to : create new
        $('#addNewItem').on('hidden.bs.modal', function() {
            changeSubmitMethod(id = null, reqMethod = 'create')
        });

        //Category delete confirmation
        const confirmItemDelete = (id) => {
            let requestAPI = '{{ route('item.delete', ['item' => '_item_']) }}';
            document.getElementById('item-delete').setAttribute('action', requestAPI.replace('_item_', id));
        }

        //Reset category delete confirmation form action
        $('#deleteItem').on('hidden.bs.modal', function() {
            document.getElementById('item-delete').setAttribute('action', '');
        });
    </script>
@endpush
