<template>
    <div style="cursor: pointer" :class="classes" @click="$emit('site-clicked',site)">
        <img :src="site.thumbnail" class="card-img-top" :alt="'Image of ' + site.name">
        <div class="card-body text-center">
            <h5 class=" text-center">{{site.name}}</h5>
        </div>
    </div>
</template>

<script>
    export default {
        name: "SiteShowMini",
        props:{
            classes:String,
            site:Object
        }
    }
</script>

<style scoped>

</style>
