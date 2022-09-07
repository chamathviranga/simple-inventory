@extends('layouts.layout')
@section('title', 'Items')

@section('content')

    <!-- Modal: create update -->
    <div class="modal fade" id="addNewCategory" tabindex="-1" role="dialog" aria-labelledby="addNewCategoryLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="addNewCategoryLabel">Add new Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="add-new-category" method="POST" action="{{ route('categories.store') }}">
                        @csrf
                        <input type="hidden" name="_method" id="_method-create-update" value="POST">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name"
                                class="form-control @error('name') is-invalid @enderror" placeholder="Computer Parts"
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
                                placeholder="Lorem Ipsum is simply dummy text of the printing ..."></textarea>

                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="change_active_status">
                            <label class="custom-control-label" for="change_active_status" id="category_status">Active/inactive</label>
                        </div> --}}

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="$('#add-new-category').submit()">Save
                        changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal: delete confirmation-->
    <div class="modal fade" id="deleteCategory" tabindex="-1" role="dialog" aria-labelledby="deleteCategoryLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger" id="deleteCategoryLabel">Confirmation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="category-delete" method="POST" action="">
                        @csrf
                        <input type="hidden" name="_method" id="_method-delete" value="DELETE">
                        <h6 class="text-danger">Do you really want to delete this category ?</h6>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" onclick="$('#category-delete').submit()">Confirm</button>
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
                        <h1 class="m-0">Categories</h1>
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
                                <h3 class="card-title">My Categories</h3>

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
                                        data-target="#addNewCategory"><i class="fas fa-plus"></i> Add new
                                        category</button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th style="max-width: 200px;word-wrap: break-word">Desc</th>
                                            <th>Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @forelse ($categoryList as $index => $category)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $category->name }}</td>
                                                <td>{{ $category->description }}</td>
                                                <td>{!! $category->isActive == 0
                                                    ? "<span class='badge badge-small badge-secondary'>deactivated</span>"
                                                    : "<span class='badge badge-small badge-success'>active</span>" !!}</td>
                                                <td class="text-center">

                                                    <button class="btn btn-sm btn-dark" data-toggle="modal"
                                                        data-target="#addNewCategory"
                                                        onclick="getSelectedCategory('{{ route('categories.edit', ['category' => $category->id]) }}')">
                                                        <i class="fa fa-file text-primary"></i>
                                                        <span class="">Open</span>
                                                    </button>

                                                    <button class="btn btn-sm btn-dark" data-toggle="modal"
                                                        data-target="#deleteCategory"
                                                        onclick="confirmCategoryDelete({{ $category->id }})">
                                                        <i class="fa fa-trash text-danger"></i>
                                                        <span class="">Remove</span>
                                                    </button>

                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">
                                                    <span class="text-danger">no categories to display</span>
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
            $('#addNewCategory').modal({
                show: true
            });
        @endif

        //Change form mode : POST / PUT
        const changeSubmitMethod = (id = null, reqMethod = 'update') => {

            if (reqMethod === 'update' && id === null) return false;

            let requestType = 'POST';
            let requestAPI = '{{ route('categories.store') }}';

            if (reqMethod == 'update') {
                requestType = 'PUT';
                requestAPI = '{{ route('categories.update', ['category' => '_category_']) }}';
            }

            document.getElementById('_method-create-update').value = requestType;
            document.getElementById('add-new-category').setAttribute('action', requestAPI.replace('_category_', id));
        }


        //Get category data: callback
        const setCategoryValuesToEdit = (responseObj) => {
            if (responseObj != null) {
                document.getElementById('name').value = responseObj.name;
                document.getElementById('description').value = responseObj.description;
                changeSubmitMethod(id = responseObj.id, reqMethod = 'update');
            }
        }

        //Get category data
        const getSelectedCategory = async (requestAPI) => {
            await fetch(requestAPI, {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                })
                .then(response => response.json())
                .then(responseJson => setCategoryValuesToEdit(responseJson));
        }

        //Reset form to : create new
        $('#addNewCategory').on('hidden.bs.modal', function() {
            changeSubmitMethod(id = null, reqMethod = 'create')
        });

        //Category delete confirmation
        const confirmCategoryDelete = (id) => {
            let requestAPI = '{{ route('categories.destroy', ['category' => '_category_']) }}';
            document.getElementById('category-delete').setAttribute('action', requestAPI.replace('_category_', id));
        }

        //Reset category delete confirmation form action
        $('#deleteCategory').on('hidden.bs.modal', function() {
            document.getElementById('category-delete').setAttribute('action', '');
        });

        // document.getElementById('change_active_status').addEventListener('click',(e) => {
        //     let lbl = document.getElementById('category_status');
        //     document.getElementById('change_active_status').checked ? lbl.text = 'Inactive' : lbl.text='Active'; 
        //     console.log(2)
        // });


    </script>
@endpush
