<script setup>
    defineProps({
        modelValue: String
    })

    defineEmits(['update:modelValue'])

    let textArea = ref(null)

    defineExpose({
        focus: () => textArea.value.focus()
    })
</script>

<template>
    <textarea
        ref="textArea"
        class="px-2 mt-1 py-1.5 font-normal text-md outline-none focus:ring focus:ring-slate-400 w-full text-gray-900 rounded"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
    ></textarea>
</template>
