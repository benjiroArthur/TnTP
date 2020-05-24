<template>
    <div class="card mb-3 btn" @click="$emit('site-clicked',site)">
        <img :src="site.thumbnail" class="card-img-top" :alt="site.name + 'thumbnail'">
        <div class="card-body">
            <h5 class="card-title">{{site.name}}</h5>
        </div>
    </div>
</template>

<script>
    export default {
        name: "SiteShowMini",
        props:{
            site:Object
        }
    }
</script>

<style scoped>

</style>
