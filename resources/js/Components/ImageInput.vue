<script setup>
import { onMounted, ref } from 'vue';

const props = defineProps({
	inputId:{
		type: String,
		required: true,
	},
	label:{
		type: String,
		required: true,
	},
	caution:{
		type: String,
		required: false,
	},
	selectedImage:{
		type: String,
		required: false,
	}
})

const emit = defineEmits([
	'image-uploaded',
])

const displayUrl = ref('');

const onFileDrop = (event) => {
	event.preventDefault();
	const file = event.dataTransfer.files[0];
	handleFile(file);
}
const onFileSelect = (event) => {
	const file = event.target.files[0];
	handleFile(file);
}
const handleFile = (file) => {
	emit('image-uploaded',file);
	const reader = new FileReader();
	reader.onload = (e) => {
		displayUrl.value = e.target.result;
	};
	reader.readAsDataURL(file);
}
const destroyImage = () => {
	emit('image-uploaded',null);
	displayUrl.value = '';
    document.getElementById(props.inputId).value = '';
}

onMounted(() => {
	if(props.selectedImage){
		displayUrl.value = props.selectedImage;
	}
})
</script>

<template>
	<label :for="inputId" class="c-image__label">
		{{ label }}<span v-if="caution" class="c-image__caution">{{ '*' + caution }}</span>
		<div class="c-image__container">
			<p v-if="!displayUrl" class="c-image__placeholder">
				画像を選択
			</p>
			<img v-show="displayUrl" :src="displayUrl" alt="" class="c-image__image">
			<input type="file" :name="inputId" :id="inputId" class="c-image__input" 
				@change="onFileSelect" 
				@dragover.prevent
				@drop.prevent="onFileDrop" 
			/>
			<span v-if="displayUrl" class="c-image__destroy" @click.prevent="destroyImage">削除</span>
		</div>
	</label>
</template>

<style scoped lang="scss">
@use 'resources/css/_variables.scss' as *;
.c-image{
	&__label{
		display: block;
		position: relative;
		font-weight: $font-weight_m;
		font-size: $font-size_m;
	}
	&__caution{
		margin-left: $space_sm;
		font-size: $font-size_s;
	}
	&__container{
		width: 11rem;
		height: 11rem;
		margin-top: $space_xs;
		position: relative;
		border:1px solid $border_gray;
		border-radius: $radius_sm;
	}
	&__placeholder{
		position: absolute;
		top: 50%;
		left: 50%;
		transform: translateY(-50%),translateX(-50%);
		-webkit-transform: translateY(-50%) translateX(-50%);
	}
	&__image{
		width: 100%;
		height: 100%;
		object-fit: cover;
	}
	&__input{
		width: 100%;
		height: 100%;
		margin-top: $space_xs;
		display: none;
	}
	&__destroy{
		position: absolute;
		bottom: 0;
		right: 0;
		margin: 0 $space_sm $space_sm 0;
		font-size: $font-size_s;
		padding: ($space_xs/2) $space_xs;
		background: $accent-color_light;
		border-radius: $radius_sm;
		color: white;
	}
}
</style>