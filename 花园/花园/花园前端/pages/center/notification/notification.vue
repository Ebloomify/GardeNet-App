<template>
	<view>
		<swiperList :tabs="tabList"></swiperList>
	</view>
</template>

<script>
	import swiperList from "@/components/centerSwiperList/swiperList.vue";
	var _list = [{
			name: 'System message',
			ajaxUrl: '/V1.Notification/systemNotification',
			template: 'message'
		}, {
			name: 'Replv to me', //tab名称
			ajaxUrl: '/V1.Notification/articleNotification', // 接口地址
			template: 'Replv' //模板区分
		}
		// , {
		// 	name: 'recommend',
		// 	ajaxUrl: '',
		// 	template: 'recommend'
		// }
	];
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
		onLoad() {},
		components: {
			swiperList
		},
		methods: {

		}
	}
</script>

<style>

</style>
