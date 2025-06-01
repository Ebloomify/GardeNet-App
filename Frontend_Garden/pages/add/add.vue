<template>
	<view>
		<view class="add_box bgf">
			<view class="lh100 fz30 c3 tac fw9 mb20">Publish new content</view>
			<view class="flex juc">
				<view class="flex_1 tac" @click="nav('/pages/add/bbs?from=bbs')">
					<image src="../../static/images/post_03.jpg" mode="" class="img"></image>
					<view class="fz26 c3">Post to Community</view>
				</view>
				<view class="flex_1 tac" @click="nav('/pages/add/bbs?from=qa')">
					<image src="../../static/images/post_05.jpg" mode="" class="img"></image>
					<view class="fz26 c3">Post to Q & A</view>
				</view>
			</view>
			<view class="h40"></view>
			<view class="bt1 lh80" @click="back">
				<view class="fz30 ca tac">Cancel</view>
			</view>
		</view>
	</view>
</template>

<script>
	export default {
		data() {
			return {

			}
		},
		methods: {
			nav(url) {
				uni.navigateTo({
					url: url
				})
			},
			back() {
				uni.navigateBack({
					delta: 1
				})
			}
		}
	}
</script>

<style>
	page {
		background-color: rgba(0, 0, 0, 0.3);
		height: 100vh;
		overflow: hidden;
	}

	.add_box {
		border-top-left-radius: 20rpx;
		border-top-right-radius: 20rpx;
		position: fixed;
		bottom: 0;
		left: 0;
		width: 100%;
	}

	.img {
		width: 85rpx;
		height: 85rpx;
	}

	.back {}
</style>
