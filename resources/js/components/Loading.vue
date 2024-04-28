<template>
    <div>
        <div class="fullview">
            <div class="loading-spacer"></div>
            <vue-loading
                type="spiningDubbles"
                color="#aaa"
                :size="{ width: '100px', height: '100px' }">
            </vue-loading>
        </div>
    </div>
</template>

<script>
    import { VueLoading } from 'vue-loading-template'

    export default {
        name: 'loading',
        components: {
            VueLoading,
        },

    }
</script>

<style>
    .fullview {
        width: 100%;
        height: 100%;
        position: fixed;
        top: 100px;
        left: 0;
        z-index: 100;
        pointer-events: none;
    }
    .loading-spacer {
        height: 30%;
        pointer-events: none;
        z-index: 100;
    }
</style>
