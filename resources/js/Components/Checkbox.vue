<script setup>
import { computed } from 'vue';

const emit = defineEmits(['update:checked']);

const props = defineProps({
    checked: {
        type: [Array, Boolean],
        required: true,
    },
    value: {
        default: null,
    },
});

const proxyChecked = computed({
    get() {
        return props.checked;
    },

    set(val) {
        emit('update:checked', val);
    },
});
</script>

<template>
    <input
        type="checkbox"
        :value="value"
        v-model="proxyChecked"
        class="c-checkbox"
    />
    <font-awesome-icon :icon="proxyChecked ? ['fas','square-check'] : ['far','square']" v-bind="$attrs" class="custom-icon"/>
</template>

<style scoped lang="scss">
@use 'resources/css/_variables.scss' as *;
// fontawesomeを使用しない場合
// .c-checkbox{
//     width: 1rem;
//     height: 1rem;
//     position: relative;
//     border-radius: $radius_sm;
//     border: 1px solid $border_gray;
//     box-shadow: $box-shadow-sm;
//     &:checked::after {
//     content: '✔';
//     position: absolute;
//     font-size: 0.85rem;
//     }
//     &:focus{
//         outline: none;
//         box-shadow: 0 0 0 2px rgba($accent-color,0.5);
//     }
// }
// fontawesomeを使用する場合
.custom-icon {
    display: inline-flex;
    align-items: center;
    border: 2px solid transparent; //透明
    height: 1rem;
    width: 1rem;
    border-radius: $radius_sm;
}
input[type="checkbox"]:checked + .custom-icon{
    border-color: $accent-color;
}
input[type="checkbox"]:focus + .custom-icon{
    border-color: $accent-color;
}
</style>