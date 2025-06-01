<template>
	<view>
		<swiperList :tabs="tabList"></swiperList>
	</view>
</template>

<script>
	import swiperList from "@/components/centerSwiperList/swiperList.vue";
	var _list = [{
		name: 'I published', //tab名称
		ajaxUrl: '/V1.MemberCommunity/list', // 接口地址
		template: 'my' //模板区分
	}, {
		name: 'I was involved',
		ajaxUrl: '/V1.MemberCommunity/commentList',
		template: 'from'
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
