<template>
	<view>
		<swiperList :tabs="tabList"></swiperList>
	</view>
</template>

<script>
	import swiperList from "@/components/centerSwiperList/swiperList.vue";
	var _list = [{
		name: 'Discover', //发现
		ajaxUrl: '/V1.MemberCollect/index', // 接口地址
		template: 'Discover' //模板区分
	}, {
		name: 'Community', // 论坛
		ajaxUrl: '/V1.MemberCollect/index',
		template: 'BBS'
	}, {
		name: 'Q&A', // 问答
		ajaxUrl: '/V1.MemberCollect/index',
		template: 'QA'
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
			// 设置来自个人中心的标志
			this.setFromCenter(true);
		},
		onUnload() {
			// 取消来自个人中心标志
			this.setFromCenter(false);
		},
		components: {
			swiperList
		},
		methods: {

		}
	}
</script>

<style>

</style>
