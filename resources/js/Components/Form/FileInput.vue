<script setup>
    defineProps({
        modelValue: File
    })

    defineEmits(['update:modelValue'])

    const input = ref(null)

    onMounted(() => {
        if (input.value?.hasAttribute('autofocus')) {
            input.value.focus()
        }
    })

    defineExpose({ focus: () => { input.value?.focus() } })
</script>

<template>
    <input
        type="file"
        ref="input"
        @change="$emit('update:modelValue', $event.target.files[0])"
        class="px-2 py-1.5 font-normal text-md focus:outline focus:outline-gray-300 w-full bg-gray-300 text-gray-900 rounded"
    >
</template>
