<script setup>
    defineProps({
        error: String
    })
</script>

<template>
    <span
        v-show="error"
        class="text-red-600 text-sm block mt-2"
        v-text="error"
    />
</template>
