<template>
    <div class="" :class="classes">
        <img :src="hotel.image"  class="card-img-top" :alt="hotel.name + ' thumbnail'">
        <div class="card mb-3 " >
            <div class="card-body">
                <h5 class="card-title">{{hotel.name}}</h5>
                <button class="btn bg-trip btn-block" @click="$emit('hotel-clicked',hotel)">Book a room</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "HotelShowMini",
        props:{
            hotel:Object,
            classes:String
        },

    }
</script>

<style scoped>

</style>
