<template>
	<view>
		<!-- 顶部切换 -->
		<view class="box oh" id="box">
			<view class="">
				<u-tabs ref="tabs" :is-scroll="false" :bar-style="barStyle" gutter="30" @change="tabChange" :list="tabs"
					active-color="#333" inactive-color="#666" font-size="30" :current="current"></u-tabs>
			</view>
			<view style="height: 1rpx;background-color: #f4f4f4;"></view>
		</view>
		<!--  -->
		<view :style="{height: parentHeight}">
			<swiper style="height: 100%" :current="current" @change="swiperChange" :duration="500">
				<swiper-item v-for="(item,index) in tabs">
					<MescrollItem :i="index" :index="current" :tabs="tabs"></MescrollItem>
				</swiper-item>
			</swiper>
		</view>
	</view>
</template>

<script>
	import MescrollItem from "@/components/centerSwiperList/mescroll-swiper-item.vue";
	export default {
		components: {
			MescrollItem,
		},
		data() {
			return {
				// tabs: ['全部asdsad', '奶粉', '面膜', '图书'],
				sys: "",
				parentHeight: {},
				current: 0, //tab 索引
				barStyle: {
					background: "linear-gradient(to right, #48d39a, #48ceb7)",
					// bottom: "18rpx",
					height: "8rpx"
				},
				showBar: true
			}
		},
		created() {
			setTimeout(() => {
				this.initHeight();
			}, 300)
		},
		mounted() {
			// this.initHeight();
		},
		mounted() {},
		/*
			tabs = 分类数据
			{
				name: 'Replv to me', //tab名称
				ajaxUrl: '', // 接口地址
				template: 'Replv' //模板区分
			}
		*/
		props: ['tabs'],
		methods: {
			// 计算滚动区域高度
			initHeight() {
				this.sys = uni.getSystemInfoSync();
				this.windowHeight = this.sys.windowHeight;
				this.statusBarHeight = this.sys.statusBarHeight;

				// 计算 内容区域高度
				const query = uni.createSelectorQuery().in(this);
				query.select('#box').boundingClientRect(data => {
					if (!data) {
						setTimeout(() => {
							this.initHeight();
						}, 200)
					} else {
						this.parentHeight = `calc(${this.windowHeight}px - ${data.height}px)`;
					};
				}).exec();
			},
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
		height: calc(100vh - var(--window-top));
		overflow: hidden;
	}
</style>
