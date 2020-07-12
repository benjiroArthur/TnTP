<template>
    <div class="">
        <img :src="hotel.image" class="card-img-top" :alt="hotel.name + ' thumbnail'">
        <div class="card mb-3 " >
            <div class="card-body">
                <h5 class="card-title">{{hotel.name}} Hotel</h5>
                <button class="btn btn-primary btn-block" @click="$emit('hotel-clicked',hotel)">Book a room</button>
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
