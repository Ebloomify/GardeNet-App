<template>
	<view>
		<swiperList :tabs="tabList"></swiperList>
	</view>
</template>

<script>
	import swiperList from "@/components/centerSwiperList/swiperList.vue";
	var _list = [{
		name: 'Questions丨Asked', //tab名称
		ajaxUrl: '/V1.Question/myList', // 接口地址
		template: 'myQa' //模板区分
	}, {
		name: 'Questions丨Answered',
		ajaxUrl: '/V1.QuestionAnswer/myList',
		template: 'fromQa'
	}];
	export default {
		data() {
			return {
				
				current: 0, //tab 索引
				barStyle: {
					background: "linear-gradient(to right, #48d39a, #48ceb7)",
					// bottom: "18rpx",
					height: "8rpx"
				},
				tabList: _list,
			}
		},
		onLoad() {
		},
		components:{
			swiperList
		},
		methods: {
			
		}
	}
</script>

<style>
	
</style>
