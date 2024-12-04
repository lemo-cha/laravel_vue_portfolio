<script setup>
import { onMounted, ref } from 'vue';
import Modal from './Modal.vue';
import { apiClient, getCsrfToken } from '@/bootstrap';
import SecondaryButton from './SecondaryButton.vue';

const props = defineProps({
    inputId:{
        type:String,
        required: true,
    },
    modelValue:{
        type: [String,Number],
        required: true,
    },
    selectedMaker:{
        type: [Object],
        required: false,
    }
})

const model = defineModel({
    type: [String,Number],
    required: true,
});

const input = ref(null);
const makers = ref([]); // 検索結果を受け取りmodalで表示
const displayValue = ref(''); // 検索値と選択したmakerのcustom_id
const selectedName = ref(''); // 選択したmakerのname
const hasResults = ref(false); // 検索結果0件の場合に表示    // *** テーブルがちらつく場合があるので要修正
const showModal = ref(false);
const emit = defineEmits([
    'update:modelValue',
]);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }

    if(props.selectedMaker){
        displayValue.value = props.selectedMaker.custom_id;
        selectedName.value = props.selectedMaker.name + ' ' + props.selectedMaker.brand;
    }
});

defineExpose({ focus: () => input.value.focus() });

const search = async (event) => {
    hasResults.value = false; // 検索が2回目以降であればtrueの可能性があるのでfalseにする
    displayValue.value = event.target.value; // 入力値を格納
    try{
        await getCsrfToken();
        const response = await apiClient.get('/makers/search',{
        params: {q: displayValue.value}
        });
        makers.value = response.data;

        switch(makers.value.length){
            case 0 : // 検索結果なし
                showModal.value = true;
                hasResults.value = true;
                break;
            case 1 : // 1件のみの場合、モーダルは表示しない
                hasResults.value = 
                selectMaker(makers.value[0])
                break;
            default : // 1件以上
                showModal.value = true;
        }
    }catch(error){
        console.log('エラー',error);
    }
}
const selectMaker = (maker) => {
    emit('update:modelValue',maker.id);
    displayValue.value = maker.custom_id;
    selectedName.value = maker.name + ' ' + maker.brand;
    closeModal();
}
const closeModal = () => {
    showModal.value = false;
}
</script>

<template>
    <div>
        <input
            :id="inputId"
            class="c-input" 
            :value="displayValue"
            ref="input"
            @keydown.enter.prevent="search"
            @focusout="search"
        />
        <input
            :class="inputId"
            type="hidden"
            v-model="model"
            ref="input"
            />
        <p class="c-input__v-model">{{ selectedName }}</p>
        
        <Modal :show="showModal">
            <input
            class="c-input p-modal__input"
            v-model="displayValue"
            ref="input"
            @keydown.enter.prevent="search"
        />
        <div v-show="hasResults" class="p-table">
            <p class="p-modal__comment">検索結果は0件でした</p>
        </div>
        <div v-show="!hasResults" class="p-table">
            <table class="p-content__table">
                <tr class="p-content__table--column">
                    <th class="p-content__table--column-title">No.</th>
                    <th class="p-content__table--column-title">ID</th>
                    <th class="p-content__table--column-title">メーカー名</th>
                    <th class="p-content__table--column-title">ブランド名</th>
                </tr>
                <tr v-for="(maker,index) in makers" :key="maker.id" class="p-content__table--column"
                    @click="selectMaker(maker)">
                    <td class="p-content__table--column-data">{{ index + 1 }}</td>
                    <td class="p-content__table--column-data">{{ maker.custom_id }}</td>
                    <td class="p-content__table--column-data">{{ maker.name }}</td>
                    <td class="p-content__table--column-data">{{ maker.brand }}</td>
                </tr>
            </table>
            <!-- <Pagination :links="makers.links" class="p-paginate" /> -->
        </div>
            <SecondaryButton class="p-modal__button" @click="closeModal">閉じる</SecondaryButton>
        </Modal>
    </div>
</template>
<style scoped lang="scss">
@use 'resources/css/_variables.scss' as *;
.c-input{
    height: 2.625rem;
    padding: 0 $space_sm; 
    background: $bg-color_content;
    border-radius: $radius_md; 
    border: 1px solid $border_gray;
    box-shadow: $box-shadow-sm;
    &:focus{
        border-color: $accent-color_light;
        box-shadow: 0 0 0 1px rgba($accent-color_light, 1);
        outline: none;
    }
    &__v-model{
        margin: 0.2rem;
        min-height: 1rem;
    }
}
.text{
    font-size: 2rem;
}
.p-table{
    display: flex;
    margin: $space_md 0;
}
.p-content__table{
    width: 100%;
    margin-left: auto;
    margin-right: auto;
    border-collapse: collapse;
    border-spacing: 0;
    padding: $space_lg;
}
.p-content__table--column-title{
    background-color: $accent-color;
    color: $bg-color_content;
}
.p-content__table--column-title,
.p-content__table--column-data{
    padding: $space_md;
    vertical-align: middle;
    text-align: center;
}
.p-content__table--column{
    &:nth-child(odd){
        background: rgba($accent-color,0.6);
    }
    &:nth-child(even){
        background: rgba($accent_color,0.3);
    }
}
.p-modal__input{
    display: flex;
    justify-content: center;
    margin: auto;
}
.p-modal__comment{
    margin: auto;
    text-align: center;
}
.p-modal__button{
    justify-content: flex-end;
    gap: $space_md;
}
.p-paginate{
    display: flex;
    justify-content: center;
    margin-top: $space_md;
}
</style>