<template>
    <div class="col-lg-3 col-6">
        <!-- small box -->
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

export default {
     props: {
        count: Number,
        infoLabel: String,
        buttonName: String,
        bgColor: String,
        cardIcon: String
    },

    data() {
        return {
            //Return data
        };
    },
    methods: {
        //Functions
    },
    //Lifecycle hoocks
    mounted() {
    
    }
};
</script>
