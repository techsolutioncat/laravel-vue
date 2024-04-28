<template>
    <div class="input_wrapper" :class="{ error: toggle}" >
        <slot>
        </slot>
        <div v-if="message" class='error_wrapper'>
            <span class="tool_error">{{ message }}</span>
        </div>
    </div>
</template>
<script>
export default {
    props: ['message', 'extraClass'],
    computed: {
        toggle: function() {
            return this.message != null;
        },
    }
}
</script>
<style scoped>
    .input_wrapper {
        display: inline-block;
        position: relative;
    }

    .input_wrapper.errortext, .input_wrapper.errortext input, .input_wrapper.errortext select, .input_wrapper.errortext textarea{
        color: rgba(255, 0, 0, 1);
    }

    .input_wrapper.error input, .input_wrapper.error select, .input_wrapper.error textarea {
        border: 2px solid rgba(255, 0, 0, .5);
    }

    .input_wrapper.error input[type=checkbox] {
        outline: 2px solid rgba(255, 0, 0, .5);
    }

    .error_wrapper {
        width: 300px;
        height: auto !important;
    }
    .tool_error{
        height: auto !important;
        padding: 2px;
        color: rgba(255, 0, 0, 0.7);
        font-size: 12px;
        z-index: 10;
        transition: opacity 0.5s
    }
</style>
