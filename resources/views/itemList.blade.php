@extends('layouts.layout')
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
                    <form id="add-new-item" method="POST" action="{{ route('item.add') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="category">Category</label>
                            <select class="form-control" name="category" id="category">
                                <option value="">Choose</option>
                                @if (!empty($categories))
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ Str::ucfirst($category->name) }}</option>
                                    @endforeach
                                @endif
                            </select>

                            {{ CustomRenderHelper::renderError($errors, 'category') }}

                        </div>

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Keyboard">

                            {{ CustomRenderHelper::renderError($errors, 'name') }}
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" cols="5" class="form-control"
                                placeholder="Lorem Ipsum is simply dummy text of the printing ..."></textarea>

                            {{ CustomRenderHelper::renderError($errors, 'description') }}
                        </div>

                        <div class="form-group">
                            <label for="image">Image</label>
                            <input type="file" name="image" id="image" class="form-control" accept="image/*">

                            {{ CustomRenderHelper::renderError($errors, 'image') }}
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


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        {{ CustomRenderHelper::renderHTTPResponseMessage() }}


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

                {{-- Display errors --}}
                {{-- @if ($errors->any())
                    <div class="w-100 m-auto text-center">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li class="text-danger">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif --}}


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
                                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addNewItem"><i
                                            class="fas fa-plus"></i> Add new item</button>
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
                                                <td>{{ $item->category }}</td>
                                                <td>{{ $item->description }}</td>
                                                <td>{{ $item->image }}</td>
                                                <td>{!! $item->isActive == 0
                                                    ? "<span class='badge badge-small badge-secondary'>deactivated</span>"
                                                    : "<span class='badge badge-small badge-success'>active</span>" !!}</td>
                                                <td>
                                                    
                                                    <div class="row">

                                                        <form action="" class="m-1" method="get">
                                                            @csrf
                                                            @method('put')
                                                            <input type="hidden" name="item" value="{{ $item->id }}">
                                                            <button class="btn btn-sm btn-dark">
                                                                <i class="fa fa-file text-primary"></i>
                                                            </button>
                                                        </form>

                                                        <form action="" class="m-1" method="get">
                                                            @csrf
                                                            <input type="hidden" name="item" value="{{ $item->id }}">
                                                            <button class="btn btn-sm btn-dark">
                                                                <i class="fa fa-edit text-warning"></i>
                                                            </button>
                                                        </form>
                                                           
                                                        <form action="" class="m-1" method="get">
                                                            @csrf
                                                            <input type="hidden" name="item" value="{{ $item->id }}">
                                                            <button class="btn btn-sm btn-dark">
                                                                <i class="fa fa-trash text-danger"></i>
                                                            </button>
                                                        </form>

                                                        <form action="" class="m-1" method="get">
                                                            @csrf
                                                            <input type="hidden" name="item" value="{{ $item->id }}">
                                                            <button class="btn btn-sm btn-dark">
                                                                <i class="fa fa-toggle-on text-success"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                    
                                                </td>
                                            </tr>

                                        @empty
                                            <tr>
                                                <td colspan="7"><span class="text-danger">no items to display</span></td>
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
    @if (!empty($errors->first()))
        <script type="text/javascript">
            $('#addNewItem').modal({
                show: true
            });
        </script>
    @endif
@endpush
