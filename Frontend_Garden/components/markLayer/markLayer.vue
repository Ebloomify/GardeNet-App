<template>
	<view>
		<view class="mark_box">
			<view class="mark_bg " v-if="type == 1">
				<image :src="bgImg" mode=""></image>
			</view>
		</view>
		<!-- <view class="mark_bg " v-if="type == 1">
				<image :src="bgImg" mode="widthFix" class="mark_img"></image>
			</view> -->
		<view class="data_lost tac" v-if="type == 2">
			<image src="/static/images/zdl.png" mode="widthFix" class="data_img"></image>
			<view class="fz30 c6 mb10">Server error</view>
			<view class="fz24 c9 mb30">Try refreshing the page</view>
			<button type="primary" plain="true" class="refresh_btn" @click="refresh()">Refresh</button>
		</view>
		<view class="data_lost tac" v-if="type == 3">
			<image src="/static/images/zdl.png" mode="widthFix" class="data_img"></image>
			<view class="fz30 c6 mb10">Network connection failed</view>
			<view class="fz24 c9 mb30">Please confirm the mobile network</view>
		</view>

	</view>
	</view>
</template>

<script>
	//来源from     类型type  1=底图遮罩  2=请求返回失败 3=断网 
	export default {
		name: 'markLayer',
		props: {
			from: {
				type: Number,
				default: ''
			},
			type: {
				type: Number,
				default: 1
			},
			bgImg: {
				type: String,
				default: '/static/images/live-logo.gif'
				// default: '@/live-logo.gif'
			}
		},
		data() {
			return {

			}
		},
		methods: {
			refresh() {
				uni.showLoading({
					mask: true,
					title: 'Loading'
				})
				this.$emit('markRefresh', this.from);
			}
		}
	}
</script>

<style>
	.data_img {
		width: 240rpx;
		height: 240rpx;
		margin: auto;
		margin-bottom: 20rpx;
	}

	.mark_box {
		background: #fff;
		position: fixed;
		top: var(--window-top);
		left: 0;
		right: 0;
		bottom: var(--window-bottom);
		z-index: 10073;
	}

	.data_lost {
		position: absolute;
		top: 50%;
		width: 100%;
		transform: translate3d(0, -50%, 0);
		z-index: 10074;
	}

	.refresh_btn {
		width: 200rpx;
		height: 80rpx;
		line-height: 80rpx;
		font-size: 24rpx;
	}

	.mark_bg {
		position: absolute;
		top: 0;
		left: 0;
		bottom: 0;
		right: 0;
		overflow: hidden;
		background-position: top left;
		background-size: 100% auto;
		-webkit-background-size: 100% auto;
		z-index:10074;
	}

	.mark_img {
		width: 100%;
		height: auto;
	}

	.mark_bg image {
		position: absolute;
		top: 50%;
		left: 50%;
		opacity: 1;
		transform: translate3d(-50%, -50%, 0);
	}
</style>
