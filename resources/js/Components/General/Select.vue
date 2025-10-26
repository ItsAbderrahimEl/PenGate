<script setup>
    defineProps({
        modelValue: String,
        elements: {
            type: Array,
            required: true
        },
        elementsKey: {
            type: String,
            default: 'id'
        },
        value: {
            type: String,
            default: 'name'
        }
    })

    defineEmits(['update:modelValue'])
</script>

<template>
    <select
        class="p-2 w-full"
        :value="modelValue"
        @change="$emit('update:modelValue', $event.target.value)"
    >
        <option
            v-for="element in elements"
            :key="element[elementsKey]"
            :value="element[elementsKey]"
        >
            {{ element[value] }}
        </option>
    </select>
</template>
