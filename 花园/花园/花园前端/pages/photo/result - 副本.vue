<template>
	<view>
		<view>
			<swiper :autoplay="true" :interval="3000" :duration="500" style="height: 450rpx;">
				<swiper-item v-for="(item,index) in 2">
					<view class="swiper-item">
						<view class="img" style="background-image: url(../../static/images/i_03.jpg);"></view>
					</view>
				</swiper-item>
			</swiper>
		</view>
		<!--  -->
		<view class="info_box">
			<view class="title">
				<view class="fz44 c3">Fleshy</view>
				<view class="fz26 c9">Name of study: xiaocuiju</view>
			</view>
			<!--  -->
			<view class="p30">
				<view class="line_title fz34 c3">Florescence:</view>
				<view class="h30"></view>
				<view class="pl50 fz30 c6">
					August to October in autumn
				</view>
				<!--  -->
				<view class="h30"></view>
				<view class="line_title fz34 c3">More:</view>
				<view class="h30"></view>
				<view class="pl50 fz30 c6 lh50">
					Yulu likes loose, fertile and well drained humus rich soil,Give it 18-21 ℃ growth environment, water - must not be excessive, every dayReceive proper light and turn basin in time. Generally, the method of inserting is usedReproduction, in addition to ensure adequate ventilation and light, so as to avoid pestsHarm.Yulu likes loose, fertile and well drained humus rich soil,Give it 18-21 ℃ growth environment, water - must not be excessive, every dayReceive proper light and turn basin in time. Generally, the method of inserting is usedReproduction, in addition to ensure adequate ventilation and light, so as to avoid pestsHarm.Yulu likes loose, fertile and well drained humus rich soil,Give it 18-21 ℃ growth environment, water - must not be excessive, every dayReceive proper light and turn basin in time. Generally, the method of inserting is usedReproduction, in addition to ensure adequate ventilation and light, so as to avoid pestsHarm.Yulu likes loose, fertile and well drained humus rich soil,Give it 18-21 ℃ growth environment, water - must not be excessive, every dayReceive proper light and turn basin in time. Generally, the method of inserting is usedReproduction, in addition to ensure adequate ventilation and light, so as to avoid pestsHarm.
				</view>
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

		}
	}
</script>

<style>
	.img {
		width: 100%;
		height: 450rpx;
		background-size: cover;
		background-position: center center;
	}

	.info_box {
		background: #fff;
		border-top-left-radius: 30rpx;
		border-top-right-radius: 30rpx;
		position: relative;
		top: -40rpx;
	}

	.title {
		border-bottom: 6rpx solid #f7f7f7;
		padding: 20rpx 30rpx;
	}

	.line_title {
		line-height: 34rpx;
		height: 34rpx;
		border-left: 6rpx solid #5fcfa0;
		text-indent: 30rpx;
	}

	.pl50 {
		padding-left: 50rpx;
	}
</style>
