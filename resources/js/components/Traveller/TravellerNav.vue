<template>
    <ul class="nav nav-justified nav-tabs">
        <li class="nav-item">
            <router-link :to="{name:'user.my.trips'}" class="nav-link">
                My Trips
            </router-link>
        </li>

        <li class="nav-item">
            <router-link :to="{name:'user.sites'}" class="nav-link">
                ALL Sites
            </router-link>

        </li>

        <li class="nav-item">
            <router-link :to="{name:'user.regions'}" class="nav-link">
                Sites By Region
            </router-link>

        </li>
    </ul>
</template>

<script>
    export default {
        name: "TravellerNav"
    }
</script>

<style scoped>

</style>
