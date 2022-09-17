<template>
    
    <div>

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
                    <form id="add-new-item" action="" enctype="multipart/form-data">
                        
                        <input type="hidden" name="_method" id="_method-create-update" value="POST">
                        <div class="form-group">
                            <label for="category">Category</label>
                            <select class="form-control" name="category_id"
                                id="category">
                                <option value="">Choose</option>
                                <option value=""></option>
                            </select>                         
                        </div>

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Keyboard" value="">
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" cols="5"
                                class="form-control" placeholder="Lorem Ipsum is simply dummy text of the printing ..."></textarea>
                        </div>

                        <div class="form-group" style="display:none" id="display-current-image">
                            <img src="" style="width:100%" alt="current-image" id="current-image">
                        </div>

                        <div class="form-group">
                            <label for="image">Image</label>
                            <input type="file" name="image" id="image"
                                class="form-control is-invalid" accept="image/*">
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



        <div class="content-wrapper">
            <!-- @include('layouts.message') -->

            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Items</h1>
                        </div>

                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <!-- <li class="breadcrumb-item active">Dashboard</li> -->
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">My Inventory</h3>

                                    <div class="card-tools">
                                        <button
                                            class="btn btn-primary btn-sm"
                                           data-toggle="modal" data-target="#addNewItem"
                                        >
                                            <i class="fas fa-plus"></i> Add new item
                                        </button>
                                    </div>
                                </div>

                                <div class="card-body table-responsive p-0">
                                    <!-- table -->
                                    <table id="tbl" class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Item</th>
                                                <th>Category</th>
                                                <th>Description</th>
                                                <th>Image</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <tr v-for="(item,index) in items" :key=index v-if="items.length" >
                                                <td>{{ ++index }}</td>
                                                <td>{{ item.name }}</td>
                                                <td>{{ item.category.name }}</td>
                                                <td>{{ item.description }}</td>
                                                <td>
                                                    <img style="max-width:100px" :src="`${base_url}/storage/images/items/${item.image}`" :alt="item.name">
                                                </td>
                                                <td>
                                                    <span :class="`badge badge-${item.is_active ? 'success':'danger'}`">{{item.is_active ? 'active':'deactive'}}</span>
                                                    
                                                </td>
                                                <td>
                                                   <button @click=updateItem class="btn btn-primary btn-small"><i class="fa fa-edit"></i></button> 
                                                   <button @click=deleteItem(item.id) class="btn btn-primary btn-danger"><i class="fa fa-trash"></i></button> 
                                                </td>
                                            </tr>

                                            <tr v-else>
                                                <td colspan="5">
                                                    <span class="text-danger">Data not available</span>
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- pagination start -->
                    <!-- <div class="row mt-2 ml-1">
                            pagination link list
                        </div> -->
                    <!-- pagination end -->
                </div>
            </section>
        </div>
    </div>
</template>

<script>
export default {
    name: "Template1",
    props: {},
    data() {
        return {
            items: [],
            base_url : process.env.MIX_BASE_URL,
        };
    },

    methods: {
        //Get table data
        getTableData: async function () {
            await axios.get(`${this.base_url}/items`).then((response) => {
                this.items = response.data.data;
            });
        },

        deleteItem: async function (item_id) {
            this.$swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete(`${this.base_url}/items/${item_id}`).then((response) => {
                        this.$swal.fire(
                            'Deleted!',
                            'Your item has been deleted.',
                            'success'
                        );
                        this.getTableData();

                        console.log(response);
                    });
                }
            });
        },

        updateItem: async function () {
            this.$swal.fire({
                title: 'Update Item',
                input: 'text',
                inputAttributes: {
                    autocapitalize: 'off'
                },
                showCancelButton: true,
                confirmButtonText: 'Look up',
                showLoaderOnConfirm: true,
                preConfirm: (login) => {
                    return fetch(`//api.github.com/users/${login}`)
                    .then(response => {
                        if (!response.ok) {
                        throw new Error(response.statusText)
                        }
                        return response.json()
                    })
                    .catch(error => {
                        this.$swal.showValidationMessage(
                        `Request failed: ${error}`
                        )
                    })
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                if (result.isConfirmed) {
                    this.$swal.fire({
                    title: `${result.value.login}'s avatar`,
                    imageUrl: result.value.avatar_url
                    })
                }
            });

        },

        createItem: function () {
            serialized
        }

    },

    async mounted() {
        await this.getTableData();
    },
    
};
</script>
