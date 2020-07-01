<template>
    <div class="">
        <div class="card mb-3 btn" @click="$emit('hotel-clicked',hotel)">
            <img :src="hotel.thumbnail" class="card-img-top" :alt="hotel.name + 'thumbnail'">
            <div class="card-body">
                <h5 class="card-title">{{hotel.name}}</h5>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "HotelShowMini",
        props:{
            hotel:Object,
        },

    }
</script>

<style scoped>

</style>
