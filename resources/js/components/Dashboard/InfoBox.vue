<template>
    <div>
        <div class="row" v-if="data.length">
            <!-- <div class="col-lg-3 col-6">
                <div class="small-box" :class="bgColor">
                    <div class="inner">
                        <h3>{{ count }}</h3>

                        <p>{{ infoLabel }}</p>
                    </div>
                    <div class="icon">
                        <i :class="cardIcon"></i>
                    </div>
                    <a href="#" class="small-box-footer"
                        >{{ buttonName }} <i class="fas fa-arrow-circle-right"></i
                    ></a>
                </div>
            </div> -->

            <div class="col-lg-3 col-6" v-for="card in data" :key="card.index">
                <div class="small-box" :class="card.background">
                    <div class="inner">
                        <h3>{{ card.count }}</h3>

                        <p>{{ card.label }}</p>
                    </div>
                    <div class="icon">
                        <i :class="card.icon"></i>
                    </div>
                    <a href="#" class="small-box-footer"
                        >{{ card.buttonName }}
                        <i class="fas fa-arrow-circle-right"></i
                    ></a>
                </div>
            </div>
        </div>

        <div v-else class="text-center">
            <span class="text-danger">Dashboard cards not found ..</span>
        </div>
    </div>
</template>

<script>
/**
 * @props
 * count
 * label
 * buttonName
 * bgColor
 *
 * v-bind -> bind data to html attribute (:href="url")
 * v-on:ANY_ACTION -> v-on:click="func" (@click="func")
 */

import data from "./DashboardDataSet";

export default {
    props: {
        // count: Number,
        // infoLabel: String,
        // buttonName: String,
        // bgColor: String,
        // cardIcon: String,
    },

    data() {
        return {
            //Return data
            data: [],
        };
    },
    methods: {
        //Functions
        setData() {
            this.data = data;
        },
    },
    //Lifecycle hoocks
    mounted() {
        this.setData();
    },
};
</script>
