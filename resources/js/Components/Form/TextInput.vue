<script setup>
    defineProps({
        modelValue: String
    })

    defineEmits(['update:modelValue'])
</script>

<template>
    <input
        class="px-2 py-2 font-normal text-md outline-none focus:ring focus:ring-slate-400 w-full text-gray-900 rounded"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
    >
</template>
