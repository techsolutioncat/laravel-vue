<template>
    <div>
        <input type="hidden" name="_token" :value="csrf">
    </div>
</template>

<script>
    export default {
        name: "Csrf",
        data() {
            return {
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        }
    }
</script>

<style scoped>

</style>
