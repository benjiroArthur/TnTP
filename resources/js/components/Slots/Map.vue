<template>
    <GmapMap
        :center="{lat:map.lat, lng:map.long}"
        :zoom="7"
        map-type-id="terrain"
        style="width: 100%; height: 450px"
    >

    </GmapMap>
</template>

<script>
    export default {
        name: "Map",
        props:{
          map:Object,
        },
        data: () => {
             return {

            }
        }
    }
</script>

<style scoped>

</style>
