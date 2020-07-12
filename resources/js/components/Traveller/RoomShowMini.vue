<template>
    <div class="card mb-3 btn" @click="$emit('site-clicked',room)">
        <div class="ribbon-wrapper ribbon-lg">
            <div class="ribbon btn-primary">
                {{room.price|currency}}
            </div>
        </div>
        <img :src="room.thumbnail" class="card-img-top" :alt="room.room_number + ' thumbnail'">
        <div class="card-body">
            <h5 class="card-title d-block">{{room.room_number}}</h5>
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

