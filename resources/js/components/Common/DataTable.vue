<template>
    <div class="card-body table-responsive p-0">
        <div v-if="rows.length && columnNames.length">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th v-for="(column,index) in columnNames" :key="`item_headers_${index}`" >{{ column }}</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(row,index) in rows" :key="`item_rows_${index}`" >
                        <td>{{ index+1 }}</td>
                        <td v-for="(data,index) in row" :key="`item_data_${index}`" > 
                            <span v-if="typeof data == 'boolean'">
                                <span v-if="data != true" class='badge badge-small badge-secondary'>deactivated</span>
                                <span v-else class='badge badge-small badge-success'>active</span>
                            </span>
                            <span v-else-if="checkIsImage(data)">
                                <img style="width:100px;height:auto" :src="`${imagePath}/${data}`" alt="Image">
                            </span>
                            <span v-else> {{ data }} </span>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-dark" data-toggle="modal"
                                :data-target="`#${actionBtn1DataTarget}`"
                                @click="btn1Action">
                                <i class="fa fa-file text-primary"></i>
                                <span class="">Open</span>
                            </button>

                            <button class="btn btn-sm btn-dark" data-toggle="modal"
                                :data-target="`#${actionBtn2DataTarget}`"
                                @click="btn2Action">
                                <i class="fa fa-trash text-danger"></i>
                                <span class="">Remove</span>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div v-else class="text-center">
            <span class="text-danger text-center">No items to display</span>
        </div>
    </div>
</template>

<script>
import data from "./DataTableSampleData";
const axios = require('axios').default;
export default {
    props: {
        updateUrl: String,
        deleteUrl: String,
        getItemUrl: String,
        allItemsUrl: String,
        imagePath: String,
        actionBtn1DataTarget: String,
        actionBtn2DataTarget: String,
    },
    data() {
        return {
            columnNames: [],
            rows: [],
        };
    },
    computed: {},
    methods: {

        getTableData: async function () {
            let response = await axios.get(this.allItemsUrl)
            // .then((response)=>{
            //     console.log(response);
            // });

            console.log(response.data.data);
        },

        setData: function () {
            if (data.items.length) {
                this.rows = data.items;
            }
        },
        setColumnNames: function () {
            let columns = Object.keys(this.rows[0]);
            columns.forEach((columnName, index) => {
                /**
                 * Capitalize first letter
                 * Remove underscore from column names
                 */
                let modifiedColumnName = (
                    columnName.charAt(0).toUpperCase() + columnName.slice(1)
                ).replace("_", " ");
                this.columnNames.push(modifiedColumnName);
            });
        },

        checkIsImage: function (text) {
            if(typeof text === 'string'){
                let extension = text.split('.')[1]?.toLowerCase();
                if(extension != 'undefined' && extension != '' && extension != null) {
                    if(extension == 'jpg' || extension == 'png' || extension == 'jpeg'){
                        return true;
                    }
                }
            }

            return false;
        },
        
        btn1Action: function () {
            //Load existing details
            //Set update-modal form data
            //Open edit modal
        },
        updateDetails: function () {
            //Submit update-modal form data
            //Clear update-modal form data after request complete
            //Display alert
        },
        btn2Action: function () {
            //Load delete confirmation modal
            //Set delete confirmation modal form data
        },
        afterDeleteComplete: function () {
            //Clear delete form data after delete action completed
            //Display alert
        },
        
        
    },
    //Lifecycle hoocks
    async mounted() {
        await this.getTableData();
        this.setData();
        this.setColumnNames();
    },
};
</script>
