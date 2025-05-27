<template>
	<view>
		<u-navbar :is-back="false" :safeAreaInsetTop="true">
			<view class="w100 bgf">
				<view class="flex p10_30">
					<view class="search_box mr20 flex_1" @click="toSearch">
						<view class="flex itc p0_40 h70">
							<input maxlength="-1"  type="text" class="w100 fz32 c3 flex_1" :placeholder="placeholder" disabled="true">
							<view class="iconsousuo fz40 c9"></view>
						</view>
					</view>
					<view class="photo_box flex itc juc" @click="photo">
						<view class="iconweibiaoti-- fz40 c9"></view>
					</view>
				</view>
			</view>
		</u-navbar>
		
		<!-- <view class="bgf">
			<view class="statusBox"></view>
			<view class="flex itc p0_3" style="height: 44px;">
				<view class="search_box mr20 flex_1" @click="toSearch">
					<view class="flex itc p0_40 h70">
						<view class=" flex_1">
							<input type="text" class="w100 fz32 c3 flex_1" :placeholder="placeholder" disabled="true">
						</view>
						<view class="iconfont iconsousuo"></view>
					</view>
				</view>
				<view class="photo_box flex itc juc" @click="photo">
					<view class="iconweibiaoti-- fz40 c9"></view>
				</view>
			</view>
		</view> -->
		
	</view>
</template>

<script>
	export default {
		data() {
			return {
				placeholder: ""
			}
		},
		props: ['from'],
		created() {
			// console.log(this.from)
			if (this.from == 'discover') {
				this.placeholder = 'Discover';
			} else if (this.from == 'bbs') {
				this.placeholder = 'Community';
			} else if (this.from == 'qa') {
				this.placeholder = 'Questions & Answers';
			}
		},
		methods: {
			toSearch() {
				uni.navigateTo({
					url: "/pages/search/search?from=" + this.from
				})
			},
			photo() {
				if(!this.token) {
					uni.navigateTo({
						url:"/pages/login/login"
					})
					return;
				};
				uni.navigateTo({
					url: "/pages/photo/photo"
				})
			}
		}
	}
</script>

<style>
	.p10_30 {
		padding: 10rpx 30rpx;
	}

	.search_box {
		height: 70rpx;
		border-radius: 35rpx;
		overflow: hidden;
		background-color: #f6f7f9;
	}

	.p0_40 {
		padding: 0 40rpx;
	}

	.photo_box {
		width: 70rpx;
		height: 70rpx;
		border-radius: 6rpx;
		background-color: #f6f7f9;
	}
	
	.statusBox{
		width: 100%;
		height: var(--status-bar-height);
	}
</style>
