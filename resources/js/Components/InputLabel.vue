<script setup>
defineProps({
    label: {
        type: String,
        default: '',
    },
    required: {
        type: Boolean,
        default: false
    },
    error: {
        type: String,
        default: null
    },
    modelValue: {
        type: [String, Number, File],
        default: ''
    }
})
</script>

<template>
    <label class="primary_input_label" for="">{{ label }}</label>
    <input style="background: #dedede !important;" class="primary_input_field name" v-bind="{
        ...$attrs,
        onInput: (event) => $emit('update:modelValue', event.target.value),
        value: modelValue
    }">
    <span class="text-danger" v-if="error">{{ error }}</span>
</template>
