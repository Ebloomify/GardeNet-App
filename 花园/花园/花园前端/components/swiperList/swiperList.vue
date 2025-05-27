<template>
	<view>
		<!-- 顶部切换 -->
		<view class="box oh" :style="{height: parentHeight}">
			<view class="">
				<u-tabs ref="tabs" :show-bar="showBar" :bar-style="barStyle" gutter="30" @change="tabChange" :list="tabs"
				 active-color="#333" inactive-color="#666" font-size="34" :current="current" name="cate_name"></u-tabs>
			</view>
			<!--  -->
			<swiper style="height: calc(100% - 80rpx)" :current="current" @change="swiperChange" :duration="500">
				<!--全部 -->
				<swiper-item v-for="(item,index) in tabs">
					<MescrollItem :i="index" :index="current" :tabs="tabs" :pageFrom="pageFrom" :requestUrl="requestUrl"></MescrollItem>
				</swiper-item>
				<!--  -->
			</swiper>
		</view>

	</view>
</template>

<script>
	import MescrollItem from "@/components/swiperList/mescroll-swiper-item.vue";
	export default {
		components: {
			MescrollItem,
		},
		data() {
			return {
				// tabs: ['全部asdsad', '奶粉', '面膜', '图书'],
				current: 0, //tab 索引
				barStyle: {
					background: "linear-gradient(to right, #48d39a, #48ceb7)",
					// bottom: "18rpx",
					height: "8rpx"
				},
				showBar: false
			}
		},
		created() {
			
		},
		mounted() {
			setTimeout(()=>{
				this.showBar = true;
			},1000)
		},
		/*
			parentHeight = 组件高度
			tabs = 分类数据
			pageFrom = 页面来源 用于区分显示哪些列表
			requestUrl = 数据请求地址
		*/
		props: ['parentHeight', 'tabs', "pageFrom", "requestUrl"],
		methods: {
			//tab改变事件
			tabChange(e) {
				this.current = e;
			},
			// 轮播菜单
			swiperChange(e) {
				this.current = e.detail.current
			}
		},

	}
</script>

<style>
	page {
		background: #f4f4f4;
	}
</style>
