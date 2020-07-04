<template>
    <div class="card mb-3 btn" @click="$emit('site-clicked',site)">
        <img :src="room.image" class="card-img-top" :alt="room.number + ' thumbnail'">
        <div class="card-body">
            <h5 class="card-title">{{room.number}}</h5>
        </div>
    </div>
</template>

<script>
    export default {
        name: "RoomShowMini",
        props:{
            room:Object
        }
    }
</script>

<style scoped>

</style>
