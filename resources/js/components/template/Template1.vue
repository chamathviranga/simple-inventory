<template>
    
    <div>

    <div class="modal fade" id="addNewItem" tabindex="-1" role="dialog" aria-labelledby="addNewItemLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">


                <div class="modal-header">
                    <h5 class="modal-title" id="addNewItemLabel">Add new item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click=closeModal>
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="add-new-item" action="" enctype="multipart/form-data">
                        
                        <div class="form-group">
                            <label for="category">Category</label>
                            <select class="form-control" v-model="form.category_id" >
                                <option value="">Choose</option>
                                <option v-for="(category,index) in categories" :value="category.id" :key=index> {{ category.name }} </option>
                            </select>                         
                        </div>

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" placeholder="Keyboard" v-model="form.name" >
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea cols="5" class="form-control" placeholder="Lorem Ipsum is simply dummy text of the printing ..." v-model="form.description"></textarea>
                        </div>

                        <div v-if="form.image != null && form.id != null" class="form-group" id="display-current-image">
                            <img  :src="`${this.base_url}/storage/images/items/${form.image}`" style="max-width:100px" alt="current-image" id="current-image">
                        </div>

                        <div class="form-group">
                            <label for="image">Image</label>
                            <input type="file" name="image" id="image"
                                class="form-control is-invalid" accept="image/*" @change=getSelectedImage>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click=closeModal data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" @click=updateOrcreateItem >Save changes</button>
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
                                            @click=clearFromData
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
                                        <tbody v-if="items.length">

                                            <tr v-for="(item,index) in items" :key=index  >
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
                                                   <button @click=getSelectedItemDetails(item.id) class="btn btn-primary btn-small"><i class="fa fa-edit"></i></button> 
                                                   <button @click=deleteItem(item.id) class="btn btn-primary btn-danger"><i class="fa fa-trash"></i></button> 
                                                </td>
                                            </tr>
                                        </tbody>

                                        <tbody v-else>
                                            <tr>
                                                <td colspan="6">
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
                    <div class="row mt-2 ml-1" v-if="pages.length">
                        <ul class="pagination">
                            <li class="page-item" v-for="(page,index) in pages" :key=index>
                                <a :class="`page-link ${ page.active ? 'bg-primary' : null }`" @click="getItems(`${ page.url != null ? page.url : null }`)" href="#" v-html=page.label ></a>
                            </li>
                        </ul>
                    </div>
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
            pages: [],
            categories: [],
            base_url : process.env.MIX_BASE_URL,
            form: {
                id: null,
                category_id: null,
                name : null,
                description : null,
                image : null,
            }
        };
    },

    methods: {

        getItems: async function (url = null) {
            
            let request_url = url != null ? url : `${this.base_url}/items`;
            
            await axios.get(request_url).then((response) => {
                this.items = response.data.data;
                this.pages = response.data.links;
                history.pushState({}, null, request_url);
            });
        },

        getSelectedItemDetails: async function (id = null) {
            if(id != null) {

                let formData = new FormData();
                formData.append('id',id);

                axios.get(`${this.base_url}/items/${id}`,formData).then((response) => {
                    
                    this.form.id = response.data.id;
                    this.form.category_id = response.data.category_id;
                    this.form.name = response.data.name;
                    this.form.description = response.data.description;
                    this.form.image = response.data.image;

                    $("#addNewItem").modal('toggle');

                }).catch((error) => {
                    console.error(error);
                });

            }else{
                this.$swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Item not found!',
                });
            }
        },

        deleteItem: async function (id) {
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
                    axios.delete(`${this.base_url}/items/${id}`).then((response) => {
                        this.$swal.fire(
                            'Deleted!',
                            'Your item has been deleted.',
                            'success'
                        );
                        this.getItems();
                        console.log(response);
                    }).catch((error) => {
                        console.error(error);
                    });
                }
            });
        },

        updateOrcreateItem: async function () {

            let formData = new FormData();
            this.form.image = formData.append('image',this.form.image);

            let request_url = `${this.base_url}/items`;
            let method = 'post';

            if(this.form.id != null){
                request_url = `${this.base_url}/items/${this.form.id}`;
                method = 'put';
            }

            console.log(this.form);

            axios({
                url : request_url,
                method: method,
                data : this.form,
                // headers: {
                //     'Content-type': 'multipart/form-data',
                //     'Access-Control-Allow-Origin': '*',
                // }
            }).then((response)=>{
                //console.log(response);
            
                this.$swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Your work has been saved',
                    showConfirmButton: true,
                    timer: 1500
                });
            
            }).catch((error) => {
                console.error(error);

                this.$swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text:error,
                    showConfirmButton: true,
                });
            }).finally(()=>{
                $("#addNewItem").modal('toggle');
                this.getItems();
                //this.clearFromData();

            });

        },

        getCategories: async function () {
            await axios.get(`${this.base_url}/item-categories`).then((response) => {
                this.categories = response.data;
            }).catch((error) => {
                console.error(error);
            });
        },

        getSelectedImage : function (event) {
            this.form.image = event.target.files[0];
        },

        clearFromData : function () {
            this.form.id = null;
            this.form.category_id = null;
            this.form.name = null;
            this.form.description = null;
            this.form.image = null;
        },

        closeModal: function () {
            $('#addNewItem').modal('toggle');
        }
    },

    async mounted() {
        await this.getItems();
        await this.getCategories();
    },
    
};
</script>
